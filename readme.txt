=== Passwordless Authentication ===
Contributors: ![Passwordless Team](https://www.passwordless4u.com)
Tags:  oauth, sso, authentication, encryption, ssl, secure, security, strong, harden, sign up, sign in, login, log in, sign out, lock, unlock, alert,  wp-login, 2 step authentication, two-factor , two step, two factor, 2-Factor, 2fa, two, tfa, mfa, qr, multi-factor, multifactorial
Requires at least: 4.7.0
Tested up to: 5.9
Stable tag: 1.3.5
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

 Go passwordless authentication and eliminate security risks.

== Description ==

Passwordless passwordless authentication Plugin enables your WordPress admin/team login system to utilize FIDO/FIDO2 certified strong customer authentication, including the ability to provide more sensitive operations such as credential management. By leveraging the end user’s existing device biometrics you can quickly integrate multi-factor authentication into your site. Our service is aligned with PSD2, GDPR, CCPA, and HIPPA.

== Benefits: ==
Privacy:
  – Biometric information never leaves your device (based on FIDO/FIDO2 principles), not stored in the cloud.
  - No tracking of customers.
Convenience: 
  - Eliminate the need for your users to enter a password when they log in to your website from their primary device.
  - Reduce your user abandonment rates by making transactions as seamless as possible.
Compliance: 
  - FIDO/FIDO2 is aligned with the GDPR and PSD2 principals around the use of strong authentication.
Security:
  - Boost your website’s security through the use of multifactorial authentication with strong public/private key credentials.

For more information on how the passwordless authentication plugin works, please view our [documentation](https://docs.passwordless4u.com/).

== Tell us how we’re doing. ==
Have the plugin in production? Tell us about your site on [help@passwordless4u.com](help@passwordless4u.com) and we’ll post on our social channels!

== Installation ==

1. Upload to the `/wp-content/plugins/` directory.
2. Activate the plugin.
3. Visit Settings > Passwordless to configure this plugin.

== Frequently Asked Questions ==

== How do I set up the plugin? ==

An answer to that question.

Once you install the plugin, click on ‘Configure’. Here, you have two setup options:

*Let Passwordless do the work for you (estimated time: 15s to 30s)*

1. Login to your WordPress developer dashboard
2. Install the Passwordless authentication plugin
3. First need to create account on https://www.passwordless4u.com/
4. Go to dashboard, click on add application and create on Web/WordPress app and get the details such as clientId and baseUrl
5. Come back to wordpress developer setting you'll see the Passwordless menu
6. fill the details such as base url and client Id.
7. save the settings
8. Two pages are generated one is Passwordless Sign in and other is authentication token
9.  Passwordless menu, you'll see the add device option, click on it.
10. Choose authentication method, there are 3 authentication method 1. Same Device 2. Appless QR and 3. InApp QR 
choose one of them and hit on register button.
11. Once you register you can add more devices to your account. Choose the authentication methods and hit on add device button.
12. Done.

== Screenshots ==

1. screenshot-1.png
2. screenshot-2.png
3. screenshot-3.png
4. screenshot-4.png

== For whom this plugin for? ==
This plugin only for the wordpress admin and other wordpress role base user  this plugin authenticate the wordpress admin and other team members.

== I need to customize the plugin or I need support and help? ==
Please email us at [help@passwordless4u.com](help@passwordless4u.com)

== Where can I report bugs or leave feedback? ==
Please email us at [help@passwordless4u.com](help@passwordless4u.com) 

== I have other queries or need additional support. ==
For any other queries or if you need additional support, please email us at [help@passwordless4u.com](help@passwordless4u.com) 
= Error: ClientId and BaseUrl is not added =
This error means that the plugin is unable to verify the validity of the login or register claim. This can often be resulted from a bad baseURL and api key combination. Please double check your Base URL and clientId API Key parameters in the plugin settings against your credentials on the Passwordless's dashboard.

= 1.3.5 =
issue resolved

= 1.3.2 =
issue resolved

= 1.3.1 =
resolved issues with inApp Auth and Push notification.

= 1.3.0 =
improved the plugin functionality and added passwordless mobile links.

= 1.2.2 =
remove create table function: no need anymore

= 1.2.1 =
Multiple device support added.

= 1.2.0 =
Simple the flow of plugin
fix the issues
added login functionality for all team members

= 1.1.0 =
documentation changes

= 1.0.0 =
Initial Version. 
Features: 
- Same Platform login (Biometric, face, pin)
-Appless QR login(for remote login)
- inApp QR (through passwordless's custom android and ios app)


== Upgrade Notice ==
Not applicable at the moment