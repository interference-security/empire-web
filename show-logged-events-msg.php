<?php
// include files
require_once("includes/check-authorize.php");
require_once("includes/functions.php");

$empire_show_msg_results = "";
if(strtolower($_SERVER['REQUEST_METHOD']) == 'get')
{
    if(isset($_GET['event_msg']) && strlen($_GET['event_msg'])>0)
    {
        $event_msg = html_entity_decode(urldecode($_GET['event_msg']));
        $arr_result = get_msg_logged_events($sess_ip, $sess_port, $sess_token, $event_msg);
        if(!empty($arr_result))
        {
            if(array_key_exists("reporting",$arr_result))
            {
                $empire_show_msg_results = $arr_result;
            }
            elseif(array_key_exists("error",$arr_result))
            {
                $empire_show_msg_results = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> ".ucfirst(htmlentities($arr_result['error']))."</div>";
            }
            else
            {
                $empire_show_msg_results = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
            }
        }
        else
        {
            $empire_show_msg_results = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Empire: Logged Events - Msg</title>
	<?php @require_once("includes/head-section.php"); ?>
</head>
<body>
    <div class="container">
        <?php @require_once("includes/navbar.php"); ?>
        <br>
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading"><span class='glyphicon glyphicon-search'></span> Show Logged Events with a Specific Msg</div>
                <div class="panel-body">
                    <form role="form" method="get" action="show-logged-events-msg.php" class="form-inline">
                        Shows events with a specific msg.<br><br>
                        <div class="form-group">
                            <input type="text" class="form-control" id="event_msg" placeholder="Enter Msg" name="event_msg">
                        </div>
                        <button type="submit" class="btn btn-success">Show Events</button>
                    </form>
                    <br>
                    <pre style='display: block; padding: 9.5px; margin: 0 0 10px; font-size: 13px; line-height: 1.42857143; color: #333; word-break: break-all; word-wrap: break-word; background-color: #f5f5f5; border: 1px solid #ccc; border-radius: 4px;'><code><?php if(is_array($empire_show_msg_results)){ var_dump($empire_show_msg_results); } else { echo $empire_show_msg_results; } ?></code></pre>
                </div>
            </div>
        </div><br>
    </div>
    <?php @require_once("includes/footer.php"); ?>
</body>
</html>
