<?php
// include files
require_once("includes/check-authorize.php");
require_once("includes/functions.php");

$empire_show_agent_results = "";
if(strtolower($_SERVER['REQUEST_METHOD']) == 'get')
{
    if(isset($_GET['agent_name']) && strlen($_GET['agent_name'])>0)
    {
        $agent_name = html_entity_decode(urldecode($_GET['agent_name']));
        $arr_result = get_agent_logged_events($sess_ip, $sess_port, $sess_token, $agent_name);
        if(!empty($arr_result))
        {
            if(array_key_exists("reporting",$arr_result))
            {
                $empire_show_agent_results = $arr_result;
            }
            elseif(array_key_exists("error",$arr_result))
            {
                $empire_show_agent_results = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> ".ucfirst(htmlentities($arr_result['error']))."</div>";
            }
            else
            {
                $empire_show_agent_results = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
            }
        }
        else
        {
            $empire_show_agent_results = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
        }
    }
}

$empire_agents = "";
$arr_result = get_all_agents($sess_ip, $sess_port, $sess_token);
if(!empty($arr_result))
{
    $empire_agents .= "<option value=''>--Choose Agent Name--</option>";
    for($i=0; $i<sizeof($arr_result["agents"]); $i++)
    {
        $empire_agents .= "<option value='".htmlentities($arr_result["agents"][$i]["name"])."'>".htmlentities($arr_result["agents"][$i]["name"])."</option>";
    }
}
else
{
    $empire_agents = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Empire: Logged Events - Agent</title>
	<?php @require_once("includes/head-section.php"); ?>
</head>
<body>
    <div class="container">
        <?php @require_once("includes/navbar.php"); ?>
        <br>
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading"><span class='glyphicon glyphicon-search'></span> Show Agent Logged Events</div>
                <div class="panel-body">
                    <form role="form" method="get" action="show-logged-events-agent.php" class="form-inline">
                        Shows events for a specific agent.<br><br>
                        <div class="form-group">
                            <select class="form-control" id="agent-name" name="agent_name">
                                <?php echo $empire_agents; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Show Events</button>
                    </form>
                    <br>
                    <pre style='display: block; padding: 9.5px; margin: 0 0 10px; font-size: 13px; line-height: 1.42857143; color: #333; word-break: break-all; word-wrap: break-word; background-color: #f5f5f5; border: 1px solid #ccc; border-radius: 4px;'><code><?php if(is_array($empire_show_agent_results)){ var_dump($empire_show_agent_results); } else { echo $empire_show_agent_results; } ?></code></pre>
                </div>
            </div>
        </div><br>
    </div>
    <?php @require_once("includes/footer.php"); ?>
</body>
</html>
