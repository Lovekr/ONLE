<?php
require_once("config.php");
require_once("functions/model.php");
$db_con = connect_database();
$error = "";

function login_log($db_con, $user_type) {

    $stmt = $db_con->prepare( 'SELECT * FROM '.DB_PREFIX.'login_log WHERE user_type=:user_type AND login_date=:login_date' );
    $stmt->execute( array(':user_type' => $user_type, ':login_date' => date("Y-m-d")) );
    $data = $stmt->fetch();

    if ( !empty($data) ) {
        /*$dataIn = array(
            'login_count' => $data["login_count"] + 1
        );*/

        /*$this->db->trans_start();
        $this->db->where('id', $data["id"]);
        $this->db->update(DB_PREFIX.'login_log', $dataIn);
        $this->db->trans_complete();*/

        $statement2 =   $db_con->prepare( "UPDATE ".DB_PREFIX."login_log SET login_count=:login_count WHERE id=:id" );
        $statement2->execute( array( ":login_count" => $data["login_count"] + 1, ":id" => $data["id"] ) );

    } else {
        /*$this->db->trans_start();
        $dataIn = array(
            'login_date' => date("Y-m-d"),
            'user_type' => $user_type,
            'login_count' => 1
        );
        $this->db->insert(DB_PREFIX.'login_log', $dataIn);
        $this->db->trans_complete();*/

        $statement = $db_con->prepare("INSERT INTO ".DB_PREFIX."login_log(login_date, user_type, login_count) VALUES(:login_date, :user_type, :login_count)");
        $statement->execute(array(
            ":login_date" => date("Y-m-d"),
            ":user_type" => $user_type,
            ":login_count" => 1
        ));
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username       =   clean_user_input($_POST["your_name"]);
    $userpwd        =   clean_user_input($_POST["your_pass"]);
    $table_name1     =   "admin";
    $rows1           =   get_row_data($db_con, $table_name1, "username", $username);
    $password       =   kittocrypt($userpwd, 'e');

    if(count($rows1) >0 AND $rows1[0]["loginpwd"] == $password)
    {
        $user_token                 =   kittocrypt($userpwd, 'e');
        $user_name                  =   $username;
        $user_id                    =   $rows1[0]["id"];
        $_SESSION["user_id"]        =   $user_id;
        $_SESSION["user_token"]     =   $user_token;
        $_SESSION["user_name"]      =   $user_name;
        $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
        $dirname = rtrim(dirname($_SERVER['PHP_SELF']), '/').'/';
        $expire=time()+(3600 * 24); /*K2 24 hours*/
        if(isset($_POST["userrem"]) ){
            setcookie("user_id",    $user_id,    $expire, "/", $domain, false);
            setcookie("user_token", $user_token, $expire, "/", $domain, false);
            setcookie("user_name",  $user_name,  $expire, "/", $domain, false);
        }

	    login_log($db_con, "ADMIN");

        if(isset($_GET["continue"])){
            $redirect_url = clean_user_input($_GET["continue"]);
            header("Location: $redirect_url");
            exit();
        }
        else{
            header('Location: set_meeting.php');
            exit();
        }
}

else{
    session_unset();
    session_destroy();
    $error = "Invalid Username / Password";
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login For ONLE</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="main">

    	 <div id="confirm"></div>
            <?php
            if(isset($_GET["confirm"])){
                $confirm = trim($_GET["confirm"]);
                if($confirm =="1"){         // FOR ADDED ALERT BOX
                   echo "<script>alert('Your registration is Successful! Please login to create meeting');window.location.href =' http://localhost/onle1/login.php'</script>"; 
                  
                }
            }
            ?>

      <!-- Sign in  Form -->
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="images/signin-image.jpg" alt="sing up image"></figure>
                        <a href="registration.php" class="signup-image-link">Create an account</a>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Sign up</h2>
                        <form method="POST" class="register-form" id="login-form">
                            <div class="form-group">
                                <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="your_name" id="your_name" placeholder="Your Name"/>
                            </div>
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="your_pass" id="your_pass" placeholder="Password"/>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="remember-me" id="remember-me" class="agree-term" />
                                <label for="remember-me" class="label-agree-term"><span><span></span></span>Remember me</label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Log in"/>
                            </div>
                        </form>

                   <!--      <div class="social-login">
                            <span class="social-label">Or login with</span>
                            <ul class="socials">
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-facebook"></i></a></li>
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-twitter"></i></a></li>
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-google"></i></a></li>
                            </ul>
                        </div> -->
                    </div>
                </div>
            </div>
        </section>

    </div>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <script type="text/javascript">
    window.setTimeout(function () {
        $(".alert").fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
        });
    }, 9000);
</script>
</body>
</html>