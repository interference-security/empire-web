<?php
// include files
require_once("includes/check-authorize.php");
require_once("includes/functions.php");

$empire_delete_agent_results = "";
if(strtolower($_SERVER['REQUEST_METHOD']) == 'post')
{
    if(isset($_POST['agent_name']) && strlen($_POST['agent_name'])>0)
    {
        $agent_name = html_entity_decode(urldecode($_POST['agent_name']));
        $arr_result = delete_agent_results($sess_ip, $sess_port, $sess_token, $agent_name);
        if(!empty($arr_result))
        {
            if(array_key_exists("success",$arr_result))
            {
                $resp = $arr_result["success"];
                if($resp)
                    $empire_delete_agent_results = "<div class='alert alert-success'><span class='glyphicon glyphicon-ok'></span> Agent results deleted successfully.</div>";
                else
                    $empire_delete_agent_results = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Could not delete agent's results.</div>";
            }
            elseif(array_key_exists("error",$arr_result))
            {
                $empire_delete_agent_results = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> ".ucfirst(htmlentities($arr_result['error']))."</div>";
            }
            else
            {
                $empire_delete_agent_results = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
            }
        }
        else
        {
            $empire_delete_agent_results = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
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
	<title>Empire: Delete Agent Results</title>
	<?php @require_once("includes/head-section.php"); ?>
</head>
<body>
    <div class="container">
        <?php @require_once("includes/navbar.php"); ?>
        <br>
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading">Delete Agent Results</div>
                <div class="panel-body">
                    <form role="form" method="post" action="delete-agent-results.php" class="form-inline">
                        Deletes the result buffer for the agent specified by Agent Name.<br><br>
                        <div class="form-group">
                            <select class="form-control" id="agent-name" name="agent_name">
                                <?php echo $empire_agents; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-danger">Delete Results</button>
                    </form>
                    <br>
                    <?php echo $empire_delete_agent_results; ?>
                </div>
            </div>
        </div>
    </div>
    <?php @require_once("includes/footer.php"); ?>
</body>
</html>
