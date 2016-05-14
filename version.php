<?php
// include files
require_once("includes/check-authorize.php");
require_once("includes/functions.php");

$empire_version = "";
$arr_result = get_version($sess_ip, $sess_port, $sess_token);
if(array_key_exists("version", $arr_result))
{
    $empire_version = htmlentities($arr_result["version"]);
}
else
{
    $empire_version = "<div class='alert alert-danger'>Unexpected response</div>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Empire: Version</title>
	<?php @require_once("includes/head-section.php"); ?>
</head>
<body>
    <div class="container">
        <?php @require_once("includes/navbar.php"); ?>
        <br>
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading">PowerShell Empire Version</div>
                <div class="panel-body"><code><?php echo $empire_version; ?></code></div>
            </div>
        </div>
    </div>
    <?php @require_once("includes/footer.php"); ?>
</body>
</html>
