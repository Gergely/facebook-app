<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2016 osCommerce

  Released under the GNU General Public License
*/

  $content = 'credentials.php';

  $modules = array('FB');
  $current_module = (isset($HTTP_GET_VARS['module']) && in_array($HTTP_GET_VARS['module'], $modules) ? $HTTP_GET_VARS['module'] : $modules[0]);

  $data = array('OSCOM_APP_FACEBOOK_SELLER_EMAIL',
                'OSCOM_APP_FACEBOOK_API_CLIENT_ID',
                'OSCOM_APP_FACEBOOK_API_SECRET',
                'OSCOM_APP_FACEBOOK_API_VERSION');

  foreach ( $data as $key ) {
    if ( !defined($key) ) {
      $OSCOM_Facebook->saveParameter($key, '');
    }
  }
?>
