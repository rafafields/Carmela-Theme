<?php
/**
 * carmela_theme Theme Customizer
 *
 * @package carmela_theme
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function carmela_theme_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'carmela_theme_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'carmela_theme_customize_partial_blogdescription',
		) );
	}
    
    //Carmela Theme Options
    
    $wp_customize->add_section( 'carmela' , array(
        'title'      => __('Carmela Theme','mytheme'),
        'priority'   => 30,
    ) );
    
    $wp_customize->add_setting(
          'carmela_phone', //give it an ID
          array(
              'default' => '666 666 666', // Give it a default
          )
      );
      $wp_customize->add_control(
         new WP_Customize_Control(
             $wp_customize,
             'carmela_custom_phone', //give it an ID
             array(
                 'label'      => __( 'Phone', 'mythemename' ), //set the label to appear in the Customizer
                 'section'    => 'carmela', //select the section for it to appear under  
                 'settings'   => 'carmela_phone' //pick the setting it applies to
             )
         )
      );
}
add_action( 'customize_register', 'carmela_theme_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function carmela_theme_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function carmela_theme_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function carmela_theme_customize_preview_js() {
	wp_enqueue_script( 'carmela_theme-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'carmela_theme_customize_preview_js' );
