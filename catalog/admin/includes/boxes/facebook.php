<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2016 osCommerce

  Released under the GNU General Public License
*/

  include(DIR_FS_CATALOG . 'includes/apps/facebook/admin/functions/boxes.php');

  $cl_box_groups[] = array('heading' => MODULES_ADMIN_MENU_FACEBOOK_HEADING,
                           'apps' => app_facebook_get_admin_box_links());
?>