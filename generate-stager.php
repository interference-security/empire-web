<?php
// include files
require_once("includes/check-authorize.php");
require_once("includes/functions.php");

$empire_listeners = "";
$arr_result_listners = get_all_listeners($sess_ip, $sess_port, $sess_token);
if(!empty($arr_result_listners))
{
    for($i=0; $i<sizeof($arr_result_listners["listeners"]); $i++)
    {
        $temp_listener_name = htmlentities($arr_result_listners["listeners"][$i]["name"]);
        $empire_listeners .= "<option value='$temp_listener_name'>$temp_listener_name</option>";
    }
}
else
{
    $empire_listeners = "[Error]: Could not get listeners";
}

$empire_stagers = "";
$arr_result = get_all_stagers($sess_ip, $sess_port, $sess_token);
if(!empty($arr_result))
{
    for($i=0; $i<sizeof($arr_result["stagers"]); $i++)
    {
        $empire_stagers .= "<div class='panel-group panel_heading_class'><div class='panel panel-success'>
                    <div class='panel-heading'><h4 class='panel-title'><a data-toggle='collapse' class='module_name_title_class' href='#collapse$i'>".htmlentities($arr_result["stagers"][$i]["Name"])."</a></h4></div>
                    <div id='collapse$i' class='panel-collapse collapse'>
                        <div class='panel-body'>";
        $stager_name = htmlentities($arr_result["stagers"][$i]["Name"]);
        $stager_desc = htmlentities($arr_result["stagers"][$i]["Description"]);
        $stager_author = htmlentities(implode(",", $arr_result["stagers"][$i]["Author"]));
        $stager_comments = htmlentities(implode(",", $arr_result["stagers"][$i]["Comments"]));
        $empire_stagers .= '<form role="form" method="post" action="generate-stager.php" class="form-inline">
            <div class="form-group">
                <input type="text" class="form-control" id="stager-name" placeholder="Stager Name" name="StagerName" value="'.htmlentities($arr_result["stagers"][$i]["Name"]).'" readonly required>
            </div>
            <div class="form-group">
                <button type="submit" id="gen-stager-submit-btn" class="btn btn-success">Generate</button>
            </div>
        <br><br>';
        $empire_stagers .= "<table class='table table-hover table-striped table-bordered'><tr><th>Name</th><td>$stager_name</td></tr><th>Description</th><td>$stager_desc</td></tr><th>Author</th><td>$stager_author</td></tr><th>Comments</th><td>$stager_comments</td></tr></table>";
        $empire_stagers .= "<table class='table table-hover table-striped table-bordered'><thead><tr><th colspan='4'>Stager Options:</th></tr><th>Name</th><th>Description</th><th>Required</th><th>Value</th></tr></thead><tbody>";
        foreach($arr_result["stagers"][$i]["options"] as $key => $value)
        {
            $key = htmlentities($key);
            $desc = htmlentities($value["Description"]);
            $reqd = (htmlentities($value["Required"]) ? "Yes" : "No");
            $val = htmlentities($value["Value"]);
            if($key == "Listener")
                $val = '<select class="form-control" id="listener-name" name="Listener" required>'.$empire_listeners.'</select>';
            
            else
                $val = "<input type='text' class='form-control' name='$key' value='$val'>";
            $empire_stagers .= "<tr>";
            $empire_stagers .= "<td>$key</td><td>$desc</td><td>$reqd</td><td>$val</td>";
            $empire_stagers .= "</tr>";
        }
        $empire_stagers .= '</tbody></table>';
        $empire_stagers .= "</div></div></div><br></div></form>";
    }
}
else
{
    $empire_stagers = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
}

$empire_gen_stager = "";
if(strtolower($_SERVER['REQUEST_METHOD']) == "post")
{
    if(isset($_POST) && !empty($_POST))
    {
        $arr_data = array();
        foreach($_POST as $key => $value)
        {
            $arr_data[$key] = html_entity_decode(urldecode($value));
        }
        $arr_result = generate_stager($sess_ip, $sess_port, $sess_token, $arr_data);
        if(array_key_exists($arr_data["StagerName"], $arr_result))
        {
            $temp_stager_name = $arr_data["StagerName"];
            $empire_gen_stager .= "<div class='panel panel-success'><div class='panel-heading'><h4 class='panel-title'><a data-toggle='collapse' href='#collapse1'><span class='glyphicon glyphicon-star'></span> Stager Output</a> <button type='button' id='decode-b64-stager-output' class='btn btn-warning btn-xs' onclick='decodeStagerBase64()'><span class='glyphicon glyphicon-retweet'></span> Decode</button>&nbsp;&nbsp;<a href='#' id='downloadLink' class='btn btn-info btn-xs' style='color:white;' onclick='downloadStagerOutput()'><span class='glyphicon glyphicon-download-alt'></span> Download</a></h4></div><div id='collapse1' class='panel-collapse collapse'><div class='panel-body'><pre style='display: block; padding: 9.5px; margin: 0 0 10px; font-size: 13px; line-height: 1.42857143; color: #333; word-break: break-all; word-wrap: break-word; background-color: #f5f5f5; border: 1px solid #ccc; border-radius: 4px;'><code id='stager-output-field'>".$arr_result[$temp_stager_name]['Output']."</code></pre></div></div></div><br>";
            $empire_gen_stager .= "<table class='table table-hover table-striped table-bordered'><thead><tr><th>Name</th><th>Description</th><th>Required</th><th>Value</th></tr></thead><tbody>";
            foreach($arr_result[$temp_stager_name] as $key => $value)
            {
                if($key != "Output")
                {
                    $key = htmlentities($key);
                    $empire_gen_stager .= "<tr><td>$key</td>";
                    foreach($value as $key1 => $value1)
                    {
                        $value1 = htmlentities($value1);
                        if($key1 == "Required")
                        {
                            if($value1 == True)
                                $empire_gen_stager .= "<td>Yes</td>";
                            else
                                $empire_gen_stager .= "<td>No</td>";
                        }
                        else
                        {
                            $empire_gen_stager .= "<td>$value1</td>";
                        }
                    }
                }
                $empire_gen_stager .= "</tr>";
            }
            $empire_gen_stager .= "</tbody></table>";
        }
        else
        {
            $empire_gen_stager = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
        }
    }
    else
    {
        $empire_gen_stager = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
    }
}
else
{
    
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Empire: All Stagers</title>
	<?php @require_once("includes/head-section.php"); ?>
    <script type="text/javascript" src="js/base64.js"></script>
    <script>
    function decodeStagerBase64()
    {
        var stager_decoded = Base64.decode(document.getElementById("stager-output-field").innerHTML);
        document.getElementById("stager-output-field").innerHTML = stager_decoded;
    }
    function downloadStagerOutput()
    {
        var fileName = 'stager-output.ext'; //To be replaced with user supplied name in future
        var stagerOutput = document.getElementById("stager-output-field").innerHTML;
        var link = document.createElement('a');
        mimeType = 'application/octet-stream';
        link.setAttribute('download', fileName);
        link.setAttribute('href', 'data:' + mimeType + ';charset=utf-8,' + encodeURIComponent(stagerOutput));
        link.click(); 
    }
    </script>
    <script>
	    function search_panels()
	    {
	        var input = document.getElementById("search_field");
            var search_term = input.value.toLowerCase();
            //alert(search_term);
            for (i=0; i<document.getElementsByClassName('panel_heading_class').length; i++)
            {
	            var module_name_title_value = (document.getElementsByClassName('module_name_title_class')[i].innerHTML).toLowerCase();
	            if ((module_name_title_value).indexOf(search_term) === -1)
	            {
		            document.getElementsByClassName('panel_heading_class')[i].style.display = 'None';
	            }
	            else
	            {
		            document.getElementsByClassName('panel_heading_class')[i].style.display = '';
	            }
            }
	    }
    </script>
</head>
<body>
    <div class="container">
        <?php @require_once("includes/navbar.php"); ?>
        <br>
        <div class="panel-group">
            <div class="panel panel-primary">
                <!--<div class="panel-heading">Generate Stager</div>-->
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left" style="padding-top: 7.5px;">Generate Stager</h4>
                    <input id="search_field" type="text" class="form-control" placeholder="Search" style="float:right; width: 200px;" onkeyup="search_panels()">
                </div>
                <div class="panel-body"><?php if(strtolower($_SERVER['REQUEST_METHOD']) == "post") { echo $empire_gen_stager; } else { echo $empire_stagers; } ?></div>
            </div>
        </div>
        <br>
    </div>
    <?php @require_once("includes/footer.php"); ?>
</body>
</html>
