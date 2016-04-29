<?php
// include files
require_once("includes/check-authorize.php");
require_once("includes/functions.php");

$empire_restart = "";
$arr_result = restart_api_server($sess_ip, $sess_port, $sess_token);
if(!empty($arr_result))
{
    if(array_key_exists("success", $arr_result))
    {
        $temp_resp = $arr_result["success"];
        if($temp_resp == true)
            header("Location: logout.php");
        elseif($temp_resp == false)
            $empire_restart = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Failed to restart Empire REST API Server.</div>";
        else
            $empire_restart = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> ".htmlentities($temp_resp)."</div>";
    }
    elseif(array_key_exists("error", $arr_result))
    {
        $error_resp = ucfirst(htmlentities($arr_result["error"]));
        $empire_restart = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> $error_resp</div>";
    }
    else
    {
        $empire_restart = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response</div>";
    }
}
else
{
    $empire_restart = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response</div>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Empire: Restart API Server</title>
	<?php @require_once("includes/head-section.php"); ?>
</head>
<body>
    <div class="container">
        <?php @require_once("includes/navbar.php"); ?>
        <br>
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading">Restart Empire REST API Server</div>
                <div class="panel-body"><?php echo $empire_restart; ?>
                </div>
            </div>
        </div><br>
    </div>
    <?php @require_once("includes/footer.php"); ?>
</body>
</html>
