# facebook-app
Facebook App for osCommerce


Bootstraped template on shop site


Installation

1. download zip archive from this repo
2. unzip files
3. upload files to webshop catalog directory

4. download from https://github.com/facebook/php-graph-sdk the latest zip package
5. unzip and upload all files from src/Facebook directory to ext/api/Facebook directory

Setup

1. go administration
2. install module Facebook login
3. setup Facebook Login App

Create Facebook APP for your site (login)

1. Goto Facebook developer site (https://developers.facebook.com)
2. Add a new App from right menu
3. From **Settings** menu you need (App ID, App Secret, App Domains, Site URL)
4. Add in **Facebook Login** menu->Settings->Valid OAuth redirect URIs:
   http(s)://yourdomainpath/login.php, http(s)://yourdomainpath/login.php?action=facebook_login
5. Set Use Strict Mode for Redirect URIs to Yes
6. Add in **App Review** menu your app for public


Support:
http://forums.oscommerce.com
