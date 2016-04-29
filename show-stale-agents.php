<?php
// include files
require_once("includes/check-authorize.php");
require_once("includes/functions.php");

$count = 0;
$empire_agents = "";
$arr_result = get_stale_agents($sess_ip, $sess_port, $sess_token);
if(!empty($arr_result))
{
    if(array_key_exists("agents", $arr_result))
    {
        if(sizeof($arr_result["agents"])>0)
        {
            $empire_agents .= "<div class='panel-group'>";
            for($i=0; $i<sizeof($arr_result["agents"]); $i++)
            {
                $empire_agents .= "<div class='panel panel-success'>
                            <div class='panel-heading'><h4 class='panel-title'><a data-toggle='collapse' href='#collapse$i'>Agent Name: ".htmlentities($arr_result["agents"][$i]["name"])."</a></h4></div>
                            <div id='collapse$i' class='panel-collapse collapse'>
                                <div class='panel-body'>";
                $empire_agents .= '<table class="table table-hover table-striped table-bordered"><thead><tr><th>Agent Option</th><th>Agent Value</th></tr></thead><tbody>';
                foreach($arr_result["agents"][$i] as $key => $value)
                {
                    $key = htmlentities($key);
                    $value = htmlentities($value);
                    $empire_agents .= "<tr><td>$key</td><td>$value</td></tr>";
                }
                $empire_agents .= '</tbody></table>';
                $empire_agents .= "</div></div></div><br>";
                $count = $i + 1;
            }
            $empire_agents .= "</div>";
        }
        else
        {
            $empire_agents = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> No stale agent found.</div>";
        }
    }
    elseif(array_key_exists("error", $arr_result))
    {
        $empire_agents = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span>".$arr_result["error"]."</div>";
    }
    else
    {
        $empire_agents = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
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
	<title>Empire: Stale Agents</title>
	<?php @require_once("includes/head-section.php"); ?>
</head>
<body>
    <div class="container">
        <?php @require_once("includes/navbar.php"); ?>
        <br>
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading">Show Stale Agents (<?php echo $count; ?>)</div>
                <div class="panel-body"><?php echo $empire_agents; ?></div>
            </div>
        </div>
    </div>
    <?php @require_once("includes/footer.php"); ?>
</body>
</html>
