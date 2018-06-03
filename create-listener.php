<?php
// include files
require_once("includes/check-authorize.php");
require_once("includes/functions.php");

$empire_listener_options = "";
if (isset($_GET['type']))
{
    if (strlen($_GET['type'])>0)
    {
        $listener_type = $_GET['type'];
        $arr_result = get_current_listener_options($sess_ip, $sess_port, $sess_token, $listener_type);
        if(array_key_exists("listeneroptions", $arr_result))
        {
            $empire_listener_options .= '<table class="table table-hover table-striped"><thead><tr><th>Name</th>';
            foreach($arr_result["listeneroptions"] as $key => $value)
            {
                foreach($value as $key1 => $value1)
                {
                    $key1 = ucfirst(htmlentities($key1));
                    $empire_listener_options .= "<th>$key1</th>";
                }
                break;
            }
            $empire_listener_options .= '</thead><tbody>';
            foreach($arr_result["listeneroptions"] as $key => $value)
            {
                $key = htmlentities($key);
                if($key  != "Name")
                {
                    $empire_listener_options .= "<tr><td>$key</td>";
                }
                foreach($value as $key1 => $value1)
                {
                    if($key  != "Name")
                    {
                        $value1 = htmlentities($value1);
                        if($key1 == "Value")
                        {
                            $empire_listener_options .= "<td><div class='form-group'><input type='text' class='form-control' id='$key' name='$key' value='$value1'></div></td>";
                        }
                        elseif($key1 == "Required")
                        {
                            if($value1 == True)
                            {
                                $empire_listener_options .= "<td>Yes</td>";
                            }
                            else
                            {
                                $empire_listener_options .= "<td>No</td>";
                            }
                        }
                        else
                        {
                            $empire_listener_options .= "<td>".$value1."</td>";
                        }
                    }
                }
                $empire_listener_options .= "</tr>";
            }
            $empire_listener_options .= '</tbody></table>';
        }
        else
        {
            $empire_listener_options = "<div class='alert alert-danger'>Unexpected response</div>";
        }
    }
}
$empire_create_listener = "";
if(isset($_POST) && !empty($_POST))
{
    $arr_data = array();
    $listener_type = $_POST['listener_type'];
    //Remove listener_type from POST so that it is not part of the arr_data else it would cause HTTP 400 error in the API
    if(isset($_POST["listener_type"]))
    {
        unset($_POST["listener_type"]);
    }
    //Remove "CertPath" item from $_POST if it is not set
    //If it exists and listener is of HTTP then it is converted into HTTPS without any error
    if(isset($_POST["CertPath"]) && strlen($_POST["CertPath"])<=0)
    {
        unset($_POST["CertPath"]);
    }
    foreach($_POST as $key => $value)
    {
        $arr_data[$key] = html_entity_decode(urldecode($value));
    }
    $arr_result = create_listener($sess_ip, $sess_port, $sess_token, $listener_type, $arr_data);
    if(array_key_exists("success", $arr_result))
    {
        if($arr_result["success"] == True)
        {
            if(array_key_exists("msg", $arr_result))
            {
                $empire_create_listener = "<div class='alert alert-success'><span class='glyphicon glyphicon-ok'></span> ".ucfirst(htmlentities($arr_result["msg"]))."</div>";
            }
            else
            {
                $empire_create_listener = "<div class='alert alert-success'><span class='glyphicon glyphicon-ok'></span> ".ucfirst(htmlentities($arr_result["success"]))."</div>";
            }
        }
        else
        {
            if(array_key_exists("msg", $arr_result))
            {
                $empire_create_listener = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> ".ucfirst(htmlentities($arr_result["msg"]))."</div>";
            }
            else
            {
                $empire_create_listener = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Listener creation failed.</div>";
            }
        }
    }
    elseif(array_key_exists("error", $arr_result))
    {
        $empire_create_listener = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> ".ucfirst(htmlentities($arr_result["error"]))."</div>";
    }
    else
    {
        $empire_create_listener = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Empire: Create Listener</title>
	<?php @require_once("includes/head-section.php"); ?>
</head>
<body>
    <div class="container">
        <?php @require_once("includes/navbar.php"); ?>
        <br>
        <div class="panel-group">
            <div class="panel panel-primary" style="overflow: visible">
                <div class="panel-heading">Create Listener</div>
                <div class="panel-body">
                    <form role="form" method="post" action="create-listener.php" class="form-inline">
                        <div class="form-group">
                            <div class="dropdown">
                                <?php $listener_type_html = "Listener Type"; if (isset($_GET['type'])) { if (strlen($_GET['type'])>0) { $listener_type_html = htmlentities($_GET['type']); } } ?>
                                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" id="listener_type" name="listener_type" value="<?php echo $listener_type_html; ?>"> <?php echo $listener_type_html; ?> <span class="caret"></span></button>
                                <input type="hidden" name="listener_type" value="<?php echo $listener_type_html; ?>">
                                <ul class="dropdown-menu">
                                    <li><a href="#" onclick='location.href="create-listener.php?type=http"'>http</a></li>
                                    <li><a href="#" onclick='location.href="create-listener.php?type=http_hop"'>http_hop</a></li>
                                    <li><a href="#" onclick='location.href="create-listener.php?type=http_mapi"'>http_mapi</a></li>
                                    <li><a href="#" onclick='location.href="create-listener.php?type=http_foreign"'>http_foreign</a></li>
                                    <li><a href="#" onclick='location.href="create-listener.php?type=http_com"'>http_com</a></li>
                                    <li><a href="#" onclick='location.href="create-listener.php?type=onedrive"'>onedrive</a></li>
                                    <li><a href="#" onclick='location.href="create-listener.php?type=dbx"'>dbx</a></li>
                                    <li><a href="#" onclick='location.href="create-listener.php?type=meterpreter"'>merterpreter</a></li>
                                    <li><a href="#" onclick='location.href="create-listener.php?type=redirector"'>redirector</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="listener-name" placeholder="Listener Name" name="Name" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Create</button>
                        </div>
                        <?php if (strlen($empire_create_listener)>0) { echo '<div class="form-group"><br>'.$empire_create_listener.'</div>'; } ?>
                        <br><br>
                        <b>Additional Options:</b>
                        <br><br>
                        <?php if (strlen($empire_listener_options)>0) { echo $empire_listener_options; } else { echo '<div class="alert alert-danger">You have not selected any "Listener Type" above. Select one to view options for it.</div>'; } ?>
                    </form>
                </div>
            </div>
        </div>
        <br>
    </div>
    <?php @require_once("includes/footer.php"); ?>
</body>
</html>
