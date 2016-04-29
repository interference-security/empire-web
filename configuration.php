<?php
// include files
require_once("includes/check-authorize.php");
require_once("includes/functions.php");

$empire_config = "";
$arr_result = get_configuration($sess_ip, $sess_port, $sess_token);
if(!empty($arr_result))
{
    $empire_config = '<table class="table table-hover table-striped"><thead><tr><th>Configuration Name</th><th>Configuration Value</th></tr></thead><tbody>';
    foreach($arr_result["config"][0] as $key => $value)
    {
        $key = htmlentities($key);
        $value = htmlentities($value);
        $empire_config .= "<tr><td>$key</td><td>$value</td></tr>";
    }
    $empire_config .= '</tbody></table>';
}
else
{
    $empire_config = "<div class='alert alert-danger'>Unexpected response</div>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Empire: Configuration</title>
	<?php @require_once("includes/head-section.php"); ?>
</head>
<body>
    <div class="container">
        <?php @require_once("includes/navbar.php"); ?>
        <br>
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading">Configuration Information</div>
                <div class="panel-body"><?php echo $empire_config; ?>
                </div>
            </div>
        </div>
        <br>
    </div>
    <?php @require_once("includes/footer.php"); ?>
</body>
</html>
