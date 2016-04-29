<?php
// include files
require_once("includes/check-authorize.php");
require_once("includes/functions.php");

$empire_all_events = "";
$arr_result = get_all_logged_events($sess_ip, $sess_port, $sess_token);
if(array_key_exists("reporting", $arr_result))
{
    $empire_all_events = $arr_result;
}
elseif(array_key_exists("error", $arr_result))
{
    $empire_all_events = "<div class='alert alert-danger'>".htmlentities($arr_result["error"])."</div>";
}
else
{
    $empire_all_events = "<div class='alert alert-danger'>Unexpected response</div>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Empire: All Logged Events</title>
	<?php @require_once("includes/head-section.php"); ?>
</head>
<body>
    <div class="container">
        <?php @require_once("includes/navbar.php"); ?>
        <br>
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading">Show All Logged Events</div>
                <div class="panel-body"><pre style='display: block; padding: 9.5px; margin: 0 0 10px; font-size: 13px; line-height: 1.42857143; color: #333; word-break: break-all; word-wrap: break-word; background-color: #f5f5f5; border: 1px solid #ccc; border-radius: 4px;'><code><?php if(is_array($empire_all_events)){ var_dump($empire_all_events); } else { echo $empire_all_events; } ?></code></pre></div>
            </div>
        </div>
        <br>
    </div>
    <?php @require_once("includes/footer.php"); ?>
</body>
</html>
