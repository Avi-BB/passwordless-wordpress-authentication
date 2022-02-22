
<?php function custom_user_profile_fields($profileuser){
    global $wpdb, $base, $client, $current_user;
    wp_get_current_user();
    $sql = "SELECT * FROM wp_passwordlessadmin";
    $results = $wpdb->get_results($sql);
    foreach ($results as $result) {
        $base = $result->base_url;
        $client = $result->client_id;
    }
?>
<style>
    .submit-btn {
        background-color: #00a0d2;
        color: white;
        border: none;
        border-radius: 0.2rem;
        padding: 0.3rem 0.7rem;
        font-size: 1rem;
        cursor: pointer;
    }
</style>
<div class="card">
        <h2 style="margin: 0 auto; text-align:center">Passwordless Authentication</h2>
        <div class="card-body" style="text-align:center">
            <h3 class="card-title">Welcome
                <strong id="pwl-username"><?php echo esc_html($current_user->user_login); ?></strong>
            </h3>
            <h4>Register yourself</h4>
            <div>
                <div name="addDevice">
                    <div style="margin-bottom:20px">
                        <select class="dropdownOption" id="authMethod" name="authMethod" aria-label="Default select example">
                            <option selected>Select Options For Registration</option>
                            <option value="1">This Device (Device Biometric/PIN)</option>
                            <option value="2">Appless QR (Remote Auth)</option>
                            <option value="3">InApp QR(Using Passwordless App)</option>

                        </select>
                    </div>
                    <div id="addTeam" style="text-align:center">
                        <button class="submit-btn">Register</button>
                    </div>
                    <br />
                    <div id="addTeamMemberDevice" style="text-align:center">
                        <button class="submit-btn">Add Device</button>
                    </div>
                </div>
            </div>
            <div style="display:none">
                <input id="client-id" type="text" value="<?php echo esc_attr($client) ?>"></input>
                <input id="base-url" type="text" value="<?php echo esc_attr($base) ?>"></input>
                <input id="redirect-url" value="<?php echo get_site_url() ?>"></input>
            </div>
            <div id="viewQR" style="margin-top:20px;display:none">
                <div style="margin:10px">
                    <h3>Scan QR from phone</h3>
                </div>
                <img src="" alt="" width="200px" height="200px" id="qrImg">
            </div>
        </div>
        <div style="text-align:center;">
            <div>
                <h3>Download Passwordless App</h3>
            </div>
            <div>
                <a href="https://play.google.com/store/apps/details?id=com.bluebricks.passwordless" target="_blank" rel="noreferrer"><button style="background-color:#b516b58a; border:none;; padding: 0.2rem; color:#fff; cursor:pointer; border-radius: 0.2rem;">Download Android App</button></a>
                <a href="https://apps.apple.com/us/app/passwordlessapp/id1587344101" target="_blank" rel="noreferrer"> <button style="background-color:#fb891ac4; border:none;; padding: 0.2rem; color:#fff; cursor:pointer;  border-radius: 0.2rem;">Download IOS App</button></a>
            </div>
        </div>
    </div>
<?php  
}
add_action('show_user_profile', 'custom_user_profile_fields');
?>