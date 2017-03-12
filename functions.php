<?php

/*
* Enqueue Frontend styles
*/

function main_styles() {
    wp_enqueue_style( 'main-css', get_stylesheet_uri() );
}

add_action( 'wp_enqueue_scripts', 'main_styles' );

/*
* Enqueue Login styles
*/

function login_stylesheet() {
    wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/style-login.css' );
}
add_action( 'login_enqueue_scripts', 'login_stylesheet' );

/*
* Login Logo url
*/
function login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'login_logo_url' );


/*
* Login Logo url
*/
function wp_admin_style() {
    if ( ! current_user_can( 'manage_options' )) {
        wp_register_style( 'admin-css', get_template_directory_uri() . '/admin-style.css', false, '1.0.0' );
        wp_enqueue_style( 'admin-css' );
    }
}
add_action( 'admin_enqueue_scripts', 'wp_admin_style' );

/*
* Remove admin bar on frontend
*/
show_admin_bar(false);

/*
* Change admin bar text
*/
add_filter('gettext', 'change_howdy', 10, 3);

function change_howdy($translated, $text, $domain) {
    if (!is_admin() || 'default' != $domain)
        return $translated;
    if (false !== strpos($translated, 'Howdy'))
        return str_replace('Howdy', 'Welcome', $translated);
    return $translated;
}


/*
* Remove Admin profile sections
*/
add_action('admin_init', 'admin_settings');

function admin_settings() {
    if ( ! current_user_can( 'manage_options' )) {
        remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
        remove_menu_page( 'index.php' ); //dashboard
        add_filter('show_admin_bar', '__return_false');
    }
}

/*
* Login redirect
*/
add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );

function my_login_redirect( $redirect_to, $request, $user ) {
	if ( isset( $user->roles ) && is_array( $user->roles ) ) {
		if ( in_array( 'admin', $user->roles ) ) {
			return $redirect_to;
		} else {
            // Redirect non-admins to todo list
			return admin_url( 'admin.php?page=cleverness-to-do-list' );
		}
	} else {
		return $redirect_to;
	}
}


/*
* Limit non-admins to todo screens
*/
add_action( 'current_screen', 'restrict_admin_screen' );

function restrict_admin_screen() {
    if ( ! current_user_can( 'manage_options' )) {
        $current_screen = get_current_screen();
        if( $current_screen->id !== "toplevel_page_cleverness-to-do-list" ) {
            echo '<h1 class="title">TodoPress</h1><br />';
            echo 'Whoops, where are we?<br /><br /><br />';
            echo '<a href="' . admin_url( 'admin.php?page=cleverness-to-do-list' ) . '" class="button">Back to Todos?</a>';
            wp_die();
        }
    }
}

/*
* Change default WP email settings
*/
add_filter('wp_mail_from', 'new_mail_from');
add_filter('wp_mail_from_name', 'new_mail_from_name');

function new_mail_from($old) {
return 'no-reply@todopress.xzy';
}
function new_mail_from_name($old) {
return 'TodoPress';
}


?>
