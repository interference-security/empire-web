<?php

// include files
require_once("includes/check-authorize.php");
require_once("includes/functions.php");



$webcam_results = "";
if(strtolower($_SERVER['REQUEST_METHOD']) == 'post')
{
	if(isset($_POST['agent_name']) && strlen($_POST['agent_name'])>0)
	{
		$agent_name = html_entity_decode(urldecode($_POST['agent_name']));
		$arr_result = show_agent_results($sess_ip, $sess_port, $sess_token, $agent_name);

		$webcam_location = get_configuration($sess_ip, $sess_port, $sess_token)['config'][0]['install_path'] . 'downloads/' . $agent_name . '/WebcamRecorder/';
		if ($sess_ip == "127.0.0.1") {
			if(file_exists($webcam_location)) {
				$webcams = glob($webcam_location . "*.avi");
				$local_location = "video/" . $agent_name . "/";
				if (!file_exists($local_location)) {
					mkdir($local_location, 0774, true);
				}			
				foreach ($webcams as $key => $webcam) {
						$avi_location = $webcam;
						$mp4_location = str_replace('.avi', '.mp4', $avi_location);
						$mp4_location = str_replace($webcam_location, $local_location, $mp4_location);
						if (!file_exists($mp4_location)) {
							$webcam_results = shell_exec("ffmpeg -i '" . $avi_location . "' -threads 0 -c:v libx264 -preset slower -crf 19 -qmin 10 -qmax 51 -strict experimental -c:a aac -b:a 128k -y '" . $mp4_location . "'");
						}
				}
				$webcams = glob($local_location . "*.mp4");
				if (strlen(shell_exec('which ffmpeg')) > 0) {
					if(!empty($webcams))
					{					
						foreach ($webcams as $key => $webcam) {
							$html_webcam = "<div class='alert alert-success' >" . $webcam . "<br><video controls><source  type='video/mp4' src='data:video/mp4;base64,". base64_encode(file_get_contents($webcam)). "'></video></div>";	
							$webcam_results = $webcam_results . $html_webcam;

						}
					}
				} else {
					$webcam_results = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> You will need to install ffmpeg on your server.<br><pre>sudo apt-get install ffmpeg</pre></div>";
				}
			} else {
			    $webcam_results = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> No webcam clips.</div>";
			}
		} else {
			$webcam_results = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> The webcam viewer will only work if the Empire server is on the same server hosting Empire-web. Also apache must be able to read the Empire downloads folder for it to work.</div>";
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
	<title>Empire: Show Agent WebCam</title>
	<?php @require_once("includes/head-section.php"); ?>
</head>
<body>
	<div class="container">
		<?php @require_once("includes/navbar.php"); ?>
		<br>
		<div class="panel-group">
			<div class="panel panel-primary">
				<div class="panel-heading">Show Agent WebCam</div>
				<div class="panel-body">
					<form role="form" method="post" action="show-agent-webcam.php" class="form-inline">
						Retrieves webcam clips for the agent specifed by Agent Name. This may take a long time to load if you have lots of long videos.<br><br>
						<div class="form-group">
							<select class="form-control" id="agent-name" name="agent_name">
								<?php echo $empire_agents; ?>
							</select>
						</div>
						<button type="submit" class="btn btn-success">Show WebCams</button>
					</form>
					<br>
					<?php  echo $webcam_results; ?>
				</div>
			</div>
		</div>
	</div>
	<?php @require_once("includes/footer.php"); ?>
</body>
</html>
