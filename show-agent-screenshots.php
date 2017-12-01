<?php

// include files
require_once("includes/check-authorize.php");
require_once("includes/functions.php");


$screenshots_results = "";
if(strtolower($_SERVER['REQUEST_METHOD']) == 'post')
{
	if(isset($_POST['agent_name']) && strlen($_POST['agent_name'])>0)
	{
		$agent_name = html_entity_decode(urldecode($_POST['agent_name']));
		$arr_result = show_agent_results($sess_ip, $sess_port, $sess_token, $agent_name);

		$screenshot_location = get_configuration($sess_ip, $sess_port, $sess_token)['config'][0]['install_path'] . 'downloads/' . $agent_name . '/screenshot/';
		if (file_exists($screenshot_location)) {
			$screenshots = scandir($screenshot_location);
			unset($screenshots[0]);
			unset($screenshots[1]);
			if(!empty($screenshots))
			{				
				foreach ($screenshots as $key => $screenshot) {
					$html_screenshot = "<div class='alert alert-success' >" . $screenshot . "<img style='width:100%' src='data:image/png;base64," . base64_encode(file_get_contents($screenshot_location . $screenshot)). "'></div>";	
					$screenshots_results = $screenshots_results . $html_screenshot;
				}
				
			} else {
		    	$screenshots_results = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> No screenshots.</div>";
			}
		} else {
		    $screenshots_results = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> No screenshots.</div>";
		}
	}
}

$empire_agents = "";
$arr_result = get_all_agents($sess_ip, $sess_port, $sess_token);
if(!empty($arr_result))
{
	$empire_agents .= "<option value=''>--Choose Agent Name--</option>";
	for($i=0; $i<sizeof($arr_result["agents"]); $i++)
	{
		$empire_agents .= "<option value='".htmlentities($arr_result["agents"][$i]["name"])."'>".htmlentities($arr_result["agents"][$i]["name"])."</option>";
	}
}
else
{
	$empire_agents = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> 5Unexpected response.</div>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Empire: Show Agent Screenshots</title>
	<?php @require_once("includes/head-section.php"); ?>
</head>
<body>
	<div class="container">
		<?php @require_once("includes/navbar.php"); ?>
		<br>
		<div class="panel-group">
			<div class="panel panel-primary">
				<div class="panel-heading">Show Agent Screenshots</div>
				<div class="panel-body">
					<form role="form" method="post" action="show-agent-screenshots.php" class="form-inline">
						Retrieves results for the agent specifed by Agent Name.<br><br>
						<div class="form-group">
							<select class="form-control" id="agent-name" name="agent_name">
								<?php echo $empire_agents; ?>
							</select>
						</div>
						<button type="submit" class="btn btn-success">Show Screenshots</button>
					</form>
					<br>
					<?php  echo $screenshots_results; ?>
				</div>
			</div>
		</div>
	</div>
	<?php @require_once("includes/footer.php"); ?>
</body>
</html>
