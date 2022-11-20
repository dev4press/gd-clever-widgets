<?php

if (!defined('ABSPATH')) { exit; }

function gdclw_is_gdcpt_active() {
    return defined('GDTAXONOMIESTOOLS_VERSION');
}

function gdclw_get_posttype_post($id) {
    $post = get_post($id);

    $item = new stdClass();
    $item->posts = 0;
    $item->url = get_permalink($post->ID);
    $item->text = $post->post_title;
    $item->value = $post->ID;
    $item->children = gdclw_get_posts_count(array('post_type' => $post->post_type, 'parent' => $post->ID)) > 0;
    $item->current = 'post-'.$post->ID;
    $item->description = gdclw_get_post_excerpt($post);
    $item->up = $post->post_parent == 0 ? get_site_url() : get_permalink($post->post_parent);

    return $item;
}

function gdclw_get_taxonomy_term($id, $taxonomy, $post_type = '', $exclude = array()) {
    $term = get_term($id, $taxonomy);

    $item = new stdClass();
    $item->posts = $term->count;
    $item->url = gdclw_get_term_link($term, $taxonomy, $post_type);
    $item->text = $term->name;
    $item->value = $term->term_id;
    $item->children = count(gdclw_get_term_children($term->term_id, $term->taxonomy, $exclude)) > 0;
    $item->current = 'term-'.$term->term_id;
    $item->description = $term->description;
    $item->up = $term->parent == 0 ? get_site_url() : gdclw_get_term_link($term->parent, $taxonomy, $post_type);

    return $item;
}

function gdclw_get_parent_date_item($instance) {
    if (is_date()) {
        global $wp_locale;

        $current = explode('-', gdclw_plugin()->navigator['page']);
        $level = is_year() ? 'yearly' : (is_month() ? 'monthly' : (is_day() ? 'daily' : ''));

        $year = intval($current[0]);
        $month = $level != 'yearly' ? intval($current[1]) : 0;
        $day = $level == 'daily' ? intval($current[2]) : 0;

        $item = new stdClass();
        $item->posts = 0;
        $item->current = gdclw_plugin()->navigator['page'];
        $item->children = true;
        $item->description = '';
        $item->value = '';
        $item->up = get_site_url();

        switch ($level) {
            case 'yearly':
                $item->url = get_year_link($year);
                $item->text = sprintf('%d', $year);
                break;
            case 'monthly':
                $item->url = get_month_link($year, $month);
                $item->text = sprintf('%1$s %2$d', $wp_locale->get_month($month), $year);
                $item->up = get_year_link($year);
                break;
            case 'daily':
                $date = sprintf('%1$d-%2$02d-%3$02d 00:00:00', $year, $month, $day);

                $item->url = get_day_link($year, $month, $day);
                $item->text = mysql2date(get_option('date_format'), $date);
                $item->up = get_month_link($year, $month);
                break;
        }

        return $item;
    } else {
        return null;
    }
}

function gdclw_get_term_link($term, $taxonomy, $post_type = '') {
    $intersection = apply_filters('clw_gdcpt_archive_intersection', gdclw_is_gdcpt_active() && function_exists('gdtt_get_intersection_link'), $taxonomy, $post_type, $term);

    if ($post_type == '' || !$intersection) {
        return get_term_link($term);
    } else {
        return gdtt_get_intersection_link($post_type, $taxonomy, $term);
    }
}

function gdclw_render_list_level($list, $widget_id, $instance, $args = array()) {
    $defaults = array('level' => 0, 'dig_deep' => true, 'total_count' => 0, 'offset' => 0, 
                      'parent' => 0, 'init' => false, 'current' => '', 'widget_name' => 0, 'up' => null);
    $args = wp_parse_args($args, $defaults);
    extract($args);
    
    $i = 1; $expander = false; $results = array();

    $visible_items = $level == 0 ? $instance['level_first'] : $instance['level_inner'];
    $visible_limit = $visible_items > 0;

    if (!is_null($up)) {
        $tag_class = array('clw-li-item', 'clw-li-level-up');

        if ($instance['mark_current'] == 'mark' && isset($up->current) && $up->current === $current) {
            $tag_class[] = 'clw-current';
        }

        $tag = '<li class="'.join(' ', $tag_class).'">';

        $tag.= '<span class="clw-item-toggle clw-item-toggle-parent"><a href="'.$up->up.'">';
        $tag.= '<span class="clw-toggle-up">'.$instance['markup_up'].'</span>';
        $tag.= '</a></span>';

        $item = '';

        if ($up->url != '') {
            $item.= '<a class="clw-item" href="'.$up->url.'" title="'.esc_attr($up->text).'">'.$up->text.'</a>';
        } else {
            $item.= '<span class="clw-item">'.$up->text.'</span>';
        }

        if (isset($instance['post_counts']) && $instance['post_counts'] == 'yes' && $up->posts > 0) {
            $item.= ' ('.$up->posts.')';
        }

        if ($instance['show_description'] == 'yes' && $up->description != '') {
            $item.= '<em>'.$up->description.'</em>';
        }

        $tag.= '<div class="clw-item-wrapper">';
        $tag.= apply_filters('clw_rendered_item_up', $item, $up, $widget_name, $widget_id, $level, $instance);
        $tag.= '</div>';

        $tag.= '</li>';

        $results[] = $tag;
    }
    
    foreach ($list as $li) {
        $has_levels = is_null($dig_deep) ? $li->children : $dig_deep;
        $tag_class = array('clw-li-item', 'clw-li-level-'.$level);

        if ($instance['mark_current'] == 'mark' && isset($li->current) && $li->current === $current) {
            $tag_class[] = 'clw-current';
        }

        $tag = '<li class="'.join(' ', $tag_class).'"';

        if ($level > 0 || ($visible_limit && $i > $visible_items) || !$init) {
            $tag.= ' style="display: none"';
            $expander = true;
        }

        $tag.= '>';

        if ($has_levels) {
            $tag.= '<span class="clw-item-toggle"><a aria-pressed="false" role="button" title="'.__("Toggle item level", "gd-clever-widgets").'" href="#'.$widget_id.'|'.($level + 1).'|'.$li->value.'|'.$instance['animate_method'].'|'.$instance['animate_speed'].'">';
            $tag.= '<span class="clw-toggle-plus">'.$instance['markup_plus'].'</span><span class="clw-toggle-minus">'.$instance['markup_minus'].'</span>';
            $tag.= '</a></span>';
        } else {
            $tag.= '<span class="clw-item-pad">&nbsp;</span>';
        }

        $item = '';

        if ($li->url != '') {
            $item.= '<a class="clw-item" href="'.$li->url.'" title="'.esc_attr($li->text).'">'.$li->text.'</a>';
        } else {
            $item.= '<span class="clw-item">'.$li->text.'</span>';
        }

        if (isset($instance['post_counts']) && $instance['post_counts'] == 'yes' && $li->posts > 0) {
            $item.= ' ('.$li->posts.')';
        }

        if (isset($instance['show_description']) && $instance['show_description'] == 'yes' && $li->description != '') {
            $item.= '<em>'.$li->description.'</em>';
        }

        $tag.= '<div class="clw-item-wrapper">';
        $tag.= apply_filters('clw_rendered_item', $item, $li, $widget_name, $widget_id, $level, $instance);
        $tag.= '</div>';

        if ($has_levels) {
            $tag.= '<ul class="clw-li-inner-level" aria-hidden="true" style="display: none;"><li class="clw-li-please-wait">'.__("Please wait...", "gd-clever-widgets").'</li></ul>';
        }

        $tag.= '</li>';

        $results[] = $tag;
        $i++;
    }

    if ($expander && $visible_limit) {
        $total_count = $total_count != 0 ? $total_count : count($list);
        $current_count = count($list) + $offset;

        $displayed_now = $offset == 0 && $level > 0 ? 0 : $visible_items + $offset;

        $results[] = '<li class="clw-li-expander"><a href="#'.$total_count.'|'.$current_count.'|'.$visible_items.'|'.$displayed_now.'|'.$widget_id.'|'.$level.'|'.$parent.'|'.$instance['animate_method'].'|'.$instance['animate_speed'].'">'.$instance['markup_more'].'</a></li>';

        if ($total_count > $current_count) {
            $results[] = '<li class="clw-li-please-wait" style="display: none;">'.$instance['markup_wait'].'</li>';
        }
    }

    return join(D4P_EOL, $results);
}


function gdclw_clear_cached_terms($args = array()) {
    $defaults = array('taxonomy' => array(), 'post_types' => array());
    $args = wp_parse_args($args, $defaults);

    if (!is_array($args['taxonomy'])) {
        $args['taxonomy'] = array($args['taxonomy']);
    }

    if (!is_array($args['post_types'])) {
        if (!empty($args['post_types'])) {
            $args['post_types'] = array($args['post_types']);
        } else {
            $args['post_types'] = array();
        }
    }

    $key = 'clwt_'.md5(serialize($args));

    delete_transient($key);
}

function gdclw_get_taxonomy_parent_terms($taxonomy = 'category') {
    if (!is_taxonomy_hierarchical($taxonomy)) {
        return array();
    }

    $key = 'gdclw_par_'.$taxonomy;
    $list = get_transient($key);

    if (!is_array($list)) {
        $list = array();

        $terms = get_terms($taxonomy, array('get' => 'all', 'orderby' => 'id', 'fields' => 'id=>parent'));
        foreach ($terms as $term_id => $parent) {
            if ($parent > 0 && !in_array($parent, $list)) {
                $list[] = $parent;
            }
        }

        set_transient($key, $list, 3600 * 24 * 7);
    }

    return $list;
}

if (!function_exists('gdclw_get_post_excerpt')) {
    function gdclw_get_post_excerpt($post, $word_limit = 15) {
        $content = $post->post_excerpt == '' ? $post->post_content : $post->post_excerpt;

        $content = strip_shortcodes($content);
        $content = str_replace(']]>', ']]&gt;', $content);
        $content = strip_tags($content);

        $words = explode(' ', $content, $word_limit + 1);

        if (count($words) > $word_limit) {
            array_pop($words);
            $content = implode(' ', $words);
            $content.= '...';
        }

        return $content;
    }
}

if (!function_exists('gdclw_get_pages')) {
    function gdclw_get_pages($args = '') {
        global $wpdb;

        $pages = false;

        $defaults = array(
            'sort_order' => 'ASC', 'fields' => 'all',
            'sort_column' => 'post_title', 'hierarchical' => 1,
            'exclude' => array(), 'include' => array(),
            'meta_key' => '', 'meta_value' => '',
            'authors' => '', 'parent' => -1, 'exclude_tree' => '',
            'number' => '', 'offset' => 0, 'child_of' => 0,
            'post_type' => 'page', 'post_status' => 'publish',
        );

        $r = wp_parse_args($args, $defaults);
        extract($r, EXTR_SKIP);
        $number = (int)$number;
        $offset = (int)$offset;

        if (!is_array($post_status)) {
            $post_status = explode(',', $post_status);
        }

        if (array_diff($post_status, get_post_stati())) return $pages;

        $inclusions = '';
        if (!empty($include)) {
            $child_of = 0;
            $parent = -1;
            $exclude = '';
            $meta_key = '';
            $meta_value = '';
            $hierarchical = false;
            $incpages = wp_parse_id_list($include);

            if (!empty($incpages)) {
                foreach ( $incpages as $incpage ) {
                    if (empty($inclusions)) {
                        $inclusions = $wpdb->prepare(' AND ( ID = %d ', $incpage);
                    } else {
                        $inclusions.= $wpdb->prepare(' OR ID = %d ', $incpage);
                    }
                }
            }
        }

        if (!empty($inclusions)) {
            $inclusions .= ')';
        }

        $exclusions = '';
        if (!empty($exclude)) {
            $expages = wp_parse_id_list($exclude);

            if (!empty($expages)) {
                foreach ($expages as $expage) {
                    if (empty($exclusions)) {
                        $exclusions = $wpdb->prepare(' AND ( ID <> %d ', $expage);
                    } else {
                        $exclusions .= $wpdb->prepare(' AND ID <> %d ', $expage);
                    }
                }
            }
        }

        if (!empty($exclusions)) {
            $exclusions .= ')';
        }

        $author_query = '';
        if (!empty($authors)) {
            $post_authors = preg_split('/[\s,]+/',$authors);

            if (!empty($post_authors)) {
                foreach ($post_authors as $post_author) {
                    if (0 == intval($post_author)) {
                        $post_author = get_user_by('login', $post_author);
                        if (empty($post_author)) continue;
                        if (empty($post_author->ID)) continue;
                        $post_author = $post_author->ID;
                    }

                    if ('' == $author_query) {
                        $author_query = $wpdb->prepare(' post_author = %d ', $post_author);
                    } else {
                        $author_query .= $wpdb->prepare(' OR post_author = %d ', $post_author);
                    }
                }

                if ('' != $author_query) {
                    $author_query = " AND ($author_query)";
                }
            }
        }

        $join = '';
        $where = "$exclusions $inclusions ";
        if (!empty($meta_key) || !empty($meta_value)) {
            $join = " LEFT JOIN $wpdb->postmeta ON ( $wpdb->posts.ID = $wpdb->postmeta.post_id )";

            $meta_key = stripslashes($meta_key);
            $meta_value = stripslashes($meta_value);

            if (!empty($meta_key)) {
                $where.= $wpdb->prepare(" AND $wpdb->postmeta.meta_key = %s", $meta_key);
            }

            if (!empty($meta_value)) {
                $where .= $wpdb->prepare(" AND $wpdb->postmeta.meta_value = %s", $meta_value);
            }
        }

        if ( $parent >= 0 ) {
            $where.= $wpdb->prepare(' AND post_parent = %d ', $parent);
        }

        if (1 == count($post_status)) {
            $where_post_type = $wpdb->prepare("post_type = %s AND post_status = %s", $post_type, array_shift($post_status));
        } else {
            $post_status = implode("', '", $post_status);
            $where_post_type = $wpdb->prepare("post_type = %s AND post_status IN ('$post_status')", $post_type);
        }

        switch ($fields) {
            default:
            case 'all':
                $select_fields = '*';
                break;
            case 'ids':
                $select_fields = 'ID';
                break;
            case 'count':
                $select_fields = 'COUNT(*)';
                break;
        }

        if ($fields != 'count' && $sort_column != 'none') {
            $orderby_array = array();
            $allowed_keys = array('author', 'post_author', 'date', 'post_date', 'title', 'post_title', 'name', 'post_name', 'modified', 'post_modified', 'modified_gmt', 'post_modified_gmt', 'menu_order', 'parent', 'post_parent', 'ID', 'rand', 'comment_count');

            foreach (explode(',', $sort_column) as $orderby) {
                $orderby = trim($orderby);

                if (!in_array($orderby, $allowed_keys)) continue;

                switch ($orderby) {
                    case 'menu_order':
                        break;
                    case 'ID':
                        $orderby = "$wpdb->posts.ID";
                        break;
                    case 'rand':
                        $orderby = 'RAND()';
                        break;
                    case 'comment_count':
                        $orderby = "$wpdb->posts.comment_count";
                        break;
                    default:
                        if (0 === strpos($orderby, 'post_')) {
                            $orderby = "$wpdb->posts.".$orderby;
                        } else {
                            $orderby = "$wpdb->posts.post_".$orderby;
                        }
                }

                $orderby_array[] = $orderby;
            }

            $sort_column = !empty($orderby_array) ? implode(',', $orderby_array) : "$wpdb->posts.post_title";

            $sort_order = strtoupper($sort_order);
            if ('' !== $sort_order && !in_array($sort_order, array('ASC', 'DESC'))) {
                $sort_order = 'ASC';
            }
        } else {
            $sort_column = '';
            $sort_order = '';
        }

        $query = "SELECT $select_fields FROM $wpdb->posts $join WHERE ($where_post_type) $where ";
        $query.= $author_query;

        if ($sort_column != '' || $sort_order != '') {
            $query.= " ORDER BY $sort_column $sort_order";
        }

        if (!empty($number)) {
            $query.= " LIMIT $offset, $number";
        }

        if ($fields == 'count') {
            return $wpdb->get_var($query);
        } else {
            $pages = $wpdb->get_results($query);

            if (empty($pages)) {
                $pages = apply_filters('get_pages', array(), $r);
                return $pages;
            }

            $num_pages = count($pages);
            for ($i = 0; $i < $num_pages; $i++) {
                $pages[$i] = sanitize_post($pages[$i], 'raw');
            }

            if ($child_of || $hierarchical) {
                $pages = get_page_children($child_of, $pages);
            }

            if (!empty($exclude_tree)) {
                $exclude = (int)$exclude_tree;
                $children = get_page_children($exclude, $pages);
                $excludes = array();

                foreach ($children as $child) {
                    $excludes[] = $child->ID;
                }

                $excludes[] = $exclude;
                $num_pages = count($pages);

                for ($i = 0; $i < $num_pages; $i++ ) {
                    if (in_array($pages[$i]->ID, $excludes)) {
                        unset($pages[$i]);
                    }
                }
            }

            $pages = array_map('get_post', $pages);
            $pages = apply_filters('gdclw_get_pages', $pages, $r);

            return $pages;
        }
    }
}

if (!function_exists('gdclw_get_terms_count')) {
    function gdclw_get_terms_count($args = '') {
        $defaults = array('post_types' => '', 'exclude' => array(), 'taxonomy' => 'category', 'hide_empty' => true, 'parent' => 0, 'fields' => 'count', 'hierarchical' => false);
        $r = wp_parse_args($args, $defaults);

        if (!taxonomy_exists($r['taxonomy'])) {
            return false;
        }

        require_once(GDCLW_PATH.'core/code/terms.php');
        return gdclw_get_terms($r);
    }
}

if (!function_exists('gdclw_get_taxonomy_archives')) {
    function gdclw_get_taxonomy_archives($args = '') {
        $defaults = array('post_types' => '', 'exclude' => array(), 'taxonomy' => 'category', 'hide_empty' => true, 'orderby' => 'name', 'order' => 'ASC', 'parent' => 0, 'offset' => '', 'number' => '', 'hierarchical' => false, 'clw' => 'yes');
        $r = wp_parse_args($args, $defaults);

        if (!taxonomy_exists($r['taxonomy'])) {
            return false;
        }

        require_once(GDCLW_PATH.'core/code/terms.php');
        $terms = gdclw_get_terms($r);

        $output = array();

        if (is_array($terms)) {
            foreach ($terms as $term) {
                $item = new stdClass();
                $item->posts = $term->count;
                $item->url = gdclw_get_term_link($term, $r['taxonomy'], $r['post_types']);
                $item->text = $term->name;
                $item->value = $term->term_id;
                $item->children = count(gdclw_get_term_children($term->term_id, $term->taxonomy, $r['exclude'])) > 0;
                $item->current = 'term-'.$term->term_id;
                $item->description = $term->description;

                $output[] = $item;
            }
        }

        return $output;
    }
}

if (!function_exists('gdclw_get_posts_count')) {
    function gdclw_get_posts_count($args = '') {
        $defaults = array('post_type' => 'pages', 'parent' => 0, 'fields' => 'count', 'exclude' => array());
        $r = wp_parse_args($args, $defaults);

        if (!post_type_exists($r['post_type'])) {
            return false;
        }

        return gdclw_get_pages($r);
    }
}

if (!function_exists('gdclw_get_nav_menu_items')) {
    function gdclw_get_nav_menu_items($args = '') {
        $defaults = array('name' => '', 'parent' => 0, 'show_top' => false, 'detect' => false);
        $r = wp_parse_args($args, $defaults);
        extract($r);

        $parent = intval($parent);

        $menu = wp_get_nav_menu_object($name);
        $menu_items = wp_get_nav_menu_items($menu->term_id, array('update_post_term_cache' => false));

        _wp_menu_item_classes_by_context($menu_items);

        $sorted_menu_items = $menu_items_with_children = array();
        foreach ((array)$menu_items as $menu_item) {
            $sorted_menu_items[$menu_item->menu_order] = $menu_item;

            if ($menu_item->menu_item_parent) {
                $menu_items_with_children[$menu_item->menu_item_parent] = true;
            }
        }

        if ($detect) {
            foreach ((array)$menu_items as $menu_item) {
                if ($menu_item->current) {
                    if (isset($menu_items_with_children[$menu_item->ID])) {
                        $parent = $menu_item->ID;
                    } else {
                        $parent = $menu_item->menu_item_parent;
                    }

                    break;
                }
            }
        }

        $output = array('items' => array(), 'current' => '', 'up' => null);

        if (is_array($sorted_menu_items)) {
            foreach ($sorted_menu_items as $post) {
                if ($show_top) {
                    if ($parent > 0 && $post->ID == $parent) {
                        $item = new stdClass();
                        $item->posts = 0;
                        $item->url = $post->url;
                        $item->text = $post->title;
                        $item->value = $post->ID;
                        $item->children = isset($menu_items_with_children[$post->ID]);
                        $item->current = $post->url;
                        $item->description = $post->description;
                        $item->up = $post->menu_item_parent == 0 ? get_site_url() : get_permalink($post->menu_item_parent);

                        if ($post->current) {
                            $output['current'] = $post->url;
                        }

                        $output['up'] = $item;
                    }
                }

                if ($parent == $post->menu_item_parent) {
                    $item = new stdClass();
                    $item->posts = 0;
                    $item->url = $post->url;
                    $item->text = $post->title;
                    $item->value = $post->ID;
                    $item->children = isset($menu_items_with_children[$post->ID]);
                    $item->current = $post->url;
                    $item->description = $post->description;

                    if ($post->current) {
                        $output['current'] = $post->url;
                    }

                    $output['items'][] = $item;
                }
            }
        }

        return $output;
    }
}

if (!function_exists('gdclw_get_hierarchy_content')) {
    function gdclw_get_hierarchy_content($args = '') {
        $defaults = array('post_type' => 'pages', 'hierarchical' => 0, 'sort_column' => 'name', 'sort_order' => 'ASC', 'parent' => 0, 'offset' => '', 'number' => '', 'exclude' => array());
        $r = wp_parse_args($args, $defaults);
        extract($r);

        if (!post_type_exists($r['post_type'])) {
            return false;
        }

        $pages = gdclw_get_pages($r);

        $output = array();

        if (is_array($pages)) {
            foreach ($pages as $page) {
                $item = new stdClass();
                $item->posts = 0;
                $item->url = get_permalink($page->ID);
                $item->text = $page->post_title;
                $item->value = $page->ID;
                $item->children = gdclw_get_posts_count(array('post_type' => $post_type, 'parent' => $page->ID)) > 0;
                $item->current = 'post-'.$page->ID;
                $item->description = gdclw_get_post_excerpt($page);

                $output[] = $item;
            }
        }

        return $output;
    }
}

if (!function_exists('gdclw_get_date_archives')) {
    function gdclw_get_date_archives($args = '') {
        global $wpdb, $wp_locale;

        $defaults = array('type' => '', 'decade' => '', 'year' => '', 'month' => '', 'offset' => '', 'limit' => '', 'sort_order' => 'DESC', 'decade_url' => 'none');
        $r = wp_parse_args($args, $defaults);
        extract($r, EXTR_SKIP);

        if ('' == $type) {
            $type = 'yearly';
        }

        $archive_date_format_over_ride = 0;
        $archive_day_date_format = 'Y/m/d';
        $archive_week_start_date_format = 'Y/m/d';
        $archive_week_end_date_format = 'Y/m/d';

        if (!$archive_date_format_over_ride) {
            $archive_day_date_format = get_option('date_format');
            $archive_week_start_date_format = get_option('date_format');
            $archive_week_end_date_format = get_option('date_format');
        }

        $where = apply_filters('gdclw_date_archives_where', "WHERE post_type = 'post' AND post_status = 'publish'", $r);
        $join = apply_filters('gdclw_date_archives_join', '', $r);

        $output = array();

        if ('monthly' == $type) {
            if ($year != '') {
                $where.= ' AND YEAR(post_date) = '.$year;
            }

            $query = "SELECT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date $sort_order";
            $key = md5($query);
            $cache = wp_cache_get('wp_get_archives' , 'general');

            if (!isset($cache[$key])) {
                $arcresults = $wpdb->get_results($query);
                $cache[$key] = $arcresults;

                wp_cache_set('wp_get_archives', $cache, 'general');
            } else {
                $arcresults = $cache[$key];
            }

            if ($arcresults) {
                foreach ((array)$arcresults as $arcresult) {
                    $dec = floor((int)$arcresult->year / 10);

                    $item = clone($arcresult);
                    $item->url = get_month_link($arcresult->year, $arcresult->month);
                    $item->text = sprintf('%1$s %2$d', $wp_locale->get_month($arcresult->month), $arcresult->year);
                    $item->value = $dec.'-'.$item->year.'-'.$item->month;
                    $item->children = true;
                    $item->current = $item->year.'-'.str_pad($item->month, 2, '0', STR_PAD_LEFT);
                    $item->description = '';

                    unset($item->year);
                    unset($item->month);

                    $output[] = $item;
                }
            }
        } elseif ('decennially' == $type || 'yearly' == $type) {
            if ($decade != '' && 'yearly' == $type) {
                $where.= ' AND YEAR(post_date) >= '.$decade * 10;
                $where.= ' AND YEAR(post_date) < '.($decade + 1) * 10;
            }

            $query = "SELECT YEAR(post_date) AS `year`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date) ORDER BY post_date $sort_order";
            $key = md5($query);
            $cache = wp_cache_get('wp_get_archives' , 'general');

            if (!isset($cache[$key])) {
                $arcresults = $wpdb->get_results($query);
                $cache[$key] = $arcresults;

                wp_cache_set('wp_get_archives', $cache, 'general');
            } else {
                $arcresults = $cache[$key];
            }

            if ($arcresults) {
                if ('decennially' == $type) {
                    $decs = array();
                    $decs_counts = array();
                    $decs_first = array();

                    foreach ((array) $arcresults as $arcresult) {
                        $dec = floor((int)$arcresult->year / 10);

                        if (!in_array($dec, $decs)) {
                            $decs[] = $dec;
                            $decs_counts[$dec] = 0;
                            $decs_first[$dec] = $arcresult->year;
                        }

                        $decs_counts[$dec]+= $arcresult->posts;

                        if ($arcresult->year < $decs_first[$dec]) {
                            $decs_first[$dec] = $arcresult->year;
                        }
                    }

                    foreach ($decs as $dec) {
                        $item = new stdClass();
                        $item->posts = $decs_counts[$dec];
                        $item->url = '';
                        $item->text = sprintf('%d0 - %d9', $dec, $dec);
                        $item->value = $dec;
                        $item->children = true;
                        $item->current = '';
                        $item->description = '';

                        if ($decade_url == 'first_year') {
                            $item->url = get_year_link($decs_first[$dec]);
                        }

                        $output[] = $item;
                    }
                } else if ('yearly' == $type) {
                    foreach ((array)$arcresults as $arcresult) {
                        $dec = floor((int)$arcresult->year / 10);

                        $item = clone($arcresult);
                        $item->url = get_year_link($arcresult->year);
                        $item->text = sprintf('%d', $arcresult->year);
                        $item->value = $dec.'-'.$item->year;
                        $item->children = true;
                        $item->current = $item->year;
                        $item->description = '';

                        unset($item->year);

                        $output[] = $item;
                    }
                }
            }
        } elseif ('daily' == $type) {
            if ($year != '') {
                $where.= ' AND YEAR(post_date) = '.$year;
            }

            if ($month != '') {
                $where.= ' AND MONTH(post_date) = '.$month;
            }

            $query = "SELECT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, DAYOFMONTH(post_date) AS `dayofmonth`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date), MONTH(post_date), DAYOFMONTH(post_date) ORDER BY post_date $sort_order";
            $key = md5($query);
            $cache = wp_cache_get('wp_get_archives' , 'general');

            if (!isset($cache[$key])) {
                $arcresults = $wpdb->get_results($query);
                $cache[$key] = $arcresults;

                wp_cache_set('wp_get_archives', $cache, 'general');
            } else {
                $arcresults = $cache[$key];
            }

            if ($arcresults) {
                foreach ((array)$arcresults as $arcresult) {
                    $date = sprintf('%1$d-%2$02d-%3$02d 00:00:00', $arcresult->year, $arcresult->month, $arcresult->dayofmonth);
                    $dec = floor((int)$arcresult->year / 10);

                    $item = clone($arcresult);
                    $item->url = get_day_link($arcresult->year, $arcresult->month, $arcresult->dayofmonth);
                    $item->text = mysql2date($archive_day_date_format, $date);
                    $item->value = $dec.'-'.$item->year.'-'.$item->month.'-'.$item->dayofmonth;
                    $item->children = false;
                    $item->current = $item->year.'-'.str_pad($item->month, 2, '0', STR_PAD_LEFT).'-'.str_pad($item->dayofmonth, 2, '0', STR_PAD_LEFT);
                    $item->description = '';

                    unset($item->year);
                    unset($item->month);
                    unset($item->dayofmonth);

                    $output[] = $item;
                }
            }
        }

        return $output;
    }
}
