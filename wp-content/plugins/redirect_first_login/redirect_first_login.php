<?php
/*
Plugin Name: Redirect On First Login
Description: Standalone functionality to redirect users to a special page on their first login(s)
Author: Mat Megat
Version: 1.0
*/

// Send new users to a special page
function redirectOnFirstLogin( $redirect_to, $requested_redirect_to, $user )
{
    // URL to redirect to
    $redirect_url = get_site_url() . '/dashboard/accounts';
    // How many times to redirect the user
    $num_redirects = 1;

    $key_name = 'redirect_on_first_login';
    // Third parameter ensures that the result is a string
    $current_redirect_value = get_user_meta( $user->ID, $key_name, true );
    if('' == $current_redirect_value || intval( $current_redirect_value ) < $num_redirects )
    {
        if( '' != $current_redirect_value )
        {
            $num_redirects = intval( $current_redirect_value ) + 1;
        }
        update_user_meta( $user->ID, $key_name, $num_redirects );
        return $redirect_url;
    }
    else
    {
        return $redirect_to;
    }
}

add_filter( 'login_redirect', 'redirectOnFirstLogin', 11, 3 );


?>