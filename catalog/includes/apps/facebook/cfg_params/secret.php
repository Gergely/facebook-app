<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2016 osCommerce

  Released under the GNU General Public License
*/

  class OSCOM_Facebook_Cfg_secret {
    var $default = '';
    var $title;
    var $description;
    var $sort_order = 300;

    function OSCOM_Facebook_Cfg_secret() {
      global $OSCOM_Facebook;

      $this->title = $OSCOM_Facebook->getDef('cfg_secret_title');
      $this->description = $OSCOM_Facebook->getDef('cfg_secret_desc');
    }

    function getSetField() {
      $input = tep_draw_input_field('secret', OSCOM_APP_FACEBOOK_API_SECRET, 'id="inputSecret"');

      $result = <<<EOT
<div>
  <p>
    <label for="inputSecret">{$this->title}</label>

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
