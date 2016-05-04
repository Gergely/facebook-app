<style>
.fb-button {
  font-size: 12px;
  font-weight: bold;
  color: white;
  padding: 6px 10px;
  border: 0;
  border-radius: 4px;
  text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
  text-decoration: none;
  display: inline-block;
  cursor: pointer;
  white-space: nowrap;
  vertical-align: baseline;
  text-align: center;
  background-image: linear-gradient(transparent, rgba(0, 0, 0, 0.05) 40%, rgba(0, 0, 0, 0.1));
}

.fb-button.fb-button-info {
  background-color: #3C5B9A;
  border-left: 1px solid #3C5B9A;
  border-bottom: 1px solid #3C5B9A;
}

.fb-button:focus {
  outline: 0;
}

.fb-button:hover {
  text-decoration: none;
  background-image: linear-gradient(transparent, rgba(0, 0, 0, 0.01) 100%, rgba(0, 0, 0, 0.1));
}
</style>
<div class="contentContainer <?php echo (OSCOM_APP_FACEBOOK_LOGIN_CONTENT_WIDTH == 'Half') ? 'col-sm-6' : 'col-sm-12'; ?>">
  <div class="panel panel-success">
    <div class="panel-body">
      <h2><?php echo $cm_facebook_login->_app->getDef('module_login_template_title'); ?></h2>

      <div class="contentText">
        <p>
          <img src="images/apps/facebook/facebook.png" width="200px">
        <?php
    /*           if ($user) {
                echo $cm_facebook_login->_app->drawButton('FACEBOOK LogOut', $logoutUrl);
              } else { */
                //echo $cm_facebook_login->_app->drawButton('LogIn', $loginUrl);
                echo tep_draw_button('Login', 'fa fa-facebook-official', htmlspecialchars($loginUrl), 'primary', NULL, 'btn-primary btn-block');

    //          }

        ?></p>
        <p><?php echo $cm_facebook_login->_app->getDef('module_login_template_content'); ?></p>

        <div id="FacebookLoginButton" style="text-align: right; padding-top: 5px;"></div>
      </div>
    </div>
  </div>
</div>