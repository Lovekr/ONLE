<?php
require_once("config.php");
require_once("functions/model.php");

$db_con = connect_database();
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $name_of_meeting           =   clean_user_input($_POST["meeting_name"]);
    $number_participant       =   clean_user_input($_POST["participants"]);

    $statement = $db_con->prepare("INSERT INTO ".DB_PREFIX."create_meeting(name_of_meeting, number_participant) VALUES (:name_of_meeting, :number_participant)");
    $insert_stat = $statement->execute(array(
        "name_of_meeting" => $name_of_meeting,
        "number_participant" => $number_participant
    ));
    
   if($insert_stat == "1"){
      header('Location: set_meeting.php?confirm=1');
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
                        <div id="confirm"></div>
                    <?php
                        if(isset($_GET["confirm"])){
                            $confirm = trim($_GET["confirm"]);
                            if($confirm =="1"){         // FOR ADDED ALERT BOX
                                 echo "<script>alert('Your registration is Successful! Your Meeting has been created sucessfully ');window.location.href =' http://localhost/onle1/set_meeting.php'</script>"; 
                           
                            }
                        }
                    ?>


                        <h2 class="form-title">Create Meeting</h2>
                        <form method="POST" class="register-form" id="register-form">
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="meeting_name" id="meeting_name" placeholder="Purpose of Meeting"/>
                            </div>

                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="participants" id="participants" placeholder="Number of participants"/>
                            </div>
                           
                            <div class="form-group">
                                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" />
                                <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all statements in  <a href="#" class="term-service">Terms of service</a></label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="Create meeting" id="signup" class="form-submit" value="create"/>
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
                            meeting_name: {
                                required: true
                            },
                            participants: {
                                required: true
                            }
                        },
                        messages: {
                            meeting_name: {
                                required: "Purpose of meeting required"
                            },
                            participants: {
                                required: "Please enter Number of Participants"
                            },
                            
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
<script type="text/javascript">
    window.setTimeout(function () {
        $(".alert").fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
        });
    }, 9000);
</script>

</body>
</html>