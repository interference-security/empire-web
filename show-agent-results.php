<?php
// include files
require_once("includes/check-authorize.php");
require_once("includes/functions.php");

$empire_show_agent_results = "";
if(strtolower($_SERVER['REQUEST_METHOD']) == 'post')
{
    if(isset($_POST['agent_name']) && strlen($_POST['agent_name'])>0)
    {
        $agent_name = html_entity_decode(urldecode($_POST['agent_name']));
        $arr_result = show_agent_results($sess_ip, $sess_port, $sess_token, $agent_name);
        if(!empty($arr_result))
        {
            if(array_key_exists("results",$arr_result))
            {
                if(sizeof($arr_result["results"])>0)
                {
                    if(array_key_exists("AgentName", $arr_result["results"][0]) && array_key_exists("AgentResults", $arr_result["results"][0]))
                    {
                        $val_agent_name = htmlentities($arr_result["results"][0]["AgentName"]);
                        $val_agent_results = str_replace("\\r\\n", "<br>", print_r($arr_result["results"][0]["AgentResults"][0], true));
                        $val_agent_results = (strlen($val_agent_results)>0 ? $val_agent_results : "No results");
                        $empire_show_agent_results .= "<div class='panel panel-success'><div class='panel-heading'>Agent $val_agent_name Results</div><div class='panel-body'><pre style='display: block; padding: 9.5px; margin: 0 0 10px; font-size: 13px; line-height: 1.42857143; color: #333; word-break: break-all; word-wrap: break-word; background-color: #f5f5f5; border: 1px solid #ccc; border-radius: 4px;'><code>$val_agent_results</code></pre></div></div>";
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
    $empire_agents = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> 5Unexpected response.</div>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Empire: Show Agent Results</title>
	<?php @require_once("includes/head-section.php"); ?>
</head>
<body>
    <div class="container">
        <?php @require_once("includes/navbar.php"); ?>
        <br>
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading">Show Agent Results</div>
                <div class="panel-body">
                    <form role="form" method="post" action="show-agent-results.php" class="form-inline">
                        Retrieves results for the agent specifed by Agent Name.<br><br>
                        <div class="form-group">
                            <select class="form-control" id="agent-name" name="agent_name">
                                <?php echo $empire_agents; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Show Results</button>
                    </form>
                    <br>
                    <?php echo $empire_show_agent_results; ?>
                </div>
            </div>
        </div>
    </div>
    <?php @require_once("includes/footer.php"); ?>
</body>
</html>
