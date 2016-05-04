<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2016 osCommerce

  Released under the GNU General Public License
*/

  $content = 'configure.php';

  $modules = $OSCOM_Facebook->getModules();
  $modules[] = 'G';

  $default_module = 'G';

  foreach ( $modules as $m ) {
    if ( $OSCOM_Facebook->isInstalled($m) ) {
      $default_module = $m;
      break;
    }
  }

  $current_module = (isset($HTTP_GET_VARS['module']) && in_array($HTTP_GET_VARS['module'], $modules)) ? $HTTP_GET_VARS['module'] : $default_module;

  if ( !defined('OSCOM_APP_FACEBOOK_LOG_TRANSACTIONS') ) {
    $OSCOM_Facebook->saveParameter('OSCOM_APP_FACEBOOK_LOG_TRANSACTIONS', '1');
  }
?>
