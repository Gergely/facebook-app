<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2016 osCommerce

  Released under the GNU General Public License
*/

  $OSCOM_Facebook->install($current_module);

  $OSCOM_Facebook->addAlert($OSCOM_Facebook->getDef('alert_module_install_success'), 'success');

  tep_redirect(tep_href_link('facebook.php', 'action=configure&module=' . $current_module));
?>
