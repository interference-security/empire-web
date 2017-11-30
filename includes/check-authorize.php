<?php
	session_start();
	$allow = 0;
    $sess_ip = ""; $sess_port = ""; $sess_user = ""; $sess_pass = ""; $sess_token = ""; $sess_csrf = "";
    if(isset($_SESSION['empire_ip']) && isset($_SESSION['empire_port']) && isset($_SESSION['empire_user']) && isset($_SESSION['empire_pass']) && isset($_SESSION['empire_session_token']) && isset($_SESSION['csrf_token']))
    {
        $sess_ip = $_SESSION['empire_ip'];
        $sess_port = $_SESSION['empire_port'];
        $sess_user = $_SESSION['empire_user'];
        $sess_pass = $_SESSION['empire_pass'];
        $sess_token = $_SESSION['empire_session_token'];
        $sess_csrf = $_SESSION['csrf_token'];
        if(strlen($sess_ip)>0 && strlen($sess_port)>0 && strlen($sess_user)>0 && strlen($sess_pass)>0 && strlen($sess_token)>0 && strlen($sess_csrf)==64)
        {
            $allow = 1;
        }
        else
		{
			die('<div class="alert alert-danger">Unauthorized Access 1</div>');
		}
    }
	else
	{
		die('<div class="alert alert-danger">Unauthorized Access 2</div>');
	}
	if($allow!=1)
	{
		die('<div class="alert alert-danger">Unauthorized Access 3</div>');
	}
?>