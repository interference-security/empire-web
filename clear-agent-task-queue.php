<?php
// include files
require_once("includes/check-authorize.php");
require_once("includes/functions.php");

$empire_clear_agent_tasks = "";
if(strtolower($_SERVER['REQUEST_METHOD']) == 'post')
{
    if(isset($_POST['agent_name']) && strlen($_POST['agent_name'])>0)
    {
        $agent_name = html_entity_decode(urldecode($_POST['agent_name']));
        $arr_result = clear_agent_task_queue($sess_ip, $sess_port, $sess_token, $agent_name);
        if(!empty($arr_result))
        {
            if(array_key_exists("success",$arr_result))
            {
                $resp = $arr_result["success"];
                if($resp)
                    $empire_clear_agent_tasks = "<div class='alert alert-success'><span class='glyphicon glyphicon-ok'></span> Agent task queue cleared.</div>";
                else
                    $empire_clear_agent_tasks = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Could not clear agent task queue.</div>";
            }
            elseif(array_key_exists("error",$arr_result))
            {
                $empire_clear_agent_tasks = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> ".ucfirst(htmlentities($arr_result['error']))."</div>";
            }
            else
            {
                $empire_clear_agent_tasks = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
            }
        }
        else
        {
            $empire_clear_agent_tasks = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
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
    $empire_agents .= "<option value='all'>All Agents</option>";
}
else
{
    $empire_agents = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Empire: Clear Task Queue</title>
	<?php @require_once("includes/head-section.php"); ?>
</head>
<body>
    <div class="container">
        <?php @require_once("includes/navbar.php"); ?>
        <br>
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading">Clear Agent Task Queue</div>
                <div class="panel-body">
                    <form role="form" method="post" action="clear-agent-task-queue.php" class="form-inline">
                        Clears the queued tasks for the agent specified by Agent Name.<br><br>
                        <div class="form-group">
                            <select class="form-control" id="agent-name" name="agent_name">
                                <?php echo $empire_agents; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-danger">Clear Tasks</button>
                    </form>
                    <br>
                    <?php echo $empire_clear_agent_tasks; ?>
                </div>
            </div>
        </div>
    </div>
    <?php @require_once("includes/footer.php"); ?>
</body>
</html>
