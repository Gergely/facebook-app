<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2016 osCommerce

  Released under the GNU General Public License
*/

  class OSCOM_Facebook_LOGIN_Cfg_attributes {
    var $default = ''; // set in classs constructor
    var $title;
    var $description;
    var $sort_order = 700;

    var $attributes = array(
                        'personal' => array(
                          'full_name' => 'profile',
                          'first_name' => 'profile',
                          'last_name' => 'profile',
                          'gender' => 'profile'
                        ),
                        'address' => array(
                          'email_address' => 'email'
                        ),
                        'account' => array(
                          'locale' => 'profile'
                        ),
                      );

    var $required = array(
                      'full_name',
                      'email_address',
                    );

    function OSCOM_Facebook_LOGIN_Cfg_attributes() {
      global $OSCOM_Facebook;

      $this->default = implode(';', $this->getAttributes());

      $this->title = $OSCOM_Facebook->getDef('cfg_login_attributes_title');
      $this->description = $OSCOM_Facebook->getDef('cfg_login_attributes_desc');
    }

    function getSetField() {
      global $OSCOM_Facebook;

      $values_array = explode(';', OSCOM_APP_FACEBOOK_LOGIN_ATTRIBUTES);

      $input = '';

      foreach ( $this->attributes as $group => $attributes ) {
        $input .= '<strong>' . $OSCOM_Facebook->getDef('cfg_login_attributes_group_' . $group) . '</strong><br />';

        foreach ( $attributes as $attribute => $scope ) {
          if ( in_array($attribute, $this->required) ) {
            $input .= '<input type="radio" id="fbLogInAttributesSelection' . ucfirst($attribute) . '" name="fbLogInAttributesTmp' . ucfirst($attribute) . '" value="' . $attribute . '" checked="checked" />';
          } else {
            $input .= '<input type="checkbox" id="fbLogInAttributesSelection' . ucfirst($attribute) . '" name="fbLogInAttributes[]" value="' . $attribute . '"' . (in_array($attribute, $values_array) ? ' checked="checked"' : '') . ' />';
          }

          $input .= '&nbsp;<label for="fbLogInAttributesSelection' . ucfirst($attribute) . '">' . $OSCOM_Facebook->getDef('cfg_login_attributes_attribute_' . $attribute) . '</label><br />';
        }
      }

      if ( !empty($input) ) {
        $input = '<br />' . substr($input, 0, -6);
      }

      $input .= '<input type="hidden" name="attributes" value="" />';

      $result = <<<EOT
<div>
  <p>
    <label>{$this->title}</label>

    {$this->description}
  </p>

  <div id="attributesSelection">
    {$input}
  </div>
</div>

<script>
function fbLogInAttributesUpdateCfgValue() {
  var fb_login_attributes_selected = '';

  if ( $('input[name^="fbLogInAttributesTmp"]').length > 0 ) {
    $('input[name^="fbLogInAttributesTmp"]').each(function() {
      fb_login_attributes_selected += $(this).attr('value') + ';';
    });
  }

  if ( $('input[name="fbLogInAttributes[]"]').length > 0 ) {
    $('input[name="fbLogInAttributes[]"]:checked').each(function() {
      fb_login_attributes_selected += $(this).attr('value') + ';';
    });
  }

  if ( fb_login_attributes_selected.length > 0 ) {
    fb_login_attributes_selected = fb_login_attributes_selected.substring(0, fb_login_attributes_selected.length - 1);
  }

  $('input[name="attributes"]').val(fb_login_attributes_selected);
}

$(function() {
  fbLogInAttributesUpdateCfgValue();

  if ( $('input[name="fbLogInAttributes[]"]').length > 0 ) {
    $('input[name="fbLogInAttributes[]"]').change(function() {
      fbLogInAttributesUpdateCfgValue();
    });
  }
});
</script>
EOT;

      return $result;
    }

    function getAttributes() {
      $data = array();

      foreach ( $this->attributes as $group => $attributes ) {
        foreach ( $attributes as $attribute => $scope ) {
          $data[] = $attribute;
        }
      }

      return $data;
    }
  }
?>
