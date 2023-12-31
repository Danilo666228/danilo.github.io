<?php

class Storely_Customizer_Notify {

	private $recommended_actions;

	
	private $recommended_plugins;

	
	private static $instance;

	
	private $recommended_actions_title;

	
	private $recommended_plugins_title;

	
	private $dismiss_button;

	
	private $install_button_label;

	
	private $activate_button_label;

	
	private $storely_deactivate_button_label;
	
	
	private $config;

	
	public static function init( $config ) {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Storely_Customizer_Notify ) ) {
			self::$instance = new Storely_Customizer_Notify;
			if ( ! empty( $config ) && is_array( $config ) ) {
				self::$instance->config = $config;
				self::$instance->setup_config();
				self::$instance->setup_actions();
			}
		}

	}

	
	public function setup_config() {

		global $storely_customizer_notify_recommended_plugins;
		global $storely_customizer_notify_recommended_actions;

		global $install_button_label;
		global $activate_button_label;
		global $storely_deactivate_button_label;

		$this->recommended_actions = isset( $this->config['recommended_actions'] ) ? $this->config['recommended_actions'] : array();
		$this->recommended_plugins = isset( $this->config['recommended_plugins'] ) ? $this->config['recommended_plugins'] : array();

		$this->recommended_actions_title = isset( $this->config['recommended_actions_title'] ) ? $this->config['recommended_actions_title'] : '';
		$this->recommended_plugins_title = isset( $this->config['recommended_plugins_title'] ) ? $this->config['recommended_plugins_title'] : '';
		$this->dismiss_button            = isset( $this->config['dismiss_button'] ) ? $this->config['dismiss_button'] : '';

		$storely_customizer_notify_recommended_plugins = array();
		$storely_customizer_notify_recommended_actions = array();

		if ( isset( $this->recommended_plugins ) ) {
			$storely_customizer_notify_recommended_plugins = $this->recommended_plugins;
		}

		if ( isset( $this->recommended_actions ) ) {
			$storely_customizer_notify_recommended_actions = $this->recommended_actions;
		}

		$install_button_label    = isset( $this->config['install_button_label'] ) ? $this->config['install_button_label'] : '';
		$activate_button_label   = isset( $this->config['activate_button_label'] ) ? $this->config['activate_button_label'] : '';
		$storely_deactivate_button_label = isset( $this->config['storely_deactivate_button_label'] ) ? $this->config['storely_deactivate_button_label'] : '';

	}

	
	public function setup_actions() {

		// Register the section
		add_action( 'customize_register', array( $this, 'storely_plugin_notification_customize_register' ) );

		// Enqueue scripts and styles
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'storely_customizer_notify_scripts_for_customizer' ), 0 );

		/* ajax callback for dismissable recommended actions */
		add_action( 'wp_ajax_quality_customizer_notify_dismiss_action', array( $this, 'storely_customizer_notify_dismiss_recommended_action_callback' ) );

		add_action( 'wp_ajax_ti_customizer_notify_dismiss_recommended_plugins', array( $this, 'storely_customizer_notify_dismiss_recommended_plugins_callback' ) );

	}

	
	public function storely_customizer_notify_scripts_for_customizer() {

		wp_enqueue_style( 'storely-customizer-notify-css', get_template_directory_uri() . '/inc/customizer/assets/css/customizer-notify.css', array());

		wp_enqueue_style( 'storely-plugin-install' );
		wp_enqueue_script( 'storely-plugin-install' );
		wp_add_inline_script( 'storely-plugin-install', 'var pagenow = "customizer";' );

		wp_enqueue_script( 'storely-updates' );

		wp_enqueue_script( 'storely-customizer-notify-js', get_template_directory_uri() . '/inc/customizer/assets/js/customizer-notify.js', array( 'customize-controls' ));
		wp_localize_script(
			'storely-customizer-notify-js', 'StorelyCustomizercompanionObject', array(
				'storely_ajaxurl'            => esc_url(admin_url( 'admin-ajax.php' )),
				'storely_template_directory' => esc_url(get_template_directory_uri()),
				'storely_base_path'          => esc_url(admin_url()),
				'storely_activating_string'  => __( 'Activating', 'storely' ),
			)
		);

	}

	
	public function storely_plugin_notification_customize_register( $wp_customize ) {

		
		require_once get_template_directory() . '/inc/customizer/customizer-notify-section.php';

		$wp_customize->register_section_type( 'Storely_Customizer_Notify_Section' );

		$wp_customize->add_section(
			new Storely_Customizer_Notify_Section(
				$wp_customize,
				'Storely-customizer-notify-section',
				array(
					'title'          => $this->recommended_actions_title,
					'plugin_text'    => $this->recommended_plugins_title,
					'dismiss_button' => $this->dismiss_button,
					'priority'       => 0,
				)
			)
		);

	}

	
	public function storely_customizer_notify_dismiss_recommended_action_callback() {

		global $storely_customizer_notify_recommended_actions;

		$action_id = ( isset( $_GET['id'] ) ) ? $_GET['id'] : 0;

		echo esc_html($action_id); 

		if ( ! empty( $action_id ) ) {

			
			if ( get_theme_mod( 'storely_customizer_notify_show' ) ) {

				$storely_customizer_notify_show_recommended_actions = get_theme_mod( 'storely_customizer_notify_show' );
				switch ( $_GET['todo'] ) {
					case 'add':
						$storely_customizer_notify_show_recommended_actions[ $action_id ] = true;
						break;
					case 'dismiss':
						$storely_customizer_notify_show_recommended_actions[ $action_id ] = false;
						break;
				}
				echo esc_html($storely_customizer_notify_show_recommended_actions);
				
			} else {
				$storely_customizer_notify_show_recommended_actions = array();
				if ( ! empty( $storely_customizer_notify_recommended_actions ) ) {
					foreach ( $storely_customizer_notify_recommended_actions as $storely_lite_customizer_notify_recommended_action ) {
						if ( $storely_lite_customizer_notify_recommended_action['id'] == $action_id ) {
							$storely_customizer_notify_show_recommended_actions[ $storely_lite_customizer_notify_recommended_action['id'] ] = false;
						} else {
							$storely_customizer_notify_show_recommended_actions[ $storely_lite_customizer_notify_recommended_action['id'] ] = true;
						}
					}
					echo esc_html($storely_customizer_notify_show_recommended_actions);
				}
			}
		}
		die(); 
	}

	
	public function storely_customizer_notify_dismiss_recommended_plugins_callback() {
	
		$action_id = ( isset( $_GET['id'] ) ) ? $_GET['id'] : 0;

		echo esc_html($action_id); 

		if ( ! empty( $action_id ) ) {

		if ( get_theme_mod( 'storely_customizer_notify_show_recommended_plugins' ) ) {
			$storely_lite_customizer_notify_show_recommended_plugins = get_theme_mod( 'storely_customizer_notify_show_recommended_plugins' );

			switch ( $_GET['todo'] ) {
				case 'add':
					$storely_lite_customizer_notify_show_recommended_plugins[ $action_id ] = false;
					break;
				case 'dismiss':
					$storely_lite_customizer_notify_show_recommended_plugins[ $action_id ] = true;
					break;
			}
			echo esc_html($storely_lite_customizer_notify_show_recommended_plugins);
			
		} else {
				$storely_lite_customizer_notify_show_recommended_plugins = array();
				if ( ! empty( $storely_customizer_notify_recommended_plugins ) ) {
					foreach ( $storely_customizer_notify_recommended_plugins as $storely_lite_customizer_notify_recommended_plugin ) {
						if ( $storely_lite_customizer_notify_recommended_plugin['id'] == $action_id ) {
							$storely_lite_customizer_notify_show_recommended_plugins[ $storely_lite_customizer_notify_recommended_plugin['id'] ] = true;
						} else {
							$storely_lite_customizer_notify_show_recommended_plugins[ $storely_lite_customizer_notify_recommended_plugin['id'] ] = false;
						}
					}
					echo esc_html($storely_lite_customizer_notify_show_recommended_plugins);
				}
			}
		}
		die(); 
	}

}
