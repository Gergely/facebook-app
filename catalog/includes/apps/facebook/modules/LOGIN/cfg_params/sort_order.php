<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2016 osCommerce

  Released under the GNU General Public License
*/

  class OSCOM_Facebook_LOGIN_Cfg_sort_order {
    var $default = '0';
    var $title;
    var $description;
    var $app_configured = false;

    function OSCOM_Facebook_LOGIN_Cfg_sort_order() {
      global $OSCOM_Facebook;

      $this->title = $OSCOM_Facebook->getDef('cfg_login_sort_order_title');
      $this->description = $OSCOM_Facebook->getDef('cfg_login_sort_order_desc');
    }

    function getSetField() {
      $input = tep_draw_input_field('sort_order', OSCOM_APP_FACEBOOK_LOGIN_SORT_ORDER, 'id="inputLogInSortOrder"');

      $result = <<<EOT
<div>
  <p>
    <label for="inputLogInSortOrder">{$this->title}</label>

    {$this->description}
  </p>

  <div>
    {$input}
  </div>
</div>
EOT;

      return $result;
    }
  }
?>
