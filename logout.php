<?php
session_start();
$_SESSION = array();

if (ini_get("session.use_cookies"))
{
	$params = session_get_cookie_params();
	setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
}

session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Empire Web Logged Out</title>
	<?php require_once("includes/head-section.php"); ?>
</head>

<body>
    <div class="container">
        <?php require_once("includes/navbar.php"); ?>
        <div class="row clearfix">
            <?php echo '<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> You have been logged out.</div>'; ?>
        </div>
    </div>
    <?php @require_once("includes/footer.php"); ?>
</body>
</html>
