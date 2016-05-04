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

<?php
  foreach ( $OSCOM_Facebook->getModules() as $m ) {
    if ( $OSCOM_Facebook->isInstalled($m) ) {
      echo $OSCOM_Facebook->drawButton($OSCOM_Facebook->getModuleInfo($m, 'short_title'), tep_href_link('facebook.php', 'action=configure&module=' . $m), 'info', 'data-module="' . $m . '"') . "\n";
    }
  }
?>

  <?php echo $OSCOM_Facebook->drawButton($OSCOM_Facebook->getDef('section_general'), tep_href_link('facebook.php', 'action=configure&module=G'), 'info', 'data-module="G"'); ?>
  <?php echo $OSCOM_Facebook->drawButton($OSCOM_Facebook->getDef('section_more'), '#', 'info', 'data-module="appFacebookToolbarMoreButton"'); ?>
</div>

<ul id="appFacebookToolbarMore" class="fb-button-menu">

<?php
  foreach ( $OSCOM_Facebook->getModules() as $m ) {
    if ( !$OSCOM_Facebook->isInstalled($m) ) {
      echo '<li><a href="' . tep_href_link('facebook.php', 'action=configure&module=' . $m) . '">' . $OSCOM_Facebook->getModuleInfo($m, 'title') . '</a></li>';
    }
  }
?>

</ul>

<script>
$(function() {
  $('#appFacebookToolbarMore').hide();

  if ( $('#appFacebookToolbarMore li').size() > 0 ) {
    $('#appFacebookToolbarMore').menu().hover(function() {
      $(this).show();
    }, function() {
      $(this).hide();
    });

    $('#appFacebookToolbar a[data-module="appFacebookToolbarMoreButton"]').click(function() {
      return false;
    }).hover(function() {
      $('#appFacebookToolbarMore').show().position({
        my: 'left top',
        at: 'left bottom',
        of: this
      });
    }, function() {
      $('#appFacebookToolbarMore').hide();
    });
  } else {
    $('#appFacebookToolbar a[data-module="appFacebookToolbarMoreButton"]').hide();
  }
});
</script>

<?php
  if ( $OSCOM_Facebook->isInstalled($current_module) || ($current_module == 'G') ) {
    $current_module_title = ($current_module != 'G') ? $OSCOM_Facebook->getModuleInfo($current_module, 'title') : $OSCOM_Facebook->getDef('section_general');
    $req_notes = ($current_module != 'G') ? $OSCOM_Facebook->getModuleInfo($current_module, 'req_notes') : null;

    if ( is_array($req_notes) && !empty($req_notes) ) {
      foreach ( $req_notes as $rn ) {
        echo '<div class="fb-panel fb-panel-warning"><p>' . $rn . '</p></div>';
      }
    }
?>

<form name="facebookConfigure" action="<?php echo tep_href_link('facebook.php', 'action=configure&subaction=process&module=' . $current_module); ?>" method="post" class="fb-form">

<h3 class="fb-panel-header-info"><?php echo $current_module_title; ?></h3>
<div class="fb-panel fb-panel-info" style="padding-bottom: 15px;">

<?php
    foreach ( $OSCOM_Facebook->getInputParameters($current_module) as $cfg ) {
      echo $cfg;
    }
?>

</div>

<p>

<?php
    echo $OSCOM_Facebook->drawButton($OSCOM_Facebook->getDef('button_save'), null, 'success');

    if ( $current_module != 'G' ) {
      echo '  <span style="float: right;">' . $OSCOM_Facebook->drawButton($OSCOM_Facebook->getDef('button_dialog_uninstall'), '#', 'warning', 'data-button="facebookButtonUninstallModule"') . '</span>';
    }
?>

</p>

</form>

<?php
    if ( $current_module != 'G' ) {
?>

<div id="facebook-dialog-uninstall" title="<?php echo tep_output_string_protected($OSCOM_Facebook->getDef('dialog_uninstall_title')); ?>">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><?php echo $OSCOM_Facebook->getDef('dialog_uninstall_body'); ?></p>
</div>

<script>
$(function() {
  $('#facebook-dialog-uninstall').dialog({
    autoOpen: false,
    resizable: false,
    modal: true,
    buttons: {
      "<?php echo addslashes($OSCOM_Facebook->getDef('button_uninstall')); ?>": function() {
        window.location = '<?php echo tep_href_link('facebook.php', 'action=configure&subaction=uninstall&module=' . $current_module); ?>';
      },
      "<?php echo addslashes($OSCOM_Facebook->getDef('button_cancel')); ?>": function() {
        $(this).dialog('close');
      }
    }
  });

  $('a[data-button="facebookButtonUninstallModule"]').click(function(e) {
    e.preventDefault();

    $('#facebook-dialog-uninstall').dialog('open');
  });
});
</script>

<?php
    }
  } else {
?>

<h3 class="fb-panel-header-warning"><?php echo $OSCOM_Facebook->getModuleInfo($current_module, 'title'); ?></h3>
<div class="fb-panel fb-panel-warning">
  <?php echo $OSCOM_Facebook->getModuleInfo($current_module, 'introduction'); ?>
</div>

<p>
  <?php echo $OSCOM_Facebook->drawButton($OSCOM_Facebook->getDef('button_install_title', array('title' => $OSCOM_Facebook->getModuleInfo($current_module, 'title'))), tep_href_link('facebook.php', 'action=configure&subaction=install&module=' . $current_module), 'success'); ?>
</p>

<?php
  }
?>

<script>
$(function() {
  $('#appFacebookToolbar a[data-module="<?php echo $current_module; ?>"]').addClass('fb-button-primary');
});
</script>
