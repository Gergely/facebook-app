<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2016 osCommerce

  Released under the GNU General Public License
*/

  class OSCOM_Facebook_LOGIN_Cfg_version {
    var $default = '';
    var $sort_order = 500;

    function OSCOM_Facebook_LOGIN_Cfg_version() {
      global $OSCOM_Facebook;

      $this->title = $OSCOM_Facebook->getDef('cfg_login_version_title');
      $this->description = $OSCOM_Facebook->getDef('cfg_login_version_desc');
    }

    //v2.0, v2.1, v2.2, v2.3, v2.5
    function getSetField() {
      $input = '<input type="radio" id="versionSelection20" name="version" value="v2.0"' . (OSCOM_APP_FACEBOOK_API_VERSION == 'v2.0' ? ' checked="checked"' : '') . '><label for="versionSelection20">v2.0</label>' .
               '<input type="radio" id="versionSelection21" name="version" value="v2.1"' . (OSCOM_APP_FACEBOOK_API_VERSION == 'v2.1' ? ' checked="checked"' : '') . '><label for="versionSelection21">v2.1</label>' .
               '<input type="radio" id="versionSelection22" name="version" value="v2.2"' . (OSCOM_APP_FACEBOOK_API_VERSION == 'v2.2' ? ' checked="checked"' : '') . '><label for="versionSelection22">v2.2</label>' .
               '<input type="radio" id="versionSelection23" name="version" value="v2.3"' . (OSCOM_APP_FACEBOOK_API_VERSION == 'v2.3' ? ' checked="checked"' : '') . '><label for="versionSelection23">v2.3</label>' .
               '<input type="radio" id="versionSelection25" name="version" value="v2.5"' . (OSCOM_APP_FACEBOOK_API_VERSION == 'v2.5' ? ' checked="checked"' : '') . '><label for="versionSelection25">v2.5</label>';

      $result = <<<EOT
<div>
  <p>
    <label>{$this->title}</label>

    {$this->description}
  </p>

  <div id="versionSelection">
    {$input}
  </div>
</div>

<script>
$(function() {
  $('#versionSelection').buttonset();
});
</script>
EOT;

      return $result;
    }
  }
?>
