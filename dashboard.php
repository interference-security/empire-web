<?php
// include files
require_once("includes/check-authorize.php");
require_once("includes/functions.php");

$listener_count = "0 listeners currently active" ;
$arr_result = get_all_listeners($sess_ip, $sess_port, $sess_token);
if(!empty($arr_result))
{
    $listener_count = sizeof($arr_result["listeners"]) . " listeners currently active";
}
else
{
    $listener_count = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
}

$agent_count = "0 agents currently active" ;
$arr_result = get_all_agents($sess_ip, $sess_port, $sess_token);
if(!empty($arr_result))
{
    $agent_count = sizeof($arr_result["agents"]) . " agents currently active";
}
else
{
    $agent_count = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Empire: Dashboard</title>
	<?php @require_once("includes/head-section.php"); ?>
</head>

<body>
    <div class="container">
        <?php @require_once("includes/navbar.php"); ?>
        <h1>PowerShell Empire Web</h1>
        <br>
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading">Empire Listeners</div>
                <div class="panel-body"><code><?php echo $listener_count; ?></code></div>
            </div>
            <br>
            <div class="panel panel-primary">
                <div class="panel-heading">Empire Agents</div>
                <div class="panel-body"><code><?php echo $agent_count; ?></code></div>
            </div>
        </div>
    </div>
    <?php @require_once("includes/footer.php"); ?>
</body>
</html>
