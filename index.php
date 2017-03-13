<?php get_header(); ?>

<h1 class="title">TodoPress</h1>

<p class="intro__text">A quick example project for creating a Web App within WordPress. See the project on <a href="https://github.com/addidesign/todopress" target="_blank">GitHub</a></p>

<div class="button__group">

<?php

$admin_link = admin_url("admin.php?page=cleverness-to-do-list");
if ( is_user_logged_in() ) {
    $link .= '<a href="' . wp_logout_url( home_url() ) . '" class="button">' . __( 'Log Out' ) . '</a>';
    $link .= '<a href="' . $admin_link . '" class="button">' . __( 'My Profile' ) . '</a>';
} else {
    $link .= '<a href="' . wp_login_url($admin_link) . '" class="button">' . __( 'Login' ) . '</a>';
    $link .= '<a href="' . wp_registration_url() . '" class="button">' . __( 'Register' ) . '</a>';
}
echo $link;
?>

</div>

<?php get_footer(); ?>
