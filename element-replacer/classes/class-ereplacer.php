<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * ElementReplacer Plugin class
 *
 * @package WordPress
 * @subpackage ereplacer
 * @author Andrew Sun
 * @since 1.0.0
 */
class ereplacer {

	/**
	 * Construct
	 * 
	 * @param string $file
	 */
	public function __construct( $file ) {
		$this->name = 'ElementReplacer';
		$this->token = 'ereplacer';

		add_action( 'init', array( $this, 'init' ) );
	}

	/**
	 * Init the extension settings
	 * 
	 * @return void
	 */
	public function init() {
		$tabs = array(
			'ereplacer' => 'ereplacer_Settings'
		);

		foreach( $tabs as $key => $obj ) {
			if( !class_exists( $obj ) )
				continue;
			$this->settings_objs[ $key ] = new $obj;
			$this->settings[ $key ] = $this->settings_objs[ $key ]->get_settings();
			add_action( 'admin_init', array( $this->settings_objs[ $key ], 'setup_settings' ) );
		}

		$this->settings_screen = new ereplacer_Settings_Screen( array(
			'default_tab' => 'ereplacer'
		));
	}
}