<?php
// include files
require_once("includes/check-authorize.php");
require_once("includes/functions.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Empire: Dashboard</title>
	<?php @require_once("includes/head-section.php"); ?>
</head>

<body>
    <div class="container">
        <?php @require_once("includes/navbar.php"); ?>
        <h1>PowerShell Empire Web</h1>
        <br>
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading">Panel Header</div>
                <div class="panel-body">Panel Body</div>
            </div>
            <br>
            <div class="panel panel-primary">
                <div class="panel-heading">Panel Header</div>
                <div class="panel-body">Panel Body</div>
            </div>
        </div><br>
    </div>
    <?php @require_once("includes/footer.php"); ?>
</body>
</html>
