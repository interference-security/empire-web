<?php
// include files
require_once("includes/check-authorize.php");
require_once("includes/functions.php");

$empire_listener = "";
if(isset($_GET['search_listener']))
{
    $search_listener = urldecode($_GET['search_listener']);
    $arr_result = search_listener_name($sess_ip, $sess_port, $sess_token, $search_listener);
    if(array_key_exists("error", $arr_result))
    {
        $empire_listener = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> ".ucfirst(htmlentities($arr_result["error"]))."</div>";
    }
    else
    {
        if(!empty($arr_result))
        {
            $empire_listener .= '<div class="panel-group"><div class="panel panel-success"><div class="panel-heading">Listener Name: '.htmlentities($arr_result["listeners"][0]["name"]).'</div><div class="panel-body">';
            $empire_listener .= '<table class="table table-hover table-striped table-bordered"><thead><tr><th>Listener Option</th><th>Listener Value</th></tr></thead><tbody>';
            foreach($arr_result["listeners"][0] as $key => $value)
            {
                $key = htmlentities($key);
                $value = htmlentities($value);
                $empire_listener .= "<tr><td>$key</td><td>$value</td></tr>";
            }
            $empire_listener .= '</tbody></table>';
            $empire_listener .= '</div></div></div>';
        }
        else
        {
            $empire_listener = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Empire: Search Listener</title>
	<?php @require_once("includes/head-section.php"); ?>
</head>
<body>
    <div class="container">
        <?php @require_once("includes/navbar.php"); ?>
        <br>
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading"><span class="glyphicon glyphicon-search"></span> Search Listener by name</div>
                <div class="panel-body">
                    <form role="form" method="get" action="search-listener-name.php" class="form-inline">
                        <div class="form-group">
                            <input type="text" class="form-control" id="search-listener" placeholder="Listener Name" name="search_listener">
                        </div>
                        <button type="submit" class="btn btn-success">Search</button>
                    </form>
                    <br>
                    <?php echo $empire_listener; ?>
                </div>
            </div>
        </div>
        <br>
    </div>
    <?php @require_once("includes/footer.php"); ?>
</body>
</html>
