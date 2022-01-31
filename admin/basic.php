<?php

function plauth_menu()
{
    add_menu_page(
        'Passwordless Authentication',
        'Passwordless',
        'manage_options',
        'pwl-auth',
        'plauth_doc',
        '',
        6
    );
    add_submenu_page(
        'pwl-auth',
        'Configure you passwordless',
        'Configure',
        'manage_options',
        'pwl-setting',
        'plauth_configue'
    );
    add_submenu_page(
        'pwl-auth',
        'pwl-register',
        'Add Device',
        'manage_options',
        'pwl-add-device',
        'plauth_add_device'
    );
}

function plauth_doc()
{
    require(__DIR__ . '/Passwordless.php');

}




function plauth_configue()
{
    ob_start();
    require(__DIR__ . '/Configure.php');
    $html = ob_get_contents();
    ob_end_clean();
    echo stripslashes( $html );
}



function plauth_add_device()
{

    ob_start();
    require(__DIR__ . '/AddDevice.php');
    $html = ob_get_contents();
    ob_end_clean();
    echo stripslashes($html);
}

add_action('admin_menu', 'plauth_menu');