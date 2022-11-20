<?php

if (!defined('ABSPATH')) { exit; }

class gdclw_core_templates {
    public $posts = array();
    public $authors = array();

    public function __construct() {
        $this->posts = apply_filters('gdclw_templates_posts', array(
            'clw-posts-standard.php' => __("Standard", "gd-clever-widgets"),
            'clw-posts-modern.php' => __("Modern", "gd-clever-widgets"),
            'clw-posts-minimal.php' => __("Minimal", "gd-clever-widgets"),
            'clw-posts-full.php' => __("Full Content", "gd-clever-widgets"),
            'clw-posts-thumbnail.php' => __("Featured Image", "gd-clever-widgets")
        ));

        $this->authors = apply_filters('gdclw_templates_authors', array(
            'clw-authors-standard.php' => __("Standard", "gd-clever-widgets")
        ));
    }
}
