<?php
// include files
require_once("includes/check-authorize.php");
require_once("includes/functions.php");

$empire_shell_agent = "";
if(strtolower($_SERVER['REQUEST_METHOD']) == 'post')
{
    if(isset($_POST['agent_name']) && strlen($_POST['agent_name'])>0 && isset($_POST['agent_cmd']) && strlen($_POST['agent_cmd'])>0)
    {
        $agent_name = html_entity_decode(urldecode($_POST['agent_name']));
        $agent_cmd = html_entity_decode(urldecode($_POST['agent_cmd']));
        //Sorry but had to do it to get better results to show to the user
        //Here I delete the current result buffer to show current command's result to user
        $delete_arr_result = delete_agent_results($sess_ip, $sess_port, $sess_token, $agent_name);
        //Continue executing the shell command execution module
        $arr_result = execute_shell_cmd_agent($sess_ip, $sess_port, $sess_token, $agent_name, $agent_cmd);
        if(!empty($arr_result))
        {
            if(array_key_exists("success",$arr_result))
            {
                $resp = $arr_result["success"];
                if($resp)
                    $empire_shell_agent = "<div class='alert alert-success'><span class='glyphicon glyphicon-ok'></span> Shell command executed successfully.</div>";
                else
                    $empire_shell_agent = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Shell command could not be executed.</div>";
            }
            elseif(array_key_exists("error",$arr_result))
            {
                $empire_shell_agent = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> ".ucfirst(htmlentities($arr_result['error']))."</div>";
            }
            else
            {
                $empire_shell_agent = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
            }
        }
        else
        {
            $empire_shell_agent = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
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
	<title>Empire: Execute Shell Command - Agent</title>
	<?php @require_once("includes/head-section.php"); ?>
</head>
<body>
    <div class="container">
        <?php @require_once("includes/navbar.php"); ?>
        <br>
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading">Task Agent to Run a Shell Command</div>
                <div class="panel-body">
                    <form role="form" method="post" action="agent-shell-cmd.php" class="form-inline">
                        <div class="form-group">
                            <select class="form-control" id="agent_name" name="agent_name" required>
                                <?php echo $empire_agents; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="agent_cmd" placeholder="Enter command" name="agent_cmd" required>
                        </div>
                        <button type="submit" class="btn btn-success">Execute</button>
                    </form>
                    <br>
                    <?php echo $empire_shell_agent; ?>
                </div>
            </div>
        </div><br>
        <div class="panel-group">
            <div class="panel panel-info">
                <div class="panel-heading">Agent Output <button type="button" id="get_result_btn" class="btn btn-primary btn-xs">Show Result</button></div>
                <div class="panel-body">
                    <form method="post" action="get-result.php" id="get-result"><input type="hidden" name="agent_name" value="<?php if(isset($_POST['agent_name']) && strlen($_POST['agent_name'])>0) { echo htmlentities(urldecode($_POST['agent_name'])); } ?>"></form>
                    <div id="loading"></div>
                    <div id="result"></div>
                    <br>
                </div>
            </div>
        </div><br>
    </div>
    <?php @require_once("includes/footer.php"); ?>
    <script>
    $("#get_result_btn").click(function(e){    
            e.preventDefault();  
            $( "#result" ).empty().append( "" );
            $( "#loading" ).empty().append( '<img src="img/loading64.gif" alt="Loading..." width="" height="">' );
            $.post("get-result.php", $("#get-result").serialize(),
            function(data){
                $( "#loading" ).empty().append( "" );
                $( "#result" ).empty().append( data );
                var mydata = $("#result").html();
            });
    });
    </script>
</body>
</html>
