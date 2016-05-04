<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2016 osCommerce

  Released under the GNU General Public License
*/

  $data = array();

  if ( $current_module == 'FB' ) {
    $data = array('OSCOM_APP_FACEBOOK_SELLER_EMAIL' => isset($HTTP_POST_VARS['seller_email']) ? tep_db_prepare_input($HTTP_POST_VARS['seller_email']) : '',
                  'OSCOM_APP_FACEBOOK_API_CLIENT_ID' => isset($HTTP_POST_VARS['client_id']) ? tep_db_prepare_input($HTTP_POST_VARS['client_id']) : '',
                  'OSCOM_APP_FACEBOOK_API_SECRET' => isset($HTTP_POST_VARS['secret']) ? tep_db_prepare_input($HTTP_POST_VARS['secret']) : '',
                  'OSCOM_APP_FACEBOOK_API_VERSION' => isset($HTTP_POST_VARS['version']) ? tep_db_prepare_input($HTTP_POST_VARS['version']) : ''
                  );
  }

  foreach ( $data as $key => $value ) {
    $OSCOM_Facebook->saveParameter($key, $value);
  }

  $OSCOM_Facebook->addAlert($OSCOM_Facebook->getDef('alert_credentials_saved_success'), 'success');

  tep_redirect(tep_href_link('facebook.php', 'action=credentials&module=' . $current_module));
?>
