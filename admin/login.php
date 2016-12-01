<?php
    include_once('../common/config.php');

    $msg = '';
    
    if(isset($_SESSION['admin_email']) && $_SESSION['admin_id']!='')
    {
        echo "<script>window.location.href = 'index.php'</script>";
    }

    if(isset($_POST['submit']))
    {
        $email = $_POST['email'];
        $pass = md5($_POST['password']);
        
        $select = $conn->query("select * from users where email = '".$email."' AND password = '".$pass."' AND role_id = 1");
        $count = mysqli_num_rows($select);
        $data = mysqli_fetch_array($select);
        
        if($count!=0)
        {
            $_SESSION['admin_email'] = $data['email'];
            $_SESSION['admin_name'] = $data['name'];
            $_SESSION['admin_id'] = $data['id'];
            
            header('Location: '.SITE_URL_ADMIN.'index.php');
        }
        else
        {
            $msg = "Username and Password are incorrect";
        }
    }
?>

<script>
    function checkdata()
    {
        var name = $('#name').val();
        var pass = $('#pass').val();
        
        if(name == '')
        {
            $('#error_name').html("Enter email");
            return false;
        }
        else if (name != '')
		{
            var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
			if (filter.test(name))
			{
			}
			else
			{
				$('#error_name').html("Enter email");
                return false;
			}
        }
        
        if(pass == '')
        {
            $('#error_pass').html("Enter Password");
            return false;
        }
    }
</script>



<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>Admin area</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>    
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>


    <body class="bg-black">
        <div class="form-box" id="login-box">
            <div class="header">Sign In</div>        
            <form  method="post" action="<?php echo SITE_URL_ADMIN.'login.php'?>">
                <div class="body bg-gray">
                    <div class="form-group">
                        <input type="text" name="email" class="form-control" placeholder="Email" id="name"/>
                        <div id="error_name" style="color:#FF0000;"/></div>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password" id="pass"/>
                        <div id="error_pass" style="color:#FF0000;"/></div>
                    </div>  
                </div>
                
                <div class="footer">
                    <button type="submit" class="btn bg-olive btn-block" name="submit" onClick="return checkdata();">Sign me in</button>
                    <p style="color:#FF0000"><?php echo $msg; ?></p>
                    <!-- <a href="register.php" class="text-center">Register a new membership</a>-->
                </div>
            </form>
        </div>
        
    
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
    </body>
</html