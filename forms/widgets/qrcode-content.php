<?php

$methods = array(
    'text' => __("Text", "gd-clever-widgets"),
    'current_url' => __("Current URL", "gd-clever-widgets"),
    'url' => __("Custom URL", "gd-clever-widgets"),
    'feed' => __("RSS Feed URL", "gd-clever-widgets"),
    'skype' => __("Skype", "gd-clever-widgets"),
    'email' => __("Email", "gd-clever-widgets"),
    'email_msg' => __("Email Message", "gd-clever-widgets"),
    'sms_msg' => __("SMS Message", "gd-clever-widgets"),
    'phone' => __("Phone Number", "gd-clever-widgets"),
    'geo' => __("GEO Location", "gd-clever-widgets"),
    'wifi' => __("WiFi Connection", "gd-clever-widgets"),
    'vcard' => __("vCard Information", "gd-clever-widgets")
);

$wifi_encryption = array(
    '' => __("No Encryption", "gd-clever-widgets"),
    'WEP' => 'WEP',
    'WPA' => 'WPA/WPA2'
);

$_method = $instance['method'];

?>

<h4><?php _e("Select Content to Encode to QR Code", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('method'); ?>"><?php _e("Content to Encode", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select($methods, array('selected' => $instance['method'], 'class' => 'widefat d4plib-div-switch', 'name' => $this->get_field_name('method'), 'id' => $this->get_field_id('method'))); ?>
            </td>
            <td class="cell-right">
                <em>
                    <?php _e("Some formats for QR Codes are not supported by all QR code scanning apps, mostly affecting older apps and devices.", "gd-clever-widgets"); ?>
                </em>
            </td>
        </tr>
    </tbody>
</table>

<div class="d4p-div-block d4p-div-block-text" style="display: <?php echo $_method == 'text' ? 'block' : 'none'; ?>;">
    <h4><?php _e("Content", "gd-clever-widgets"); ?>: <?php _e("Text", "gd-clever-widgets"); ?></h4>

    <table>
        <tbody>
            <tr>
                <td class="cell-singular">
                    <label for="<?php echo $this->get_field_id('text_text'); ?>"><?php _e("Custom Text", "gd-clever-widgets"); ?>:</label>
                    <textarea id="<?php echo $this->get_field_id('text_text'); ?>" name="<?php echo $this->get_field_name('text_text'); ?>"><?php echo $instance['text_text']; ?></textarea>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="d4p-div-block d4p-div-block-current_url" style="display: <?php echo $_method == 'current_url' ? 'block' : 'none'; ?>;">
    <h4><?php _e("Content", "gd-clever-widgets"); ?>: <?php _e("Current URL", "gd-clever-widgets"); ?></h4>

    <table>
        <tbody>
            <tr>
                <td class="cell-singular">
                    <?php _e("Widget will use URL of the page it is own to generate QR Code.", "gd-clever-widgets"); ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="d4p-div-block d4p-div-block-url" style="display: <?php echo $_method == 'url' ? 'block' : 'none'; ?>;">
    <h4><?php _e("Content", "gd-clever-widgets"); ?>: <?php _e("URL", "gd-clever-widgets"); ?></h4>

    <table>
        <tbody>
            <tr>
                <td class="cell-singular">
                    <label for="<?php echo $this->get_field_id('url_url'); ?>"><?php _e("Custom URL", "gd-clever-widgets"); ?>:</label>
                    <input class="widefat" id="<?php echo $this->get_field_id('url_url'); ?>" name="<?php echo $this->get_field_name('url_url'); ?>" type="url" placeholder="https://" value="<?php echo $instance['url_url']; ?>" />
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="d4p-div-block d4p-div-block-email" style="display: <?php echo $_method == 'email' ? 'block' : 'none'; ?>;">
    <h4><?php _e("Content", "gd-clever-widgets"); ?>: <?php _e("Email", "gd-clever-widgets"); ?></h4>

    <table>
        <tbody>
            <tr>
                <td class="cell-singular">
                    <label for="<?php echo $this->get_field_id('email_email'); ?>"><?php _e("Email", "gd-clever-widgets"); ?>:</label>
                    <input class="widefat" id="<?php echo $this->get_field_id('email_email'); ?>" name="<?php echo $this->get_field_name('email_email'); ?>" type="email" value="<?php echo $instance['email_email']; ?>" />
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="d4p-div-block d4p-div-block-phone" style="display: <?php echo $_method == 'phone' ? 'block' : 'none'; ?>;">
    <h4><?php _e("Content", "gd-clever-widgets"); ?>: <?php _e("Phone", "gd-clever-widgets"); ?></h4>

    <table>
        <tbody>
            <tr>
                <td class="cell-singular">
                    <label for="<?php echo $this->get_field_id('phone_number'); ?>"><?php _e("Phone Number", "gd-clever-widgets"); ?>:</label>
                    <input class="widefat" id="<?php echo $this->get_field_id('phone_number'); ?>" name="<?php echo $this->get_field_name('phone_number'); ?>" type="text" value="<?php echo $instance['phone_number']; ?>" />
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="d4p-div-block d4p-div-block-email_msg" style="display: <?php echo $_method == 'email_msg' ? 'block' : 'none'; ?>;">
    <h4><?php _e("Content", "gd-clever-widgets"); ?>: <?php _e("Email Message", "gd-clever-widgets"); ?></h4>

    <table>
        <tbody>
            <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('email_msg_to'); ?>"><?php _e("Email", "gd-clever-widgets"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('email_msg_to'); ?>" name="<?php echo $this->get_field_name('email_msg_to'); ?>" type="email" value="<?php echo $instance['email_msg_to']; ?>" />
            </td>
            <td class="cell-right">
                <label for="<?php echo $this->get_field_id('email_msg_sub'); ?>"><?php _e("Subject", "gd-clever-widgets"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('email_msg_sub'); ?>" name="<?php echo $this->get_field_name('email_msg_sub'); ?>" type="text" value="<?php echo $instance['email_msg_sub']; ?>" />
            </td>
        </tr>
        <tr>
            <td class="cell-singular" colspan="2">
                <label for="<?php echo $this->get_field_id('email_msg_body'); ?>"><?php _e("Message Text", "gd-clever-widgets"); ?>:</label>
                <textarea id="<?php echo $this->get_field_id('email_msg_body'); ?>" name="<?php echo $this->get_field_name('email_msg_body'); ?>"><?php echo $instance['email_msg_body']; ?></textarea>
            </td>
        </tr>
        </tbody>
    </table>
</div>

<div class="d4p-div-block d4p-div-block-skype" style="display: <?php echo $_method == 'skype' ? 'block' : 'none'; ?>;">
    <h4><?php _e("Content", "gd-clever-widgets"); ?>: <?php _e("Skype", "gd-clever-widgets"); ?></h4>

    <table>
        <tbody>
            <tr>
                <td class="cell-singular">
                    <label for="<?php echo $this->get_field_id('skype_name'); ?>"><?php _e("Skype Username or Number", "gd-clever-widgets"); ?>:</label>
                    <input class="widefat" id="<?php echo $this->get_field_id('skype_name'); ?>" name="<?php echo $this->get_field_name('skype_name'); ?>" type="text" value="<?php echo $instance['skype_name']; ?>" />
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="d4p-div-block d4p-div-block-feed" style="display: <?php echo $_method == 'feed' ? 'block' : 'none'; ?>;">
    <h4><?php _e("Content", "gd-clever-widgets"); ?>: <?php _e("RSS Feed URL", "gd-clever-widgets"); ?></h4>

    <table>
        <tbody>
            <tr>
                <td class="cell-singular">
                    <label for="<?php echo $this->get_field_id('feed_url'); ?>"><?php _e("RSS Feed URL", "gd-clever-widgets"); ?>:</label>
                    <input class="widefat" id="<?php echo $this->get_field_id('feed_url'); ?>" name="<?php echo $this->get_field_name('feed_url'); ?>" type="url" placeholder="https://" value="<?php echo $instance['feed_url']; ?>" />
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="d4p-div-block d4p-div-block-geo" style="display: <?php echo $_method == 'geo' ? 'block' : 'none'; ?>;">
    <h4><?php _e("Content", "gd-clever-widgets"); ?>: <?php _e("GEO Location", "gd-clever-widgets"); ?></h4>

    <table>
        <tbody>
            <tr>
                <td class="cell-left">
                    <label for="<?php echo $this->get_field_id('geo_latitude'); ?>"><?php _e("Latitude", "gd-clever-widgets"); ?>:</label>
                    <input class="widefat" id="<?php echo $this->get_field_id('geo_latitude'); ?>" name="<?php echo $this->get_field_name('geo_latitude'); ?>" type="text" value="<?php echo $instance['geo_latitude']; ?>" />
                </td>
                <td class="cell-right">
                    <label for="<?php echo $this->get_field_id('geo_longitude'); ?>"><?php _e("Longitude", "gd-clever-widgets"); ?>:</label>
                    <input class="widefat" id="<?php echo $this->get_field_id('geo_longitude'); ?>" name="<?php echo $this->get_field_name('geo_longitude'); ?>" type="text" value="<?php echo $instance['geo_longitude']; ?>" />
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="d4p-div-block d4p-div-block-sms_msg" style="display: <?php echo $_method == 'sms_msg' ? 'block' : 'none'; ?>;">
    <h4><?php _e("Content", "gd-clever-widgets"); ?>: <?php _e("SMS Message", "gd-clever-widgets"); ?></h4>

    <table>
        <tbody>
            <tr>
                <td class="cell-singular">
                    <label for="<?php echo $this->get_field_id('sms_msg_phone'); ?>"><?php _e("Phone Number", "gd-clever-widgets"); ?>:</label>
                    <input class="widefat" id="<?php echo $this->get_field_id('sms_msg_phone'); ?>" name="<?php echo $this->get_field_name('sms_msg_phone'); ?>" type="text" value="<?php echo $instance['sms_msg_phone']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="cell-singular">
                    <label for="<?php echo $this->get_field_id('sms_msg_subject'); ?>"><?php _e("Message Text", "gd-clever-widgets"); ?>:</label>
                    <textarea id="<?php echo $this->get_field_id('sms_msg_subject'); ?>" name="<?php echo $this->get_field_name('sms_msg_subject'); ?>"><?php echo $instance['sms_msg_subject']; ?></textarea>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="d4p-div-block d4p-div-block-wifi" style="display: <?php echo $_method == 'wifi' ? 'block' : 'none'; ?>;">
    <h4><?php _e("Content", "gd-clever-widgets"); ?>: <?php _e("WiFi Connection", "gd-clever-widgets"); ?></h4>

    <table>
        <tbody>
            <tr>
                <td class="cell-singular" colspan="2">
                    <label for="<?php echo $this->get_field_id('wifi_s'); ?>"><?php _e("SSID", "gd-clever-widgets"); ?>:</label>
                    <input class="widefat" id="<?php echo $this->get_field_id('wifi_s'); ?>" name="<?php echo $this->get_field_name('wifi_s'); ?>" type="text" value="<?php echo $instance['wifi_s']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="cell-left">
                    <label for="<?php echo $this->get_field_id('wifi_p'); ?>"><?php _e("Password", "gd-clever-widgets"); ?>:</label>
                    <input class="widefat" id="<?php echo $this->get_field_id('wifi_p'); ?>" name="<?php echo $this->get_field_name('wifi_p'); ?>" type="text" value="<?php echo $instance['wifi_p']; ?>" />
                </td>
                <td class="cell-right">
                    <label for="<?php echo $this->get_field_id('wifi_t'); ?>"><?php _e("Encryption", "gd-clever-widgets"); ?>:</label>
                    <?php d4p_render_select($wifi_encryption, array('selected' => $instance['wifi_t'], 'class' => 'widefat', 'name' => $this->get_field_name('wifi_t'), 'id' => $this->get_field_id('wifi_t'))); ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="d4p-div-block d4p-div-block-vcard" style="display: <?php echo $_method == 'vcard' ? 'block' : 'none'; ?>;">
    <h4><?php _e("Content", "gd-clever-widgets"); ?>: <?php _e("vCard Information", "gd-clever-widgets"); ?></h4>

    <table>
        <tbody>
            <tr>
                <td class="cell-left">
                    <label for="<?php echo $this->get_field_id('vcard_n'); ?>"><?php _e("Name", "gd-clever-widgets"); ?>:</label>
                    <input class="widefat" id="<?php echo $this->get_field_id('vcard_n'); ?>" name="<?php echo $this->get_field_name('vcard_n'); ?>" type="text" value="<?php echo $instance['vcard_n']; ?>" />
                </td>
                <td class="cell-right">
                    <label for="<?php echo $this->get_field_id('vcard_org'); ?>"><?php _e("Company", "gd-clever-widgets"); ?>:</label>
                    <input class="widefat" id="<?php echo $this->get_field_id('vcard_org'); ?>" name="<?php echo $this->get_field_name('vcard_org'); ?>" type="text" value="<?php echo $instance['vcard_org']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="cell-left">
                    <label for="<?php echo $this->get_field_id('vcard_title'); ?>"><?php _e("Title", "gd-clever-widgets"); ?>:</label>
                    <input class="widefat" id="<?php echo $this->get_field_id('vcard_title'); ?>" name="<?php echo $this->get_field_name('vcard_title'); ?>" type="text" value="<?php echo $instance['vcard_title']; ?>" />
                </td>
                <td class="cell-right">
                    <label for="<?php echo $this->get_field_id('vcard_tel'); ?>"><?php _e("Phone", "gd-clever-widgets"); ?>:</label>
                    <input class="widefat" id="<?php echo $this->get_field_id('vcard_tel'); ?>" name="<?php echo $this->get_field_name('vcard_tel'); ?>" type="text" value="<?php echo $instance['vcard_tel']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="cell-left">
                    <label for="<?php echo $this->get_field_id('vcard_url'); ?>"><?php _e("URL", "gd-clever-widgets"); ?>:</label>
                    <input class="widefat" id="<?php echo $this->get_field_id('vcard_url'); ?>" name="<?php echo $this->get_field_name('vcard_url'); ?>" type="text" value="<?php echo $instance['vcard_url']; ?>" />
                </td>
                <td class="cell-right">
                    <label for="<?php echo $this->get_field_id('vcard_email'); ?>"><?php _e("Email", "gd-clever-widgets"); ?>:</label>
                    <input class="widefat" id="<?php echo $this->get_field_id('vcard_email'); ?>" name="<?php echo $this->get_field_name('vcard_email'); ?>" type="text" value="<?php echo $instance['vcard_email']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="cell-left">
                    <label for="<?php echo $this->get_field_id('vcard_adr'); ?>"><?php _e("Address", "gd-clever-widgets"); ?>:</label>
                    <input class="widefat" id="<?php echo $this->get_field_id('vcard_adr'); ?>" name="<?php echo $this->get_field_name('vcard_adr'); ?>" type="text" value="<?php echo $instance['vcard_adr']; ?>" />
                </td>
                <td class="cell-right">
                    <label for="<?php echo $this->get_field_id('vcard_note'); ?>"><?php _e("Note", "gd-clever-widgets"); ?>:</label>
                    <input class="widefat" id="<?php echo $this->get_field_id('vcard_note'); ?>" name="<?php echo $this->get_field_name('vcard_note'); ?>" type="text" value="<?php echo $instance['vcard_note']; ?>" />
                </td>
            </tr>
        </tbody>
    </table>
</div>
