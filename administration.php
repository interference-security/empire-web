<?php
// include files
require_once("includes/check-authorize.php");
require_once("includes/functions.php");

$empire_permanent_token = "";
$arr_result = get_permanent_session_token($sess_ip, $sess_port, $sess_token);
if(array_key_exists("token", $arr_result))
{
    $empire_permanent_token = htmlentities($arr_result["token"]);
}
else
{
    $empire_permanent_token = "<div class='alert alert-danger'>Unexpected response</div>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Empire: Administration</title>
	<?php @require_once("includes/head-section.php"); ?>
</head>
<body>
    <div class="container">
        <?php @require_once("includes/navbar.php"); ?>
        <br>
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading">Permanent Session Token</div>
                <div class="panel-body"><code><?php echo $empire_permanent_token; ?></code></div>
            </div>
            <br>
            <div class="panel panel-primary">
                <div class="panel-heading">Restart Empire REST API Server</div>
                <div class="panel-body"><button type="button" class="btn btn-warning" onclick="location.href='restart-api-server.php';">Restart API Server</button></div>
            </div>
            <br>
            <div class="panel panel-primary">
                <div class="panel-heading">Shutdown Empire REST API Server</div>
                <div class="panel-body"><button type="button" class="btn btn-danger" onclick="location.href='shutdown-api-server.php';">Shutdown API Server</button></div>
            </div>
        </div>
        <br>
    </div>
    <?php @require_once("includes/footer.php"); ?>
</body>
</html>
