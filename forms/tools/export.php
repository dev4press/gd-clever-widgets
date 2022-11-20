<input type="hidden" value="<?php echo admin_url('options-general.php?page=gd-clever-widgets&panel=tools&gdclw_handler=getback&run=export&_ajax_nonce='.wp_create_nonce('dev4press-plugin-export')); ?>" id="gdclwtools-export-url" />

<div class="d4p-group d4p-group-export d4p-group-important">
    <h3><?php _e("Important", "gd-clever-widgets"); ?></h3>
    <div class="d4p-group-inner">
        <?php _e("With this tool you export all plugin settings into plain text file (JSON). Do not modify export file, any change you make can make it unusable.", "gd-clever-widgets"); ?><br/><br/>
        <?php _e("This will not export widgets added to any of the sidebars, only main plugin settings!", "gd-clever-widgets"); ?>
    </div>
</div>

<script type="text/javascript">
    ;(function($, window, document, undefined) {
        $("#gdclw-tool-export").click(function(e){
            e.preventDefault();

            window.location = $("#gdclwtools-export-url").val();
        });
    })(jQuery, window, document);
</script>