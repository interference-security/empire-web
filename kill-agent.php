<?php
// include files
require_once("includes/check-authorize.php");
require_once("includes/functions.php");

$empire_kill_agent = "";
if(strtolower($_SERVER['REQUEST_METHOD']) == 'post')
{
    if(isset($_POST['kill_agent']) && strlen($_POST['kill_agent'])>0)
    {
        $kill_agent = html_entity_decode(urldecode($_POST['kill_agent']));
        $arr_result = kill_agent($sess_ip, $sess_port, $sess_token, $kill_agent);
        if(!empty($arr_result))
        {
            if(array_key_exists("success",$arr_result))
            {
                $resp = $arr_result["success"];
                if($resp)
                    $empire_kill_agent = "<div class='alert alert-success'><span class='glyphicon glyphicon-ok'></span> Agent killed successfully.</div>";
                else
                    $empire_kill_agent = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Could not kill agent.</div>";
            }
            elseif(array_key_exists("error",$arr_result))
            {
                $empire_kill_agent = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> ".ucfirst(htmlentities($arr_result['error']))."</div>";
            }
            else
            {
                $empire_kill_agent = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
            }
        }
        else
        {
            $empire_kill_agent = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
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
	<title>Empire: Kill Agent(s)</title>
	<?php @require_once("includes/head-section.php"); ?>
</head>
<body>
    <div class="container">
        <?php @require_once("includes/navbar.php"); ?>
        <br>
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading">Kill Agent(s)</div>
                <div class="panel-body">
                    <form role="form" method="post" action="kill-agent.php" class="form-inline">
                        Tasks an agent or all agents to exit.<br><br>
                        <div class="form-group">
                            <select class="form-control" id="kill-agent" name="kill_agent">
                                <?php echo $empire_agents; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-danger">Kill Now</button>
                    </form>
                    <br>
                    <?php echo $empire_kill_agent; ?>
                </div>
            </div>
        </div><br>
    </div>
    <?php @require_once("includes/footer.php"); ?>
</body>
</html>
