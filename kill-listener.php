<?php
// include files
require_once("includes/check-authorize.php");
require_once("includes/functions.php");

$empire_kill_listener = "";
if(isset($_POST['kill_listener']) && strlen($_POST['kill_listener'])>0)
{
    $kill_listener = html_entity_decode(urldecode($_POST['kill_listener']));
    $arr_result = kill_listener($sess_ip, $sess_port, $sess_token, $kill_listener);
    if(!empty($arr_result))
    {
        if(array_key_exists("error", $arr_result))
        {
            $empire_kill_listener = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> ".ucfirst(htmlentities($arr_result["error"]))."</div>";
        }
        elseif(array_key_exists("success", $arr_result))
        {
            if($arr_result["success"] == True)
            {
                $empire_kill_listener .= "<div class='alert alert-success'><span class='glyphicon glyphicon-ok'></span> Listener killed successfully.</div>";
            }
            elseif($arr_result["success"] == False)
            {
                $empire_kill_listener .= "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Kill listener failed.</div>";
            }
            else
            {
                $empire_kill_listener = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
            }
        }
        else
        {
            $empire_kill_listener = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
        }
    }
    else
    {
        $empire_kill_listener = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
    }
}

$empire_listeners = "";
$arr_result = get_all_listeners($sess_ip, $sess_port, $sess_token);
if(!empty($arr_result))
{
    $empire_listeners .= "<option value=''>--Choose Listener--</option>";
    for($i=0; $i<sizeof($arr_result["listeners"]); $i++)
    {
        $empire_listeners .= "<option value='".htmlentities($arr_result["listeners"][$i]["name"])."'>".htmlentities($arr_result["listeners"][$i]["name"])."</option>";
    }
    $empire_listeners .= "<option value='all'>All Listeners</option>";
}
else
{
    $empire_listeners = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Empire: Kill Listener</title>
	<?php @require_once("includes/head-section.php"); ?>
</head>
<body>
    <div class="container">
        <?php @require_once("includes/navbar.php"); ?>
        <br>
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading">Kill Listener(s)</div>
                <div class="panel-body">
                    <form role="form" method="post" action="kill-listener.php" class="form-inline">
                        <div class="form-group">
                            <select class="form-control" id="kill-listener" name="kill_listener">
                                <?php echo $empire_listeners; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-danger">Kill Now</button>
                    </form>
                    <br>
                    <?php echo $empire_kill_listener; ?>
                </div>
            </div>
        </div><br>
    </div>
    <?php @require_once("includes/footer.php"); ?>
</body>
</html>
