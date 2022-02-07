<div sstyle="margin: 0 auto; text-align: center; ">
    <h1>Documentation: Passwordless Admin Authentication </h1>
    <p style="width:50%">
    <ol style="font-size:0.9rem; color: #000; width: 60%;">
        <li>  Login to your WordPress developer dashboard</li>
        <li>Install the passworldess authentication plugin</li>
        <li> First need to create account on https://www.passwordless.com.au/</li>
        <li>

             Go to dashboard, click on add application and create on Web/WordPress app and get the details such as clientId and baseUrl

        </li>
        <li>

           Come back to wordpress developer setting you'll see the passworldess menu

        </li>

        <li>

           Go to passwordless configue and click on <strong>create</strong> button <strong>only once</strong>.

        </li>
        <li>
          Fill the details which is base url and client Id.

        </li>

        <li>
           Save the settings

        </li>
        <li>

          Two pages are generated one is Passworldless Sign in and other is authentication token

        </li>
        <li>

        If passwordless login page slug is not memeber-login then change to that it must have member-login slug. ex if site name is https://www.exmaple.com then the login in page url is https://www.example.com/member-login

        </li>

        <li>

            Come back to passworldess menu in wordpress you'll see the add device option

        </li>
        <li>

            Click on add device and add your device if user is register successfully then alert will display "Registration successfull" or  if user is aleardy register then alert will display "User Already Exist !!".

        </li>
    </ol>

   

    </p>
</div>