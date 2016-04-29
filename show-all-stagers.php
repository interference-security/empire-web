<?php
// include files
require_once("includes/check-authorize.php");
require_once("includes/functions.php");

$count = 0;
$empire_stagers = "";
$arr_result = get_all_stagers($sess_ip, $sess_port, $sess_token);
if(!empty($arr_result))
{
    for($i=0; $i<sizeof($arr_result["stagers"]); $i++)
    {
        $empire_stagers .= "<div class='panel-group'><div class='panel panel-success'>
                    <div class='panel-heading'><h4 class='panel-title'><a data-toggle='collapse' href='#collapse$i'>Stager Name: ".htmlentities($arr_result["stagers"][$i]["Name"])."</a></h4></div>
                    <div id='collapse$i' class='panel-collapse collapse'>
                        <div class='panel-body'>";
        $stager_name = htmlentities($arr_result["stagers"][$i]["Name"]);
        $stager_desc = htmlentities($arr_result["stagers"][$i]["Description"]);
        $stager_author = htmlentities(implode(", ", $arr_result["stagers"][$i]["Author"]));
        $stager_comments = htmlentities(implode(", ", $arr_result["stagers"][$i]["Comments"]));
        $empire_stagers .= "<table class='table table-hover table-striped table-bordered'><tr><th>Name</th><td>$stager_name</td></tr><tr><th>Description</th><td>$stager_desc</td></tr><tr><th>Author</th><td>$stager_author</td></tr><tr><th>Comments</th><td>$stager_comments</td></tr></table>";
        $empire_stagers .= "<table class='table table-hover table-striped table-bordered'><thead><tr><th colspan='4'>Stager Options:</th></tr><th>Name</th><th>Description</th><th>Required</th><th>Value</th></tr></thead><tbody>";
        foreach($arr_result["stagers"][$i]["options"] as $key => $value)
        {
            $key = htmlentities($key);
            $desc = htmlentities($value["Description"]);
            $reqd = (htmlentities($value["Required"]) ? "Yes" : "No");
            $val = htmlentities($value["Value"]);
            $empire_stagers .= "<tr>";
            $empire_stagers .= "<td>$key</td><td>$desc</td><td>$reqd</td><td>$val</td>";
            $empire_stagers .= "</tr>";
        }
        $empire_stagers .= '</tbody></table>';
        $empire_stagers .= "</div></div></div></div><br>";
        $count = $i+1;
    }
}
else
{
    $empire_stagers = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Empire: All Stagers</title>
	<?php @require_once("includes/head-section.php"); ?>
</head>
<body>
    <div class="container">
        <?php @require_once("includes/navbar.php"); ?>
        <br>
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading">All Stagers (<?php echo $count; ?>)</div>
                <div class="panel-body"><?php echo $empire_stagers; ?></div>
            </div>
        </div>
        <br>
    </div>
    <?php @require_once("includes/footer.php"); ?>
</body>
</html>
