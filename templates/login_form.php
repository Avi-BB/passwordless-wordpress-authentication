<div class="content">

<div class="container">
    <?php if ($attributes['show_title']) : ?>
    <h2><?php _e('Sign In', 'personalize-login'); ?></h2>
    <?php endif; ?>




    <div class="row align-items-stretch justify-content-center no-gutters">

        <!-- Show errors if there are any -->

        <div class="col-md-7 col-sm-12">
            <div class="card">
            <div style="margin:0 auto; text-align: center;">
                <img id="appLogo" width=80  style="object-fit:fill; height: 50px; margin-top: 1rem"/>
            </div>
                <div class="card-body">
                    <h4 class="text-center card-title">Passwordless Login</h4>
                    <?php if (count($attributes['errors']) > 0) : ?>
                    <?php foreach ($attributes['errors'] as $error) : ?>
                    <code>
                                <?php echo $error; ?>
                            </code>
                    <?php endforeach; ?>
                    <?php endif; ?>

                    <!-- Show logged out message if user just logged out -->
                    <?php if ($attributes['logged_out']) : ?>
                    <code>
                            <?php _e('You have signed out. Would you like to sign in again?', 'personalize-login'); ?>
                        </code>
                    <?php endif; ?>
              
                    <div class="form h-100 contact-wrap pt-5">

                        <form class="mb-2 mt-5" id="contactForm" name="contactForm">
                            <div class="row">
                                <div class="col-md-12 form-group mb-3">
                                    <input type="text" class="form-control" name="username" id="username"
                                        placeholder="Username" required>
                                </div>
                            </div>
                            <div class="row" id="password-section" style="display: none;">
                                <div class="col-md-12 form-group mb-3">
                                    <input type="password" class="form-control" name="password" id="password"
                                        placeholder="Password">
                                </div>
                            </div>



                            <div class="form-group" id="passwordless-section" style="display: none;">
                                <select class="form-select dropdownOption" id="authMethod" name="authMethod"
                                    aria-label="Default select example">
                                    <option selected>Select Options For Login</option>
                                    <option value="1">Same Platform</option>
                                    <option value="2">Appless QR</option>
                                    <option value="3">InApp QR</option>
                                    <option value="4">Push Notification</option>
                                </select>
                            </div>

                            <div class="form-group">

                                <p>Select Method for Authentication</p>

                                <div>
                                    <input type="radio" value="1" name="type" id="type1">
                                    <label for="type1">Password Based</label>

                                </div>
                                <div>
                                    <input type="radio" value="2" name="type" id="type2">
                                    <label for="type2">Password Less</label>

                                </div>




                            </div>
                            <input id="nonce" readonly hidden
                                value="<?php echo esc_attr(wp_create_nonce('passwordless_login_nonce')) ?>">

                            <div class="row justify-content-center mt-3">
                                <div class="col-md-5 form-group text-center">
                                    <input class="btn btn-block btn-primary rounded-0 py-2 px-4"
                                        style="color: #fff;" value="Login" type="submit">
                                </div>
                            </div>


                        </form>




                        <a class="forgot-password" href="<?php echo wp_lostpassword_url(); ?>">
                            <?php _e('Forgot your password?', 'personalize-login'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="loginModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <button type="button" class="close p-3 text-right" data-dismiss="modal">&times;</button>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="row d-flex justify-content-center">
                    <h3>Passwordless Sign in</h3>
                </div>
                <h3 class="text-center mt-4">Verify It's You</h3>
                <p class="text-center">Scan the code below using your phones camera</p>
                <div class="row d-flex justify-content-center">
                    <img src="" id="qrImg" style="width: 18rem;">
                </div>
            </div>

        </div>
    </div>
</div>

</div>


<!-- <div class="login-form-container">
<form method="post" action="<?php echo wp_login_url(); ?>">
    <p class="login-username">
        <label for="user_login"><?php _e('Email'); ?></label>
        <input type="text" name="log" id="user_login">
    </p>
    <p class="login-password">
        <label for="user_pass"><?php _e('Password', 'personalize-login'); ?></label>
        <input type="password" name="pwd" id="user_pass">
    </p>
    <p class="login-submit">
        <input type="submit" value="<?php _e('Sign In', 'personalize-login'); ?>">
    </p>
</form>
</div> -->

<script>
document.querySelectorAll("input[name='type']").forEach((input) => {
input.addEventListener('change', function() {

//for radio button  
if (this.value == 1) {
    document.getElementById("password-section").style.display = "block";
    document.getElementById("passwordless-section").style.display = "none";
} else {
    document.getElementById("password-section").style.display = "none";
    document.getElementById("passwordless-section").style.display = "block";
}


})
});

</script>


<?php

global $wpdb, $base, $client;
$sql = "SELECT * FROM wp_passwordlessadmin";
$results = $wpdb->get_results($sql);
   foreach( $results as $result ) {

        $base = $result->base_url;
        $client = $result->client_id;

   }
?>
<div style="display:none">
<input id="client-id" value="<?php echo $client?>"></input>
<input id="base-url" value="<?php echo $base?>"></input>
<input id="login-url" value="<?php echo wp_login_url(); ?>">
<input id="redirect-url" value="<?php echo get_site_url()?>"></input>
</div>

