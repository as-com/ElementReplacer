<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * ElementReplacer Settings Screen Class
 *
 * A class that works with the settings API to display settings
 *
 * @package WordPress
 * @subpackage ereplacer_Settings_Screen
 * @author Andrew Sun
 * @since 1.0.0
 */
class ereplacer_Settings_Screen {
	
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct( $args ) {
		global $ereplacer;
		$defaults = array(
			'parent_slug' => 'options-general.php',
			'page_title' => $ereplacer->name,
			'menu_title' => $ereplacer->name,
			'capability' => 'manage_options',
			'menu_slug' => $ereplacer->token,
			'default_tab' => isset( $ereplacer->default_tab ) ? $ereplacer->default_tab : '',
			'screen_icon' => 'options-general'
		);
		$this->args = wp_parse_args( $args, $defaults );
		add_action( 'admin_menu', array( $this, 'register_settings_screen' ) );
	} // End __construct()

	/**
	 * Register the settings screen within the WordPress admin.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function register_settings_screen() {
		global $ereplacer;
		$this->_hook = add_submenu_page( $this->args['parent_slug'], $this->args['page_title'], $this->args['menu_title'], $this->args['capability'], $this->args['menu_slug'], array( $this, 'settings_screen' ) );

		if( method_exists( $ereplacer, 'admin_print_scripts' ) )
			add_action( 'admin_print_styles-' . $this->_hook, array( $ereplacer, 'admin_print_scripts' ) );

		if( method_exists( $ereplacer, 'admin_print_styles' ) )
			add_action( 'admin_print_styles-' . $this->_hook, array( $ereplacer, 'admin_print_styles' ) );

	} // End register_settings_screen()

	public function settings_screen() {
		global $ereplacer;
		$tabs = $this->get_settings_tabs();
		$current_tab = $this->get_current_tab();
?>
<div id="<?php echo $ereplacer->token; ?>" class="wrap">
	<?php screen_icon( $this->args['screen_icon'] ); ?>
	<h2 class="nav-tab-wrapper">
	<?php
		echo $this->get_settings_tabs_html( $tabs, $current_tab );
		do_action( $ereplacer->token . '_after_settings_tabs' );
	?>
	</h2>
	<form action="options.php" method="post">
	<?php
		if ( is_object( $ereplacer->settings_objs[ $current_tab ] ) )
			$ereplacer->settings_objs[ $current_tab ]->settings_screen();
		else 
			_e( 'Invalid Settings Class', '' );
	?>
	</form>
</div><!--/.wrap-->
<?php
	} // End settings_screen()

	/**
	 * Generate an array of admin section tabs.
	 * @access  private
	 * @since   1.0.0
	 * @return  array Tab data with key, and a value of array( 'name', 'callback' )
	 */
	private function get_settings_tabs() {
		global $ereplacer;
		$tabs = array();
		foreach( $ereplacer->settings_objs as $k => $obj ) {
			$tabs[ $k ] = $obj;
		}
		return (array) $tabs;
	} // End get_settings_tabs()

	/**
	 * Generate HTML markup for the section tabs.
	 * @access  public
	 * @since   1.0.0
	 * @param   array $tabs An array of tabs.
	 * @param   string $current_tab The key of the current tab.
	 * @return  string HTML markup for the settings tabs.
	 */
	public function get_settings_tabs_html( $tabs = false, $current_tab = false ) {
		global $ereplacer;
		if ( ! is_array( $tabs ) ) $tabs = $this->get_settings_tabs(); // Fail-safe, in case we don't pass tab data.
		if ( false == $current_tab ) $current_tab = $this->get_current_tab();

		$html = '';
		if ( 0 < count( $tabs ) ) {
			foreach ( $tabs as $obj ) {
				$class = 'nav-tab';
				if ( $current_tab == $obj->token ) {
					$class .= ' nav-tab-active';
				}
				$url = add_query_arg( 'tab', $obj->token );
				$html .= '<a href="' . esc_url( $url ) . '" class="' . esc_attr( $class ) . '">' . esc_html( $obj->name ) . '</a>';
			}
		}
		return $html;
	} // End get_settings_tabs_html()

	/**
	 * Get the current selected tab key.
	 * @access  private
	 * @since   1.0.0
	 * @param   array $tabs Available tabs.
	 * @return  string Current tab's key, or a default value.
	 */
	private function get_current_tab ( $tabs = false ) {
		if ( ! is_array( $tabs ) ) $tabs = $this->get_settings_tabs(); // Fail-safe, in case we don't pass tab data.
		if ( isset( $_GET['tab'] ) && in_array( $_GET['tab'], array_keys( $tabs ) ) )
			$current_tab = esc_attr( $_GET['tab'] );
		else
			$current_tab = $this->args['default_tab'];

		return $current_tab;
	} // End get_current_tab()

} // End Class