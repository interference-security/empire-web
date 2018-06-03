<?php
// include files
require_once("includes/check-authorize.php");
require_once("includes/functions.php");

$empire_shell_agent = "";
if(strtolower($_SERVER['REQUEST_METHOD']) == 'post')
{
    if(isset($_POST['agent_name']) && strlen($_POST['agent_name'])>0 && isset($_POST['agent_cmd']) && strlen($_POST['agent_cmd'])>0)
    {
        $agent_name = html_entity_decode(urldecode($_POST['agent_name']));
        $agent_cmd = html_entity_decode(urldecode($_POST['agent_cmd']));
        //Sorry but had to do it to get better results to show to the user
        //Here I delete the current result buffer to show current command's result to user
        $delete_arr_result = delete_agent_results($sess_ip, $sess_port, $sess_token, $agent_name);
        //Continue executing the shell command execution module
        $arr_result = execute_shell_cmd_agent($sess_ip, $sess_port, $sess_token, $agent_name, $agent_cmd);
        if(!empty($arr_result))
        {
            if(array_key_exists("success",$arr_result))
            {
                $resp = $arr_result["success"];
                if($resp)
                    $empire_shell_agent = "<div class='alert alert-success'><span class='glyphicon glyphicon-ok'></span> Shell command executed successfully.</div>";
                else
                    $empire_shell_agent = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Shell command could not be executed.</div>";
            }
            elseif(array_key_exists("error",$arr_result))
            {
                $empire_shell_agent = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> ".ucfirst(htmlentities($arr_result['error']))."</div>";
            }
            else
            {
                $empire_shell_agent = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
            }
        }
        else
        {
            $empire_shell_agent = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
        }
    }
    echo $empire_shell_agent;
}
else
{
    echo "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Request should be submitted over POST method only.</div>";
}
?>
