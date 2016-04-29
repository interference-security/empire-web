<?php
error_reporting(0);
// include files
require_once("includes/check-authorize.php");
require_once("includes/php_file_tree.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Empire: Browser</title>
	<?php @require_once("includes/head-section.php"); ?>
    <link href="styles/default/default.css" rel="stylesheet" type="text/css" media="screen" />
    <script src="styles/js/php_file_tree.js" type="text/javascript"></script>
</head>
<body>
    <div class="container">
        <?php @require_once("includes/navbar.php"); ?>
        <br>
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading">File System Browser</div>
                <div class="panel-body">
                    <?php echo php_file_tree(__DIR__, ""); ?>
                </div>
            </div>
        </div><br>
    </div>
    <?php @require_once("includes/footer.php"); ?>
</body>
</html>
