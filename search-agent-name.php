<?php
// include files
require_once("includes/check-authorize.php");
require_once("includes/functions.php");

$empire_agent = "";
if(isset($_GET['search_agent']))
{
    $search_agent = urldecode($_GET['search_agent']);
    $arr_result = search_agent_name($sess_ip, $sess_port, $sess_token, $search_agent);
    if(array_key_exists("error", $arr_result))
    {
        $empire_agent = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> ".ucfirst(htmlentities($arr_result["error"]))."</div>";
    }
    else
    {
        if(!empty($arr_result))
        {
            if(array_key_exists("agents", $arr_result) && !empty($arr_result["agents"][0]))
            {
                $empire_agent .= "<div class='panel-group'><div class='panel panel-success'><div class='panel-heading'>Agent Name: ".htmlentities($arr_result["agents"][0]["name"])."</a></h4></div><div class='panel-body'>";
                $empire_agent .= "<table class='table table-hover table-striped table-bordered'><thead><tr><th>Agent Option</th><th>Agent Value</th></tr></thead><tbody>";
                foreach($arr_result["agents"][0] as $key => $value)
                {
                    $key = htmlentities($key);
                    $value = htmlentities($value);
                    $empire_agent .= "<tr><td>$key</td><td>$value</td></tr>";
                }
                $empire_agent .= '</tbody></table>';
                $empire_agent .= "</div></div></div><br>";
            }
            elseif(array_key_exists("agents", $arr_result) && empty($arr_result["agents"][0]))
            {
                $empire_agent = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Agent not found.</div>";
            }
            else
            {
                $empire_agent = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
                //$empire_agent = $arr_result;
            }
        }
        else
        {
            $empire_agent = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Empire: Search Agent</title>
	<?php @require_once("includes/head-section.php"); ?>
</head>
<body>
    <div class="container">
        <?php @require_once("includes/navbar.php"); ?>
        <br>
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading"><span class='glyphicon glyphicon-search'></span> Search Agent by Name</div>
                <div class="panel-body">
                    <form role="form" method="get" action="search-agent-name.php" class="form-inline">
                        <div class="form-group">
                            <input type="text" class="form-control" id="search-agent" placeholder="Agent Name" name="search_agent">
                        </div>
                        <button type="submit" class="btn btn-success">Search</button>
                    </form>
                    <br>
                    <?php echo $empire_agent; ?>
                </div>
            </div>
        </div><br>
    </div>
    <?php @require_once("includes/footer.php"); ?>
</body>
</html>
