<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
 * ElementReplacer Settings
 *
 * All functionality pertaining to the subscribe settings screen.
 *
 * @package WordPress
 * @subpackage ereplacer_Settings
 * @category Admin
 * @author Andrew Sun
 * @since 1.0.0
 */
class ereplacer_Settings extends ereplacer_Settings_API {
	
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct () {
		global $ereplacer;
		parent::__construct( $ereplacer->name, 'ereplacer' ); // Required in extended classes.
	} // End __construct()

	/**
	 * init_sections function.
	 * 
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function init_sections () {
		$sections = array();

		$sections['general'] = array(
			'name' => __('General Settings' , ''),
		);

		$this->sections = $sections;
	} // End init_sections()
	
	/**
	 * init_fields function.
	 * 
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function init_fields () {
		$fields = array();

		$fields['ereplacer'] = array(
			'name' => __( 'Enable ElementReplacer', '' ),
			'description' => '',
			'type' => 'checkbox',
			'default' => true,
			'section' => 'general'
		);
		
		$this->fields = $fields;
	} // End init_fields()
	
} // End Class
?>