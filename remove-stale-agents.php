<?php
// include files
require_once("includes/check-authorize.php");
require_once("includes/functions.php");

$empire_remove_stale_agents = "";
if(strtolower($_SERVER['REQUEST_METHOD']) == 'post')
{
    if(isset($_POST['removestale']))
    {
        $empire_remove_stale_agents = "";
        $arr_result = remove_stale_agents($sess_ip, $sess_port, $sess_token);
        if(!empty($arr_result))
        {
            if(array_key_exists("success",$arr_result))
            {
                $resp = $arr_result["success"];
                if($resp)
                    $empire_remove_stale_agents = "<div class='alert alert-success'><span class='glyphicon glyphicon-ok'></span> Stale agents deleted</div>";
                else
                    $empire_remove_stale_agents = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Could not delete stale agents.</div>";
            }
            elseif(array_key_exists("error",$arr_result))
            {
                $empire_remove_stale_agents = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> ".ucfirst(htmlentities($arr_result['error']))."</div>";
            }
            else
            {
                $empire_remove_stale_agents = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
            }
        }
        else
        {
            $empire_remove_stale_agents = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Empire: Remove Stale Agents</title>
	<?php @require_once("includes/head-section.php"); ?>
</head>
<body>
    <div class="container">
        <?php @require_once("includes/navbar.php"); ?>
        <br>
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading">Remove Stale Agents</div>
                <div class="panel-body">
                    <form role="form" method="post" action="remove-stale-agents.php">
                        <div class="form-group">
                            <button type="submit" class="btn btn-danger" name="removestale">Remove Stale Agents</button>
                        </div>
                    </form>
                    <?php echo $empire_remove_stale_agents; ?>
                </div>
            </div>
        </div><br>
    </div>
    <?php @require_once("includes/footer.php"); ?>
</body>
</html>
