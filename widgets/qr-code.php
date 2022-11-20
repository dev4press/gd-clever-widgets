<?php

if (!defined('ABSPATH')) { exit; }

class d4pclwWidget_QR_Code extends d4p_widget_core {
    public $widget_base = 'd4p_clw_qrcode';
    public $widget_domain = 'd4pclw_widgets';
    public $cache_prefix = 'd4pclw';

    public $defaults = array(
        'title' => '',
        '_display' => 'all',
        '_hook' => '',
        '_cached' => 0,
        '_class' => '',
        '_tab' => 'global',
        '_style' => '',
        'textual' => 'yes',
        'size' => 400,
        'fill' => '#000000',
        'background' => '#ffffff',
        'transparent' => 'no',
        'render' => 'image',
        'ecLevel' => 'M',
        'minVersion' => 1,
        'quiet' => 1,
        'radius' => 0,
        'method' => 'text',
        'text_text' => '',
        'url_url' => '',
        'email_email' => '',
        'email_msg_to' => '',
        'email_msg_sub' => '',
        'email_msg_body' => '',
        'phone_number' => '',
        'feed_url' => '',
        'sms_msg_phone' => '',
        'sms_msg_subject' => '',
        'geo_latitude' => '',
        'geo_longitude' => '',
        'wifi_s' => '',
        'wifi_t' => '',
        'wifi_p' => '',
        'skype_name' => '',
        'vcard_n' => '',
        'vcard_org' => '',
        'vcard_title' => '',
        'vcard_tel' => '',
        'vcard_url' => '',
        'vcard_email' => '',
        'vcard_adr' => '',
        'vcard_note' => '',
        'before' => '',
        'after' => ''
    );

    public function __construct($id_base = false, $name = '', $widget_options = array(), $control_options = array()) {
        $this->widget_description = __("QR Code for various content.", "gd-clever-widgets");
        $this->widget_name = __("Clever", "gd-clever-widgets").': '.__("QR Code", "gd-clever-widgets");

        parent::__construct($this->widget_base, $this->widget_name, array(), array('width' => 500));
    }

    public function get_tabkey($tab) {
        $key = $this->get_field_id('tab-'.$tab);

        return str_replace(array('_', ' '), array('-', '-'), $key);
    }

    public function form($instance) {
        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        $_tabs = array(
            'global' => array('name' => __("Global", "gd-clever-widgets"), 'include' => array('shared-global', 'shared-display')),
            'content' => array('name' => __("Content", "gd-clever-widgets"), 'include' => array('qrcode-content')),
            'display' => array('name' => __("Display", "gd-clever-widgets"), 'include' => array('qrcode-display')),
            'extra' => array('name' => __("Extra", "gd-clever-widgets"), 'include' => array('shared-wrapper'))
        );

        include(GDCLW_PATH.'forms/widgets/shared-loader.php');
    }

    public function update($new_instance, $old_instance) {
        d4p_include('functions', 'admin', GDCLW_D4PLIB);

        $instance = $old_instance;

        $instance['title'] = strip_tags(stripslashes($new_instance['title']));
        $instance['_display'] = strip_tags(stripslashes($new_instance['_display']));
        $instance['_class'] = strip_tags(stripslashes($new_instance['_class']));
        $instance['_hook'] = sanitize_key($new_instance['_hook']);
        $instance['_tab'] = strip_tags(stripslashes($new_instance['_tab']));

        $instance['size'] = intval(strip_tags(stripslashes($new_instance['size'])));
        $instance['minVersion'] = intval(strip_tags(stripslashes($new_instance['minVersion'])));
        $instance['quiet'] = intval(strip_tags(stripslashes($new_instance['quiet'])));
        $instance['radius'] = intval(strip_tags(stripslashes($new_instance['radius'])));

        $instance['ecLevel'] = strip_tags(stripslashes($new_instance['ecLevel']));
        $instance['method'] = strip_tags(stripslashes($new_instance['method']));
        $instance['textual'] = strip_tags(stripslashes($new_instance['textual']));
        $instance['render'] = strip_tags(stripslashes($new_instance['render']));
        $instance['fill'] = strip_tags(stripslashes($new_instance['fill']));
        $instance['background'] = strip_tags(stripslashes($new_instance['background']));
        $instance['transparent'] = strip_tags(stripslashes($new_instance['transparent']));

        $instance['vcard_n'] = strip_tags(stripslashes($new_instance['vcard_n']));
        $instance['vcard_org'] = strip_tags(stripslashes($new_instance['vcard_org']));
        $instance['vcard_title'] = strip_tags(stripslashes($new_instance['vcard_title']));
        $instance['vcard_tel'] = strip_tags(stripslashes($new_instance['vcard_tel']));
        $instance['vcard_url'] = strip_tags(stripslashes($new_instance['vcard_url']));
        $instance['vcard_email'] = strip_tags(stripslashes($new_instance['vcard_email']));
        $instance['vcard_adr'] = strip_tags(stripslashes($new_instance['vcard_adr']));
        $instance['vcard_note'] = strip_tags(stripslashes($new_instance['vcard_note']));

        $instance['text_text'] = strip_tags(stripslashes($new_instance['text_text']));
        $instance['url_url'] = strip_tags(stripslashes($new_instance['url_url']));
        $instance['email_email'] = strip_tags(stripslashes($new_instance['email_email']));
        $instance['email_msg_to'] = strip_tags(stripslashes($new_instance['email_msg_to']));
        $instance['email_msg_sub'] = strip_tags(stripslashes($new_instance['email_msg_sub']));
        $instance['email_msg_body'] = strip_tags(stripslashes($new_instance['email_msg_body']));
        $instance['phone_number'] = strip_tags(stripslashes($new_instance['phone_number']));
        $instance['feed_url'] = strip_tags(stripslashes($new_instance['feed_url']));
        $instance['sms_msg_phone'] = strip_tags(stripslashes($new_instance['sms_msg_phone']));
        $instance['sms_msg_subject'] = strip_tags(stripslashes($new_instance['sms_msg_subject']));
        $instance['geo_latitude'] = strip_tags(stripslashes($new_instance['geo_latitude']));
        $instance['geo_longitude'] = strip_tags(stripslashes($new_instance['geo_longitude']));
        $instance['skype_name'] = strip_tags(stripslashes($new_instance['skype_name']));
        $instance['wifi_s'] = strip_tags(stripslashes($new_instance['wifi_s']));
        $instance['wifi_t'] = strip_tags(stripslashes($new_instance['wifi_t']));
        $instance['wifi_p'] = strip_tags(stripslashes($new_instance['wifi_p']));

        if (current_user_can('unfiltered_html')) {
            $instance['before'] = $new_instance['before'];
            $instance['after'] = $new_instance['after'];
        } else {
            $instance['before'] = stripslashes(wp_filter_post_kses(addslashes($new_instance['before'])));
            $instance['after'] = stripslashes(wp_filter_post_kses(addslashes($new_instance['after'])));
        }

        return $instance;
    }

    public function render($results, $instance) {
        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        $atts = array();

        foreach (array('size', 'render', 'fill', 'background', 'transparent', 'ecLevel', 'radius', 'quiet', 'minVersion') as $key) {
            $atts[$key] = $instance[$key];
        }

        $data = array();
        $method = $instance['method'];

        if ($method == 'email') {
            $data['email'] = $instance['email_email'];
        } else {
            $method_length = strlen($method);

            foreach ($instance as $code => $value) {
                if (substr($code, 0, $method_length + 1) == $method.'_') {
                    $key = substr($code, $method_length + 1);
                    $data[$key] = $value;
                }
            }
        }

        if (count($data) == 1) {
            $data = reset($data);
        }

        echo gdclw_widget_render_header($instance, $this->widget_base, 'gdclw-qr-code');

        require_once(GDCLW_PATH.'core/code/qr.php');

        $qr = gdclw_qrcode_obj::instance();

        echo $qr->render($method, $data, $atts);

        if ($instance['textual'] == 'yes') {
            echo '<div class="clw-qrcode-textual">';
            echo '<h5>'.$qr->title.':</h5>';
            echo $qr->text;
            echo '</div>';
        }

        echo gdclw_widget_render_footer($instance);
    }

	public function widget( $args, $instance ) {
		parent::widget( $args, $instance );

		gdclw_plugin()->load_css();
    }
}
