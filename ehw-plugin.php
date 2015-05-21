<?php
/**
 * Everyday Hero Widget
 *
 * @package   Everyday_Hero_Widget
 * @author    Adrian Ciaschetti <http://twitter.com/_aciaschetti>
 * @license   GPL-2.0+
 * @link      http://adrianciaschetti.com/projects/everyday-hero/
 * @copyright 2015 Adrian Ciaschetti
 *
 * @wordpress-plugin
 * Plugin Name:       Everyday Hero Widget
 * Plugin URI:        http://wordpress.org
 * Description:       A WordPress widget to display an Everyday Hero's profile.
 * Version:           1.0.0
 * Author:            Adrian Ciaschetti
 * Author URI:        http://adrianciaschetti.com
 * Text Domain:       everyday-hero-widget
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /lang
 * GitHub Plugin URI: https://github.com/aciaschetti/everyday-hero-widget
 */
 
 // Prevent direct file access
if ( ! defined ( 'ABSPATH' ) ) {
	exit;
}

// TODO: change 'Everyday_Hero_Widget' to the name of your plugin
class Everyday_Hero_Widget extends WP_Widget {

    /**
     *
     * The variable name is used as the text domain when internationalizing strings
     * of text. Its value should match the Text Domain file header in the main
     * widget file.
     *
     * @since    1.0.0
     *
     * @var      string
     */
    protected $widget_slug = 'everyday-hero-widget';

	/*--------------------------------------------------*/
	/* Constructor
	/*--------------------------------------------------*/

	/**
	 * Specifies the classname and description, instantiates the widget,
	 * loads localization files, and includes necessary stylesheets and JavaScript.
	 */
	public function __construct() {

		// load plugin text domain
		add_action( 'init', array( $this, 'widget_textdomain' ) );

		// Hooks fired when the Widget is activated and deactivated
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

		// TODO: update description
		parent::__construct(
			$this->get_widget_slug(),
			__( 'Everyday Hero', $this->get_widget_slug() ),
			array(
				'classname'  => $this->get_widget_slug().'-class',
				'description' => __( 'Display your Everyday Hero profile on your WordPress site.', $this->get_widget_slug() )
			)
		);

		// Register admin styles and scripts
		add_action( 'admin_print_styles', array( $this, 'register_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );

		// Register site styles and scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_scripts' ) );

		// Refreshing the widget's cached output with each new post
		add_action( 'save_post',    array( $this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );

	} // end constructor


    /**
     * Return the widget slug.
     *
     * @since    1.0.0
     *
     * @return    Plugin slug variable.
     */
    public function get_widget_slug() {
        return $this->widget_slug;
    }

	/*--------------------------------------------------*/
	/* Widget API Functions
	/*--------------------------------------------------*/

	/**
	 * Outputs the content of the widget.
	 *
	 * @param array args  The array of form elements
	 * @param array instance The current instance of the widget
	 */
	public function widget( $args, $instance ) {

		
		// Check if there is a cached output
		$cache = wp_cache_get( $this->get_widget_slug(), 'widget' );

		if ( !is_array( $cache ) )
			$cache = array();

		if ( ! isset ( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset ( $cache[ $args['widget_id'] ] ) )
			return print $cache[ $args['widget_id'] ];
		
		// go on with your widget logic, put everything into a string and …
        $data = $this->everyday_hero_data($instance['url'], 4);

		extract( $args, EXTR_SKIP );

		$widget_string = $before_widget;

		// TODO: Here is where you manipulate your widget's values based on their input fields
		ob_start();
		include( plugin_dir_path( __FILE__ ) . 'views/widget.php' );
		$widget_string .= ob_get_clean();
		$widget_string .= $after_widget;


		$cache[ $args['widget_id'] ] = $widget_string;

		wp_cache_set( $this->get_widget_slug(), $cache, 'widget' );

		print $widget_string;

	} // end widget
	
	
	public function flush_widget_cache() {
    	wp_cache_delete( $this->get_widget_slug(), 'widget' );
	}
	/**
	 * Processes the widget's options to be saved.
	 *
	 * @param array new_instance The new instance of values to be generated via the update.
	 * @param array old_instance The previous instance of values before the update.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['url']        = strip_tags( $new_instance['url'] );
		$instance['logo']        = strip_tags( $new_instance['logo'] );

		return $instance;

	} // end widget

	/**
	 * Generates the administration form for the widget.
	 *
	 * @param array instance The array of keys and values for the widget.
	 */
	public function form( $instance ) {
        
        $defaults = array(
            'title'     => __('Everyday Hero', 'everyday-hero-widget'),
            'url'       => '',
            'logo'      => 0
		);
		
		// TODO: Define default values for your variables
		$instance = wp_parse_args(
			(array) $instance,
			$defaults
		);

		// Display the admin form
		include( plugin_dir_path(__FILE__) . 'views/admin.php' );

	} // end form

	/*--------------------------------------------------*/
	/* Public Functions
	/*--------------------------------------------------*/
    	
	/**
	 * Loads the Widget's text domain for localization and translation.
	 */
	public function widget_textdomain() {

		// TODO be sure to change 'everyday-hero-widget' to the name of *your* plugin
		load_plugin_textdomain( $this->get_widget_slug(), false, plugin_dir_path( __FILE__ ) . 'lang/' );

	} // end widget_textdomain

	/**
	 * Fired when the plugin is activated.
	 *
	 * @param  boolean $network_wide True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
	 */
	public function activate( $network_wide ) {
		// TODO define activation functionality here
	} // end activate

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @param boolean $network_wide True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog
	 */
	public function deactivate( $network_wide ) {
		// TODO define deactivation functionality here
	} // end deactivate

	/**
	 * Registers and enqueues admin-specific styles.
	 */
	public function register_admin_styles() {

		wp_enqueue_style( $this->get_widget_slug().'-admin-styles', plugins_url( 'css/admin.css', __FILE__ ) );

	} // end register_admin_styles

	/**
	 * Registers and enqueues admin-specific JavaScript.
	 */
	public function register_admin_scripts() {

		wp_enqueue_script( $this->get_widget_slug().'-admin-script', plugins_url( 'js/admin.js', __FILE__ ), array('jquery') );

	} // end register_admin_scripts

	/**
	 * Registers and enqueues widget-specific styles.
	 */
	public function register_widget_styles() {

		wp_enqueue_style( $this->get_widget_slug().'-widget-styles', plugins_url( 'css/widget.css', __FILE__ ) );

	} // end register_widget_styles

	/**
	 * Registers and enqueues widget-specific scripts.
	 */
	public function register_widget_scripts() {

		wp_enqueue_script( $this->get_widget_slug().'-script', plugins_url( 'js/widget.js', __FILE__ ), array('jquery') );

	} // end register_widget_scripts
	
	/*--------------------------------------------------*/
	/* Private Functions
	/*--------------------------------------------------*/
	
	/**
	 * Stores the fetched data from Everyday Hero in WordPress DB using transients
	 *	 
	 * @param    string    $url    	        Everyday Hero profile to fetch data from
	 * @param    string    $cache_hours     Cache hours for transient		  	 
	 *
	 * @return array of locally saved Everyday Hero data
	 */
	private function everyday_hero_data( $url, $cache_hours ) {
		
		$opt_name  = 'ehw_' . md5( $url );
		$data = get_transient( $opt_name );

		if ( false === $data ) {
			
			$data = array();
			//Get properly formatted url for json output
            $clean_url = $this->formatted_url( $url );
			$response = wp_remote_get( $clean_url, array( 'sslverify' => false, 'timeout' => 60 ) );
            
			if ( is_wp_error( $response ) ) {
    			
				return $response->get_error_message();
				
			}
			
			if ( $response['response']['code'] == 200 ) {
				
				$json = $response['body'];
				
				// Function json_last_error() is not available before PHP * 5.3.0 version
				if ( function_exists( 'json_last_error' ) ) {
					
					( $results = json_decode( $json, true ) ) && json_last_error() == JSON_ERROR_NONE;
					
				} else {
    				
					$results = json_decode( $json, true );
					
				}
				
				if ( $results && is_array( $results ) ) {
                    
                    //Filter out the parent 'page' object
                    $results = isset( $results['page'] ) ? $results['page'] : array();

					if ( empty( $results ) ) {
						return __( 'A problem has occurred.', 'everyday-hero-widget');
					}
                    
                    //Strip out the important information
                    $data['name']       = $results['name'];
                    $data['image']      = $results['image']['large_image_url'];
                    $data['profile']    = $results['url'];
                    $data['target']     = ( (int) $results['target_cents'] ) / 100;
                    $data['current']    = ( (int) $results['amount']['cents'] ) / 100;
                    $data['currency']   = $results['amount']['currency']['symbol'];
                    $data['remaining']  = $data['target'] - $data['current'];
                    $data['donations']  = $results['meta']['totals']['total_donations'];
                    			
				} // end -> ( $results ) && is_array( $results ) )
				
			} else { 

				return $response['response']['message'];

			} // end -> $response['response']['code'] === 200 )
			
			if ( is_array( $data ) && !empty( $data )  ) {

				set_transient( $opt_name, $data, $cache_hours * 60 * 60 );
			}
			
		} // end -> false === $data
		
		return $data;
	}
    
    private function formatted_url( $url ) {
        $url = preg_replace("/^http:/i", "https:", $url);
        $clean_url = $url . '.json';
        return $clean_url;
    }
    
} // end class

// TODO: Remember to change 'Everyday_Hero_Widget' to match the class name definition
add_action( 'widgets_init', create_function( '', 'register_widget("Everyday_Hero_Widget");' ) );
