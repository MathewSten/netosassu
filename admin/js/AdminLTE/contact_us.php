<?php
/*
  $Id: contact_us.php 1739 2007-12-20 00:52:16Z hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');
include('class.phpmailer.php');
require_once('recaptchalib.php');

// Get a key from https://www.google.com/recaptcha/admin/create
$publickey = "";
$privatekey = "";


  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CONTACT_US);

  $error = false;
  if (isset($HTTP_GET_VARS['action']) && ($HTTP_GET_VARS['action'] == 'send')) { 
  
	  if ($_POST["recaptcha_response_field"]) {
		$resp = recaptcha_check_answer ('6LdKx_wSAAAAAG_7z9tZoyl_XwaCXYYSCxJbo9oG ',
									$_SERVER["SERVER_ADDR"],
									$_POST["recaptcha_challenge_field"],
									$_POST["recaptcha_response_field"]);
		if (!$resp->is_valid) {
			$error = true;
			die("wrong");
			/*$messageStack->add('contact', 'Invalid captcha code');*/
			
		}
}
  	
    $name = tep_db_prepare_input($HTTP_POST_VARS['name']);
	$surname = tep_db_prepare_input($HTTP_POST_VARS['surname']);
	$telephone = tep_db_prepare_input($HTTP_POST_VARS['telephone']);
    $email_address = tep_db_prepare_input($HTTP_POST_VARS['email']);
    $enquiry = tep_db_prepare_input($HTTP_POST_VARS['enquiry']);
	$telephone = tep_db_prepare_input($HTTP_POST_VARS['telephone']);
	$mobile = tep_db_prepare_input($HTTP_POST_VARS['mobile']);
	
	$location = tep_db_prepare_input($HTTP_POST_VARS['location']);
	$code = tep_db_prepare_input($HTTP_POST_VARS['code']);
	
	$services = tep_db_prepare_input($HTTP_POST_VARS['services']);
	$property_type = tep_db_prepare_input($HTTP_POST_VARS['property_type']);
	
	
	

    if (tep_validate_email($email_address) && tep_validate_telephone($telephone) && $error==false) {
	$from_name=STORE_OWNER;

	$admin_email=STORE_OWNER_EMAIL_ADDRESS;
	//echo '<br>';
	$subject=EMAIL_SUBJECT;
	
/*	Nethouseplans.com
	info@nethouseplans.com
	Enquiry from Nethouseplans.com
*/	

		$TemplateMessage.="<br/><br />Hi Admin";
		
		$TemplateMessage.="";		
		$TemplateMessage.="<br><br>";
		
		$TemplateMessage.=" Name :".$name;		
		$TemplateMessage.="<br><br>";
		
		$TemplateMessage.="E-mail :".$email_address;
		$TemplateMessage.="<br><br>";		
		
		$TemplateMessage.="Enquiry :".$enquiry;
		$TemplateMessage.="<br><br>";			

		$TemplateMessage.="Property Location :".$location;
		$TemplateMessage.="<br><br>";		

		$TemplateMessage.="Plan Code :".$code;
		$TemplateMessage.="<br><br>";		

		$TemplateMessage.="Services :".$services;
		$TemplateMessage.="<br><br>";		

		$TemplateMessage.="Property Type :".$property_type;
		$TemplateMessage.="<br><br>";
		
		$TemplateMessage.="<br><br><br/>Thanks & Regards<br/>";
		
		$TemplateMessage.="Nethouseplans Team";
		
		$TemplateMessage.="<br><br><br>This is a post-only mailing.  Replies to this message are not monitored or answered.";
		
		$mail1 = new PHPMailer;
		
		$mail1->FromName = $from_name;
		
		$mail1->From    = "info@nethouseplans.com";
		
		$mail1->Subject = $subject;
		
		$mail1->Body    = stripslashes($TemplateMessage);
		
		$mail1->AltBody = stripslashes($TemplateMessage);
		
		$mail1->IsHTML(true);
		
		$mail1->AddAddress($admin_email,"nethouseplans.com");//info@salaryleak.com
		
		$mail1->Send();
		
		
		// MAIL TO CUSTOMER============================
		//echo $email_address;
		$TemplateMessage='';
		$TemplateMessage.="<br/><br />Hi ".$name;
		
		$TemplateMessage.="";		
		$TemplateMessage.="<br><br>";
		
		$TemplateMessage.=" Thank you for your enquiry. We will contact you shortly.";		
		$TemplateMessage.="<br><br>";
		$TemplateMessage.="<br><br><br/>Thanks & Regards<br/>";
		
		$TemplateMessage.="Nethouseplans Team";
		
		$TemplateMessage.="<br><br><br>This is a post-only mailing.  Replies to this message are not monitored or answered.";
		
		$mail12 = new PHPMailer;
		
		$mail12->FromName = "Main Send Successful..";
		
		$mail12->From    = "office@nethouseplans.com";
		
		$mail12->Subject = $subject;
		
		$mail12->Body    = stripslashes($TemplateMessage);
		
		$mail12->AltBody = stripslashes($TemplateMessage);
		
		$mail12->IsHTML(true);
		
		$mail12->AddAddress($email_address,"nethouseplans.com");//info@salaryleak.com
		
		$mail12->Send();
		
		
		
		
		
     // tep_mail(STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, EMAIL_SUBJECT, $enquiry, $name, $email_address);

      tep_redirect(tep_href_link(FILENAME_CONTACT_US, 'action=success'));
    } else {
      $error = true;

     if(tep_validate_email($email_address) == false && tep_validate_telephone($telephone) == false){
      $messageStack->add('contact', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
	  $messageStack->add('contact', ENTRY_TELEPHONE_NUMBER_CHECK_ERROR);
	}
	else if(tep_validate_email($email_address) == false && tep_validate_telephone($telephone)){
		$messageStack->add('contact', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
	}
	else if(tep_validate_email($email_address) && tep_validate_telephone($telephone) == false){
		$messageStack->add('contact', ENTRY_TELEPHONE_NUMBER_CHECK_ERROR);
	}
    }
  }

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_CONTACT_US));
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title>Contact Nethouseplans.com</title>
<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>">
<link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->
<!-- body //-->
<table width="876" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="0" cellpadding="2">
        <!-- left_navigation //-->
        <?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
        <!-- left_navigation_eof //-->
      </table></td>
    <!-- body_text //-->
    <td width="100%" valign="top"><?php echo tep_draw_form('contact_us', tep_href_link(FILENAME_CONTACT_US, 'action=send')); ?>
      <table border="0" width="100%" cellspacing="0" cellpadding="0">
        <tr>
          <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td class="pageHeading"><?php echo HEADING_TITLE; ?> <span style="font-size:14px; font-weight:normal;">(<a href="mailto:info@nethouseplans.com">info@nethouseplans.com</a>)</span></td>
                <td class="pageHeading" align="right"><?php echo tep_image(DIR_WS_IMAGES . 'table_background_contact_us.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
        </tr>
        <!-- <tr>
      	<td class="main">Contact us<strong> </strong>on 084 011 7761 (Normal Cellular Rates Apply)</td>
      </tr>-->
        <tr>
          <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
        </tr>
        <?php
  if ($messageStack->size('contact') > 0) {
?>
        <tr>
          <td><?php echo $messageStack->output('contact'); ?></td>
        </tr>
        <tr>
          <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
        </tr>
        <?php
  }

  if (isset($HTTP_GET_VARS['action']) && ($HTTP_GET_VARS['action'] == 'success')) {
?>
        <tr>
          <td class="main" align="center"><?php echo tep_image(DIR_WS_IMAGES . 'table_background_man_on_board.gif', HEADING_TITLE, '0', '0', 'align="left"') . TEXT_SUCCESS; ?></td>
        </tr>
        <tr>
          <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
        </tr>
        <tr>
          <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
              <tr class="infoBoxContents">
                <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
                    <tr>
                      <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                      <td align="right"><?php echo '<a href="' . tep_href_link(FILENAME_DEFAULT) . '">' . tep_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>'; ?></td>
                      <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
        <?php
  } else {
?>
        <tr>
          <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
              <tr class="infoBoxContents">
                <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
                    <tr>
                      <td class="main"><?php echo ENTRY_NAME; ?></td>
                    </tr>
                    <tr>
                      <td class="main"><?php echo tep_draw_input_field('name'); ?></td>
                    </tr>
               		<tr>
                      <td class="main"><?php echo "Surname:"; ?></td>
                    </tr>
                    <tr>
                      <td class="main"><?php echo tep_draw_input_field('surname'); ?></td>
                    </tr>
                    <tr>
                      <td class="main"><?php echo "Telephone Number:"; ?></td>
                    </tr>
                    <tr>
                      <td class="main"><?php echo tep_draw_input_field('telephone'); ?></td>
                    </tr>
                    <tr>
                      <td class="main"><?php echo ENTRY_EMAIL; ?></td>
                    </tr>
                    <tr>
                      <td class="main"><?php echo tep_draw_input_field('email'); ?></td>
                    </tr>
                    <tr>
                      <td class="main"><?php echo "Property Location:"; ?></td>
                    </tr>
                    <tr>
                      <td class="main"><?php echo tep_draw_input_field('location'); ?></td>
                    </tr>
                    <tr>
                      <td class="main" style="font-size:9px; line-height:0.5;"><?php echo "ie. Suburb, City, Country"; ?></td>
                    </tr>
                    <tr>
                      <td class="main"><?php echo "Plan Code:"; ?></td>
                    </tr>
                    <tr>
                      <td class="main"><?php echo tep_draw_input_field('code'); ?></td>
                    </tr>
                    <tr>
                      <td class="main"><?php echo "Property Type:"; ?></td>
                    </tr>
                    <tr>
                      <td class="main"><select name="property_type">
                          <option selected="Select Option" >Select Option</option>
                          <option value="Freehold(Suburban)">Freehold (Suburban)</option>
                          <option value="Freehold(Residential Complex/Estate)">Freehold (Residential Complex/Estate)</option>
                          <option value="Freehold(Rural/Country)">Freehold (Rural/Country)</option>
                          <option value="Sectional Title(i.e townhouses)">Sectional Title (i.e townhouses)</option>
                          <option value="Other">Other</option>
                        </select></td>
                    </tr>
                    <tr>
                      <td class="main"><?php echo "I am interested in the following services:"; ?></td>
                    </tr>
                    <tr>
                      <td class="main"><select name="services">
                          <option selected="Select Option" >Select Option</option>
                          <option value="Purchasing a plan">Purchasing a plan</option>
                          <option value="Modifying a plan">Modifying a plan</option>
                          <option value="Including a Site Plan">Including a Site Plan</option>
                          <option value="Full Custom Design Services">Full Custom Design Services</option>
                          <option value="Plans for Building Additions and Alterations">Plans for Building Additions and Alterations</option>
                          <option value="Other">Other</option>
                        </select></td>
                    </tr>
                    <tr>
                      <td class="main"><?php echo ENTRY_ENQUIRY; ?></td>
                    </tr>
                    <tr>
                      <td><?php echo tep_draw_textarea_field('enquiry', 'soft', 25, 8); ?></td>
                    </tr>
					<tr>
		<td>
 <?php echo recaptcha_get_html('6LdKx_wSAAAAADM2ZDW4RWnqH7VSpUayymVWP_fe', $error);?>
 </td>
		</tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
        </tr>
        <tr>
          <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
              <tr class="infoBoxContents">
                <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
                    <tr>
                      <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                      <td align="right"><?php echo tep_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE); ?></td>
                      <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
        <?php
  }
?>
      </table>
      </form></td>
    <!-- body_text_eof //-->
    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="0" cellpadding="2">
        <!-- right_navigation //-->
        <?php require(DIR_WS_INCLUDES . 'column_right.php'); ?>
        <!-- right_navigation_eof //-->
      </table></td>
  </tr>
</table>
<!-- body_eof //-->
<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
