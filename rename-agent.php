<?php
// include files
require_once("includes/check-authorize.php");
require_once("includes/functions.php");

$empire_rename_agent = "";
if(strtolower($_SERVER['REQUEST_METHOD']) == 'post')
{
    if(isset($_POST['current_agent_name']) && strlen($_POST['current_agent_name'])>0 && isset($_POST['newname']) && strlen($_POST['newname'])>0)
    {
        $current_agent_name = html_entity_decode(urldecode($_POST['current_agent_name']));
        $agent_newname = html_entity_decode(urldecode($_POST['newname']));
        $arr_result = rename_agent($sess_ip, $sess_port, $sess_token, $current_agent_name, $agent_newname);
        if(!empty($arr_result))
        {
            if(array_key_exists("success",$arr_result))
            {
                $resp = $arr_result["success"];
                if($resp)
                    $empire_rename_agent = "<div class='alert alert-success'><span class='glyphicon glyphicon-ok'></span> Agent renamed successfully.</div>";
                else
                    $empire_rename_agent = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Could not rename agent.</div>";
            }
            elseif(array_key_exists("error",$arr_result))
            {
                $empire_rename_agent = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> ".ucfirst(htmlentities($arr_result['error']))."</div>";
            }
            else
            {
                $empire_rename_agent = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
            }
        }
        else
        {
            $empire_rename_agent = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
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
	<title>Empire: Rename Agent</title>
	<?php @require_once("includes/head-section.php"); ?>
</head>
<body>
    <div class="container">
        <?php @require_once("includes/navbar.php"); ?>
        <br>
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading">Rename Agent</div>
                <div class="panel-body">
                    <form role="form" method="post" action="rename-agent.php" class="form-inline">
                        <div class="form-group">
                            <select class="form-control" id="current_agent_name" name="current_agent_name">
                                <?php echo $empire_agents; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="newname" placeholder="Enter new agent name" name="newname">
                        </div>
                        <button type="submit" class="btn btn-success">Change Name</button>
                    </form>
                    <br>
                    <?php echo $empire_rename_agent; ?>
                </div>
            </div>
        </div><br>
    </div>
    <?php @require_once("includes/footer.php"); ?>
</body>
</html>
