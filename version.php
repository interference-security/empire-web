<?php
// include files
require_once("includes/check-authorize.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Empire: Version</title>
	<?php @require_once("includes/head-section.php"); ?>
</head>
<body>
    <div class="container">
        <?php @require_once("includes/navbar.php"); ?>
        <br>
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading">PowerShell Empire Version</div>
                <div class="panel-body"><?php echo $empire_version; ?></div>
            </div>
        </div>
    </div>
    <?php @require_once("includes/footer.php"); ?>
</body>
</html>
