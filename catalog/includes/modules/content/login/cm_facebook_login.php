<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2014 osCommerce

  Released under the GNU General Public License
*/

  if ( !class_exists('OSCOM_Facebook') ) {
    include(DIR_FS_CATALOG . 'includes/apps/facebook/OSCOM_Facebook.php');
  }

  require_once DIR_FS_CATALOG . '/ext/api/Facebook/autoload.php';
  use Facebook\FacebookClient;

  class cm_facebook_login {
    var $code;
    var $group;
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;
    var $_app;
    var $_api;
    var $_tokenMetadata;

    public function __construct() {
      global $PHP_SELF;

      $this->_app = new OSCOM_Facebook();
      $this->_app->loadLanguageFile('modules/LOGIN/LOGIN.php');

      $this->signature = 'facebook login|100';

      $this->code = get_class($this);
      $this->group = basename(dirname(__FILE__));

      $this->title = $this->_app->getDef('module_login_title');
      $this->description = '<div align="center">' . $this->_app->drawButton($this->_app->getDef('module_login_legacy_admin_app_button'), tep_href_link('facebook.php', 'action=configure&module=LOGIN'), 'primary', null, true) . '</div>';

      if ( defined('OSCOM_APP_FACEBOOK_LOGIN_STATUS') ) {
        $this->sort_order = OSCOM_APP_FACEBOOK_LOGIN_SORT_ORDER;
        $this->enabled = (OSCOM_APP_FACEBOOK_LOGIN_STATUS == '1' ? true : false);

        if ( OSCOM_APP_FACEBOOK_LOGIN_STATUS == '-1' ) {
          $this->title .= ' [Disabled]';
        }

        if ( !function_exists('curl_init') ) {
          $this->description .= '<div class="secWarning">' . $this->_app->getDef('module_login_error_curl') . '</div>';

          $this->enabled = false;
        }

        if ( $this->enabled === true ) {
          if ( (OSCOM_APP_FACEBOOK_LOGIN_STATUS == '1') && (!tep_not_null(OSCOM_APP_FACEBOOK_API_CLIENT_ID)) && (!tep_not_null(OSCOM_APP_FACEBOOK_API_SECRET)) && (!tep_not_null(OSCOM_APP_FACEBOOK_API_VERSION)) ) {
            $this->description .= '<div class="secWarning">' . $this->_app->getDef('module_login_error_configure') . '</div>';

            $this->enabled = false;
          }
        }

        if ( (OSCOM_APP_FACEBOOK_LOGIN_STATUS == '1') && (tep_not_null(OSCOM_APP_FACEBOOK_API_CLIENT_ID)) ) {
          $this->_api = new Facebook\Facebook([
                                                    'app_id'   => OSCOM_APP_FACEBOOK_API_CLIENT_ID,
                                                    'app_secret'  => OSCOM_APP_FACEBOOK_API_SECRET,
                                                    'default_graph_version' => OSCOM_APP_FACEBOOK_API_VERSION,
                                                   ]);
        }
      }
    }

    public function execute() {
      global $HTTP_GET_VARS, $oscTemplate;

      if ( isset($HTTP_GET_VARS['action']) ) {
        if ( $HTTP_GET_VARS['action'] == 'facebook_login' ) {
          $this->preLogin();
        } elseif ( $HTTP_GET_VARS['action'] == 'facebook_login_process' ) {
          $this->postLogin();
        }
      }

/*       $scopes = cm_facebook_login_get_attributes();
      $use_scopes = array('openid');

      foreach ( explode(';', OSCOM_APP_FACEBOOK_LOGIN_ATTRIBUTES) as $a ) {
        foreach ( $scopes as $group => $attributes ) {
          foreach ( $attributes as $attribute => $scope ) {
            if ( $a == $attribute ) {
              if ( !in_array($scope, $use_scopes) ) {
                $use_scopes[] = $scope;
              }
            }
          }
        }
      } */

      $cm_facebook_login = $this;

      $helper = $this->_api->getRedirectLoginHelper();

      $permissions = ['email']; // Optional permissions
      $loginUrl = $helper->getLoginUrl(tep_href_link(FILENAME_LOGIN, 'action=facebook_login', 'SSL'), $permissions);

      ob_start();
      include(DIR_WS_MODULES . 'content/' . $this->group . '/templates/facebook_login.php');
      $template = ob_get_clean();

      $oscTemplate->addContent($template, $this->group);
    }

    private function preLogin() {
      global $HTTP_GET_VARS, $facebook_login_access_token, $facebook_login_customer_id, $sendto, $billto, $messageStack;

      $log_text = '';
      $return_url = tep_href_link(FILENAME_LOGIN, '', 'SSL');

      if ( isset($HTTP_GET_VARS['code']) ) {
        $facebook_login_customer_id = false;

        $helper = $this->_api->getRedirectLoginHelper();

        try {
          $accessToken = $helper->getAccessToken();
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
          // When Graph returns an error
          $this->_app->log('FB_LOGIN', 'Graph returns an error', 0, 'GET', $e->getMessage());
          $messageStack->add_session('login', $this->_app->getDef('module_facebook_login_error'));
          header("Location: " . tep_href_link(FILENAME_LOGIN, Null, 'SSL'));
          exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
          // When validation fails or other local issues
          $this->_app->log('FB_LOGIN', 'Validation fails or other local issues', 0, 'GET', $e->getMessage());
          $messageStack->add_session('login', $this->_app->getDef('module_facebook_login_error'));
          header("Location: " . tep_href_link(FILENAME_LOGIN, Null, 'SSL'));
          exit;
        }

        if (! isset($accessToken)) {
          if ($helper->getError()) {
            header('HTTP/1.0 401 Unauthorized');
            $msg = "Error: " . $helper->getError() . "\n";
            $msg .= "Error Code: " . $helper->getErrorCode() . "\n";
            $msg .= "Error Reason: " . $helper->getErrorReason() . "\n";
            $msg .= "Error Description: " . $helper->getErrorDescription() . "\n";
          } else {
            header('HTTP/1.0 400 Bad Request');
            $msg = 'Bad request';
          }
          $this->_app->log('FB_LOGIN', 'Not set access token', 0, 'GET', $msg);
          $messageStack->add_session('login', $this->_app->getDef('module_facebook_login_error'));
          header("Location: " . tep_href_link(FILENAME_LOGIN, Null, 'SSL'));
          exit;
        }

        // Logged in
        $this->_app->log('FB_LOGIN', 'AccessToken', 1, 'GET', $accessToken->getValue());

        // The OAuth 2.0 client handler helps us manage access tokens
        $oAuth2Client = $this->_api->getOAuth2Client();

        // Get the access token metadata from /debug_token
        $this->_tokenMetadata = $oAuth2Client->debugToken($accessToken);
        // Validation (these will throw FacebookSDKException's when they fail)
        $this->_tokenMetadata->validateAppId(OSCOM_APP_FACEBOOK_API_CLIENT_ID);
        // If you know the user ID this access token belongs to, you can validate it here
        $this->_tokenMetadata->validateExpiration();

        // $this->_tokenMetadata is protected object so no reason to do log

        if (! $accessToken->isLongLived()) {
          // Exchanges a short-lived access token for a long-lived one
          try {
            $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
          } catch (Facebook\Exceptions\FacebookSDKException $e) {
            $this->_app->log('FB_LOGIN', 'Getting long-lived access token', 0, 'GET', $helper->getMessage());
            $messageStack->add_session('login', $this->_app->getDef('module_facebook_login_error'));
            header("Location: " . tep_href_link(FILENAME_LOGIN, Null, 'SSL'));
            exit;
          }

          $this->_app->log('FB_LOGIN', 'Token', 1, 'Long-lived', $accessToken->getValue());
        }

        $_SESSION['fb_access_token'] = (string) $accessToken;

        try {
          // Returns a `Facebook\FacebookResponse` object
          $response = $this->_api->get('/me?fields=gender,name,last_name,first_name,email,locale', $_SESSION['fb_access_token']);
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
          $this->_app->log('FB_LOGIN', 'Graph returned an error', 0, 'GET', $e->getMessage());
          $messageStack->add_session('login', $this->_app->getDef('module_facebook_login_error'));
          header("Location: " . tep_href_link(FILENAME_LOGIN, Null, 'SSL'));
          exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
          $this->_app->log('FB_LOGIN', 'Facebook SDK returned an error', 0, 'GET', $e->getMessage());
          $messageStack->add_session('login', $this->_app->getDef('module_facebook_login_error'));
          header("Location: " . tep_href_link(FILENAME_LOGIN, Null, 'SSL'));
          exit;
        }

        $user = $response->getGraphUser();


        if ( isset($user['email']) ) {

          $force_login = false;

// check if e-mail address exists in database and login or create customer account
          if ( !tep_session_is_registered('customer_id') ) {
            $customer_id = 0;
            $customer_default_address_id = 0;

            $force_login = true;

            $email_address = tep_db_prepare_input($user['email']);
            if (tep_validate_email($email_address) == false ) {
              // TODO something for example go to normal registration account
              $messageStack->add_session('create_account', $this->_app->getDef('module_login_email_address_error'));
              tep_redirect(tep_href_link('create_account.php', Null, 'SSL'));
            }
            $check_query = tep_db_query("select customers_id from " . TABLE_CUSTOMERS . " where customers_email_address = '" . tep_db_input($email_address) . "' limit 1");
            if (tep_db_num_rows($check_query)) {
              $check = tep_db_fetch_array($check_query);

              $customer_id = (int)$check['customers_id'];
            } else {

              $customers_firstname = tep_db_prepare_input($user['first_name']);
              $customers_lastname = tep_db_prepare_input($user['last_name']);
              $customers_gender = (($user['gender'] == 'male') ? 'm' : 'f');

              $sql_data_array = array('customers_firstname' => $customers_firstname,
                                      'customers_lastname' => $customers_lastname,
                                      'customers_email_address' => $email_address,
                                      'customers_gender' => $customers_gender);

              tep_db_perform(TABLE_CUSTOMERS, $sql_data_array);

              $customer_id = (int)tep_db_insert_id();

              //tep_db_query("insert into " . TABLE_CUSTOMERS_INFO . " (customers_info_id, customers_info_number_of_logons, customers_info_date_account_created) values ('" . (int)$customer_id . "', '0', now())");
              $_SESSION['customer_id'] = $customer_id;

              $this->_app->log('FB_LOG+', 'User', 1, 'GET', json_decode($user, true));

              tep_redirect(tep_href_link('create_account_social.php', Null, 'SSL'));
            }
          }

          if ($force_login == true) {
            $facebook_login_customer_id = $customer_id;
          } else {
            $facebook_login_customer_id = false;
          }

          if ( !tep_session_is_registered('facebook_login_customer_id') ) {
            tep_session_register('facebook_login_customer_id');
          }


          $check_query = tep_db_query("select address_book_id from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int)$customer_id . "' limit 1");
          if (tep_db_num_rows($check_query)) {
            $check = tep_db_fetch_array($check_query);

            $sendto = $check['address_book_id'];

            $billto = $sendto;

            if ( !tep_session_is_registered('sendto') ) {
              tep_session_register('sendto');
            }

            if ( !tep_session_is_registered('billto') ) {
              tep_session_register('billto');
            }
          }

          $return_url = tep_href_link(FILENAME_LOGIN, 'action=facebook_login_process', 'SSL');
        }

        $this->_app->log('FB_LOGIN', 'User', 1, 'GET', json_decode($user, true));

        tep_redirect($return_url);
      }
    }

    private function postLogin() {
      global $facebook_login_customer_id, $login_customer_id, $language, $payment;

      if ( tep_session_is_registered('facebook_login_customer_id') ) {
        if ( $facebook_login_customer_id !== false ) {
          $login_customer_id = $facebook_login_customer_id;
        }

        tep_session_unregister('facebook_login_customer_id');
      }
    }

    public function isEnabled() {
      return $this->enabled;
    }

    public function check() {
      return defined('OSCOM_APP_FACEBOOK_LOGIN_STATUS');
    }

    public function install() {
      tep_redirect(tep_href_link('facebook.php', 'action=configure&subaction=install&module=LOGIN'));
    }

    public function remove() {
      tep_redirect(tep_href_link('facebook.php', 'action=configure&subaction=uninstall&module=LOGIN'));
    }

    public function keys() {
      return array('OSCOM_APP_FACEBOOK_LOGIN_CONTENT_WIDTH', 'OSCOM_APP_FACEBOOK_LOGIN_SORT_ORDER');
    }

    public function hasAttribute($attribute) {
      return in_array($attribute, explode(';', OSCOM_APP_FACEBOOK_LOGIN_ATTRIBUTES));
    }

    public function get_default_attributes() {
      $data = array();

      foreach ( cm_facebook_login_get_attributes() as $group => $attributes ) {
        foreach ( $attributes as $attribute => $scope ) {
          $data[] = $attribute;
        }
      }

      return $data;
    }

    private function getJsonData() {
      $metadata = get_object_vars($this->_tokenMetadata);
      foreach ($metadata as &$value) {
        if (is_object($value) && method_exists($value, 'getJsonData')) {
          $value = $value->getJsonData();
        }
      }
      return $metadata;
    }
  }

  function cm_facebook_login_get_attributes() {
    return array('personal' => array('full_name' => 'profile',
                                     'last_name' => 'profile',
                                     'first_name' => 'profile',
                                     'gender' => 'profile'),
                 'address' => array('email_address' => 'email'),
                 'account' => array('locale' => 'profile')
                 );
  }
?>
