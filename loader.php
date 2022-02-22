<?php
/**
 * Plugin Name: Passwordless Authentication
 * Plugin URI: http://wordpress.org/extend/plugins/passwordless-authentication/
 * Description: Provides any team member the option to login without a password
 * Author: Passwordless Team
 * Author URI: https://passwordless4u.com
 * Version: 1.3.1
 * Text Domain: passwordless-authentication
 * License: GPL v3 - https://www.gnu.org/licenses/gpl-3.0.en.html
 */

if (!defined('ABSPATH')) exit;
require_once(__DIR__ . '/passwordless_login.php');
require_once(__DIR__ . '/admin/basic.php');
require_once(__DIR__ . '/admin/EditProfile.php');
register_activation_hook(__FILE__, array('Passwordless_login','plugin_activated'));
?>