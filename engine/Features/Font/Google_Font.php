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
namespace EZPZ_TWEAKS\Engine\Features\Font;


class Google_Font {
    private static $fonts = [
      "Alegreya:400", 
      "B612:400", 
      "Muli:400", 
      "Titillium+Web:400", 
      "Varela:400", 
      "Vollkorn:400", 
      "Crimson+Text:400", 
      "Cairo:400", 
      "BioRhyme:400", 
      "Karla:400",
      "Lora:400", 
      "Frank+Ruhl+Libre:400", 
      "Playfair+Display:400", 
      "Archivo:400", 
      "Spectral:400", 
      "Fjalla+One:400", 
      "Roboto:400", 
      "Montserrat:400", 
      "Rubik:400", 
      "Source+Sans:400", 
      "Cardo:400", 
      "Cormorant:400", 
      "Work+Sans:400", 
      "Rakkas:400", 
      "Concert+One:400", 
      "Yatra+One:400", 
      "Arvo:400", 
      "Lato:400", 
      "Ubuntu:400", 
      "PT+Serif:400", 
      "Old+Standard+TT:400",
      "Oswald:400", 
      "PT+Sans:400", 
      "Poppins:400", 
      "Fira+Sans:400", 
      "Nunito:400", 
      "Oxygen:400", 
      "Exo+2:400", 
      "Open+Sans:400", 
      "Merriweather:400", 
      "Noto+Sans:400", 
    ];


    public static function get_fonts() {
		return self::$fonts;
	}

    public static function get_google_font_url( $selected_font ) {
		$font_url = '';
		$font_url = add_query_arg( 'family', urlencode( $selected_font ), "https://fonts.googleapis.com/css" );
		return $font_url;
	}
}