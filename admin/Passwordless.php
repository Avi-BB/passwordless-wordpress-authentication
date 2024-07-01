<div style=" background-color: #fff; padding:1rem; width: 50%; margin-top: 1rem">
    <h1 style="color: #00a0d2;">Documentation: Passwordless Admin Authentication </h1>
    <p >
    <ol style="font-size:0.9rem; color: #000; width: 80%; text-align:justify;">
        <li>Install the passwordless authentication plugin</li>
        <li> First need to create account on <a href="https://app.passwordless4u.com/" target="_blank" noreferrer>https://app.passwordless4u.com/</a></li>
        <li>

             Go to Passwordless's dashboard, click on add application and create on Web/WordPress app and get the details such as clientId and baseUrl
        </li>
        <li>

           Come back to wordpress developer setting you'll see the Passwordless menu, click on <strong>Configure</strong>

        </li>

        <li>
          Fill the details which is base url and client Id

        </li>

        <li>
           Save the settings

        </li>
        <li>
        After configuring the plugin, you will see a below  <strong>Add Device</strong> menu button, click on it.

        </li>
        <li>
        <p>
                <strong>Select the options</strong>
                <br />
                There are three option to select from.
                <ul>
                  <li><strong>Same platform or This Device: </strong> you can register your device with inbuilt methods such as biometric, pin or the device inbuilt security.</li>
                  <li><strong>Appless QR or Remote auth with appless QR: </strong> Register your remote device scanning the qr code.</li>
                  <strong>inApp QR or Remote auth with inApp QR: </strong> Register your remote device scanning the qr code with passwordless mobile app.
                  <li>
                    <br/>
                    <strong>Note: </strong>
                    <p style="color:red;">For inApp Authentication: You need to create folder called <code>.well-known</code> in root directory
                     (where your <code>wp-admin, wp-content, and wp-includes</code> folder are there)
                      and in that folder you need to add <a  href="<?php echo plugin_dir_url(__FILE__) . '/assetlinks.json' ?>" download>assetlinks.json</a> (JSON) file</p>
                  </li>
                 
                </ul>
              </p>
        </li>
        <li>After successful registration, you ready to use the passwordless authentication for your WordPress account.</li>

    </ol>

   

    </p>
</div>
<script>
const download = document.getElementById("fileRequest");

download.addEventListener('click', request);

function request() {
    window.location = './assetlinks.json';
}
  </script>