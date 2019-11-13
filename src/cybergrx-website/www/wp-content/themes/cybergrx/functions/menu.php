<?php
// Register menus
register_nav_menus(
	array(
		'main-nav' => __( 'The Main Menu', 'cybergrx' ),   // Main nav in header
		'footer-links' => __( 'Footer Links', 'cybergrx' ) // Secondary nav in footer
	)
);

// The Top Menu
function joints_top_nav() {
	 wp_nav_menu(array(
        'container' => false,                           // Remove nav container
        'menu_class' => 'medium-horizontal menu',       // Adding custom nav class
        'items_wrap' => '<ul id="%1$s" class="%2$s" data-responsive-menu="accordion large-dropdown" data-submenu-toggle="true">%3$s</ul>',
        'theme_location' => 'main-nav',        			// Where it's located in the theme
        'depth' => 5,                                   // Limit the depth of the nav
        'fallback_cb' => false,                         // Fallback function (see below)
        'walker' => new Topbar_Menu_Walker()
    ));
}

// Big thanks to Brett Mason (https://github.com/brettsmason) for the awesome walker
class Topbar_Menu_Walker extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = Array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"menu\">\n";
    }
}

// The Off Canvas Menu
function joints_off_canvas_nav() {
	 wp_nav_menu(array(
        'container' => false,                           // Remove nav container
        'menu_class' => 'vertical menu accordion-menu',       			// Adding custom nav class
        'items_wrap' => '<ul id="%1$s" class="%2$s" data-accordion-menu>%3$s</ul>',
        'theme_location' => 'main-nav',        			// Where it's located in the theme
        'depth' => 5,                                   // Limit the depth of the nav
        'fallback_cb' => false,                         // Fallback function (see below)
        'walker' => new Off_Canvas_Menu_Walker()
    ));
}

class Off_Canvas_Menu_Walker extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = Array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"vertical menu\">\n";
    }
}

// The Footer Menu
function joints_footer_links() {
    wp_nav_menu(array(
    	'container' => 'false',                         // Remove nav container
    	'menu' => __( 'Footer Links', 'cybergrx' ),   	// Nav name
    	'menu_class' => 'menu',      					// Adding custom nav class
    	'theme_location' => 'footer-links',             // Where it's located in the theme
        'depth' => 0,                                   // Limit the depth of the nav
    	'fallback_cb' => ''  							// Fallback function
	));
} /* End Footer Menu */

// Header Fallback Menu
function joints_main_nav_fallback() {
	wp_page_menu( array(
		'show_home' => true,
    	'menu_class' => '',      						// Adding custom nav class
		'include'     => '',
		'exclude'     => '',
		'echo'        => true,
        'link_before' => '',                           // Before each link
        'link_after' => ''                             // After each link
	) );
}

// Footer Fallback Menu
function joints_footer_links_fallback() {
	/* You can put a default here if you like */
}

// Add Foundation active class to menu
function required_active_nav_class( $classes, $item ) {
    if ( $item->current == 1 || $item->current_item_ancestor == true ) {
        $classes[] = 'active';
    }
    return $classes;
}
// add_filter( 'nav_menu_css_class', 'required_active_nav_class', 10, 2 );

/*------------------------------------*\
    ::Custom Scripts
    version: 1.0.1
    ----------------------------------
    Useful for adding 3rd party scripts
    like analytics.
    Usage:
    1.  Add the following code including this
        comment to your functions.php file (or
        custom-functions.php if you are
        using the zemplate theme.)
        A new Custom Scripts menu item
        will appear in the WordPress sidebar
        where you can add your custom scripts.
    2.  Add this to header.php right before
        the closing </head> tag:
        <?php the_field('before_closing_head', 'option'); ?>
    3.  Add this to header.php right after
        the opening <body> tag:
        <?php the_field('after_opening_body', 'option'); ?>
    4.  Add this to footer.php right before
        the closing </body> tag:
        <?php the_field('before_closing_body', 'option'); ?>
    5. For static or old sites that don't have the ACF options,
        page, you will have to add these scripts manually. The
        Google Tag Manger script should always be placed right
        after the opening <body> tag, per Google's suggestions.
\*------------------------------------*/
if( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array(
        'page_title'    => 'Custom Scripts',
        'menu_title'    => 'Custom Scripts',
        'menu_slug'     => 'custom-scripts',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));
}
if( function_exists('acf_add_local_field_group') ){
    acf_add_local_field_group(array (
        'key' => 'group_56eaaf410d8a4',
        'title' => 'Custom Scripts',
        'fields' => array (
            array (
                'key' => 'field_56eaaf69ba041',
                'label' => 'Description',
                'name' => '',
                'type' => 'message',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'message' => '<span style="color:red">For advanced users only.</span> These fields allow you to add custom code to common spots on your website. If handled improperly, changing these settings could break your site: edit with caution.',
                'new_lines' => 'wpautop',
                'esc_html' => 0,
            ),
            array (
                'key' => 'field_56eab060cc22d',
                'label' => 'Before Closing < / head >',
                'name' => 'before_closing_head',
                'type' => 'textarea',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '<!-- your code would go here --> </head>',
                'maxlength' => '',
                'rows' => '',
                'new_lines' => '',
                'readonly' => 0,
                'disabled' => 0,
            ),
            array (
                'key' => 'field_56eab09ccc22e',
                'label' => 'After Opening < body >',
                'name' => 'after_opening_body',
                'type' => 'textarea',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '<body> <!-- your code would go here -->',
                'maxlength' => '',
                'rows' => '',
                'new_lines' => '',
                'readonly' => 0,
                'disabled' => 0,
            ),
            array (
                'key' => 'field_56eab0b6cc22f',
                'label' => 'Before Closing < / body >',
                'name' => 'before_closing_body',
                'type' => 'textarea',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '<!-- your code would go here --> </body>',
                'maxlength' => '',
                'rows' => '',
                'new_lines' => '',
                'readonly' => 0,
                'disabled' => 0,
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'custom-scripts',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => 1,
        'description' => '',
    ));
}