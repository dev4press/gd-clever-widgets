<?php

if (!defined('ABSPATH')) { exit; }

function gdclw_dummy_get_terms_count($args = '') {
    return 32;
}

function gdclw_dummy_get_posts_count($args = '') {
    return 32;
}

function gdclw_dummy_get_taxonomy_archives($args = '') {
    $terms = gdclw_dummy_get_list_of_random_terms();

    $output = array();
    foreach ($terms as $term) {
        $item = new stdClass();
        $item->posts = rand(3, 25);
        $item->url = '#';
        $item->text = $term;
        $item->value = rand(1, 30);
        $item->children = rand(0, 3) == 1;

        $output[] = $item;
    }

    return $output;
}

function gdclw_dummy_get_hierarchy_content($args = '') {
    return gdclw_dummy_get_taxonomy_archives($args);
}

function gdclw_dummy_get_nav_menu_items($args = '') {
    $output = array('items' => gdclw_dummy_get_taxonomy_archives($args), 'current' => '', 'up' => null);

    return $output;
}

function gdclw_dummy_get_date_archives($args = '') {
    global $wpdb, $wp_locale;

    $defaults = array('type' => 'monthly', 'decade' => '', 'year' => '', 'month' => '', 'offset' => '', 'limit' => '', 'sort_order' => 'DESC', 'decade_url' => 'none');
    $r = wp_parse_args($args, $defaults);
    extract($r, EXTR_SKIP);

    if ('' == $type) {
        $type = 'yearly';
    }

    $archive_week_separator = '&#8211;';
    $archive_date_format_over_ride = 0;
    $archive_day_date_format = 'Y/m/d';
    $archive_week_start_date_format = 'Y/m/d';
    $archive_week_end_date_format = 'Y/m/d';

    if (!$archive_date_format_over_ride) {
        $archive_day_date_format = get_option('date_format');
        $archive_week_start_date_format = get_option('date_format');
        $archive_week_end_date_format = get_option('date_format');
    }

    $_year_range = array(1982, 2016);
    $_month_range = array(1, 12);

    $output = array();

    if ('monthly' == $type) {
        if ($year != '') {
            $_year_range = array($year, $year);
        }

        for ($i = $_year_range[1]; $i >= $_year_range[0]; $i--) {
            $dec = floor((int)$i / 10);

            for ($j = $_month_range[1]; $j >= $_month_range[0]; $j--) {
                $item = new stdClass();
                $item->url = get_month_link($i, $j);
                $item->text = sprintf('%1$s %2$d', $wp_locale->get_month($j), $i);
                $item->value = $dec.'-'.$i.'-'.$j;
                $item->posts = rand(3, 50);
                $item->children = true;

                $output[] = $item;
            }
        }
    } elseif ('decennially' == $type) {
        $decs = array();
        $decs_first = array();

        for ($i = $_year_range[1]; $i >= $_year_range[0]; $i--) {
            $dec = floor((int)$i / 10);
            
            if (!in_array($dec, $decs)) {
                $decs[] = $dec;
                $decs_first[$dec] = $i;
            }

            if ($i < $decs_first[$dec]) {
                $decs_first[$dec] = $i;
            }
        }

        foreach ($decs as $dec) {
            $item = new stdClass();
            $item->posts = rand(50, 700);
            $item->url = '';
            $item->text = sprintf('%d0 - %d9', $dec, $dec);
            $item->value = $dec;
            $item->children = true;

            if ($decade_url == 'first_year') {
                $item->url = get_year_link($decs_first[$dec]);
            }

            $output[] = $item;
        }
    } elseif ('yearly' == $type) {
        if ($decade != '' && 'yearly' == $type) {
            $_year_range = array($decade * 10, $decade * 10 + 9);
        }

        for ($i = $_year_range[1]; $i >= $_year_range[0]; $i--) {
            $dec = floor((int)$i / 10);

            $item = new stdClass();
            $item->url = get_year_link($i);
            $item->text = sprintf('%d', $i);
            $item->value = $dec.'-'.$i;
            $item->posts = rand(5, 500);
            $item->children = true;

            $output[] = $item;
        }
    } elseif ('daily' == $type) {
        if ($year != '') {
            $_year_range = array($year, $year);
        }

        if ($month != '') {
            $_month_range = array($month, $month);
        }

        for ($i = $_year_range[1]; $i >= $_year_range[0]; $i--) {
            $dec = floor((int)$i / 10);

            for ($j = $_month_range[1]; $j >= $_month_range[0]; $j--) {
                $max_days = cal_days_in_month(CAL_GREGORIAN, $j, $i);

                for ($k = $max_days; $k >= 1; $k--) {
                    $date = sprintf('%1$d-%2$02d-%3$02d 00:00:00', $i, $j, $k);

                    $item = new stdClass();
                    $item->url = get_day_link($i, $j, $k);
                    $item->text = mysql2date($archive_day_date_format, $date);
                    $item->value = $dec.'-'.$i.'-'.$j.'-'.$k;
                    $item->children = false;
                    $item->posts = rand(2, 15);

                    $output[] = $item;
                }
            }
        }
    }

    if ($sort_order == 'ASC') {
        $output = array_reverse($output);
    }

    return $output;
}

function gdclw_dummy_get_list_of_random_terms($count = 32) {
    $terms = array();

    $word = gdclw_rand_word::getInstance();
    
    for ($i = 0; $i < $count; $i++) {
        $terms[] = $word->generate(rand(4, 10), false, true).' '.$word->generate(rand(4, 10), true, true);
    }

    return $terms;
}

/**
* @author        Eric Sizemore <admin@secondversion.com>
* @package       Random Word
* @version       1.0.2
* @copyright     2006 - 2011 Eric Sizemore
* @license       GNU GPL
* 
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by 
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
* 
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*/

// Slightly inspired by class randomWord by kumar mcmillan
class gdclw_rand_word { 
    private static $instance;

    private $vowels = array('a', 'e', 'i', 'o', 'u', 'y');

    private $consonants = array(
        'b', 'c', 'd', 'f', 'g', 'h',
        'j', 'k', 'l', 'm', 'n', 'p',
        'r', 's', 't', 'v', 'w', 'z',
        'ch', 'qu', 'th', 'xy'
    );

    private $word = '';

    private function __construct() {}

    /**
     * Creates an instance of the class.
     *
     * @param  void
     * @return object
    */
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Generates the random word.
     *
     * @param    integer        $length            Length of the word
     * @param    boolean        $lower_case        Return the word lowercase?
     * @param    boolean        $ucfirst        Reutrn the word with the first letter capitalized?
     * @param    boolean        $upper_case        Return the word uppercase?
     * @return   string
    */
    public function generate($length = 5, $lower_case = true, $ucfirst = false, $upper_case = false) { 
        $done = false;
        $const_or_vowel = 1;

        while (!$done) {
            switch ($const_or_vowel) { 
                case 1:
                    $this->word .= $this->consonants[array_rand($this->consonants)];
                    $const_or_vowel = 2;
                    break;
                case 2:
                    $this->word .= $this->vowels[array_rand($this->vowels)];
                    $const_or_vowel = 1;
                    break;
            } 

            if (strlen($this->word) >= $length) {
                $done = true;
            }
        }

        $this->word = substr($this->word, 0, $length);

        if ($lower_case) {
            $this->word = strtolower($this->word);
        } else if ($ucfirst) {
            $this->word = ucfirst(strtolower($this->word));
        } else if ($upper_case) {
            $this->word = strtoupper($this->word);
        }
        return $this->word;
    }
}
