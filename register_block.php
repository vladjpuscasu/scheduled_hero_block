function register_hero_block() {

    if( ! function_exists( 'acf_register_block_type' ) )
        return;

    acf_register_block_type( array(
        'name'                   => 'hero_scheduled',
        'title'                  => __( 'Hero Scheduled', 'psb-true' ),
        'render_template'        => 'template-parts/blocks/hero_scheduled.php',
        'category'               => 'media',
        'icon'                   => 'cover-image',
        'mode'                   => 'auto',
        'align'                  => 'full',
        'keywords'               => array( 'cover', 'image', 'background' ),
        'supports'               => [
            'align'                => false,
            'anchor'               => true,
            'jsx'                  => true,
        ]
    ));
}

add_action('acf/init', 'register_hero_block');
