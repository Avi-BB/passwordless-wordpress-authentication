<?php

function passwordless_admin_auth_menu()
{
    add_menu_page(
        'Passwordless Authentication',
        'Passwordless',
        'manage_options',
        'pwl-auth',
        'passwordless_admin_auth_doc',
        '',
       5
    );
    add_submenu_page(
        'pwl-auth',
        'Configure you passwordless',
        'Configure',
        'manage_options',
        'pwl-setting',
        'passwordless_admin_auth_configue'
    );
    add_submenu_page(
        'pwl-auth',
        'pwl-register',
        'Add Device',
        'manage_options',
        'pwl-add-device',
        'passwordless_admin_auth_device'
    );
}

function passwordless_admin_auth_doc()
{
    require(__DIR__ . '/Passwordless.php');

}




function passwordless_admin_auth_configue()
{
    require(__DIR__ . '/Configure.php');
}



function passwordless_admin_auth_device()
{

    require(__DIR__ . '/AddDevice.php');
}

// function edit_profile()
// {

//     require(__DIR__ . '/AddDevice.php');
// }
add_action('admin_menu', 'passwordless_admin_auth_menu');

// add_action( 'edit_user_profile', 'edit_profile' );
// This will show below the color scheme and above username field
     
?>