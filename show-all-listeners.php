<?php
error_reporting(E_ALL);
// include files
require_once("includes/check-authorize.php");
require_once("includes/functions.php");

$count = 0;
$empire_listeners = "";
$empire_listeners_detailed = "";
$arr_result = get_all_listeners($sess_ip, $sess_port, $sess_token);
if(!empty($arr_result))
{
    //$empire_listeners = '<table class="table table-hover table-striped"><thead><tr><th>Listener Option</th><th>Listener Value</th></tr></thead><tbody>';
    $empire_listeners .= "<div class='panel-group'>";
    if (count($arr_result["listeners"])>0)
    {
        for($i=0; $i<sizeof($arr_result["listeners"]); $i++)
        {
            $empire_listeners .= "<div class='panel panel-success'>
                        <div class='panel-heading'><h4 class='panel-title'><a data-toggle='collapse' href='#collapse$i'>Listener Name: ".htmlentities($arr_result["listeners"][$i]["name"])."</a></h4></div>
                        <div id='collapse$i' class='panel-collapse collapse'>
                            <div class='panel-body'>";
            $empire_listeners .= '<table class="table table-hover table-striped"><thead><tr><th>Listener Option</th><th>Listener Value</th></tr></thead><tbody>';
            foreach($arr_result["listeners"][$i] as $key => $value)
            {
                $key = htmlentities($key);
                $value = htmlentities($value);
                if($key=="options")
                {
                    //$empire_listeners .= "<tr><td colspan='2' align='center'><b>Listener Detailed Options</b></td></tr>";
                    //for($i=0; $i<sizeof($arr_result["listeners"]); $i++)
                    $empire_listeners_detailed .= "<fieldset><legend>Listener Detailed Options</legend>";
                    $empire_listeners_detailed .= '<table class="table table-hover table-striped"><thead><tr><th>Name</th><th>Description</th><th>Required</th><th>Value</th></tr></thead><tbody>';
                    foreach($arr_result["listeners"][$i]["options"] as $key1 => $value1)
                    {
                        $empire_listeners_detailed .= "<tr>";
                        $empire_listeners_detailed .= "<td>".htmlentities($key1)."</td>";
                        $empire_listeners_detailed .= "<td>".$value1["Description"]."</td>";
                        if ($value1["Required"] == True)
                        {
                            $empire_listeners_detailed .= "<td>Yes</td>";
                        }
                        else
                        {
                            $empire_listeners_detailed .= "<td>No</td>";
                        }
                        $empire_listeners_detailed .= "<td>".htmlentities($value1["Value"])."</td>";
                        $empire_listeners_detailed .= "</tr>";
                    }
                    $empire_listeners_detailed .= '</tbody></table><fieldset>';
                }
                else
                {
                    $empire_listeners .= "<tr><td>$key</td><td>$value</td></tr>";
                }
            }
            $empire_listeners .= '</tbody></table>';
            $empire_listeners .= $empire_listeners_detailed;
            $empire_listeners .= "</div></div></div>";
            $count = $i + 1;
        }
    }
    else
    {
        $empire_listeners .= "<code>You do not have any listenters running</code><br><br>";
        $empire_listeners .= '<button type="button" class="btn btn-success" onclick="location.href=\'create-listener.php\';">Create Listener</button>';
    }
    $empire_listeners .= "</div>";
}
else
{
    $empire_listeners = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Empire: All Listeners</title>
	<?php @require_once("includes/head-section.php"); ?>
</head>
<body>
    <div class="container">
        <?php @require_once("includes/navbar.php"); ?>
        <br>
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading">Show All Listeners (<?php echo $count; ?>)</div>
                <div class="panel-body"><?php echo $empire_listeners; ?></div>
            </div>
        </div>
    </div>
    <?php @require_once("includes/footer.php"); ?>
</body>
</html>
