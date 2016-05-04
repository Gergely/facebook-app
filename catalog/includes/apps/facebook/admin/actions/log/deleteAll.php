<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2016 osCommerce

  Released under the GNU General Public License
*/

  tep_db_query('delete from oscom_app_facebook_log');

  $OSCOM_Facebook->addAlert($OSCOM_Facebook->getDef('alert_delete_success'), 'success');

  tep_redirect(tep_href_link('facebook.php', 'action=log'));
?>
