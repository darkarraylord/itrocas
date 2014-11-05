<?php

/**
 * @file
 * Theme settings for the theme903
 */
function theme903_form_system_theme_settings_alter( &$form, &$form_state ) {
	if ( !isset( $form['theme903_settings'] ) ) {
		/**
		 * Vertical tabs layout borrowed from Sasson.
		 *
		 * @link http://drupal.org/project/sasson
		 */
		drupal_add_css( drupal_get_path( 'theme', 'theme903' ) . '/css/options/theme-settings.css', array(
			'group'				=> CSS_THEME,
			'every_page'		=> TRUE,
			'weight'			=> 99
		) );

		/* Submit function */
		$form['#submit'][] = 'theme903_form_system_theme_settings_submit';

		/* Add reset button */
		$form['actions']['reset'] = array(
			'#type' => 'submit',
			'#value' => t('Reset to defaults'),
			'#submit' => array( 'theme903_form_system_theme_settings_reset' ),
		);

		/* Settings */
		$form['theme903_settings'] = array(
			'#type'				=> 'vertical_tabs',
			'#weight'			=> -10,
		);
		
		/**
		 * General settings.
		 */
		$form['theme903_settings']['theme903_general'] = array(
			'#type'				=> 'fieldset',
			'#title'			=> t( 'General Settings' ),
		);
		
		$form['theme903_settings']['theme903_general']['theme_settings'] = $form['theme_settings'];
		unset($form['theme_settings']);

		$form['theme903_settings']['theme903_general']['logo'] = $form['logo'];
		unset($form['logo']);

		$form['theme903_settings']['theme903_general']['favicon'] = $form['favicon'];
		unset($form['favicon']);
		
		$form['theme903_settings']['theme903_general']['theme903_sticky_menu'] = array(
			'#type'				=> 'checkbox',
			'#title'			=> t('Stick up menu.'),
			'#default_value'	=> theme_get_setting('theme903_sticky_menu'),
		);

		/**
		 * Breadcrumb settings.
		 */
		$form['theme903_settings']['theme903_breadcrumb'] = array(
			'#type'				=> 'fieldset',
			'#title'			=> t('Breadcrumb Settings'),
		);

		$form['theme903_settings']['theme903_breadcrumb']['theme903_breadcrumb_show'] = array(
			'#type'				=> 'checkbox',
			'#title'			=> t('Show the breadcrumb.'),
			'#default_value'	=> theme_get_setting('theme903_breadcrumb_show'),
		);

		$form['theme903_settings']['theme903_breadcrumb']['theme903_breadcrumb_container'] = array(
			'#type'				=> 'container',
			'#states'			=> array(
				'invisible'		=> array(
					'input[name="theme903_breadcrumb_show"]' => array(
						'checked'	=> FALSE
					),
				),
			),
		);

		$form['theme903_settings']['theme903_breadcrumb']['theme903_breadcrumb_container']['theme903_breadcrumb_hideonlyfront'] = array(
			'#type'				=> 'checkbox',
			'#title'			=> t('Hide the breadcrumb if the breadcrumb only contains a link to the front page.'),
			'#default_value'	=> theme_get_setting('theme903_breadcrumb_hideonlyfront'),
		);

		$form['theme903_settings']['theme903_breadcrumb']['theme903_breadcrumb_container']['theme903_breadcrumb_showtitle'] = array(
			'#type'				=> 'checkbox',
			'#title'			=> t('Show page title on breadcrumb.'),
			'#description'		=> t("Check this option to add the current page's title to the breadcrumb trail."),
			'#default_value'	=> theme_get_setting('theme903_breadcrumb_showtitle'),
		);

		$form['theme903_settings']['theme903_breadcrumb']['theme903_breadcrumb_container']['theme903_breadcrumb_separator'] = array(
			'#type'				=> 'textfield',
			'#title'			=> t('Breadcrumb separator'),
			'#default_value'	=> theme_get_setting('theme903_breadcrumb_separator'),
			'#description'		=> t('Text only. Dont forget to include spaces.'),
			'#size'				=> 8,
		);
		
		/**
		 * Blog settings
		 */
		$form['theme903_settings']['theme903_blog'] = array(
			'#type'				=> 'fieldset',
			'#title'			=> t('Blog Settings'),
		);

		$form['theme903_settings']['theme903_blog']['theme903_blog_title'] = array(
			'#type'				=> 'textfield',
			'#title'			=> t('Blog title'),
			'#default_value'	=> theme_get_setting('theme903_blog_title'),
			'#description'		=> t('Text only. Leave empty to set Blog title the same as Blog menu link'),
			'#size'				=> 60,
		);
		
		/**
		 * Custom CSS
		 */
		$form['theme903_settings']['theme903_css'] = array(
			'#type'				=> 'fieldset',
			'#title'			=> t('Custom CSS'),
		);

		$form['theme903_settings']['theme903_css']['theme903_custom_css'] = array(
			'#type'				=> 'textarea',
			'#title'			=> t('Custom CSS'),
			'#default_value'	=> theme_get_setting('theme903_custom_css'),
			'#description'		=> t('Insert your CSS code here.'),
		);
	}
}


/* Custom CSS */
function theme903_form_system_theme_settings_submit( $form, &$form_state ) {
	$fp = fopen( drupal_get_path( 'theme', 'theme903' ) . '/css/custom.css', 'a');
	ftruncate( $fp, 0 );
	fwrite( $fp, $form_state['values']['theme903_custom_css'] );
	fclose( $fp );
}

/* Reset options */
function theme903_form_system_theme_settings_reset( $form, &$form_state ) {
	form_state_values_clean( $form_state );

	variable_del( 'theme_theme903_settings' );
	
	$fp = fopen( drupal_get_path( 'theme', 'theme903' ) . '/css/custom.css', 'a' );
	ftruncate( $fp, 0 );
	fclose( $fp );

	drupal_set_message( t( 'The configuration options have been reset to their default values.' ) );
}