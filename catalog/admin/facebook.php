<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2016 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  if ( tep_db_num_rows(tep_db_query("show tables like 'oscom_app_facebook_log'")) != 1 ) {
    $sql = <<<EOD
CREATE TABLE oscom_app_facebook_log (
  id int unsigned NOT NULL auto_increment,
  customers_id int NOT NULL,
  module varchar(8) NOT NULL,
  action varchar(255) NOT NULL,
  result tinyint NOT NULL,
  server tinyint NOT NULL,
  request text NOT NULL,
  response text NOT NULL,
  ip_address int unsigned,
  date_added datetime,
  PRIMARY KEY (id),
  KEY idx_oapl_module (module)
) CHARACTER SET utf8 COLLATE utf8_unicode_ci;

EOD;

    tep_db_query($sql);
  }

  require(DIR_FS_CATALOG . 'includes/apps/facebook/OSCOM_Facebook.php');
  $OSCOM_Facebook = new OSCOM_Facebook();

  $content = 'start.php';
  $action = 'start';
  $subaction = '';

  $OSCOM_Facebook->loadLanguageFile('admin.php');

  if ( isset($HTTP_GET_VARS['action']) && file_exists(DIR_FS_CATALOG . 'includes/apps/facebook/admin/actions/' . basename($HTTP_GET_VARS['action']) . '.php') ) {
    $action = basename($HTTP_GET_VARS['action']);
  }

  $OSCOM_Facebook->loadLanguageFile('admin/' . $action . '.php');

/*   if ( $action == 'start' ) {
    if ( $OSCOM_Facebook->migrate() ) {
      if ( defined('MODULE_ADMIN_DASHBOARD_INSTALLED') ) {
        $admin_dashboard_modules = explode(';', MODULE_ADMIN_DASHBOARD_INSTALLED);

        if ( !in_array('d_facebook_app.php', $admin_dashboard_modules) ) {
          $admin_dashboard_modules[] = 'd_facebook_app.php';

          tep_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = '" . tep_db_input(implode(';', $admin_dashboard_modules)) . "' where configuration_key = 'MODULE_ADMIN_DASHBOARD_INSTALLED'");
          tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_ADMIN_DASHBOARD_FACEBOOK_APP_SORT_ORDER', '5000', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
        }
      }

      tep_redirect(tep_href_link('facebook.php', tep_get_all_get_params()));
    }
  } */

  include(DIR_FS_CATALOG . 'includes/apps/facebook/admin/actions/' . $action . '.php');

  if ( isset($HTTP_GET_VARS['subaction']) && file_exists(DIR_FS_CATALOG . 'includes/apps/facebook/admin/actions/' . $action . '/' . basename($HTTP_GET_VARS['subaction']) . '.php') ) {
    $subaction = basename($HTTP_GET_VARS['subaction']);
  }

  if ( !empty($subaction) ) {
    include(DIR_FS_CATALOG . 'includes/apps/facebook/admin/actions/' . $action . '/' . $subaction . '.php');
  }

  include(DIR_WS_INCLUDES . 'template_top.php');
?>

<style>
.fb-container {
  font-size: 12px;
  line-height: 1.5;
}

.fb-header {
  padding: 15px;
}

#fbAppInfo {
  color: #898989;
}

#fbAppInfo a {
  color: #000;
  padding-left: 10px;
}

#fbAppInfo a:hover {
  color: #000;
}

.fb-button {
  font-size: 12px;
  font-weight: bold;
  color: white;
  padding: 6px 10px;
  border: 0;
  border-radius: 4px;
  text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
  text-decoration: none;
  display: inline-block;
  cursor: pointer;
  white-space: nowrap;
  vertical-align: baseline;
  text-align: center;
  background-image: linear-gradient(transparent, rgba(0, 0, 0, 0.05) 40%, rgba(0, 0, 0, 0.1));
}

small .fb-button {
  font-size: 11px;
  padding: 4px 8px;
}

.fb-button:active {
  box-shadow: 0 0 0 1px rgba(0,0,0, 0.15) inset, 0 0 6px rgba(0,0,0, 0.20) inset;
}

.fb-button:focus {
  outline: 0;
}

.fb-button:hover {
  text-decoration: none;
  background-image: linear-gradient(transparent, rgba(0, 0, 0, 0.01) 100%, rgba(0, 0, 0, 0.1));
}

.fb-button.fb-button-success {
  background-color: #1cb841;
  border-left: 1px solid #097c20;
  border-bottom: 1px solid #097c20;
}

.fb-button.fb-button-error {
  background-color: #ca3c3c;
  border-left: 1px solid #610404;
  border-bottom: 1px solid #610404;
}

.fb-button.fb-button-warning {
  background-color: #ebaa16;
  border-left: 1px solid #986008;
  border-bottom: 1px solid #986008;
}

.fb-button.fb-button-info {
  background-color: #42b8dd;
  border-left: 1px solid #177a93;
  border-bottom: 1px solid #177a93;
}

.fb-button.fb-button-primary {
  background-color: #0078e7;
  border-left: 1px solid #023c63;
  border-bottom: 1px solid #023c63;
}

.fb-panel {
  padding: 1px 10px;
  margin-bottom: 15px;
}

.fb-panel.fb-panel-info {
  background-color: #e2f2f8;
  border-left: 2px solid #97c5dd;
  color: #20619a;
}

.fb-panel.fb-panel-warning {
  background-color: #fff4dd;
  border-left: 2px solid #e2ab62;
  color: #cd7c20;
}

.fb-panel.fb-panel-success {
  background-color: #e8ffe1;
  border-left: 2px solid #a0e097;
  color: #349a20;
}

.fb-panel.fb-panel-error {
  background-color: #fceaea;
  border-left: 2px solid #df9a9a;
  color: #9a2020;
}

.fb-panel-header-info {
  background-color: #97c5dd;
  background-image: linear-gradient(transparent, rgba(0, 0, 0, 0.05) 40%, rgba(0, 0, 0, 0.1));
  font-size: 12px;
  color: #fff;
  margin: 0;
  padding: 3px 15px;
}

.fb-panel-header-warning {
  background-color: #e2ab62;
  background-image: linear-gradient(transparent, rgba(0, 0, 0, 0.05) 40%, rgba(0, 0, 0, 0.1));
  font-size: 12px;
  color: #fff;
  margin: 0;
  padding: 3px 15px;
}

.fb-panel-header-success {
  background-color: #a0e097;
  background-image: linear-gradient(transparent, rgba(0, 0, 0, 0.05) 40%, rgba(0, 0, 0, 0.1));
  font-size: 12px;
  color: #fff;
  margin: 0;
  padding: 3px 15px;
}

.fb-panel-header-error {
  background-color: #df9a9a;
  background-image: linear-gradient(transparent, rgba(0, 0, 0, 0.05) 40%, rgba(0, 0, 0, 0.1));
  font-size: 12px;
  color: #fff;
  margin: 0;
  padding: 3px 15px;
}

.fb-form input, .fb-form select {
  width: 400px;
}

.fb-form .fb-panel div p label {
  display: block;
  font-size: 12px;
  font-weight: bold;
  padding-top: 15px;
  padding-bottom: 10px;
}

.fb-form .fb-panel div:first-child p label {
  padding-top: 0;
}

.fb-table {
  background-color: #e2f2f8;
  border-left: 2px solid #97c5dd;
  border-spacing: 0;
  line-height: 2;
  margin-bottom: 15px;
  color: #20619a;
}

.fb-table thead, .fb-table-header {
  background-color: #97c5dd;
  background-image: linear-gradient(transparent, rgba(0, 0, 0, 0.05) 40%, rgba(0, 0, 0, 0.1));
  color: #fff;
  margin: 0;
  font-weight: bold;
  font-size: 12px;
}

.fb-table thead th, .fb-table-header th {
  text-align: left;
  padding: 3px 15px;
}

.fb-table tbody tr td {
  padding: 3px 15px;
}

.fb-table tbody tr td.fb-table-action {
  text-align: right;
  visibility: hidden;
  display: block;
}

.fb-table tbody tr:hover td.fb-table-action {
  visibility: visible;
}

.fb-table.fb-table-hover tbody tr:hover:not(.fb-table-header) {
  background-color: #fff;
}

.logSuccess { font-size: 11px; font-weight: bold; color: #fff; background-color: #3fad3b; padding: 4px; }
.logError { font-size: 11px; font-weight: bold; color: #fff; background-color: #d32828; padding: 4px; }

.fb-alerts ul { list-style-type: none; padding: 15px; margin: 10px; }
.fb-alerts .fb-alerts-error { background-color: #f2dede; border: 1px solid #ebccd1; border-radius: 4px; color: #a94442; }
.fb-alerts .fb-alerts-success { background-color: #dff0d8; border: 1px solid #d6e9c6; border-radius: 4px; color: #3c763d; }
.fb-alerts .fb-alerts-warning { background-color: #fcf8e3; border: 1px solid #faebcc; border-radius: 4px; color: #8a6d3b; }

.fb-button-menu {
  position: absolute;
  width: 300px;
  z-index: 100;
}

.fb-button-menu li > a {
  display: block;
}
</style>

<script>
if ( typeof jQuery == 'undefined' ) {
  document.write('<scr' + 'ipt src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></scr' + 'ipt>');
}
</script>
<script>
if ( typeof jQuery.ui == 'undefined' ) {
  document.write('<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/redmond/jquery-ui.css" />');
  document.write('<scr' + 'ipt src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></scr' + 'ipt>');
/* Custom jQuery UI */
  document.write('<style>.ui-widget { font-family: Lucida Grande, Lucida Sans, Verdana, Arial, sans-serif; font-size: 11px; } .ui-dialog { min-width: 500px; }</style>');
}
</script>

<script>
var OSCOM = {
  dateNow: new Date(),
  htmlSpecialChars: function(string) {
    if ( string == null ) {
      string = '';
    }

    return $('<span />').text(string).html();
  },
  nl2br: function(string) {
    return string.replace(/\n/g, '<br />');
  },
  APP: {
    FACEBOOK: {
      version: '<?php echo $OSCOM_Facebook->getVersion(); ?>',
      versionCheckResult: <?php echo (defined('OSCOM_APP_FACEBOOK_VERSION_CHECK')) ? '"' . OSCOM_APP_FACEBOOK_VERSION_CHECK . '"' : 'undefined'; ?>,
      action: '<?php echo $action; ?>',
      doOnlineVersionCheck: false,
      canApplyOnlineUpdates: <?php echo class_exists('ZipArchive') && function_exists('json_encode') && function_exists('openssl_verify') ? 'true' : 'false'; ?>,
      versionCheck: function() {
        $.get('<?php echo tep_href_link('facebook.php', 'action=checkVersion'); ?>', function (data) {
          var versions = [];

          if ( OSCOM.APP.FACEBOOK.canApplyOnlineUpdates == true ) {
            try {
              data = $.parseJSON(data);
            } catch (ex) {
            }

            if ( (typeof data == 'object') && ('rpcStatus' in data) && (data['rpcStatus'] == 1) && ('releases' in data) && (data['releases'].length > 0) ) {
              for ( var i = 0; i < data['releases'].length; i++ ) {
                versions.push(data['releases'][i]['version']);
              }
            }
          } else {
            if ( (typeof data == 'string') && (data.indexOf('rpcStatus') > -1) ) {
              var result = data.split("\n", 2);

              if ( result.length == 2 ) {
                var rpcStatus = result[0].split('=', 2);

                if ( rpcStatus[1] == 1 ) {
                  var release = result[1].split('=', 2);

                  versions.push(release[1]);
                }
              }
            }
          }

          if ( versions.length > 0 ) {
            OSCOM.APP.FACEBOOK.versionCheckResult = [ OSCOM.dateNow.getDate(), Math.max.apply(Math, versions) ];

            OSCOM.APP.FACEBOOK.versionCheckNotify();
          }
        });
      },
      versionCheckNotify: function() {
        if ( (typeof this.versionCheckResult[0] != 'undefined') && (typeof this.versionCheckResult[1] != 'undefined') ) {
          if ( this.versionCheckResult[1] > this.version ) {
            $('#fbAppUpdateNotice').show();
          }
        }
      }
    }
  }
};

if ( typeof OSCOM.APP.FACEBOOK.versionCheckResult != 'undefined' ) {
  OSCOM.APP.FACEBOOK.versionCheckResult = OSCOM.APP.FACEBOOK.versionCheckResult.split('-', 2);
}
</script>

<div class="fb-container">
  <div class="fb-header">
    <div id="fbAppInfo" style="float: right;">
      <?php echo $OSCOM_Facebook->getTitle() . ' v' . $OSCOM_Facebook->getVersion() . ' <a href="' . tep_href_link('facebook.php', 'action=info') . '">' . $OSCOM_Facebook->getDef('app_link_info') . '</a> <a href="' . tep_href_link('facebook.php', 'action=privacy') . '">' . $OSCOM_Facebook->getDef('app_link_privacy') . '</a>'; ?>
    </div>

    <a href="<?php echo tep_href_link('facebook.php', 'action=' . $action); ?>"><img width="200px" src="<?php echo tep_catalog_href_link('images/apps/facebook/facebook.png', '', 'SSL'); ?>" /></a>
  </div>

  <div id="fbAppUpdateNotice" style="padding: 0 12px 0 12px; display: none;">
    <div class="fb-panel fb-panel-success">
      <?php echo $OSCOM_Facebook->getDef('update_available_body', array('button_view_update' => $OSCOM_Facebook->drawButton($OSCOM_Facebook->getDef('button_view_update'), tep_href_link('facebook.php', 'action=update'), 'success'))); ?>
    </div>
  </div>

<?php
  if ( $OSCOM_Facebook->hasAlert() ) {
    echo $OSCOM_Facebook->getAlerts();
  }
?>

  <div style="padding: 0 10px 10px 10px;">
<script>
// Make sure jQuery >= v1.5 is loaded for jQuery Deferred Objects (eg $.get().fail())
if ( !$.isFunction($.Deferred) ) {
  document.write('<div class="fb-panel fb-panel-error"><p>jQuery version is too old (v' + $.fn.jquery + '). Please update your Administration Tool template to use at least v1.5.</p></div>');
}
</script>

    <?php include(DIR_FS_CATALOG . 'includes/apps/facebook/admin/content/' . basename($content)); ?>
  </div>
</div>

<script>
$(function() {
  if ( (OSCOM.APP.FACEBOOK.action != 'update') && (OSCOM.APP.FACEBOOK.action != 'info') ) {
    if ( typeof OSCOM.APP.FACEBOOK.versionCheckResult == 'undefined' ) {
      OSCOM.APP.FACEBOOK.doOnlineVersionCheck = true;
    } else {
      if ( typeof OSCOM.APP.FACEBOOK.versionCheckResult[0] != 'undefined' ) {
        if ( OSCOM.dateNow.getDate() != OSCOM.APP.FACEBOOK.versionCheckResult[0] ) {
          OSCOM.APP.FACEBOOK.doOnlineVersionCheck = true;
        }
      }
    }

    if ( OSCOM.APP.FACEBOOK.doOnlineVersionCheck == true ) {
      OSCOM.APP.FACEBOOK.versionCheck();
    } else {
      OSCOM.APP.FACEBOOK.versionCheckNotify();
    }
  }
});
</script>

<?php
  include(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
