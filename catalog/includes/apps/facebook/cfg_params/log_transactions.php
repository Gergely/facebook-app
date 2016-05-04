<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2016 osCommerce

  Released under the GNU General Public License
*/

  class OSCOM_Facebook_Cfg_log_transactions {
    var $default = '1';
    var $sort_order = 500;

    function OSCOM_Facebook_Cfg_log_transactions() {
      global $OSCOM_Facebook;

      $this->title = $OSCOM_Facebook->getDef('cfg_log_transactions_title');
      $this->description = $OSCOM_Facebook->getDef('cfg_log_transactions_desc');
    }

    function getSetField() {
      global $OSCOM_Facebook;

      $input = '<input type="radio" id="logTransactionsSelectionAll" name="log_transactions" value="1"' . (OSCOM_APP_FACEBOOK_LOG_TRANSACTIONS == '1' ? ' checked="checked"' : '') . '><label for="logTransactionsSelectionAll">' . $OSCOM_Facebook->getDef('cfg_log_transactions_all') . '</label>' .
               '<input type="radio" id="logTransactionsSelectionErrors" name="log_transactions" value="0"' . (OSCOM_APP_FACEBOOK_LOG_TRANSACTIONS == '0' ? ' checked="checked"' : '') . '><label for="logTransactionsSelectionErrors">' . $OSCOM_Facebook->getDef('cfg_log_transactions_errors') . '</label>' .
               '<input type="radio" id="logTransactionsSelectionDisabled" name="log_transactions" value="-1"' . (OSCOM_APP_FACEBOOK_LOG_TRANSACTIONS == '-1' ? ' checked="checked"' : '') . '><label for="logTransactionsSelectionDisabled">' . $OSCOM_Facebook->getDef('cfg_log_transactions_disabled') . '</label>';

      $result = <<<EOT
<div>
  <p>
    <label>{$this->title}</label>

    {$this->description}
  </p>

  <div id="logSelection">
    {$input}
  </div>
</div>

<script>
$(function() {
  $('#logSelection').buttonset();
});
</script>
EOT;

      return $result;
    }
  }
?>
