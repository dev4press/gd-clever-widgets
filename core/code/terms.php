<?php

if (!defined('ABSPATH')) { exit; }

function gdclw_build_hierarchy($terms, $counts, $id = 0) {
    $tree = array();

    foreach ($terms as $term) {
        if ($term->parent == $id) {
            $term->terms = gdclw_build_hierarchy($terms, $counts, $term->term_id);
            $term->count = isset($counts[$term->term_id]) ? $counts[$term->term_id] : 0;

            $tree[$term->term_id] = $term;
        }
    }

    return $tree;
}

function gdclw_recalculate_hierarchy(&$terms) {
    $count = 0;

    foreach ($terms as $id => $term) {
        if (!empty($term->terms)) {
            $term->count+= gdclw_recalculate_hierarchy($term->terms);
        }

        $count+= $term->count;
    }

    return $count;
}

function gdclw_cleanup_hierarchy(&$terms, $list = array()) {
    foreach ($terms as $id => $term) {
        if (!empty($term->terms)) {
            $list = gdclw_cleanup_hierarchy($term->terms, $list);
        }

        if (empty($term->terms) && $term->count == 0) {
            unset($terms[$id]);
        } else {
            $list[$term->term_id] = $term->count;
        }
    }

    return $list;
}

function gdclw_cached_terms($args = array()) {
    $defaults = array('taxonomy' => array(), 'post_types' => array());
    $args = wp_parse_args($args, $defaults);

    $key = 'clw_terms_'.md5(serialize($args));
    $list = get_transient($key);

    if ($list == '') {
        $args['fields'] = 'id=>count';
        $args['hierarchical'] = false;
        $args['get'] = 'all';
        $args['flat'] = true;
        $args['hide_empty'] = false;

        $count_terms = gdclw_get_terms($args);

        $args['post_types'] = array();
        $args['fields'] = 'id_counts';

        $all_terms = gdclw_get_terms($args);

        $tree = gdclw_build_hierarchy($all_terms, $count_terms);
                gdclw_recalculate_hierarchy($tree);
        $list = gdclw_cleanup_hierarchy($tree);

        $timeout = apply_filters('gdclw_cached_terms_timout', 3600 * 24 * 2);

        set_transient($key, $list, $timeout);
    }

    return $list;
}

function gdclw_get_terms($args = '') {
    global $wpdb;

    $defaults = array('taxonomy' => array(), 'post_types' => array(), 'orderby' => 'name', 'order' => 'ASC', 
            'hide_empty' => true, 'exclude' => array(), 'exclude_tree' => array(), 'include' => array(),
            'number' => '', 'fields' => 'all', 'slug' => '', 'parent' => '', 'offset' => '', 'search' => '',
            'hierarchical' => true, 'child_of' => 0, 'get' => '', 'name__like' => '', 'pad_counts' => false,
            'flat' => false, 'force_cached_recalc' => false, 'limit_terms' => array());
    $args = wp_parse_args($args, $defaults);

    $recalc_terms = array();
    $list_parents = array();
    $single_taxonomy = false;
    $real_hieararchy = false;

    if (!is_array($args['taxonomy'])) {
        $single_taxonomy = true;
        $args['taxonomy'] = array($args['taxonomy']);
    }

    foreach ($args['taxonomy'] as $taxonomy) {
        if (!taxonomy_exists($taxonomy)) {
            return new WP_Error('invalid_taxonomy', __("Invalid Taxonomy", "gd-clever-widgets"));
        }

        if (is_taxonomy_hierarchical($taxonomy)) {
            $list_parents = array_merge($list_parents, gdclw_get_taxonomy_parent_terms($taxonomy));
            $real_hieararchy = true;
        }
    }
    
    $args['taxonomies'] = $args['taxonomy'];
    unset($args['taxonomy']);
    
    if (!is_array($args['post_types'])) {
        if (!empty($args['post_types'])) {
            $args['post_types'] = array($args['post_types']);
        } else {
            $args['post_types'] = array();
        }
    }

    $args['number'] = absint($args['number']);
    $args['offset'] = absint($args['offset']);

    if (!$single_taxonomy) {
        $args['parent'] = '';
    }

    if (!$single_taxonomy || !is_taxonomy_hierarchical($args['taxonomies'][0]) || '' !== $args['parent']) {
        $args['child_of'] = 0;
        $args['hierarchical'] = false;
        $args['pad_counts'] = false;
    }

    if ('all' == $args['get']) {
        $args['child_of'] = 0;
        $args['hide_empty'] = 0;
        $args['hierarchical'] = false;
        $args['pad_counts'] = false;
    }

    extract($args, EXTR_SKIP);

    $force_cached_recalc = apply_filters('gdclw_terms_forced_recalc', $force_cached_recalc);

    $extraction_method = (!empty($post_types) || $force_cached_recalc) && $real_hieararchy && !$flat ? 'advanced' : 'normal';
    $args['_extraction_method'] = $extraction_method;

    if ($extraction_method == 'advanced') {
        $recalc_terms = gdclw_cached_terms(array('taxonomy' => $taxonomies, 'post_types' => $post_types));

        if (!empty($post_types)) {
            if (empty($recalc_terms)) {
                if ('count' == $fields) {
                    return 0;
                } else {
                    return array();
                }
            }

            $limit_terms = array_keys($recalc_terms);
            $post_types = array();
        }
    }

    $in_taxonomies = "'".implode("', '", $taxonomies)."'";
    $in_post_types = "'".implode("', '", $post_types)."'";

    if ($child_of) {
        $hierarchy = _get_term_hierarchy($taxonomies[0]);
        if (!isset($hierarchy[$child_of])) return array();
    }

    if ($parent) {
        $hierarchy = _get_term_hierarchy($taxonomies[0]);
        if (!isset($hierarchy[$parent])) return array();
    }

    $_orderby = strtolower($orderby);
    if ('count' == $_orderby && empty($post_types)) {
        $orderby = 'tt.count';
    }

    if ('count' == $_orderby && !empty($post_types)) {
        $orderby = 'count(*)';
    } else if ('name' == $_orderby) {
        $orderby = 't.name';
    } else if ('slug' == $_orderby) {
        $orderby = 't.slug';
    } else if ('term_group' == $_orderby) {
        $orderby = 't.term_group';
    } else if ('rand' == $_orderby) {
        $orderby = 'rand()';
        $order = '';
    } else if ('none' == $_orderby) {
        $orderby = '';
    } else if (empty($_orderby) || 'id' == $_orderby) {
        $orderby = 't.term_id';
    }

    $orderby = apply_filters('gdclw_get_terms_orderby', $orderby, $args);

    if (!empty($orderby)) {
        $orderby = "ORDER BY $orderby";
    } else {
        $order = '';
    }

    $where = $group_by = $inclusions = $exclusions = '';

    if (!empty($post_types)) {
        $group_by = ' GROUP BY t.term_id';
    }

    if (!empty($limit_terms)) {
        $interms = wp_parse_id_list($limit_terms);

        $where.= ' AND t.term_id IN ('.join(', ', $interms).') ';
    }

    if (!empty($include)) {
        $exclude = $exclude_tree = '';
        $interms = wp_parse_id_list($include);

        foreach ($interms as $interm) {
            if (empty($inclusions)) {
                $inclusions = ' AND (t.term_id = '.intval($interm);
            } else {
                $inclusions.= ' OR t.term_id = '.intval($interm);
            }
        }
    }

    if (!empty($inclusions)) {
        $inclusions.= ')';
    }

    $where.= $inclusions;
    if (!empty($exclude_tree)) {
        $excluded_trunks = wp_parse_id_list($exclude_tree);

        foreach ($excluded_trunks as $extrunk) {
            $excluded_children = (array)get_terms($taxonomies[0], array('child_of' => intval($extrunk), 'fields' => 'ids'));
            $excluded_children[] = $extrunk;

            foreach ($excluded_children as $exterm) {
                if (empty($exclusions)) {
                    $exclusions = ' AND (t.term_id <> '.intval($exterm);
                } else {
                    $exclusions.= ' AND t.term_id <> '.intval($exterm);
                }
            }
        }
    }

    if (!empty($exclude)) {
        $exterms = wp_parse_id_list($exclude);

        foreach ($exterms as $exterm) {
            if (empty($exclusions)) {
                $exclusions = ' AND (t.term_id <> '.intval($exterm);
            } else {
                $exclusions.= ' AND t.term_id <> '.intval($exterm);
            }
        }
    }

    if (!empty($exclusions)) {
        $exclusions.= ')';
    }

    $exclusions = apply_filters('gdclw_list_terms_exclusions', $exclusions, $args);
    $where.= $exclusions;

    if (!empty($slug)) {
        $slug = sanitize_title($slug);
        $where.= " AND t.slug = '$slug'";
    }

    if (!empty($name__like)) {
        $where.= " AND t.name LIKE '{$name__like}%'";
    }

    if ('' !== $parent) {
        $parent = (int) $parent;
        $where.= " AND tt.parent = '$parent'";
    }

    if ($hide_empty && !$hierarchical) {
        if (empty($post_types)) {
            if (!empty($list_parents)) {
                $where.= ' AND ((tt.count > 0 AND t.term_id NOT IN ('.join(', ', $list_parents).')) OR t.term_id IN ('.join(', ', $list_parents).')) ';
            } else {
                $where.= ' AND tt.count > 0';
            }
        } else {
            $group_by.= ' HAVING count(*) > 0';
        }
    }

    if (!empty($number) && !$hierarchical && empty($child_of) && '' === $parent) {
        if ($offset) {
            $limit = 'LIMIT '.$offset.', '.$number;
        } else {
            $limit = 'LIMIT '.$number;
        }
    } else {
        $limit = '';
    }

    if (!empty($search)) {
        $search = like_escape($search);
        $where.= " AND (t.name LIKE '%$search%')";
    }

    if (!empty($post_types)) {
        $where.= " AND p.post_type IN ($in_post_types)";
    }

    $selects = array();
    switch ($fields) {
        default:
        case 'all':
            if (empty($post_types)) {
                $selects = array('t.*', 'tt.*');
            } else {
                $selects = array('t.*', 'tt.term_taxonomy_id', 'tt.taxonomy', 'tt.description', 'tt.parent', 'COUNT(*) as count');
            }
            break;
        case 'ids':
        case 'id_counts':
        case 'id=>parent':
        case 'id=>count':
            if (empty($post_types)) {
                $selects = array('t.term_id', 'tt.parent', 'tt.count');
            } else {
                $selects = array('t.term_id', 'tt.parent', 'COUNT(*) as count');
            }
            break;
        case 'names':
            if (empty($post_types)) {
                $selects = array('t.term_id', 'tt.parent', 'tt.count', 't.name');
            } else {
                $selects = array('t.term_id', 'tt.parent', 'COUNT(*) as count', 't.name');
            }
            break;
        case 'count':
           $orderby = '';
           $order = '';
           $selects = array('COUNT(*)');
    }

    $select_this = implode(', ', apply_filters('gdclw_get_terms_fields', $selects, $args));

    if (empty($post_types)) {
        $query = "SELECT $select_this FROM $wpdb->terms AS t INNER JOIN $wpdb->term_taxonomy AS tt ON t.term_id = tt.term_id WHERE tt.taxonomy IN ($in_taxonomies) $where $orderby $order $limit";
    } else {
        $query = "SELECT $select_this FROM $wpdb->terms AS t INNER JOIN $wpdb->term_taxonomy AS tt ON t.term_id = tt.term_id INNER JOIN $wpdb->term_relationships AS tr ON tr.term_taxonomy_id = tt.term_taxonomy_id INNER JOIN $wpdb->posts AS p ON p.ID = tr.object_id WHERE tt.taxonomy IN ($in_taxonomies) $where $group_by $orderby $order $limit";
    }

    if ('count' == $fields) {
        $term_count = $wpdb->get_var($query);
        return $term_count;
    }

    $terms = $wpdb->get_results($query);

    if (empty($terms)) {
        return $terms;
    }

    foreach ($terms as $term) {
        if (isset($recalc_terms[$term->term_id])) {
            $term->count = $recalc_terms[$term->term_id];
        }
    }

    if ($pad_counts && 'all' == $fields) {
        _pad_term_counts($terms, $taxonomies[0]);
    }

    if ($hierarchical && $hide_empty && is_array($terms)) {
        foreach ($terms as $k => $term) {
            if (!$term->count) {
                $children = _get_term_children($term->term_id, $terms, $taxonomies[0]);

                if (is_array($children)) {
                    foreach ($children as $child) {
                        if ($child->count) {
                            continue 2;
                        }
                    }
                }

                unset($terms[$k]);
            }
        }
    }

    reset($terms);

    $_terms = array();
    if ('id=>parent' == $fields) {
        while ($term = array_shift($terms))
            $_terms[$term->term_id] = $term->parent;
        $terms = $_terms;
    } elseif ('id=>count' == $fields) {
        while ($term = array_shift($terms))
            $_terms[$term->term_id] = $term->count;
        $terms = $_terms;
    } elseif ('ids' == $fields) {
        while ($term = array_shift($terms))
            $_terms[] = $term->term_id;
        $terms = $_terms;
    } elseif ('names' == $fields) {
        while ($term = array_shift($terms))
            $_terms[] = $term->name;
        $terms = $_terms;
    }

    if (0 < $number && intval(@count($terms)) > $number) {
        $terms = array_slice($terms, $offset, $number);
    }

    return apply_filters('gdclw_get_terms', $terms, $taxonomies, $args);
}

function gdclw_get_term_children($term_id, $taxonomy, $exclude = array()) {
    if (!taxonomy_exists($taxonomy)) {
        return new WP_Error('invalid_taxonomy', __("Invalid taxonomy", "gd-clever-widgets"));
    }

    $term_id = intval($term_id);

    $terms = _get_term_hierarchy($taxonomy);

    if (!isset($terms[$term_id])) {
        return array();
    }

    $children = array();

    foreach ((array)$terms[$term_id] as $child) {
        if (!in_array($child, $exclude)) {
            $children[] = $child;
        }
    }

    foreach ((array)$terms[$term_id] as $child) {
        if ($term_id == $child) {
            continue;
        }

        if (isset($terms[$child]) && !in_array($child, $exclude)) {
            $children = array_merge($children, gdclw_get_term_children($child, $taxonomy, $exclude));
        }
    }

    return $children;
}
