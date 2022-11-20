<?php

if (!defined('ABSPATH')) { exit; }

class gdclw_core_styles {
    public $converter = array();
    public $navigator = array();
    public $posts = array();
    public $featured = array();
    public $calendar = array();

    public function __construct() {
        $this->converter = apply_filters('gdclw_styles_converter', array(
            '' => __("None", "gd-clever-widgets"),
            'clw-converter-plain' => __("Plain", "gd-clever-widgets"),
            'clw-converter-plain clw-plain-large' => __("Plain, Large", "gd-clever-widgets"),
            'clw-converter-flat' => __("Flat", "gd-clever-widgets"),
            'clw-converter-flat clw-flat-large' => __("Flat, Large", "gd-clever-widgets")
        ));

        $this->navigator = apply_filters('gdclw_styles_navigator', array(
            '' => __("None", "gd-clever-widgets"),
            'clw-navigator-plain' => __("Plain", "gd-clever-widgets"),
            'clw-navigator-elegant' => __("Elegant", "gd-clever-widgets")
        ));

        $this->posts = apply_filters('gdclw_styles_posts', array(
            '' => __("None", "gd-clever-widgets"),
            'clw-posts-plain' => __("Plain", "gd-clever-widgets")
        ));

        $this->authors = apply_filters('gdclw_styles_authors', array(
            '' => __("None", "gd-clever-widgets"),
            'clw-authors-plain' => __("Plain", "gd-clever-widgets")
        ));

        $this->featured = apply_filters('gdclw_styles_featured', array(
            '' => __("None", "gd-clever-widgets"),
            'clw-featured-plain' => __("Plain", "gd-clever-widgets")
        ));

        $this->calendar = apply_filters('gdclw_styles_calendar', array(
            '' => __("None", "gd-clever-widgets"),
            'clw-calendar-basic' => __("Basic", "gd-clever-widgets"),
            'clw-calendar-clean' => __("Clean", "gd-clever-widgets")
        ));
    }
}
