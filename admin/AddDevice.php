

<?php

global $wpdb, $base, $client;
$sql = "SELECT * FROM wp_passwordlessadmin";
$results = $wpdb->get_results($sql);
foreach ($results as $result) {

    $base = $result->base_url;
    $client = $result->client_id;
}
?>

<?php global $current_user;
wp_get_current_user(); ?>
<style>
    .submit-btn {
        background-color: #00a0d2;
        color: white;
        border: none;
        border-radius: 0.2rem;
        padding: 0.3rem 0.7rem;
        font-size: 1rem;
        cursor: pointer;
        margin: 0.4rem auto;
    }
    .download-app-container{
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
    }
</style>
<div class="card">
    <div class="card-body" style="text-align:center">


        <h3 class="card-title">Welcome

            <span id="pwl-username"><?php echo esc_html($current_user->user_login); ?></span>
        </h3>
        <h4>Register yourself</h4>

        <div>
            <form id="addDevice" name="addDevice">
                <div style="margin-bottom:20px">
                    <select class="dropdownOption" id="authMethod" name="authMethod" aria-label="Default select example">
                        <option selected>Select Options For Registration</option>
                        <option value="1">Same Platform</option>
                        <option value="2">Appless QR</option>
                        <option value="3">InApp QR</option>

                    </select>
                </div>


                <div style="text-align:center">
                    <input class="submit-btn" value="Register" type="submit">

                </div>

            </form>
            <div id="addTeamMemberDevice" style="text-align:center">
                <button class="submit-btn">Add Device</button>
            </div>
        </div>
        <div id="viewQR" style="margin-top:20px;display:none">

            <div style="margin:10px">
                <h3>Scan QR from phone</h3>
            </div>
            <img src="" alt="" width="200px" height="200px" id="qrImg">
        </div>
    </div>
  <div>
  <div style="text-align:center;">
        <div>
            <h3 style="margin-bottom: 0;">Download Passwordless App</h3>
        </div>
    <div class="download-app-container">
    <a href="https://play.google.com/store/apps/details?id=com.bluebricks.passwordless" target="_blank" rel="noreferrer"><img width="120" src="<?php echo plugin_dir_url(__FILE__) . '/googlePlaystore.png' ?>" /></a>
       <a href="https://apps.apple.com/us/app/passwordlessapp/id1587344101" target="_blank" rel="noreferrer" ><img width="120" src="<?php echo plugin_dir_url(__FILE__) . '/appleAppStore.png' ?>" /> </a>
    </div>
    

  </div>

    </div>
</div>

<div style="display:none">
    <input id="client-id" type="text" value="<?php echo esc_attr($client) ?>"></input>
    <input id="base-url" type="text" value="<?php echo esc_attr($base) ?>"></input>
    <input id="redirect-url" value="<?php echo get_site_url() ?>"></input>
</div>