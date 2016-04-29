<?php
session_start();
$allow = 0;
$sess_ip = ""; $sess_port = ""; $sess_user = ""; $sess_pass = ""; $sess_token = ""; $sess_csrf = "";
if(isset($_SESSION['empire_ip']) && isset($_SESSION['empire_port']) && isset($_SESSION['empire_user']) && isset($_SESSION['empire_pass']) && isset($_SESSION['empire_session_token']) && isset($_SESSION['csrf_token']))
{
    $sess_ip = $_SESSION['empire_ip'];
    $sess_port = $_SESSION['empire_port'];
    $sess_user = $_SESSION['empire_user'];
    $sess_pass = $_SESSION['empire_pass'];
    $sess_token = $_SESSION['empire_session_token'];
    $sess_csrf = $_SESSION['csrf_token'];
    if(strlen($sess_ip)>0 && strlen($sess_port)>0 && strlen($sess_user)>0 && strlen($sess_pass)>0 && strlen($sess_token)>0 && strlen($sess_csrf)==64)
    {
        $allow = 1;
    }
}
if($allow==1)
{
    header("Location: dashboard.php");
}

require_once("includes/functions.php");

$status = "";
if(isset($_POST["empire_ip"]) && isset($_POST["empire_port"]) && isset($_POST["empire_user"]) && isset($_POST["empire_pass"]))
{
    $empire_ip = urldecode($_POST["empire_ip"]);
    $empire_port = urldecode($_POST["empire_port"]);
    $empire_user = urldecode($_POST["empire_user"]);
    $empire_pass = urldecode($_POST["empire_pass"]);
    if(strlen($empire_ip)>0 && strlen($empire_port)>0 && strlen($empire_user)>0 && strlen($empire_pass)>0)
    {
        $arr_result = authenticate_empire($empire_ip, $empire_port, $empire_user, $empire_pass);
        if(array_key_exists("token", $arr_result))
        {
            $empire_session_token = $arr_result["token"];
            $status = "<div class='alert alert-success'><span class='glyphicon glyphicon-ok'></span> Login success. $empire_session_token</div>";
            @session_destroy();
            session_start();
            session_regenerate_id();
            //Create session values
            $_SESSION['empire_ip'] = $empire_ip;
            $_SESSION['empire_port'] = $empire_port;
            $_SESSION['empire_user'] = $empire_user;
            $_SESSION['empire_pass'] = $empire_pass;
            $_SESSION['empire_session_token'] = $empire_session_token;
            //For anti-csrf
            $_SESSION['csrf_token'] = substr("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ",mt_rand(0,50),1).substr(hash("sha256",time().rand().rand()), 1);
            header("Location: dashboard.php");
        }
        else
        {
            $status = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Failed login attempt.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Empire Web Login</title>
	<?php @require_once("includes/head-section.php"); ?>
</head>

<body>
    <div class="container">
        <?php @require_once("includes/navbar.php"); ?>
        <div class="row clearfix">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <form role="form" method="post" action="login.php" autocomplete="on">
                    <div class="form-group">
                        <center>
                            <img src="img/empire_logo_black4.png" style="width:200px; height:200px;">
                            <h3>PowerShell Empire Web</h3>
                        </center>
                    </div>
                    <div class="form-group">
                        <label for="loginip">Empire IP Address</label>
                        <input type="text" class="form-control" id="loginip" placeholder="Enter IP Address" name="empire_ip">
                    </div>
                    <div class="form-group">
                        <label for="loginport">Empire Port</label>
                        <input type="text" class="form-control" id="loginport" placeholder="Enter Port" name="empire_port">
                    </div>
                    <div class="form-group">
                        <label for="loginusername">Empire Username</label>
                        <input type="text" class="form-control" id="loginusername" placeholder="Enter Username" name="empire_user">
                    </div>
                    <div class="form-group">
                        <label for="loginpassword">Empire Password</label>
                        <input type="password" class="form-control" id="loginpassword" placeholder="Enter Password" name="empire_pass">
                    </div>
                    <button type="submit" class="btn btn-success">Login</button>
                </form><br>
                <?php if(strlen($status)>0){ echo $status; } ?>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
    <?php @require_once("includes/footer.php"); ?>
</body>
</html>