<?php
// include files
require_once("includes/check-authorize.php");
require_once("includes/functions.php");

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
                    <form role="form" method="post" action="agent-shell-cmd.php" class="form-inline" id="agent_submit_command">
                        <div class="form-group">
                            <select class="form-control" id="agent_name" name="agent_name" required>
                                <?php echo $empire_agents; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="agent_cmd" placeholder="Enter command" name="agent_cmd" required>
                        </div>
                        <button type="submit" id="agent_submit_command_btn" class="btn btn-success">Execute</button>
                    </form>
                    <br>
                    <div id="loading_submit_cmd"></div>
                    <div id="result_submit_cmd"></div>
                </div>
            </div>
        </div><br>
        <div class="panel-group">
            <div class="panel panel-info">
                <div class="panel-heading">Agent Output</div>
                <div class="panel-body">
                    <form method="post" action="get-result.php" id="get-result" class="form-inline">
                        <!--<input type="hidden" name="agent_name" value="<?php if(isset($_POST['agent_name']) && strlen($_POST['agent_name'])>0) { echo htmlentities(urldecode($_POST['agent_name'])); } ?>">-->
                        <div class="form-group">
                            <select class="form-control" id="agent_name" name="agent_name" required>
                                <?php echo $empire_agents; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="button" id="get_result_btn" class="btn btn-success">Show Result</button>
                        </div>
                    </form>
                    <br>
                    <div id="loading"></div>
                    <div id="result"></div>
                    <br>
                </div>
            </div>
        </div><br>
    </div>
    <?php @require_once("includes/footer.php"); ?>
    <script>
    $("#agent_submit_command_btn").click(function(e){    
            e.preventDefault();  
            $( "#result_submit_cmd" ).empty().append( "" );
            $( "#loading_submit_cmd" ).empty().append( '<img src="img/loading64.gif" alt="Loading..." width="" height="">' );
            $.post("agent-shell-submit-cmd.php", $("#agent_submit_command").serialize(),
            function(data1){
                $( "#loading_submit_cmd" ).empty().append( "" );
                $( "#result_submit_cmd" ).empty().append( data1 );
                var mydata1 = $("#result_submit_cmd").html();
            });
    });
    
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
