<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2016 osCommerce

  Released under the GNU General Public License
*/

  if ( $current_module == 'G' ) {
    $cut = 'OSCOM_APP_FACEBOOK_';
  } else {
    $cut = 'OSCOM_APP_FACEBOOK_' . $current_module . '_';
  }

  $cut_length = strlen($cut);

  foreach ( $OSCOM_Facebook->getParameters($current_module) as $key ) {
    $p = strtolower(substr($key, $cut_length));

    if ( isset($HTTP_POST_VARS[$p]) ) {
      $OSCOM_Facebook->saveParameter($key, $HTTP_POST_VARS[$p]);
    }
  }

  $OSCOM_Facebook->addAlert($OSCOM_Facebook->getDef('alert_cfg_saved_success'), 'success');

  tep_redirect(tep_href_link('facebook.php', 'action=configure&module=' . $current_module));
?>
