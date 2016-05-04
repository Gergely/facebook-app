<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2016 osCommerce

  Released under the GNU General Public License
*/

  class OSCOM_Facebook_Cfg_client_id {
    var $default = '';
    var $title;
    var $description;
    var $sort_order = 200;

    function OSCOM_Facebook_Cfg_client_id() {
      global $OSCOM_Facebook;

      $this->title = $OSCOM_Facebook->getDef('cfg_client_id_title');
      $this->description = $OSCOM_Facebook->getDef('cfg_client_id_desc');
    }

    function getSetField() {
      $input = tep_draw_input_field('client_id', OSCOM_APP_FACEBOOK_API_CLIENT_ID, 'id="inputClientId"');

      $result = <<<EOT
<div>
  <p>
    <label for="inputClientId">{$this->title}</label>

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
