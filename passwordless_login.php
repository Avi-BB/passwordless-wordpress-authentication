<?php

function passwordless_enqueue_css_js()
{
    wp_enqueue_script('pwl-sdk', plugin_dir_url(__FILE__) . 'Scripts/passwordless-bb.js', null, null, false);
    wp_enqueue_script('detect', plugin_dir_url(__FILE__) . 'Scripts/detect.js', null, null, false);
    wp_enqueue_style('style',  plugin_dir_url(__FILE__) . 'Styles/style.css');
    wp_enqueue_style('bootstrap',  plugin_dir_url(__FILE__) . 'Styles/bootstrap.min.css');
    wp_enqueue_script('bootstrapjs', plugin_dir_url(__FILE__) . 'Scripts/bootstrap.min.js');
    wp_enqueue_script('mainjs', plugin_dir_url(__FILE__) . 'Scripts/main.js', null, null, true);
}

function passwordless_admin_css_js()
{
    wp_enqueue_script('pwl-sdk', plugin_dir_url(__FILE__) . 'Scripts/passwordless-bb.js', null, null, false);
    wp_enqueue_script('mainjs', plugin_dir_url(__FILE__) . 'Scripts/main.js', null, null, true);
    wp_enqueue_script('detect', plugin_dir_url(__FILE__) . 'Scripts/detect.js', null, null, false);
}
add_action('wp_enqueue_scripts', 'passwordless_enqueue_css_js');
add_action('admin_enqueue_scripts', 'passwordless_admin_css_js');

 function custom_permalinks()
{
    global $wp_rewrite;
    $wp_rewrite->page_structure = $wp_rewrite->root . '%pagename%'; // custom page permalinks
    $wp_rewrite->set_permalink_structure($wp_rewrite->root . '%postname%'); // custom post permalinks
}

// function create_passwordless_table(){
//     global $wpdb;

// 	// Set table name
// 	$table = $wpdb->prefix . 'passwordlessadmin';


// 	$charset_collate = $wpdb->get_charset_collate();
// 	$query1 = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table ) );
// 	if ( $wpdb->get_var( $query1 ) !== $table) {
// 	// Write creating query
// 	$query =  "CREATE TABLE IF NOT EXISTS  " . $table . " (
//             base_url varchar(255) ,
//             client_id VARCHAR(255)
//             );";
// 	// Execute the query
//     require_once(ABSPATH.'wp-admin/includes/upgrade.php');
//     dbDelta($query);
// 		}
// }
class Passwordless_login
{
    /**
     * Initializes the plugin.
     *
     * To keep the initialization fast, only add filter and action
     * hooks in the constructor.
     */
private $username;
public function __construct()
    {
        add_action('init', 'custom_permalinks');
        add_shortcode('passwordless-login-form', array($this, 'render_login_form'));
        add_shortcode('passwordless-remote-auth', array($this, 'render_remote_auth'));
        add_action('login_form_login', array($this, 'redirect_to_custom_login'));
        add_action('login_form_login', array($this, 'do_custom_login'));
        add_action('wp_logout', array($this, 'redirect_after_logout'));
        add_filter('authenticate', array($this, 'maybe_redirect_at_authenticate'), 101, 3);
        add_filter('login_redirect', array($this, 'redirect_after_login'), 10, 3);
        add_action('template_redirect', array($this, 'redirect_if_applicable'));
        $username = null;
    }
    /**
     * Plugin activation hook.
     *
     * Creates all WordPress pages needed by the plugin.
     */



public static function plugin_activated()
    {
        // Information needed for creating the plugin's pages
        $page_definitions = array(
            'member-login' => array(
                'title' => __('Passwordless Sign In', 'personalize-login'),
                'content' => '[passwordless-login-form]'
            ),
            'authenticate' => array(
                'title' => __('Authenticate Token', 'personalize-login'),
                'content' => '[passwordless-remote-auth]'
            ),



        );

        foreach ($page_definitions as $slug => $page) {
            // Check that the page doesn't exist already
            $query = new WP_Query('pagename=' . $slug);
            if (!$query->have_posts()) {
                // Add the page using the data from the array above
                wp_insert_post(
                    array(
                        'post_content'   => $page['content'],
                        'post_name'      => $slug,
                        'post_title'     => $page['title'],
                        'post_status'    => 'publish',
                        'post_type'      => 'page',
                        'ping_status'    => 'closed',
                        'comment_status' => 'closed',
                    )
                );
            }
        }
    }


    public function throw_error($message)
    {
        echo '<div class="error"><p>' . esc_html_e($message, "error") . '</p></div>';
    }

    public function do_custom_login()
    {
        if (
            'POST' == $_SERVER['REQUEST_METHOD']

        ) {


            if (sanitize_text_field(!isset($_POST['nonce']))) {

                die('nonce not set');
            }

            $nonce = sanitize_text_field($_POST['nonce']);


            if (wp_verify_nonce($nonce, 'passwordless_login_nonce')) {



                $type = sanitize_text_field($_POST['type']);
                if ($type == '1') {
                    $username = sanitize_text_field($_POST['username']);
                    $password = sanitize_text_field($_POST['password']);
                    $usr =  wp_authenticate($username, $password);
                    if (!is_wp_error($usr)) {
                        wp_clear_auth_cookie();
                        wp_set_current_user($usr->ID);
                        wp_set_auth_cookie($usr->ID);


                        wp_safe_redirect(wp_login_url());
                        exit();
                    }
                } else {

                    if (sanitize_text_field(!isset($_POST['token']))) {
                        die('Invalid token');
                    }
                    $accessToken = sanitize_text_field($_POST['token']);

                    $req = wp_remote_get('https://api.passwordless.com.au/v1/verifyToken/' . $accessToken);
                    if (is_wp_error($req)) {
                        return false;
                    }
                    $body = wp_remote_retrieve_body($req);
                    $response = json_decode($body);
                    if ($response->verified) {

                        $username = $response->email;
                        $user = get_user_by('login', $username);
                        if (!is_wp_error($user)) {
                            wp_clear_auth_cookie();
                            wp_set_current_user($user->ID);
                            wp_set_auth_cookie($user->ID);

                            $redirect_to = wp_login_url();
                            wp_safe_redirect($redirect_to);
                            exit();
                        }
                    }
                }
            } else {
                die("Invalid nonce");
            }
        }
    }


    public function redirect_if_applicable()
    {
        if (isset($this->username)) {
            $this->login_user($this->username); // login and redirects, then exit();
        }
    }

    /**
     * Redirect the user to the custom login page instead of wp-login.php.
     */
    public function redirect_to_custom_login()
    {
        $redirect_to = sanitize_text_field($_REQUEST['redirect_to']) ? sanitize_text_field($_REQUEST['redirect_to']) : null;

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (is_user_logged_in()) {
                $this->redirect_logged_in_user($redirect_to);
                exit;
            }

            // The rest are redirected to the login page
            $login_url = home_url('member-login');
            if (!empty($redirect_to)) {
                $login_url = add_query_arg('redirect_to', $redirect_to, $login_url);
            }

            wp_redirect($login_url);
            exit;
        }
    }

    /**
     * Returns the URL to which the user should be redirected after the (successful) login.
     *
     * @param string           $redirect_to           The redirect destination URL.
     * @param string           $requested_redirect_to The requested redirect destination URL passed as a parameter.
     * @param WP_User|WP_Error $user                  WP_User object if login was successful, WP_Error object otherwise.
     *
     * @return string Redirect URL
     */
    public function redirect_after_login($redirect_to, $requested_redirect_to, $user)
    {
        $redirect_url = home_url();

        if (!isset($user->ID)) {
            return $redirect_url;
        }

        if (user_can($user, 'manage_options')) {
            // Use the redirect_to parameter if one is set, otherwise redirect to admin dashboard.
            if ($requested_redirect_to == '') {
                $redirect_url = admin_url();
            } else {
                $redirect_url = $redirect_to;
            }
        } else {
            // Non-admin users always go to their account page after login
            $redirect_url = home_url('member-account');
        }

        return wp_validate_redirect($redirect_url, home_url());
    }

    /**
     * Redirect to custom login page after the user has been logged out.
     */
    public function redirect_after_logout()
    {
        $redirect_url = home_url('member-login?logged_out=true');
        wp_safe_redirect($redirect_url);
        exit;
    }

    /**
     * Redirect the user after authentication if there were any errors.
     *
     * @param Wp_User|Wp_Error  $user       The signed in user, or the errors that have occurred during login.
     * @param string            $username   The user name used to log in.
     * @param string            $password   The password used to log in.
     *
     * @return Wp_User|Wp_Error The logged in user, or error information if there were errors.
     */
    public function maybe_redirect_at_authenticate($user, $username, $password)
    {
        // Check if the earlier authenticate filter (most likely,
        // the default WordPress authentication) functions have found errors
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (is_wp_error($user)) {
                $error_codes = join(',', $user->get_error_codes());

                $login_url = home_url('member-login');
                $login_url = add_query_arg('login', $error_codes, $login_url);

                wp_redirect($login_url);
                exit;
            }
        }

        return $user;
    }


    //
    // FORM RENDERING SHORTCODES
    //

    /**
     * A shortcode for rendering the login form.
     *
     * @param  array   $attributes  Shortcode attributes.
     * @param  string  $content     The text content for shortcode. Not used.
     *
     * @return string  The shortcode output
     */


    public function render_remote_auth($attributes, $content = null)
    {
        // Parse shortcode attributes
        $default_attributes = array(
            'show_title' => false,
        );

        $attributes = shortcode_atts($default_attributes, $attributes);





        // Error messages
        $errors = array();
        if (isset($_REQUEST['login'])) {
            $error_codes = explode(',', sanitize_text_field($_REQUEST['login']));

            foreach ($error_codes as $code) {
                $errors[] = $this->get_error_message($code);
            }
        }
        $attributes['errors'] = $errors;

        return $this->get_template_html('remote_auth', $attributes);
    }
    public function render_login_form($attributes, $content = null)
    {
        // Parse shortcode attributes
        $default_attributes = array('show_title' => false);
        $attributes = shortcode_atts($default_attributes, $attributes);

        if (is_user_logged_in()) {
            return __('You are already signed in.', 'personalize-login');
        }

        // Pass the redirect parameter to the WordPress login functionality: by default,
        // don't specify a redirect, but if a valid redirect URL has been passed as
        // request parameter, use it.
        $attributes['redirect'] = '';
        if (sanitize_text_field(isset($_REQUEST['redirect_to']))) {
            $attributes['redirect'] = wp_validate_redirect($_REQUEST['redirect_to'], $attributes['redirect']);
        }

        // Error messages
        $errors = array();
        if (sanitize_text_field(isset($_REQUEST['login']))) {
            $error_codes = explode(',', sanitize_text_field($_REQUEST['login']));

            foreach ($error_codes as $code) {
                $errors[] = $this->get_error_message($code);
            }
        }
        $attributes['errors'] = $errors;

        // Check if user just logged out
        $attributes['logged_out'] = sanitize_text_field(isset($_REQUEST['logged_out'])) && sanitize_text_field($_REQUEST['logged_out']) == true;

        // Render the login form using an external template
        return $this->get_template_html('login_form', $attributes);
    }




    /**
     * Renders the contents of the given template to a string and returns it.
     *
     * @param string $template_name The name of the template to render (without .php)
     * @param array  $attributes    The PHP variables for the template
     *
     * @return string               The contents of the template.
     */
    private function get_template_html($template_name, $attributes = null)
    {
        if (!$attributes) {
            $attributes = array();
        }

        ob_start();

        do_action('personalize_login_before_' . $template_name);

        require('templates/' . $template_name . '.php');


        do_action('personalize_login_after_' . $template_name);

        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }


    //
    // HELPER FUNCTIONS
    //

    /**
     * Redirects the user to the correct page depending on whether he / she
     * is an admin or not.
     *
     * @param string $redirect_to   An optional redirect_to URL for admin users
     */
    private function redirect_logged_in_user($redirect_to = null)
    {
        $user = wp_get_current_user();
        if (user_can($user, 'manage_options')) {
            if ($redirect_to) {
                wp_safe_redirect($redirect_to);
            } else {
                wp_redirect(admin_url());
            }
        } else {
            wp_redirect(home_url('member-account'));
        }
    }

    /**
     * Finds and returns a matching error message for the given error code.
     *
     * @param string $error_code    The error code to look up.
     *
     * @return string               An error message.
     */
    private function get_error_message($error_code)
    {
        switch ($error_code) {
                // Login errors


            case 'empty_username':
                return __('You do have an email address, right?', 'personalize-login');

            case 'empty_password':
                return __('You need to enter a password to login.', 'personalize-login');

            case 'invalid_username':
                return __(
                    "We don't have any users with that email address. Maybe you used a different one when signing up?",
                    'personalize-login'
                );

            case 'incorrect_password':
                $err = __(
                    "The password you entered wasn't quite right. <a href='%s'>Did you forget your password</a>?",
                    'personalize-login'
                );
                return sprintf($err, wp_lostpassword_url());

            default:
                break;
        }

        return __('An unknown error occurred. Please try again later.', 'personalize-login');
    }

    protected function login_user($username)
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

    public function process_post()
    {
        if (isset($_POST['username'])) {
            $username = sanitize_text_field($_POST['username']);

            $this->login_user($username);
        }
    }
}


$passwordless_login_pages_plugin = new Passwordless_login();
