<?php

if (!defined('ABSPATH')) { exit; }

function gdclw_calendar($args = array()) {
    global $wpdb, $m, $monthnum, $year, $wp_locale;

    $w = '';

    $defaults = array('weekdays' => 'initials', 'post_type' => 'post', 
        'days_titles' => 'date_counts', 'echo' => true, 'content' => 'auto',
        'date_month' => 1, 'date_year' => 2016, 'table_id' => 'wp-calendar');
    $args = wp_parse_args($args, $defaults);
    extract($args, EXTR_OVERWRITE);

    $post_type = (array)$post_type;
    $post_types = "'".join("', '", $post_type)."'";

    $use_monthnum = '';
    $use_year = '';
    $use_m = '';

    if ($content == 'month') {
        $use_monthnum = $date_month;
        $use_year = $date_year;
    } else if ($content == 'auto') {
        $use_monthnum = $monthnum;
        $use_year = $year;
        $use_m = $m;

        if (isset($_GET['w'])) {
            $w = ''.intval($_GET['w']);
        }
    }

    $week_begins = intval(get_option('start_of_week'));

    if (!empty($use_monthnum) && !empty($use_year)) {
        $thismonth = ''.zeroise(intval($use_monthnum), 2);
        $thisyear = ''.intval($use_year);
    } else if (!empty($w)) {
        $thisyear = ''.intval(substr($use_m, 0, 4));
        $d = (($w - 1) * 7) + 6;
        $thismonth = $wpdb->get_var("SELECT DATE_FORMAT((DATE_ADD('{$thisyear}0101', INTERVAL $d DAY) ), '%m')");
    } else if (!empty($use_m)) {
        $thisyear = ''.intval(substr($use_m, 0, 4));

        if (strlen($use_m) < 6) {
            $thismonth = '01';
        } else {
            $thismonth = ''.zeroise(intval(substr($use_m, 4, 2)), 2);
        }
    } else {
        $thisyear = gmdate('Y', current_time('timestamp'));
        $thismonth = gmdate('m', current_time('timestamp'));
    }

    $unixmonth = mktime(0, 0 , 0, $thismonth, 1, $thisyear);
    $last_day = date('t', $unixmonth);

    $previous = $wpdb->get_row("SELECT MONTH(post_date) AS month, YEAR(post_date) AS year
            FROM $wpdb->posts
            WHERE post_date < '$thisyear-$thismonth-01'
            AND post_type IN ($post_types) AND post_status = 'publish'
            ORDER BY post_date DESC
            LIMIT 1");
    $next = $wpdb->get_row("SELECT MONTH(post_date) AS month, YEAR(post_date) AS year
            FROM $wpdb->posts
            WHERE post_date > '$thisyear-$thismonth-{$last_day} 23:59:59'
            AND post_type IN ($post_types) AND post_status = 'publish'
            ORDER BY post_date ASC
            LIMIT 1");

    $table_class = 'clw-calendar clw-cal-year-'.$thisyear.' clw-cal-month-'.$thismonth;
    $table_class.= ' clw-weekdays-'.$weekdays;

    $calendar_caption = _x('%1$s %2$s', 'calendar caption', "gd-clever-widgets");
    $calendar_output = '<table id="'.$table_id.'" class="'.$table_class.'">
    <caption>'.sprintf($calendar_caption, $wp_locale->get_month($thismonth), date('Y', $unixmonth)).'</caption>
    <thead>
    <tr>';

    $myweek = array();

    for ($wdcount = 0; $wdcount <= 6; $wdcount++) {
        $myweek[] = $wp_locale->get_weekday(($wdcount + $week_begins) % 7);
    }

    foreach ($myweek as $wd) {
        $day_name = $weekdays == 'initials' ? $wp_locale->get_weekday_initial($wd) : $wp_locale->get_weekday_abbrev($wd);
        $wd = esc_attr($wd);
        $calendar_output.= "\n\t\t<th scope=\"col\" title=\"$wd\">$day_name</th>";
    }

    $calendar_output.= '
    </tr>
    </thead>

    <tfoot>
    <tr>';

    if ($previous) {
        $calendar_output.= "\n\t\t".'<td colspan="3" class="clw-calendar-prev"><a href="'.get_month_link($previous->year, $previous->month).'">&laquo; '.$wp_locale->get_month_abbrev($wp_locale->get_month($previous->month)).'</a></td>';
    } else {
        $calendar_output.= "\n\t\t".'<td colspan="3" class="clw-calendar-prev pad">&nbsp;</td>';
    }

    $calendar_output.= "\n\t\t".'<td class="pad">&nbsp;</td>';

    if ($next) {
        $calendar_output.= "\n\t\t".'<td colspan="3" class="clw-calendar-next"><a href="'.get_month_link($next->year, $next->month).'">'.$wp_locale->get_month_abbrev($wp_locale->get_month($next->month)).' &raquo;</a></td>';
    } else {
        $calendar_output.= "\n\t\t".'<td colspan="3" class="clw-calendar-next pad">&nbsp;</td>';
    }

    $calendar_output.= '
    </tr>
    </tfoot>

    <tbody>
    <tr>';

    $dayswithposts = $wpdb->get_results("SELECT DISTINCT DAYOFMONTH(post_date)
            FROM $wpdb->posts WHERE post_date >= '{$thisyear}-{$thismonth}-01 00:00:00'
            AND post_type IN ($post_types) AND post_status = 'publish'
            AND post_date <= '{$thisyear}-{$thismonth}-{$last_day} 23:59:59'", ARRAY_N);

    if ($dayswithposts) {
        foreach ((array)$dayswithposts as $daywith) {
            $daywithpost[] = $daywith[0];
        }
    } else {
        $daywithpost = array();
    }

    $daysinmonth = intval(date('t', $unixmonth));

    $ak_pc_raw = $wpdb->get_results("SELECT DAYOFMONTH(post_date) as dom, count(*) as posts 
            FROM $wpdb->posts WHERE post_date >= '{$thisyear}-{$thismonth}-01 00:00:00' 
            AND post_date <= '{$thisyear}-{$thismonth}-{$last_day} 23:59:59' 
            AND post_type IN ($post_types) AND post_status = 'publish' GROUP BY dom"
    );

    $ak_posts_counts = array();
    if ($ak_pc_raw) {
        foreach ((array)$ak_pc_raw as $row) {
            $ak_posts_counts["$row->dom"] = $row->posts;
        }
    }

    $ak_titles_for_day = array();
    if ($days_titles == 'titles') {
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false || stripos($_SERVER['HTTP_USER_AGENT'], 'camino') !== false || stripos($_SERVER['HTTP_USER_AGENT'], 'safari') !== false) {
            $ak_title_separator = "\n";
        } else {
            $ak_title_separator = ', ';
        }

        $ak_post_titles = $wpdb->get_results("SELECT ID, post_title, DAYOFMONTH(post_date) as dom 
                FROM $wpdb->posts WHERE post_date >= '{$thisyear}-{$thismonth}-01 00:00:00' 
                AND post_date <= '{$thisyear}-{$thismonth}-{$last_day} 23:59:59' 
                AND post_type IN ($post_types) AND post_status = 'publish'"
        );

        if ($ak_post_titles) {
            foreach ((array) $ak_post_titles as $ak_post_title) {
                $post_title = esc_attr(apply_filters('the_title', $ak_post_title->post_title, $ak_post_title->ID));

                if (empty($ak_titles_for_day['day_'.$ak_post_title->dom])) {
                    $ak_titles_for_day['day_'.$ak_post_title->dom] = '';
                }

                if (empty($ak_titles_for_day["$ak_post_title->dom"])) {
                    $ak_titles_for_day["$ak_post_title->dom"] = $post_title;
                } else {
                    $ak_titles_for_day["$ak_post_title->dom"].= $ak_title_separator.$post_title;
                }
            }
        }
    } else if ($days_titles == 'date_counts') {
        for ($day = 1; $day <= $daysinmonth; ++$day) {
            $timestamp = mktime(0, 0, 0, $thismonth, $day, $thisyear);
            $posts = isset($ak_posts_counts["$day"]) ? $ak_posts_counts["$day"] : 0;

            $ak_titles_for_day["$day"] = date(get_option('date_format'), $timestamp).' ('.$posts.' '._n("post", "posts", $posts, "gd-clever-widgets").')';
        }
    } else {
        for ($day = 1; $day <= $daysinmonth; ++$day) {
            $timestamp = mktime(0, 0, 0, $thismonth, $day, $thisyear);
            $ak_titles_for_day["$day"] = date(get_option('date_format'), $timestamp);
        }
    }

    $pad = calendar_week_mod(date('w', $unixmonth) - $week_begins);

    if (0 != $pad) {
        $calendar_output .= "\n\t\t".'<td colspan="'. esc_attr($pad) .'" class="pad">&nbsp;</td>';
    }

    for ($day = 1; $day <= $daysinmonth; ++$day) {
        $posts = isset($ak_posts_counts["$day"]) ? $ak_posts_counts["$day"] : 0;

        if (isset($newrow) && $newrow) {
            $calendar_output.= "\n\t</tr>\n\t<tr>\n\t\t";
        }

        $newrow = false;

        $td_class = '';

        if ($day == gmdate('j', current_time('timestamp')) && $thismonth == gmdate('m', current_time('timestamp')) && $thisyear == gmdate('Y', current_time('timestamp'))) {
            $td_class.= 'clw-calendar-today ';
        }

        if ($posts > 0) {
            $td_class.= 'clw-calendar-has-posts ';
        }
        
        $calendar_output.= '<td class="'.trim($td_class).'">';

        if (in_array($day, $daywithpost)) {
            $calendar_output.= '<a href="'.get_day_link($thisyear, $thismonth, $day).'" title="'.esc_attr($ak_titles_for_day[$day]).'">'.$day.'</a>';
        } else {
            $calendar_output.= '<span title="'.esc_attr($ak_titles_for_day[$day]).'">'.$day.'</span>';
        }

        $calendar_output.= '</td>';

        if (6 == calendar_week_mod(date('w', mktime(0, 0 , 0, $thismonth, $day, $thisyear)) - $week_begins)) {
            $newrow = true;
        }
    }

    $pad = 7 - calendar_week_mod(date('w', mktime(0, 0 , 0, $thismonth, $day, $thisyear)) - $week_begins);

    if ($pad != 0 && $pad != 7) {
        $calendar_output.= "\n\t\t".'<td class="pad" colspan="'.esc_attr($pad).'">&nbsp;</td>';
    }

    $calendar_output.= "\n\t</tr>\n\t</tbody>\n\t</table>";

    if ($echo) {
        echo $calendar_output;
    } else {
        return $calendar_output;
    }
}
