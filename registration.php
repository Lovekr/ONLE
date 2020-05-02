<?php
require_once("config.php");
require_once("functions/model.php");

$db_con = connect_database();
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $name           =   clean_user_input($_POST["name"]);
    $username       =   clean_user_input($_POST["username"]);
    $loginpwd       =   clean_user_input($_POST["pass"]);
    $loginpwd       =   kittocrypt($loginpwd, 'e' ); //$decrypted_pass = 

    $email_id       =   clean_user_input($_POST["email"]);


    $statement = $db_con->prepare("INSERT INTO ".DB_PREFIX."admin(name, username, loginpwd, email_id) VALUES (:name, :username, :loginpwd, :email_id)");
    $insert_stat = $statement->execute(array(
        "name" => $name,
        "username" => $username,
        "loginpwd" => $loginpwd,
        "email_id" => $email_id
    ));
    
   if($insert_stat == "1"){
      header('Location: login.php?confirm=1');
      exit();
  }
}
?>











<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration For ONLE</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="main">

        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">REGISTRATION</h2>
                        <form method="POST" class="register-form" id="register-form">
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="name" id="name" placeholder="Your Name"/>
                            </div>

                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="username" id="username" placeholder="Your Username"/>
                            </div>


                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Your Email"/>
                            </div>
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="pass" id="pass" placeholder="Password"/>
                            </div>
                            <div class="form-group">
                                <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" name="re_pass" id="re_pass" placeholder="Repeat your password"/>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" />
                                <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all statements in  <a href="#" class="term-service">Terms of service</a></label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Register"/>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="images/signup-image.jpg" alt="sing up image"></figure>
                        <a href="login.php" class="signup-image-link">I am already member</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- End of Registayion Form -->

        

    </div>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
      <!-- Validator eNGINE -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>

     <script type="text/javascript">
                jQuery(document).ready(function(){
              
                    $("#register-form").validate({
                        ignore: [],
                        rules: {
                            name: {
                                required: true
                            },
                            password: {
                                required: true
                            },
                            username:{
                                required: true,
                                minlength: 5,
                                remote: {
                                    url: "ajax/checkusername.php",
                                    type: "post"
                                }
                            },
                            pass:{
                                required: true,
                                minlength: 5
                            },
                            re_pass:{
                                required: true,
                                minlength: 5,
                                equalTo: "#pass"
                            },
                            
                            email:{
                                email: true,
                             
                            }
                        },
                        messages: {
                            name: {
                                required: " Enter Your name"
                            },
                            username:{
                                required: " Enter Username",
                                minlength: "username should contain at-least 5 characters",
                                remote: "Username already in use!"
                            },
                            pass:{
                                required: " Enter Password",
                                minlength: "Password should contain at-least 5 characters"
                            },
                            re_pass:{
                                required: " Enter Confirm Password",
                                minlength: "Confirm Password should contain at-least 5 characters",
                                equalTo: "Password not same"
                            },
                            /*inputemailid:{
                                required: " Enter Email Id",
                                remote: "Email already in use!"
                            },*/
                        },
                        errorElement: "span",
                        errorPlacement: function ( error, element ) {
        // Add the `help-block` class to the error element
        error.addClass( "help-block" );
        // Add `has-feedback` class to the parent div.form-group
        // in order to add icons to inputs
        element.parents( ".col-sm-5" ).addClass( "has-feedback" );
        if(element.parent('.input-group').length) {
            error.insertAfter(element.parent());
        } else {
            error.insertAfter(element);
        }
        /*if ( element.prop( "type" ) === "checkbox" ) {
        error.insertAfter( element.parent( "label" ) );
        } else {
        error.insertAfter( element );
    }*/
        // Add the span element, if doesn't exists, and apply the icon classes to it.
        if ( !element.next( "span" )[ 0 ] ) {
        //$( "<span class='glyphicon glyphicon-remove form-control-feedback'></span>" ).insertAfter( element );
    }
},
success: function ( label, element ) {
        // Add the span element, if doesn't exists, and apply the icon classes to it.
        if ( !$( element ).next( "span" )[ 0 ] ) {
        //$( "<span class='glyphicon glyphicon-ok form-control-feedback'></span>" ).insertAfter( $( element ) );
    }
},
        /*highlight: function ( element, errorClass, validClass ) {
        $( element ).parents( ".col-sm-5" ).addClass( "has-error" ).removeClass( "has-success" );
        //$( element ).next( "span" ).addClass( "glyphicon-remove" ).removeClass( "glyphicon-ok" );
        },
        unhighlight: function ( element, errorClass, validClass ) {
        $( element ).parents( ".col-sm-5" ).addClass( "has-success" ).removeClass( "has-error" );
        //$( element ).next( "span" ).addClass( "glyphicon-ok" ).removeClass( "glyphicon-remove" );
    },*/
    submitHandler: function(form) {
        form.submit();
    }
} );
} );
</script>
</body>
</html>