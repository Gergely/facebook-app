<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2016 osCommerce

  Released under the GNU General Public License
*/

  class OSCOM_Facebook_LOGIN_Cfg_content_width {
    var $default = 'Full';
    var $title;
    var $description;
    var $app_configured = false;
    var $set_func = 'tep_cfg_select_option(array(\'Full\', \'Half\'), ';

    function OSCOM_Facebook_LOGIN_Cfg_content_width() {
      global $OSCOM_Facebook;

      $this->title = $OSCOM_Facebook->getDef('cfg_login_content_width_title');
      $this->description = $OSCOM_Facebook->getDef('cfg_login_content_width_desc');
    }

    function getSetField() {
      global $OSCOM_Facebook;

      $input = '<input type="radio" id="contentWidthSelectionHalf" name="content_width" value="Half"' . (OSCOM_APP_FACEBOOK_LOGIN_CONTENT_WIDTH == 'Half' ? ' checked="checked"' : '') . '><label for="contentWidthSelectionHalf">' . $OSCOM_Facebook->getDef('cfg_login_content_width_half') . '</label>' .
               '<input type="radio" id="contentWidthSelectionFull" name="content_width" value="Full"' . (OSCOM_APP_FACEBOOK_LOGIN_CONTENT_WIDTH == 'Full' ? ' checked="checked"' : '') . '><label for="contentWidthSelectionFull">' . $OSCOM_Facebook->getDef('cfg_login_content_width_full') . '</label>';

      $result = <<<EOT
<div>
  <p>
    <label>{$this->title}</label>

    {$this->description}
  </p>

  <div id="contentWidthSelection">
    {$input}
  </div>
</div>

<script>
$(function() {
  $('#contentWidthSelection').buttonset();
});
</script>
EOT;

      return $result;
    }
  }
?>
