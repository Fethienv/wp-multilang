<?php
namespace WPM\Includes;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * ShortCodes
 *
 * Class WPM_Shortcodes
 * @package WPM\Includes
 */
class WPM_Shortcodes {

	/**
	 * WPM_Shortcodes constructor.
	 */
	public function __construct() {
		add_shortcode( 'wpm_lang_switcher', array( $this, 'language_switcher' ) );
		add_shortcode( 'wp_translate', array( $this,'WP_Translate_shortcode') );
        add_shortcode( 'wpm_translate', array( $this,'wpm_translate_string_shortcode' ));
	}

	/**
	 * Language switcher html
	 *
	 * @param $atts
	 *
	 * @return string
	 */
	public function language_switcher( $atts ) {

		$atts = shortcode_atts( array(
			'type' => 'list',
			'show' => 'both'
		), $atts );

		return wpm_get_language_switcher( $atts['type'], $atts['show'] );
	}
	
	/**
	 * Language get translate string form default language
	 *
	 * @param $atts    string
	 * @param $content string
	 *
	 * @return string
	 */
        
     public function WP_Translate_shortcode( $atts, $content = null ) {
               extract(shortcode_atts( array(
                                            'domain' => 'default',
                                            ), $atts ));
               return __($content,$domain);
     }
        
    /**
	 * wpm_translate_string by shortcode
	 *
	 * @param $atts string
	 *
	 * @return string
	 */
        
     public function wpm_translate_string_shortcode( $atts, $content = null ) {
               extract(shortcode_atts( array(
                                              'domain' => 'default',
                                             ), $atts ));

               return wpm_translate_string($content);
     }
}
