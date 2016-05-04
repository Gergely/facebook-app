<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2016 osCommerce

  Released under the GNU General Public License
*/

  function app_facebook_get_admin_box_links() {
    $facebook_menu = array(
      array('code' => 'facebook.php',
            'title' => MODULES_ADMIN_MENU_FACEBOOK_START,
            'link' => tep_href_link('facebook.php'))
    );

    $facebook_menu_check = array('OSCOM_APP_FACEBOOK_LOGIN_STATUS',
                                 'OSCOM_APP_FACEBOOK_API_CLIENT_ID');

    foreach ( $facebook_menu_check as $value ) {
      if ( defined($value) && tep_not_null(constant($value)) ) {
        $facebook_menu = array(
          array('code' => 'facebook.php',
                'title' => MODULES_ADMIN_MENU_FACEBOOK_CONFIGURE,
                'link' => tep_href_link('facebook.php', 'action=configure')),
          array('code' => 'facebook.php',
                'title' => MODULES_ADMIN_MENU_FACEBOOK_MANAGE_CREDENTIALS,
                'link' => tep_href_link('facebook.php', 'action=credentials')),
          array('code' => 'facebook.php',
                'title' => MODULES_ADMIN_MENU_FACEBOOK_LOG,
                'link' => tep_href_link('facebook.php', 'action=log'))
        );

        break;
      }
    }

    return $facebook_menu;
  }
?>
