<?php
    $wp_customize->add_setting(
        'guava_theme_options[guava_primary_color]',
        array(
                'default' => $defaults['guava_primary_color'],
                'sanitize_callback' => 'sanitize_hex_color',
              )
    );

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,
        'guava_theme_options[guava_primary_color]',
        array(
                'label' => esc_html__( 'Primary Color','guava'),
                'description' => esc_html__('We recommend choose  different  background color but not to choose similar to font color', 'guava'),
                'section' => 'colors',
                'priority' => 14,

              )
        )
    );