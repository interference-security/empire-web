<?php
// include files
require_once("includes/check-authorize.php");
require_once("includes/functions.php");

$empire_modules = "";
$arr_result = get_all_modules($sess_ip, $sess_port, $sess_token);
if(!empty($arr_result))
{
    if(array_key_exists("modules", $arr_result))
    {
        if(sizeof($arr_result["modules"])>0)
        {
            $res_module_name = array();
            for($i=0; $i<sizeof($arr_result["modules"]); $i++)
            {
                array_push($res_module_name, $arr_result["modules"][$i]["Name"]);
                //$empire_modules .= "<option value='$res_module_name'>$res_module_name</option>";
            }
            if(!empty($res_module_name))
            {
                sort($res_module_name);
                foreach($res_module_name as $tempkey => $temp_module_name)
                {
                    $temp_module_name= htmlentities($temp_module_name);
                    $empire_modules .= "<option value='$temp_module_name'>$temp_module_name</option>";
                }
            }
        }
        else
        {
            $empire_modules = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> No module found.</div>";
        }
    }
    elseif(array_key_exists("error", $arr_result))
    {
        $empire_modules = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span>".ucfirst(htmlentities($arr_result["error"]))."</div>";
    }
    else
    {
        $empire_modules = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
    }
}
else
{
    $empire_modules = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
}

$empire_module = "";
if(isset($_GET['module_name']) && strlen($_GET['module_name'])>0)
{
    $module_name = html_entity_decode(urldecode($_GET['module_name']));
    $arr_result = search_module_name($sess_ip, $sess_port, $sess_token, $module_name);
    if(!empty($arr_result))
    {
        if(array_key_exists("modules", $arr_result))
        {
            if(sizeof($arr_result["modules"])>0)
            {
                for($i=0; $i<sizeof($arr_result["modules"]); $i++)
                {
                    $empire_module .= "<div class='panel-group'><div class='panel panel-success'>
                            <div class='panel-heading'>Module Name: ".htmlentities($arr_result["modules"][$i]["Name"])."</div>
                                <div class='panel-body'>
                                    <button type='submit' class='btn btn-primary'>Execute Module</button><br><br>";
                    $empire_module .= "<table class='table table-hover table-striped table-bordered'>";
                    foreach($arr_result["modules"][$i] as $key => $value)
                    {
                        if($key != "options")
                        {
                            $key = htmlentities($key);
                            $value = (is_array($value) ? htmlentities(implode(', ', $value)) : $value);
                            if(is_bool($value))
                            {
                                if($value == True)
                                    $value = "Yes";
                                else
                                    $value = "No";
                            }
                            elseif(is_null($value))
                            {
                                $value = "Null";
                            }
                            else
                            {
                                $value = htmlentities($value);
                            }
                            $empire_module .= "<tr><th>$key</th><td>$value</td></tr>";
                        }
                    }
                    $empire_module .= "</table>";
                    
                    //Get Agent Names to be used in next FOR loop, required for module execution
                    $agent_names_select = "";
                    $agent_names_select .= "<select class='form-control' id='agent_name' name='Agent'>";
                    $agent_arr_result = get_all_agents($sess_ip, $sess_port, $sess_token);
                    if(!empty($agent_arr_result))
                    {
                        if(array_key_exists("agents", $agent_arr_result))
                        {
                            if(sizeof($agent_arr_result["agents"])>0)
                            {
                                for($j=0; $j<sizeof($agent_arr_result["agents"]); $j++)
                                {
                                    $temp_agent_name = htmlentities($agent_arr_result["agents"][$j]["name"]);
                                    $agent_names_select .= "<option value='$temp_agent_name'>$temp_agent_name</option>";
                                }
                            }
                            else
                            {
                                $agent_names_select = "<option value=''>--No agent found--</option>";
                            }
                        }
                        elseif(array_key_exists("error", $agent_arr_result))
                        {
                            $agent_names_select = "<option value=''>Error: ".$agent_arr_result["error"]."</option>";
                        }
                        else
                        {
                            $agent_names_select = "<option value=''>--Unexpected Response--</option>";
                        }
                    }
                    else
                    {
                        $agent_names_select = "<option value=''>--Unexpected Response--</option>";
                    }
                    $agent_names_select .= "<option value='all'>All Agents</option>";
                    $agent_names_select .= "<select>";
                    
                    $empire_module .= "<table class='table table-hover table-striped table-bordered'><thead><tr><th colspan='4'>Module Options:</th></tr><th>Name</th><th>Description</th><th>Required</th><th>Value</th></tr></thead><tbody>";
                    foreach($arr_result["modules"][$i]["options"] as $key => $value)
                    {
                        $key = htmlentities($key);
                        $desc = htmlentities($value["Description"]);
                        $reqd = (htmlentities($value["Required"]) ? "Yes" : "No");
                        $val = htmlentities($value["Value"]);
                        if($key == "Agent")
                            $val = $agent_names_select;
                        else
                            $val = "<input type='text' class='form-control' name='$key' value='$val'>";
                        $empire_module .= "<tr>";
                        $empire_module .= "<td>$key</td><td>$desc</td><td>$reqd</td><td>$val</td>";
                        $empire_module .= "</tr>";
                    }
                    $empire_module .= '</tbody></table>';
                    $empire_module .= "</div></div></div>";
                }
            }
            else
            {
                $empire_module = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> No module found.</div>";
            }
        }
        elseif(array_key_exists("error", $arr_result))
        {
            $empire_module = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> ".ucfirst(htmlentities($arr_result["error"]))."</div>";
        }
        else
        {
            $empire_module = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
        }
    }
    else
    {
        $empire_module = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
    }
}
//Execute Empire Module
$empire_execute_module = "";
if(isset($_POST) && !empty($_POST))
{
    $arr_data = array();
    foreach($_POST as $key => $value)
    {
        if($key != "module_run")
            $arr_data[$key] = html_entity_decode(urldecode($value));
    }
    $module_to_run = html_entity_decode(urldecode($_POST['module_run']));
    //Sorry but had to do it to get better results to show to the user
    //Here I delete the current result buffer to show current command's result to user
    $agent_name = html_entity_decode(urldecode($_POST['Agent']));
    $delete_arr_result = delete_agent_results($sess_ip, $sess_port, $sess_token, $agent_name);
    //Continue executing the shell command execution module
    $arr_result = execute_module($sess_ip, $sess_port, $sess_token, $arr_data, $module_to_run);
    if(array_key_exists("success", $arr_result))
    {
        if($arr_result["success"] == True)
        {
            if(array_key_exists("msg", $arr_result))
            {
                $empire_execute_module = "<div class='alert alert-success'><span class='glyphicon glyphicon-ok'></span> ".ucfirst(htmlentities($arr_result["msg"]))."</div>";
            }
            else
            {
                $empire_execute_module = "<div class='alert alert-success'><span class='glyphicon glyphicon-ok'></span> Listener created successfully.</div>";
            }
        }
        else
        {
            if(array_key_exists("msg", $arr_result))
            {
                $empire_execute_module = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> ".ucfirst(htmlentities($arr_result["msg"]))."</div>";
            }
            else
            {
                $empire_execute_module = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Listener creation failed.</div>";
            }
        }
    }
    elseif(array_key_exists("error", $arr_result))
    {
        $empire_execute_module = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> ".ucfirst(htmlentities($arr_result["error"]))."</div>";
    }
    else
    {
        $empire_execute_module = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Empire: Execute Module</title>
	<?php @require_once("includes/head-section.php"); ?>
</head>
<body>
    <div class="container">
        <?php @require_once("includes/navbar.php"); ?>
        <br>
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading"><span class='glyphicon glyphicon-search'></span> Execute Module</div>
                <div class="panel-body">
                    <form role="form" method="get" action="execute-module.php" class="form-inline">
                        <div class="form-group">
                            <select class="form-control" id="module_name" name="module_name">
                                <option value=''>--Choose Module--</option>
                                <?php echo $empire_modules; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Choose</button>
                    </form>
                    <br>
                    <?php
                        if(strtolower($_SERVER["REQUEST_METHOD"]) == "post")
                            echo $empire_execute_module;
                    ?>
                    <form role="form" method="post" action="execute-module.php" class="form-inline">
                    <?php echo $empire_module; ?>
                    <input type="hidden" name="module_run" value="<?php if(isset($_GET['module_name'])){ echo htmlentities(urldecode($_GET['module_name'])); } ?>">
                    </form>
                </div>
            </div>
        </div><br>
        <div class="panel-group">
            <div class="panel panel-info">
                <div class="panel-heading">Agent Output <button type="button" id="get_result_btn" class="btn btn-primary btn-xs">Show Result</button></div>
                <div class="panel-body">
                    <form method="post" action="get-result.php" id="get-result"><input type="hidden" name="agent_name" value="<?php if(isset($_POST['Agent']) && strlen($_POST['Agent'])>0) { echo htmlentities(urldecode($_POST['Agent'])); } ?>"></form>
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
