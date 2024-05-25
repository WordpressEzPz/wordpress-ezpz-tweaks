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
                            tab = (new URL(location.href)).searchParams.get('tab');
                            if(tab) 
                            $('.ezpz_option_user').attr('form','wpezpz-tweaks_options_'+tab);
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
?>