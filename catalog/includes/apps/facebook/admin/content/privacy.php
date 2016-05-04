<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2016 osCommerce

  Released under the GNU General Public License
*/
?>

<h2><?php echo $OSCOM_Facebook->getDef('privacy_title'); ?></h2>

<?php echo $OSCOM_Facebook->getDef('privacy_body', array('api_req_countries' => implode(', ', $OSCOM_Facebook->getReqApiCountries()))); ?>
