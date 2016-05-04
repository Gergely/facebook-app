<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2016 osCommerce

  Released under the GNU General Public License
*/

  class OSCOM_Facebook_LOGIN_Cfg_status {
    var $default = '1';
    var $title;
    var $description;
    var $sort_order = 100;

    function OSCOM_Facebook_LOGIN_Cfg_status() {
      global $OSCOM_Facebook;

      $this->title = $OSCOM_Facebook->getDef('cfg_login_status_title');
      $this->description = $OSCOM_Facebook->getDef('cfg_login_status_desc');
    }

    function getSetField() {
      global $OSCOM_Facebook;

      $input = '<input type="radio" id="statusSelectionLive" name="status" value="1"' . (OSCOM_APP_FACEBOOK_LOGIN_STATUS == '1' ? ' checked="checked"' : '') . '><label for="statusSelectionLive">' . $OSCOM_Facebook->getDef('cfg_login_status_live') . '</label>' .
               '<input type="radio" id="statusSelectionDisabled" name="status" value="-1"' . (OSCOM_APP_FACEBOOK_LOGIN_STATUS == '-1' ? ' checked="checked"' : '') . '><label for="statusSelectionDisabled">' . $OSCOM_Facebook->getDef('cfg_login_status_disabled') . '</label>';

      $result = <<<EOT
<div>
  <p>
    <label>{$this->title}</label>

    {$this->description}
  </p>

  <div id="statusSelection">
    {$input}
  </div>
</div>

<script>
$(function() {
  $('#statusSelection').buttonset();
});
</script>
EOT;

      return $result;
    }
  }
?>
