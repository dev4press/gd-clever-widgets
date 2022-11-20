<?php

global $wp_roles;
$list = array(
    array('title' => __("Global", "gd-clever-widgets"), 
          'values' => array('all' => __("Everyone", "gd-clever-widgets"), 'visitor' => __("Only Visitors", "gd-clever-widgets"), 'user' => __("All Users", "gd-clever-widgets"))),
    array('title' => __("User Roles", "gd-clever-widgets"), 
          'values' => array())
);

foreach ($wp_roles->role_names as $role => $title) {
    $list[1]['values']['role:'.$role] = $title;
}

?>

<h4><?php _e("Extras", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-singular" colspan="2">
                <label for="<?php echo $this->get_field_id('_class'); ?>"><?php _e("Additional CSS Class", "gd-clever-widgets"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('_class'); ?>" name="<?php echo $this->get_field_name('_class'); ?>" type="text" value="<?php echo esc_attr($instance['_class']); ?>" />
            </td>
        </tr>
    </tbody>
</table>
