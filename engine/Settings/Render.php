<?php

/**
 * EZPZ_TWEAKS
 *
 * @package   EZPZ_TWEAKS
 * @author    WP EzPz <info@wpezpz.dev>
 * @copyright 2022 WP EzPz
 * @license   GPL 3.0+
 * @link      https://wpezpzdev.com/
 */
namespace EZPZ_TWEAKS\Engine\Settings;

class Render extends Settings {

    public static function navigation( $page ) {
        $tabs = self::get_tabs( $page );

        // Sort tabs by priority
        usort( $tabs, function( $a, $b ) {
            return $a['priority'] - $b['priority'];
        });
        $current_tab = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : $tabs[0]['id'];

        echo '<ul class="wp-tab-bar">';
		foreach( $tabs as $tab ) {

			$active = $current_tab === $tab['id'] ? 'wp-tab-active' : '';
			echo '<li class="' . $active . '"><a href="#' . $tab['id'] . '" >' . $tab['title'] . '</a></li>';
		}
	    echo '</ul>';

    }

    public static function field( $field ) {
        if ($field['only_callback'] && is_callable($field['callback'])) {
            return call_user_func( $field['callback'] );
        }

        if ($field['cmb2_args']) {

            $field['cmb2_args']['id'] = $field['id'];
            $field['cmb2_args']['desc'] = $field['description'];
            $field['cmb2_args']['name'] = $field['title'];

            return self::add_cmb2_field( $field['tab'], $field['cmb2_args']);
        }

		return false;
    }

    public static function fields( $page, $tab, $fields = [] ) {
        // early return if no fields
        if ( empty( $fields ) ) {
            $fields = Settings::get_fields( $page, $tab );
            if ( empty( $fields ) ) {
                return;
            }
        }

        // Sort by priority
        usort( $fields, function( $a, $b ) {
            return $a['priority'] - $b['priority'];
        });

        foreach ( $fields as $field ) {
            self::field( $field );
        }

        $tab = self::get_tab( $tab );
        if ( $tab['is_cmb2'] ) {
            cmb2_metabox_form( EZPZ_TWEAKS_TEXTDOMAIN . '_options_' . $tab['id'], EZPZ_TWEAKS_TEXTDOMAIN . '-' . $tab['id'] );
        }
    }

    public static function tabs( $page ): bool
	{
        $tabs = self::get_tabs();
        $current_tab = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : $tabs[0]['id'];

        // Sort tabs by priority
        usort( $tabs, function( $a, $b ) {
            return $a['priority'] - $b['priority'];
        });

        // Render tabs
        foreach ( $tabs as $tab ) {
            // Hide if not current tab
            $style = $current_tab == $tab['id'] ? '' : 'display: none';
            echo '<div id="'. $tab['id'] .'" class="wp-tab-panel" style="'. $style .'">';
                self::fields( $page, $tab['id']);
            echo '</div>';

        }

        return true;
    }


}
