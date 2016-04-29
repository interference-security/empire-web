<?php
// include files
require_once("includes/check-authorize.php");
require_once("includes/functions.php");


$empire_module = "";
if(isset($_GET['search_module']))
{
    $search_module = urldecode($_GET['search_module']);
    $arr_result = search_module_name($sess_ip, $sess_port, $sess_token, $search_module);
    if(!empty($arr_result))
    {
        if(array_key_exists("modules", $arr_result))
        {
            if(sizeof($arr_result["modules"])>0)
            {
                for($i=0; $i<sizeof($arr_result["modules"]); $i++)
                {
                    $empire_module .= "<div class='panel-group'><div class='panel panel-success'>
                            <div class='panel-heading'>Module Name: ".htmlentities($arr_result["modules"][$i]["Name"])." <a href='execute-module.php?module_name=".htmlentities($arr_result["modules"][$i]["Name"])."' role='button' class='btn btn-xs btn-primary' style='color:white;'>Use Module</a></div>
                                <div class='panel-body'>";
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
                    $empire_module .= "<table class='table table-hover table-striped table-bordered'><thead><tr><th colspan='4'>Module Options:</th></tr><th>Name</th><th>Description</th><th>Required</th><th>Value</th></tr></thead><tbody>";
                    foreach($arr_result["modules"][$i]["options"] as $key => $value)
                    {
                        $key = htmlentities($key);
                        $desc = htmlentities($value["Description"]);
                        $reqd = (htmlentities($value["Required"]) ? "Yes" : "No");
                        $val = htmlentities($value["Value"]);
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Empire: Search Module Name</title>
	<?php @require_once("includes/head-section.php"); ?>
</head>
<body>
    <div class="container">
        <?php @require_once("includes/navbar.php"); ?>
        <br>
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading"><span class='glyphicon glyphicon-search'></span> Show Module by Name</div>
                <div class="panel-body">
                    <form role="form" method="get" action="search-module-name.php" class="form-inline">
                        <div class="form-group">
                            <input type="text" class="form-control" id="search-module" placeholder="Module Name" name="search_module">
                        </div>
                        <button type="submit" class="btn btn-success">Search</button>
                    </form>
                    <br>
                    <?php echo $empire_module; ?>
                </div>
            </div>
        </div><br>
    </div>
    <?php @require_once("includes/footer.php"); ?>
</body>
</html>
