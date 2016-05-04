<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2016 osCommerce

  Released under the GNU General Public License
*/
?>

<div id="fbStartDashboard" style="width: 100%;">

<?php
/*  if ( $OSCOM_Facebook->isReqApiCountrySupported(STORE_COUNTRY) ) {
?>

  <div style="float: left; width: 50%;">
    <div style="padding: 2px;">
      <h3 class="fb-panel-header-info"><?php echo $OSCOM_Facebook->getDef('onboarding_intro_title'); ?></h3>
      <div class="fb-panel pp-panel-info">
        <?php echo $OSCOM_Facebook->getDef('onboarding_intro_body', array('button_retrieve_credentials' => $OSCOM_Facebook->drawButton($OSCOM_Facebook->getDef('button_retrieve_credentials'), tep_href_link('facebook.php', 'action=start&subaction=process&type=live'), 'info'), 'button_retrieve_sandbox_credentials' => $OSCOM_Facebook->drawButton($OSCOM_Facebook->getDef('button_retrieve_sandbox_credentials'), tep_href_link('facebook.php', 'action=start&subaction=process&type=sandbox'), 'info'))); ?>
      </div>
    </div>
  </div>

<?php
  } */
?>

  <div style="float: left; width: 50%;">
    <div style="padding: 2px;">
      <h3 class="fb-panel-header-warning"><?php echo $OSCOM_Facebook->getDef('manage_credentials_title'); ?></h3>
      <div class="fb-panel pp-panel-warning">
        <?php echo $OSCOM_Facebook->getDef('manage_credentials_body', array('button_manage_credentials' => $OSCOM_Facebook->drawButton($OSCOM_Facebook->getDef('button_manage_credentials'), tep_href_link('facebook.php', 'action=credentials'), 'warning'))); ?>
      </div>
    </div>
  </div>
</div>

<script>
$(function() {
  $('#fbStartDashboard > div:nth-child(2)').each(function() {
    if ( $(this).prev().height() < $(this).height() ) {
      $(this).prev().height($(this).height());
    } else {
      $(this).height($(this).prev().height());
    }
  });
});
</script>
