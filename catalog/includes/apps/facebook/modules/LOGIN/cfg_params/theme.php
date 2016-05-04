<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2016 osCommerce

  Released under the GNU General Public License
*/

  class OSCOM_Facebook_LOGIN_Cfg_theme {
    var $default = 'Blue';
    var $title;
    var $description;
    var $sort_order = 600;

    function OSCOM_Facebook_LOGIN_Cfg_theme() {
      global $OSCOM_Facebook;

      $this->title = $OSCOM_Facebook->getDef('cfg_login_theme_title');
      $this->description = $OSCOM_Facebook->getDef('cfg_login_theme_desc');
    }

    function getSetField() {
      global $OSCOM_Facebook;

      $input = '<input type="radio" id="themeSelectionBlue" name="theme" value="Blue"' . (OSCOM_APP_FACEBOOK_LOGIN_THEME == 'Blue' ? ' checked="checked"' : '') . '><label for="themeSelectionBlue">' . $OSCOM_Facebook->getDef('cfg_login_theme_blue') . '</label>' .
               '<input type="radio" id="themeSelectionNeutral" name="theme" value="Neutral"' . (OSCOM_APP_FACEBOOK_LOGIN_THEME == 'Neutral' ? ' checked="checked"' : '') . '><label for="themeSelectionNeutral">' . $OSCOM_Facebook->getDef('cfg_login_theme_neutral') . '</label>';

      $result = <<<EOT
<div>
  <p>
    <label>{$this->title}</label>

    {$this->description}
  </p>

  <div id="themeSelection">
    {$input}
  </div>
</div>

<script>
$(function() {
  $('#themeSelection').buttonset();
});
</script>
EOT;

      return $result;
    }
  }
?>
