<?php
// include files
require_once("includes/check-authorize.php");
require_once("includes/functions.php");

$empire_credentials = "";
$arr_result = get_credentials($sess_ip, $sess_port, $sess_token);
if(array_key_exists("error", $arr_result))
{
    $empire_credentials = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> ".ucfirst(htmlentities($arr_result["error"]))."</div>";
}
else
{
    if(!empty($arr_result))
    {
        $empire_credentials .= '<table class="table table-hover table-striped"><thead><tr>';
        foreach($arr_result["creds"][0] as $key => $value)
        {
            $empire_credentials .= '<th>'.htmlentities($key).'</th>';
        }
        for($i=0; $i<sizeof($arr_result["creds"]); $i++)
        {
            $empire_credentials .= "<tr>";
            foreach($arr_result["creds"][$i] as $key => $value)
            {
                $value = htmlentities($value);
                $empire_credentials .= "<td>$value</td>";
            }
            $empire_credentials .= "</tr>";
        }
        $empire_credentials .= '</tbody></table>';
    }
    else
    {
        $empire_credentials = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Empire: Credentials</title>
	<?php @require_once("includes/head-section.php"); ?>
</head>
<body>
    <div class="container">
        <?php @require_once("includes/navbar.php"); ?>
        <br>
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading">Credentials</div>
                <div class="panel-body"><?php echo $empire_credentials; ?></div>
            </div>
        </div><br>
    </div>
    <?php @require_once("includes/footer.php"); ?>
</body>
</html>
