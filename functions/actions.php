<?php
	add_action( 'wp_footer','apply_front_colors',99999);
    
    function apply_front_colors(){
        if(is_admin())
        return;
        (new \EZPZ_TWEAKS\Engine\Features\Dashboard_Colors)->apply_admin_colors();
    }
    
    add_action('admin_footer',function(){
        if(isset($_GET['page']) and $_GET['page']=='wpezpz-tweaks'){
        ?>
        <script>
            jQuery(document).ready(function($){
                
                $('select[name="role"]').select2();
                
                $('ul.wp-tab-bar li a').click(function(){
                    if($('ul.wp-tab-bar li a').index(this)<3){
                        $('.ezpz_option_user').show();
                        setTimeout(function(){
                            tab = new URLSearchParams(window.location.href).get('tab');console.log(tab);
                            if(tab){
                                $('.ezpz_option_user').attr('form','wpezpz-tweaks_options_'+tab);
                                $('[name="ezpz_nonce"]').attr('form','wpezpz-tweaks_options_'+tab);                                
                            }
                        }, 1000);
                    }else
                        $('.ezpz_option_user').hide();
                });

                $('.ezpz_option_user').change(function(){
                    $('<form method="post"><input type="text" name="ezpz_option_user" value="'+$(this).val()+'"/></form>').appendTo('body').submit();
                });
            });
        </script>
        <?php
        }
        if($widgets = get_option('wpezpz_dashboard_widgets'))
        return;
        include_once(ABSPATH.'/wp-admin/includes/dashboard.php');
        @wp_dashboard_setup();
        global $wp_meta_boxes;
        $widgets = array_merge($wp_meta_boxes['plugins']['normal']['core'],$wp_meta_boxes['plugins']['side']['core']);
        update_option('wpezpz_dashboard_widgets', $widgets);
    });

    if(is_admin() and isset($_GET['page']) and $_GET['page']=='wpezpz-tweaks'){
        add_filter("cmb2_types_esc_select2",'cmb2_types_esc_select2',10,4);
        add_filter("cmb2_types_esc_file",'cmb2_types_esc_select2',10,4);
        add_filter("cmb2_types_esc_textarea",'cmb2_types_esc_select2',10,4);
        add_filter("cmb2_types_esc_checkbox",'cmb2_types_esc_select2',10,4);
        add_filter("cmb2_types_esc_select2multiple",'cmb2_types_esc_code_editor',10,4);
        add_filter("cmb2_types_esc_wysiwyg",'cmb2_types_esc_select2',10,4);
        add_filter("cmb2_types_esc_colorpicker",'cmb2_types_esc_colorpicker',10,4);
        add_filter("cmb2_types_esc_code-editor",'cmb2_types_esc_code_editor',10,4);
        add_filter("cmb2_types_esc_radio",'cmb2_types_esc_select2',10,4);
        add_filter("cmb2_types_esc_text",'cmb2_types_esc_select2',10,4);
    }

    function cmb2_types_esc_select2($i, $meta_value, $args, $cmb2_field){
        
        $tab = $args['render_row_cb'][0]->object_id;
        $len = strlen(EZPZ_TWEAKS_TEXTDOMAIN)+1;
        $tab = substr($tab,$len);
        $opt = expz_admin_settings($tab);
        //if(empty($opt))
        //return $meta_value;

        return empty($opt[$args['_name']])?'':esc_attr($opt[$args['_name']]);
    }

    function cmb2_types_esc_code_editor($i, $meta_value, $args, $cmb2_field){
        $tab = $args['render_row_cb'][0]->object_id;
        $len = strlen(EZPZ_TWEAKS_TEXTDOMAIN)+1;
        $tab = substr($tab,$len);
        $opt = expz_admin_settings($tab);
        $val = (isset($opt[$args['_name']]))?$opt[$args['_name']]:$meta_value;
        return $val;
    }
    
    function cmb2_types_esc_colorpicker($i, $meta_value, $args, $cmb2_field){
        $DEFAULT_COLORS = [
            'admin_colors__base'         => '#1d2327',
            'admin_colors__text'         => '#f0f0f1',
            'admin_colors__icon'         => '#f0f6fc99',
            'admin_colors__highlight'    => '#2271b1',
            'admin_colors__notification' => '#d63638',
        ];
        $tab = $args['render_row_cb'][0]->object_id;
        $len = strlen(EZPZ_TWEAKS_TEXTDOMAIN)+1;
        $tab = substr($tab,$len);
        $opt = expz_admin_settings($tab);
        if(empty($opt) or empty($opt[$args['_name']]))
        return $DEFAULT_COLORS[$args['_name']];
        return esc_attr($opt[$args['_name']]);
    }
?>