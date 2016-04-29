<?php
// include files
require_once("includes/check-authorize.php");
require_once("includes/functions.php");

$count = 0;
$empire_modules = "";
$arr_result = get_all_modules($sess_ip, $sess_port, $sess_token);
if(!empty($arr_result))
{
    if(array_key_exists("modules", $arr_result))
    {
        if(sizeof($arr_result["modules"])>0)
        {
            $temp_module_name_list = array();
            for($temp_i=0; $temp_i<sizeof($arr_result["modules"]); $temp_i++)
            {
                array_push($temp_module_name_list, $arr_result["modules"][$temp_i]["Name"]);
            }
            array_multisort($temp_module_name_list, SORT_ASC, $arr_result["modules"]);
            
            for($i=0; $i<sizeof($arr_result["modules"]); $i++)
            {
                $empire_modules .= "<div class='panel-group'><div class='panel panel-success'>
                        <div class='panel-heading'><h4 class='panel-title'><a data-toggle='collapse' href='#collapse$i'>Module Name: ".htmlentities($arr_result["modules"][$i]["Name"])."</a> <a href='execute-module.php?module_name=".htmlentities($arr_result["modules"][$i]["Name"])."' role='button' class='btn btn-xs btn-primary' style='color:white;'>Use Module</a></h4></div>
                        <div id='collapse$i' class='panel-collapse collapse'>
                            <div class='panel-body'>";
                $empire_modules .= "<table class='table table-hover table-striped table-bordered'>";
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
                        $empire_modules .= "<tr><th>$key</th><td>$value</td></tr>";
                    }
                }
                $empire_modules .= "</table>";
                $empire_modules .= "<table class='table table-hover table-striped table-bordered'><thead><tr><th colspan='4'>Module Options:</th></tr><th>Name</th><th>Description</th><th>Required</th><th>Value</th></tr></thead><tbody>";
                foreach($arr_result["modules"][$i]["options"] as $key => $value)
                {
                    $key = htmlentities($key);
                    $desc = htmlentities($value["Description"]);
                    $reqd = (htmlentities($value["Required"]) ? "Yes" : "No");
                    $val = htmlentities($value["Value"]);
                    $empire_modules .= "<tr>";
                    $empire_modules .= "<td>$key</td><td>$desc</td><td>$reqd</td><td>$val</td>";
                    $empire_modules .= "</tr>";
                }
                $empire_modules .= '</tbody></table>';
                $empire_modules .= "</div></div></div></div><br>";
                $count = $i+1;
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Empire: All Modules</title>
	<?php @require_once("includes/head-section.php"); ?>
</head>
<body>
    <div class="container">
        <?php @require_once("includes/navbar.php"); ?>
        <br>
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading">Show All Modules (<?php echo $count; ?>)</div>
                <div class="panel-body"><?php echo $empire_modules; ?></div>
            </div>
        </div><br>
    </div>
    <?php @require_once("includes/footer.php"); ?>
</body>
</html>
