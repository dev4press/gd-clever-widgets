<?php

if (!defined('ABSPATH')) { exit; }

class gdclw_qrcode_obj {
    public $count = 0;

    public $d_args = array();
    public $d_extra = array();

    public $text = '';
    public $title = '';

    public function __construct() {
        wp_enqueue_script('gdclw-qrcode');
    }

    public static function instance() {
        static $qr_code = null;

        if (is_null($qr_code)) {
            $qr_code = new gdclw_qrcode_obj();
        }

        return $qr_code;
    }

    public function render($method = 'text', $data = 'smart-qr-codes-generator', $args = array()) {
        $this->count++;

        $args = wp_parse_args($args, array(
            'render' => 'image',
            'size' => 200,
            'fill' => '#000000',
            'background' => '#ffffff',
            'transparent' => 'no',
            'ecLevel' => 'H',
            'radius' => 0,
            'quiet' => 2,
            'minVersion' => 1,
            'maxVersion' => 40
        ));

        $args['text'] = $this->text($method, $data);
        $args['radius'] = $args['radius'] * .01;

        if ($args['transparent'] == 'yes') {
            $args['background'] = null;

            unset($args['transparent']);
        }

        $class = trim('clw-qrcode-container');

        $render = '<div id="'.$this->id().'" class="'.$class.'"></div>'.D4P_EOL;

        $json_args = json_encode($args);

        $render.= '<script type="text/javascript">'.D4P_EOL;
        $render.= 'jQuery(document).ready(function() {'.D4P_EOL;
        $render.= 'jQuery("#'.$this->id().'").qrcode('.$json_args.');'.D4P_EOL;
        $render.= '});'.D4P_EOL;
        $render.= '</script>'.D4P_EOL;

        return $render;
    }
    
    private function id() {
        return 'clw-container-'.$this->count;
    }

    private function text($method = 'text', $data = null) {
        $title = ''; $text = ''; $render = '';

        switch ($method) {
            default:
            case 'text':
                $title = __("Text", "gd-clever-widgets");
                $text = $data;

                $render = $data;
                break;
            case 'url':
                $title = __("URL", "gd-clever-widgets");
                $text = '<a href="'.$data.'" rel="nofollow">'.$data.'</a>';

                $render = $data;
                break;
            case 'email':
                $title = __("Email", "gd-clever-widgets");
                $text = '<a href="mailto:'.$data.'" rel="nofollow">'.$data.'</a>';

                $render = 'MAILTO:'.$data;
                break;
            case 'skype':
                $title = __("Skype Username", "gd-clever-widgets");
                $text = $data;

                $render = 'SKYPE:'.$data;
                break;
            case 'feed':
                $title = __("RSS Feed", "gd-clever-widgets");
                $text = '<a href="'.$data.'" rel="nofollow">'.$data.'</a>';

                $render = 'FEED:'.$data;
                break;
            case 'phone':
                $title = __("Phone Number", "gd-clever-widgets");
                $text = $data;

                $render = 'TEL:'.$data;
                break;
            case 'sms_msg':
                $title = __("SMS Message", "gd-clever-widgets");
                $text = $data['phone'].'<br/>'.$data['subject'];

                $render = 'SMSTO:'.$data['phone'].':'.$data['subject'];
                break;
            case 'geo':
                $title = __("Map Location", "gd-clever-widgets");
                $text = '<a href="http://www.google.com/maps/place/'.$data['latitude'].','.$data['longitude'].'" rel="nofollow">'.$data['latitude'].','.$data['longitude'].'</a>';

                $render = 'GEO:'.$data['latitude'].','.$data['longitude'];
                break;
            case 'vcard':
                $list = array_values(array_filter($data));

                $title = __("Contact Information", "gd-clever-widgets");
                $text = '<ul><li>'.join('</li><li>', $list).'</li></ul>';
                
                $render = $this->_vcard($data);
                break;
            case 'wifi':
                $list = array_values($data);

                $title = __("WiFi Access", "gd-clever-widgets");
                $text = '<ul>';
                $text.= '<li>SSID: '.$data['s'].'</li>';

                if ($data['p'] != '') {
                    $text.= '<li>'.__("Password", "gd-clever-widgets").': '.$data['p'].'</li>';
                }

                if ($data['t'] != '') {
                    $text.= '<li>'.__("Encryption", "gd-clever-widgets").': '.$data['t'].'</li>';
                }

                $text.= '</ul>';
                
                $render = $this->_wifi($data);
                break;
            case 'email_msg':
                $title = __("Email Message", "gd-clever-widgets");
                $text = $data['to'].'<br/>'.$data['sub'].'<br/>'.$data['body'];

                $render = 'MATMSG:TO:'.$data['to'].';SUB:'.$data['sub'].';BODY:'.$data['body'].';;';
                break;
            case 'current_url':
                $url = d4p_current_url();

                $title = __("Current Page URL", "gd-clever-widgets");
                $text = '<a href="'.$url.'" rel="nofollow">'.$url.'</a>';

                $render = $url;
                break;
        }

        $this->title = apply_filters('clw_qrcode_render_display_title', $title, $method, $data);
        $this->text = apply_filters('clw_qrcode_render_display_text', $text, $method, $data);

        return $render;
    }

    private function _wifi($data) {
        $list = array('WIFI:');

        foreach ($data as $key => $value) {
            $list[] = strtoupper($key).':'.$value.';';
        }

        return join('', $list).';';
    }

    private function _vcard($data) {
        $list = array(
            'BEGIN:VCARD',
            'VERSION:3.0'
        );

        foreach ($data as $key => $value) {
            $list[] = strtoupper($key).':'.$value;
        }

        $list[] = 'END:VCARD';

        return join(D4P_EOL, $list);
    }
}
