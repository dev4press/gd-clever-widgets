<?php

if (!defined('ABSPATH')) { exit; }

d4p_include('functions', 'admin', GDCLW_D4PLIB);
require(GDCLW_PATH.'d4punits/d4p.units.php');

$list_types = array();
$units_list = array();

$instance['units'] = (array)$instance['units'];

foreach ($instance['units'] as $key) {
    gdclw_plugin()->converter_load_unit($key);

    if (d4p_units()->is_loaded($key)) {
        $list_types[$key] = d4p_units()->units[$key]['name'];
    }
}

$classes = array('gd-clever-widget', 'clw-units-converter', $instance['_style']);

if ($instance['_class'] != '') {
    $classes[] = $instance['_class'];
}

?>
<div class="<?php echo join(' ', $classes); ?>" id="clw-<?php echo $_ID; ?>">
    <?php 

    if ($instance['before'] != '') {
        echo '<div class="clw-before">'.$instance['before'].'</div>';
    }

    ?>

    <div class="clw-converter-wrapper">
        <?php

        if (count($instance['units']) == 1) {
            echo '<input type="hidden" class="clw-converter-type" value="'.$instance['units'][0].'" data-key="type" />';
        } else {
            d4p_render_select($list_types, array('class' => 'clw-converter-type'), array('data-key' => 'type', 'title' => __("Coversion data source", "gd-clever-widgets")));
        }

        ?>
        <input type="number" class="clw-converter-input clw-input-number" value="1" data-key="input" title="<?php _e("Source value", "gd-clever-widgets"); ?>" />
        <?php d4p_render_select($units_list, array('class' => 'clw-converter-from'), array('data-key' => 'from', 'title' => __("Source currency", "gd-clever-widgets"))); ?>
        <div class="clw-middle">
            <div class="clw-middle-to"><?php echo $instance['string_to']; ?></div>
            <div class="clw-middle-replace"><?php echo $instance['string_replace']; ?></div>
        </div>
        <?php d4p_render_select($units_list, array('class' => 'clw-converter-to'), array('data-key' => 'to', 'title' => __("Target currency", "gd-clever-widgets"))); ?>
        <div class="clw-converter-output" data-key="output" title="<?php _e("Converted value", "gd-clever-widgets"); ?>">1</div>
    </div>

    <?php 

    if ($instance['after'] != '') {
        echo '<div class="clw-after">'.$instance['after'].'</div>';
    }

    ?>
</div>