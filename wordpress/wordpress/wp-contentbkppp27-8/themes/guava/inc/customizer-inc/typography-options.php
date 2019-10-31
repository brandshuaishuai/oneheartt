<?php

    /**
     * Typography Option
     *
     * @since 1.0.0
     */
    $wp_customize->add_panel(
      'guava_typography',
      array(
        'priority'       => 16,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '',
        'title'          => esc_html__( 'Typography Options','guava'),
      )
    );

/*------------------------------------------------------------------
         Typography Options for paragraph
       */

         $wp_customize->add_section(
          'guava_paragraph_typography_options',
          array(
            'title'   => esc_html__( 'Paragraph Typography Options','guava'),
            'panel'     => 'guava_theme_options',
            'priority'  => 200,
          )
        );

         $wp_customize->add_setting('guava_theme_options[guava_paragraph_font_url]', array(
          'default'           =>  $defaults['guava_paragraph_font_url'],
          'transport'         => 'refresh',
          'sanitize_callback' => 'esc_url_raw'
        ));

         $wp_customize->add_control('guava_theme_options[guava_paragraph_font_url]', array(
           'label' => __('Google Font URL', 'guava'),
           'section' => 'guava_paragraph_typography_options',
           'type'    => 'text',
           'description' => sprintf('%1$s <a href="%2$s" target="_blank">%3$s</a> %4$s',
            __( 'Insert', 'guava' ),
            esc_url('https://www.google.com/fonts'),
            __('Google Font URL' , 'guava'),
            __('for embed fonts.' ,'guava')
          ),

         ));

         $wp_customize->add_setting('guava_theme_options[guava_paragraph_font_family]', array(
          'default' =>  $defaults['guava_paragraph_font_family'],
          'transport'   => 'refresh',
          'sanitize_callback' => 'guava_sanitize_strip_slashes'
        ));

         $wp_customize->add_control('guava_theme_options[guava_paragraph_font_family]', array(
           'label' => __('Font Family', 'guava'),
           'section' => 'guava_paragraph_typography_options',
           'type'    => 'text',
           'description' => __( 'Insert Font Family.', 'guava' ),     
         ));


