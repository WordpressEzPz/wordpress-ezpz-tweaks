<?php
/**
 * EZPZ_TWEAKS
 *
 * @package   EZPZ_TWEAKS
 * @author    WP EzPz <info@wpezpzdev.com>
 * @license   GPL 2.0+
 * @link      https://wpezpzdev.com/
 */

/**
 * Get the settings of the plugin in a filterable way
 *
 * @since 1.0.0
 * @return array
 */
function ezpz_tweaks_get_settings(): array {
	return apply_filters( 'ezpz_tweaks_get_settings', get_option( EZPZ_TWEAKS_TEXTDOMAIN . '-settings' ) );
}

/**
 * @return array
 */
function ezpz_tweaks_wp_roles_array(): array {
	if ( ! function_exists( 'get_editable_roles' ) ) {
		require_once ABSPATH . 'wp-admin/includes/user.php';
	}

	$editable_roles = get_editable_roles();

	foreach ( $editable_roles as $role => $details ) {
		$roles[ esc_attr( $role ) ] = translate_user_role( $details['name'] );
	}

	return $roles;
}

function ezpz_tweaks_get_google_font_name( $font ) {
	$font 		 = str_replace( '+', ' ', $font );
	$font 		 = explode( ':', $font );
	
	return $font[0];
}

/**
 * Recursive sanitation for an array
 * 
 * @param $array
 *
 * @return mixed
 */
function ezpz_tweaks_recursive_sanitize( $array ) {
    foreach ( $array as $key => &$value ) {
        if ( is_array( $value ) ) {
            $value = ezpz_tweaks_recursive_sanitize( $value );
        } else {
            $value = sanitize_text_field( $value );
        }
    }

    return $array;
}

function ezpz_option_dropdown(){
    global $wp_roles;
    $select = empty($_POST['ezpz_option_user'])?'all':$_POST['ezpz_option_user'];
    $form   = 'wpezpz-tweaks_options_'.(empty($_GET['tab'])?'customizing-branding':$_GET['tab']);
    $out    = '<select name="ezpz_option_user" class="ezpz_option_user" form="'.$form.'" dir="'.(is_rtl()?'rtl':'ltr').'">
                <option value="all" '.($select=='all'?'selected="selected"':'').'>All</option>
                <optgroup label="Roles">';
    foreach($wp_roles->roles as $key=>$value){
        $out .="<option value='$key' ".($select==$key?'selected="selected"':'').">{$value['name']}</option>";
    }
    return $out.'
        </optgroup>    
    </select>';
}

function expz_user_settings($name,$default=[]){
    global $current_user;
    foreach($current_user->roles as $role){var_dump("$role-$name");
        if($opt = get_option("$role-$name",[]))
        return $opt;
    }

    return get_option("all-$name",$default);
}

function expz_admin_settings($tab='',$default=[]){
    $role = isset($_POST['ezpz_option_user'])?$_POST['ezpz_option_user']:'all';
    $tab  = empty($tab)?(isset($_GET['tab'])?$_GET['tab']:'customizing-branding'):$tab;
    return get_option("$role-$tab",$default);
}

/*function ezpz_tweaks_get_dashboard_widgets(){
    global $wp_meta_boxes;
    if(isset($wp_meta_boxes['dashboard']))
    return $wp_meta_boxes['dashboard'];

    if(!function_exists('wp_dashboard_setup'))
        include_once(ABSPATH.'/wp-admin/includes/dashboard.php');
    $metaboxes = $wp_meta_boxes;
    @wp_dashboard_setup();
    $widgets = ['dashboard'=>$wp_meta_boxes['plugins']];
    $wp_meta_boxes = $metaboxes;
    return $widgets;
}*/