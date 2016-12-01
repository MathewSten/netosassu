<?php
session_start();
include("simple-php-captcha.php");
$_SESSION['captcha'] = simple_php_captcha();
?>

<!DOCTYPE>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Moxian</title>
<style type="text/css">
@import url("css/style.css");
</style>
<script src="jquery-1.8.2.min.js" type="text/javascript"></script> 
</head>

<body>
<div id="wrapper">

<div id="landingpage">
	<div class="landingpage_in">
	<div class="logo">
    <ul>
    <li><img src="images/galaxy.png" width="93" height="88" alt=""></li>
    <li><img src="images/moxian-logo.png" width="96" height="88" alt=""></li>
    </ul>
    </div>


	<div class="form" name="frmemail" id="frmemail">
    
    <form action="" method="get">
	<ul>
    <li><h1>Get Started With Moxian</h1></li>
    	<li><label>Email:</label><input name="email" id="email" type="text" placeholder="E-mail"/></li>
        <li><label>Password:</label><input name="password" id="password" type="text" placeholder="Choose password"/> </li>
        <li><label>Username:</label><input name="username" type="text" id="username" placeholder="Username"/></li>
        <li><label>Verification code:</label><input class="date" name="captchachode" id="captchachode" type="text" placeholder="Verification code"/>
        <i><?php
    	echo '<img src="' . $_SESSION['captcha']['image_src'] . '" alt="CAPTCHA code">';
    	
    	?></i></li>
        <li><label>&nbsp;</label> <input name="accept" type="checkbox" id="accept" value="accept" style="margin-left:0px;"><span  id="acceptId" style="color:#fff;font-size:12px;"> I accept Moxian Registration Agreement</span><li>
       <li><label>&nbsp;</label><input type="submit" name="submit" value="REGISTER ACCOUNT"</li> 
   	</ul>
<div class="checkbox">
  

</div>
</form>
    
    <div class="social">
    
    
    <h1>Others Login</h1>
	<ul>
    <li><a href="#"><img src="images/f.png" width="29" height="29" alt=""></a></li>
    <li><a href="#"><img src="images/t.png" width="30" height="29" alt=""></a></li>
    <li><a href="#"><img src="images/p.png" width="29" height="29" alt=""></a></li>
    <li><a href="#"><img src="images/q.png" width="27" height="29" alt=""></a></li>
    </ul>
    </div>
    </div>
<div class="section">    
    <div class="companylogo">
	<ul>
    <li><img src="images/company-logo_03.png" width="77" height="77" alt=""></li>
       <li><img src="images/company-logo_05.png" width="70" height="77" alt=""></li>
       <li><img src="images/company-logo_07.png" width="76" height="77" alt=""></li>
       <li><img src="images/company-logo_09.png" width="47" height="77" alt=""></li>
       <li><img src="images/company-logo_11.png" width="46" height="77" alt=""></li>
       <li><img src="images/company-logo_13.png" width="47" height="77" alt=""></li>
   	</ul>
   </div>
    
   <div class="ticket">
   <span class="aa">TICKET PRICES</span></br>   
   <span class="bb">RM538&nbsp;RM538&nbsp;RM538&nbsp;RM538&nbsp;RM538&nbsp;RM538</span></br>
   <span class="cc">GALAXY HOTLINE&nbsp; +60322822020&nbsp; WWW.GALAXY.COM.MY</br>ONLINE PURCHASE</span>
   <span class="dd">BUY TICKETS.COM.MY</span>
   </div>
  </div>
</div>
</div>
  
</div>


<script>
	$(function() {
		
			$("#frmemail").submit(function() {
				
				var error = false;
				var email = $("#email").val();
				var password = $("#password").val();
				var username = $("#username").val();
				var captchachode = $("#captchachode").val();
				var isChecked = $('#accept').attr('checked')?true:false;
				
				if(isChecked==false){
						$('#acceptId').css('color', 'red');
						error = true;
				}
				
				
				if(email==""){
						$('#email').css('border', 'solid 1px red');
						error = true;

				}
				
				if(password==""){
						$('#password').css('border', 'solid 1px red');
						error = true;

				}
				
				if(username==""){
						$('#username').css('border', 'solid 1px red');
						error = true;

				}
				
				if(captchachode==""){
						$('#captchachode').css('border', 'solid 1px red');
						error = true;

				}
				
				
				if(error==false){
				$.post("frmemail.php", { email: email, password: password,username:username,captchachode:captchachode})
				.done(function(data) {
					if (data ==0)
					{
						$('#captchachode').css('border', 'solid 1px red');
						//$("#sent").text("Error");  
						return false;
					}
					else { 
						window.location.href = 'thanks.php';
					}
				});
				return false;
			  }else{
			  	return false;
			  }
				
			})
			
	});
	
	</script>
</body>
</html>