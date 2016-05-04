<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2016 osCommerce

  Released under the GNU General Public License
*/

  class OSCOM_Facebook_LOGIN {
    var $_title;
    var $_short_title;
    var $_introduction;
    var $_req_notes;
    var $_cm_code = 'login/cm_facebook_login';
    var $_sort_order = 1000;

    function OSCOM_Facebook_LOGIN() {
      global $OSCOM_Facebook;

      $this->_title = $OSCOM_Facebook->getDef('module_login_title');
      $this->_short_title = $OSCOM_Facebook->getDef('module_login_short_title');
      $this->_introduction = $OSCOM_Facebook->getDef('module_login_introduction');

      $this->_req_notes = array();

      if ( !function_exists('curl_init') ) {
        $this->_req_notes[] = $OSCOM_Facebook->getDef('module_login_error_curl');
      }

      if ( (OSCOM_APP_FACEBOOK_LOGIN_STATUS == '1') && (!tep_not_null(OSCOM_APP_FACEBOOK_API_CLIENT_ID)) && (!tep_not_null(OSCOM_APP_FACEBOOK_API_SECRET)) && (!tep_not_null(OSCOM_APP_FACEBOOK_API_VERSION)) ) {
        $this->_req_notes[] = $OSCOM_Facebook->getDef('module_login_error_configure');
      }
    }

    function getTitle() {
      return $this->_title;
    }

    function getShortTitle() {
      return $this->_short_title;
    }

    function install($OSCOM_Facebook) {
      $installed = explode(';', MODULE_CONTENT_INSTALLED);
      $installed[] = $this->_cm_code;

      $OSCOM_Facebook->saveParameter('MODULE_CONTENT_INSTALLED', implode(';', $installed));
    }

    function uninstall($OSCOM_Facebook) {
      $installed = explode(';', MODULE_CONTENT_INSTALLED);
      $installed_pos = array_search($this->_cm_code, $installed);

      if ( $installed_pos !== false ) {
        unset($installed[$installed_pos]);

        $OSCOM_Facebook->saveParameter('MODULE_CONTENT_INSTALLED', implode(';', $installed));
      }
    }
  }
?>
