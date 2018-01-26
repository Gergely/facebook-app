<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2016 osCommerce

  Released under the GNU General Public License
*/
?>

<div id="appFacebookToolbar" style="padding-bottom: 15px;">
  <?php echo $OSCOM_Facebook->drawButton($OSCOM_Facebook->getDef('section_facebook'), tep_href_link('facebook.php', 'action=credentials&module=FB'), 'info', 'data-module="FB"'); ?>
</div>

<form name="facebookCredentials" action="<?php echo tep_href_link('facebook.php', 'action=credentials&subaction=process&module=' . $current_module); ?>" method="post" class="fb-form">

<?php
  if ( $current_module == 'FB' ) {
?>

<h3 class="fb-panel-header-warning"><?php echo $OSCOM_Facebook->getDef('facebook_title'); ?></h3>
<div class="fb-panel fb-panel-warning">
  <table>
    <tr>
      <td width="420px" valign="top">
        <div>
          <p>
            <label for="client_id"><?php echo $OSCOM_Facebook->getDef('facebook_api_client_id'); ?></label>
            <?php echo tep_draw_input_field('client_id', OSCOM_APP_FACEBOOK_API_CLIENT_ID); ?>
          </p>
        </div>

        <div>
          <p>
            <label for="secret"><?php echo $OSCOM_Facebook->getDef('facebook_api_secret'); ?></label>
            <?php echo tep_draw_input_field('secret', OSCOM_APP_FACEBOOK_API_SECRET); ?>
          </p>
        </div>

        <div>
          <p>
            <label><?php echo $OSCOM_Facebook->getDef('facebook_api_version'); ?></label>

          </p>
          <div id="versionSelection">
          <?php for ($i=0; $i<11; $i+=1) { ?>
            <input type="radio" id="versionSelection2<?= $i; ?>" name="version" value="v2.<?= $i; ?>"<?php echo (OSCOM_APP_FACEBOOK_API_VERSION == 'v2.'.(string)$i ? ' checked="checked"' : ''); ?>><label for="versionSelection2<?= $i; ?>">v2.<?= $i; ?></label>
          <?php } ?>
          </div>
<script>
$(function() {
  $('#versionSelection').buttonset();
});
</script>
        </div>
      </td>
      <td width="420px" valign="top">
        <div>
          <p>
            <label for="seller_email"><?php echo $OSCOM_Facebook->getDef('facebook_seller_email_address'); ?></label>
            <?php echo tep_draw_input_field('seller_email', OSCOM_APP_FACEBOOK_SELLER_EMAIL); ?>
          </p>
        </div>

      </td>
    </tr>
  </table>
</div>

<?php
  }
?>

<p><?php echo $OSCOM_Facebook->drawButton($OSCOM_Facebook->getDef('button_save'), null, 'success'); ?></p>

</form>

<script>
$(function() {
  $('#appFacebookToolbar a[data-module="<?php echo $current_module; ?>"]').addClass('fb-button-primary');
});
</script>
