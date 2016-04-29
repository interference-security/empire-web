<?php
// include files
require_once("includes/check-authorize.php");
require_once("includes/functions.php");

$empire_remove_agent = "";
if(strtolower($_SERVER['REQUEST_METHOD']) == 'post')
{
    if(isset($_POST['remove_agent']) && strlen($_POST['remove_agent'])>0)
    {
        $remove_agent = html_entity_decode(urldecode($_POST['remove_agent']));
        $arr_result = remove_agent($sess_ip, $sess_port, $sess_token, $remove_agent);
        if(!empty($arr_result))
        {
            if(array_key_exists("success",$arr_result))
            {
                $resp = $arr_result["success"];
                if($resp)
                    $empire_remove_agent = "<div class='alert alert-success'><span class='glyphicon glyphicon-ok'></span> Agent removed successfully.</div>";
                else
                    $empire_remove_agent = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Could not remove agent.</div>";
            }
            elseif(array_key_exists("error",$arr_result))
            {
                $empire_remove_agent = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> ".ucfirst(htmlentities($arr_result['error']))."</div>";
            }
            else
            {
                $empire_remove_agent = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
            }
        }
        else
        {
            $empire_remove_agent = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
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
	<title>Empire: Remove Agent</title>
	<?php @require_once("includes/head-section.php"); ?>
</head>
<body>
    <div class="container">
        <?php @require_once("includes/navbar.php"); ?>
        <br>
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading">Remove Agent</div>
                <div class="panel-body">
                    <form role="form" method="post" action="remove-agent.php" class="form-inline">
                        Removes the agent specified by Agent Name (doesn't kill first).<br><br>
                        <div class="form-group">
                            <select class="form-control" id="remove-agent" name="remove_agent">
                                <?php echo $empire_agents; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-danger">Remove Now</button>
                    </form>
                    <br>
                    <?php echo $empire_remove_agent; ?>
                </div>
            </div>
        </div><br>
    </div>
    <?php @require_once("includes/footer.php"); ?>
</body>
</html>
