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

//include("simple-php-captcha.php");
//$_SESSION['captcha'] = simple_php_captcha();

define("FILENAME_REQUEST_US", "request_form.php");

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_REQUEST_US);

  $error = false;

  if (isset($HTTP_GET_VARS['action']) && ($HTTP_GET_VARS['action'] == 'send')) {

  

		$name = tep_db_prepare_input($HTTP_POST_VARS['name']);

		$surname = tep_db_prepare_input($HTTP_POST_VARS['surname']);

		$telephone = tep_db_prepare_input($HTTP_POST_VARS['telephone']);

		$email_address = tep_db_prepare_input($HTTP_POST_VARS['email']);

		$enquiry = tep_db_prepare_input($HTTP_POST_VARS['enquiry']);

		

		$address = tep_db_prepare_input($HTTP_POST_VARS['address']);

		

		$location = tep_db_prepare_input($HTTP_POST_VARS['location']);

		$stand_size = tep_db_prepare_input($HTTP_POST_VARS['stand_size']."m2");

		

		$property_type = tep_db_prepare_input($HTTP_POST_VARS['property_type']);

		$responce_area = tep_db_prepare_input($HTTP_POST_VARS['responce_area']);

		$floar_level = tep_db_prepare_input($HTTP_POST_VARS['floar_level']);

		

		$architectural_style = tep_db_prepare_input($HTTP_POST_VARS['architectural_style']);





    if (tep_validate_email($email_address) && tep_validate_telephone($telephone)) {

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

		

		$TemplateMessage.=" Surname :".$surname;		

		$TemplateMessage.="<br><br>";

		

		$TemplateMessage.="E-mail :".$email_address;

		$TemplateMessage.="<br><br>";		

		

		$TemplateMessage.="Property-Address :".$address;

		$TemplateMessage.="<br><br>";		



		

		$TemplateMessage.="Property Location :".$location;

		$TemplateMessage.="<br><br>";	

		

		$TemplateMessage.="Property Type :".$property_type;

		$TemplateMessage.="<br><br>";	



		$TemplateMessage.="Stand Size :".$stand_size;

		$TemplateMessage.="<br><br>";		



		$TemplateMessage.="Response Area :".$responce_area ;

		$TemplateMessage.="<br><br>";	

			

		$TemplateMessage.="Floar Level:".$floar_level ;

		$TemplateMessage.="<br><br>";		



		$TemplateMessage.="architectural Style:".$architectural_style ;

		$TemplateMessage.="<br><br>";		



		

		$TemplateMessage.="<br><br><br/>Thanks & Regards<br/>";

		

		$TemplateMessage.="Nethouseplans Team";

		

		echo $TemplateMessage.="<br><br><br>This is a post-only mailing.  Replies to this message are not monitored or answered.";

		

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



        tep_redirect(tep_href_link(FILENAME_REQUEST_US, 'action=success'));


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



  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_REQUEST_US));

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
    <td width="100%" valign="top"><?php echo tep_draw_form('request_form', tep_href_link(FILENAME_REQUEST_US, 'action=send')); ?>
      <table border="0" width="100%" cellspacing="0" cellpadding="0">
        <tr>
          <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td class="pageHeading"><?php echo "Enquiry From" ?> <span style="font-size:14px; font-weight:normal;">(<a href="mailto:info@nethouseplans.com">info@nethouseplans.com</a>)</span></td>
                <td class="pageHeading" align="right"><?php echo tep_image(DIR_WS_IMAGES . 'table_background_contact_us.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
        </tr>
        <!--<tr>

      	<td class="main">Enquiry Form<strong> </strong>on 084 011 7761 (Normal Cellular Rates Apply)</td>

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
                      <td class="main"><?php echo "Name:"; ?></td>
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
                      <td class="main"><?php echo "Property Address"; ?></td>
                    </tr>
                    <tr>
                      <td class="main"><?php echo tep_draw_input_field('address'); ?></td>
                    </tr>
                    <!--  <tr>

                <td class="main"><?php echo "Property Location:"; ?></td>

              </tr>

              <tr>

                <td class="main"><?php echo tep_draw_input_field('location'); ?></td>

              </tr>

			  -->
                    <tr>
                      <td class="main" style="font-size:9px; line-height:0.5;"><?php echo "ie. Suburb, City, Country"; ?></td>
                    </tr>
                    <tr>
                      <td class="main"><?php echo "Property Type:"; ?></td>
                    </tr>
                    <tr>
                      <td class="main"><select name="property_type">
                          <option selected="Select Option" >Select Option</option>
                          <option value="Suburban">Suburban</option>
                          <option value="Residential Complex/Estate">Residential Complex/Estate</option>
                          <option value="Rural/Country">Rural/Country</option>
                          <option value="Commercial">Commercial</option>
                        </select></td>
                    </tr>
                    <tr>
                      <td class="main">Stand Size (M<sup>2</sup>)</td>
                    </tr>
                    <tr>
                      <td class="main"><?php echo tep_draw_input_field('stand_size'); ?></td>
                    </tr>
                    <tr>
                      <td class="main">Proposed Area/Size(M<sup>2</sup>)</td>
                    </tr>
                    <tr>
                      <td class="main"><select name="responce_area">
                          <option selected="Select Option" >I'm not sure</option>
                          <option value="100m2">0 - 100 m<sup>2</sup></option>
                          <option value="150m2">100 - 150 m<sup>2</sup></option>
                          <option value="200m2">150 - 200 m<sup>2</sup></option>
                          <option value="250m2">200 - 250 m<sup>2</sup></option>
                          <option value="300m2">250 - 300 m<sup>2</sup></option>
                          <option value="350m2">300 - 350 m<sup>2</sup></option>
                          <option value="400m2">350 - 400 m<sup>2</sup></option>
                          <option value="450m2">400- 450 m<sup>2</sup></option>
                          <option value="500m2">450 - 500 m<sup>2</sup></option>
                          <option value="600m2">500 - 600 m<sup>2</sup></option>
                          <option value="above_600m2">above 600m<sup>2</sup></option>
                        </select></td>
                    </tr>
                    <tr>
                      <td class="main">Floor Levels</td>
                    </tr>
                    <tr>
                      <td class="main"><select name="floar_level">
                          <option selected="Select Option" >Select</option>
                          <option value="Single Storey">Single Storey</option>
                          <option value="Double Storey">Double Storey</option>
                          <option value="Other">Other</option>
                        </select></td>
                    </tr>
                    <tr>
                      <td class="main">Architectural Style</td>
                    </tr>
                    <tr>
                      <td class="main"><select name="architectural_style">
                          <option selected="Select Option" >Select</option>
                          <option value="Traditional">Traditional</option>
                          <option value="Modern">Modern</option>
                          <option value="Ultra_Modern">Ultra Modern</option>
                          <option value="Tuscan">Tuscan</option>
                          <option value="Bali">Bali</option>
                          <option value="Country">Country</option>
                          <option value="Modern_country">Modern Country</option>
                        </select></td>
                    </tr>
                    <tr>
                      <td class="main"><?php echo "Remarks/ Requerments :"; ?></td>
                    </tr>
                    <tr>
                      <td><?php echo tep_draw_textarea_field('enquiry', 'soft', 25, 8); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
        </tr>
		<tr>
		<td>
 <!--<script type="text/javascript"
    src="http://www.google.com/recaptcha/api/challenge?k=6LdKx_wSAAAAADM2ZDW4RWnqH7VSpUayymVWP_fe">
 </script>
 <script type="text/javascript">
        var RecaptchaOptions = {
                lang : 'en', 
                theme : 'white' 
        };
</script>
 <noscript>
   <iframe src="http://www.google.com/recaptcha/api/noscript?k=6LdKx_wSAAAAADM2ZDW4RWnqH7VSpUayymVWP_fe"
        height="300" width="500" frameborder="0"></iframe><br>
   <textarea name="recaptcha_challenge_field" rows="3" cols="40">
   </textarea>
   <input type="hidden" name="recaptcha_response_field"
        value="manual_challenge">
 </noscript>-->
 
 <?php
    	#echo '<img src="' . $_SESSION['captcha']['image_src'] . '" alt="CAPTCHA code">';
    	echo $_SESSION['key'];
		//echo tep_getcookie('cookie_test');
    	?>
	 <script type="text/javascript" src="jquery-1.8.0.min.js"></script>
   <script type="text/javascript">
$(document).ready(function(){
$("#new").click(function() {
$("#captcha").attr("src", "captcha.php?"+Math.random());
});    
});
</script>
<span style="float: left;margin-top: 7px;margin-right:10px;">CAPTCHA Code:</span>
<img src="captcha.php" border="0" alt="CAPTCHA!" id="captcha"><a href="#new" id="new"><img src="reload.png" style="width: 35px;margin-left:10px;" /></a>
<br /> 
<input type="hidden" name="captechaval" value=""/>
Enter CAPTCHA: <input type="text" name="key" value="" /> 
 </td>
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
