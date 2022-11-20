<?php

if (!defined('ABSPATH')) { exit; }

class gdclw_core_plugin extends d4p_plugin_core {
    public $plugin = 'gd-clever-widgets';

    private $_enqueued = false;
    private $_js_data = array();

    public $styles;
    public $templates;
    public $loaded_units = array();
    public $navigator = array(
        'page' => '',
        'url' => '',
        'static' => false
    );

    public $wp_widgets = array(
        'disable_wp_calendar' => 'WP_Widget_Calendar',
        'disable_wp_posts' => 'WP_Widget_Recent_Posts',
        'disable_wp_cloud' => 'WP_Widget_Tag_Cloud',
        'disable_wp_meta' => 'WP_Widget_Meta',
        'disable_wp_text' => 'WP_Widget_Text'
    );

    public $widgets = array(
        'enhanced-text' => 'd4pclwWidget_Enhanced_Text',
        'enhanced-posts' => 'd4pclwWidget_Enhanced_Posts',
        'enhanced-calendar' => 'd4pclwWidget_Enhanced_Calendar',
        'enhanced-cloud' => 'd4pclwWidget_Enhanced_Cloud',
        'enhanced-meta' => 'd4pclwWidget_Enhanced_Meta',
        'featured-post' => 'd4pclwWidget_Featured_Post',
        'posts-authors' => 'd4pclwWidget_Posts_Authors',
        'author-information' => 'd4pclwWidget_Author_Information',
        'related-posts' => 'd4pclwWidget_Related_Posts',
        'navigator-date' => 'd4pclwWidget_Navigator_Date',
        'navigator-menu' => 'd4pclwWidget_Navigator_Menu',
        'navigator-pages' => 'd4pclwWidget_Navigator_Pages',
        'navigator-terms' => 'd4pclwWidget_Navigator_Terms',
        'currency-exchange' => 'd4pclwWidget_Currency_Exchange',
        'units-converter' => 'd4pclwWidget_Units_Converter',
        'videos-playlist' => 'd4pclwWidget_Videos_Playlist',
        'qr-code' => 'd4pclwWidget_QR_Code'
    );

    public $is_debug;
    public $wp_version;

    function __construct() {
        parent::__construct();

        $this->styles = new gdclw_core_styles();
        $this->templates = new gdclw_core_templates();

        $this->url = GDCLW_URL;
    }

    public function plugins_loaded() {
        parent::plugins_loaded();

        define('GDCLW_WPV', intval($this->wp_version));
        define('GDCLW_WPV_MAJOR', substr($this->wp_version, 0, 3));

        if (GDCLW_WPV < 46) {
            add_action('admin_notices', array($this, 'system_requirements_problem'));
        }

        add_action('wp_head', array($this, 'javascript_settings'));
	    add_action('init', array($this, 'register_css_and_js'));

        do_action('gdclw_load_settings');

        do_action('gdclw_plugin_init');
    }

    public function system_requirements_problem() {
        ?>

        <div class="notice notice-error">
            <p><?php echo sprintf(__("GD Clever Widgets Pro requires WordPress %s or newer. Plugin will now be disabled. To use this plugin, upgrade WordPress to %s or newer version.", "gd-clever-widgets"), '4.5', '4.5'); ?></p>
        </div>

        <?php

	    deactivate_plugins('gd-clever-widgets/gd-clever-widgets.php', false, false);
    }

    public function register_css_and_js() {
	    wp_register_style('gdclw-frontend', $this->file('css', 'frontend'), array(), gdclw_settings()->info_version);

	    wp_register_script('d4plib-cookies', GDCLW_URL.'d4plib/resources/libraries/cookies.min.js', array(), D4P_VERSION, true);
	    wp_register_script('d4plib-select', GDCLW_URL.'d4plib/resources/libraries/jquery.select.min.js', array('jquery'), D4P_VERSION, true);
	    wp_register_script('gdclw-frontend', ($this->is_debug ? GDCLW_URL.'js/frontend.js' : GDCLW_URL.'js/frontend.min.js'), array('jquery', 'd4plib-cookies', 'd4plib-select'), gdclw_settings()->info_version, true);
	    wp_register_script('gdclw-qrcode', GDCLW_URL.'d4pjs/qrcode/qrcode.min.js', array('jquery'), gdclw_settings()->info_version, true);
    }

	public function load_js() {
		add_action( 'wp_footer', array( $this, 'actual_load_js' ) );
	}

	public function actual_load_js() {
        wp_enqueue_script('gdclw-frontend');

        if (!$this->_enqueued) {
	        wp_localize_script( 'gdclw-frontend', 'gdclw_data', $this->_js_data );

	        $this->_enqueued = true;
        }
	}

    public function load_css() {
	    wp_enqueue_style('gdclw-frontend');
    }

    public function widgets_init() {
        foreach ($this->widgets as $folder => $widget) {
            if (gdclw_settings()->get($folder, 'widgets')) {
                require_once(GDCLW_PATH.'widgets/'.$folder.'.php');

                register_widget($widget);
            }
        }

        foreach ($this->wp_widgets as $option => $widget) {
            if (gdclw_settings()->get($option, 'widgets')) {
                unregister_widget($widget);
            }
        }
    }

    public function javascript_settings() {
        global $wp_query;

        if (is_date()) {
            if (is_year()) {
                $this->navigator['page'] = $wp_query->query_vars['year'];
                $this->navigator['url'] = get_year_link($wp_query->query_vars['year']);
            } else if (is_month()) {
                $this->navigator['page'] = $wp_query->query_vars['year'].'-'.str_pad($wp_query->query_vars['monthnum'], 2, '0', STR_PAD_LEFT);
                $this->navigator['url'] = get_month_link($wp_query->query_vars['year'], $wp_query->query_vars['monthnum']);
            } else if (is_day()) {
                $this->navigator['page'] = $wp_query->query_vars['year'].'-'.str_pad($wp_query->query_vars['monthnum'], 2, '0', STR_PAD_LEFT).'-'.str_pad($wp_query->query_vars['day'], 2, '0', STR_PAD_LEFT);
                $this->navigator['url'] = get_day_link($wp_query->query_vars['year'], $wp_query->query_vars['monthnum'], $wp_query->query_vars['day']);
            }
        } else if (is_singular()) {
            $this->navigator['page'] = 'post-'.$wp_query->queried_object->ID;
            $this->navigator['url'] = get_permalink($wp_query->queried_object->ID);
        } else if (is_tax() || is_category() || is_tag()) {
            $this->navigator['page'] = 'term-'.$wp_query->queried_object->term_id;
            $this->navigator['url'] = get_term_link($wp_query->queried_object);
        }

        $this->navigator['static'] = gdclw_settings()->navigator_ajax_website_active;

        $this->navigator = apply_filters('gdclw_settings_current_page', $this->navigator);

        $this->_js_data = array(
            'ajax' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('gd-clever-widgets'),
            'modules' => array(
                'converter' => false,
                'navigator' => true
            ),
            'converter' => array(
                'cookie_prefix' => 'gdclw-memory-',
                'units' => array()
            ),
            'navigator' => array(
                'static' => $this->navigator['static'],
                'page' => $this->navigator['page'],
                'url' => $this->navigator['url'],
            )
        );
    }

    public function converter_load_unit($unit) {
        switch ($unit) {
            case 'currency_google':
                d4p_units()->load($unit, array(
                    'timeout' => gdclw_settings()->get('currency_google_timeout', 'converter') * 3600)
                );
                break;
            case 'currency_ecb':
                d4p_units()->load($unit, array(
                    'timeout' => gdclw_settings()->get('currency_ecb_timeout', 'converter') * 3600)
                );
                break;
            case 'currency_oer':
                if (gdclw_settings()->get('currency_oer_app_id', 'converter') != '') {
                    d4p_units()->load($unit, array(
                        'timeout' => gdclw_settings()->get('currency_oer_timeout', 'converter') * 3600,
                        'app_id' => gdclw_settings()->get('currency_oer_app_id', 'converter'),
                        'https' => gdclw_settings()->get('currency_oer_https', 'converter'))
                    );
                }
                break;
            default:
                d4p_units()->load($unit);
                break;
        }
    }

    public function converter_load_units($list) {
        require(GDCLW_PATH.'d4punits/d4p.units.php');

        if (empty($this->loaded_units)) {
            $this->_js_data['modules']['converter'] = true;
        }

        foreach ($list as $unit) {
            d4p_units()->load($unit);

            if (!in_array($unit, $this->loaded_units) && isset(d4p_units()->data[$unit])) {
                $this->converter_load_unit($unit);
                $this->_js_data['converter']['units'][$unit] = d4p_units()->data[$unit];

                $this->loaded_units[] = $unit;
            }
        }
    }

    public function select_yesno() {
        return array('yes' => __("Yes", "gd-clever-widgets"), 
                     'no' => __("No", "gd-clever-widgets"));
    }

    public function recommend($panel = 'update') {
        d4p_includes(array(
            array('name' => 'ip', 'directory' => 'classes'), 
            array('name' => 'four', 'directory' => 'classes')
        ), GDCLW_D4PLIB);

        $four = new d4p_core_four('plugin', 'gd-clever-widgets', gdclw_settings()->info_version, gdclw_settings()->info_build);
        $four->ad();

        return $four->ad_render($panel);
    }
}
