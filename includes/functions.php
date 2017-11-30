<?php
//If you want to proxy data then add this to the function which you want to intercept (update $proxy)
//$proxy = "http://127.0.0.1:9092/";
//curl_setopt($ch, CURLOPT_PROXY, $proxy);

//Authenticate to Empire using username-password
//Returns session token value (success) or NULL (fail)
function authenticate_empire($empire_ip, $empire_port, $empire_username, $empire_password)
{
    $data = array("username" => $empire_username,"password" => $empire_password);
    $data_string = json_encode($data);
    $ch = curl_init("https://$empire_ip:$empire_port/api/admin/login");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string),'Except:'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    $arr_result = json_decode($result, true);
    return $arr_result;
}

function get_version($empire_ip, $empire_port, $empire_session_token)
{
    $ch = curl_init("https://$empire_ip:$empire_port/api/version?token=$empire_session_token");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Except:'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    $arr_result = json_decode($result,true);
    return $arr_result;
}

function get_configuration($empire_ip, $empire_port, $empire_session_token)
{
    $ch = curl_init("https://$empire_ip:$empire_port/api/config?token=$empire_session_token");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Except:'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    $arr_result = json_decode($result,true);
    return $arr_result;
}

function get_permanent_session_token($empire_ip, $empire_port, $empire_session_token)
{
    $ch = curl_init("https://$empire_ip:$empire_port/api/admin/permanenttoken?token=$empire_session_token");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Except:'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    $arr_result = json_decode($result,true);
    return $arr_result;
}

function restart_api_server($empire_ip, $empire_port, $empire_session_token)
{
    $ch = curl_init("https://$empire_ip:$empire_port/api/admin/restart?token=$empire_session_token");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Except:'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    $arr_result = json_decode($result,true);
    return $arr_result;
}

function shutdown_api_server($empire_ip, $empire_port, $empire_session_token)
{
    $ch = curl_init("https://$empire_ip:$empire_port/api/admin/shutdown?token=$empire_session_token");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Except:'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    $arr_result = json_decode($result,true);
    return $arr_result;
}

function get_all_listeners($empire_ip, $empire_port, $empire_session_token)
{
    $ch = curl_init("https://$empire_ip:$empire_port/api/listeners?token=$empire_session_token");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Except:'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    $arr_result = json_decode($result,true);
    return $arr_result;
}

function search_listener_name($empire_ip, $empire_port, $empire_session_token, $search_term)
{
    $ch = curl_init("https://$empire_ip:$empire_port/api/listeners/$search_term?token=$empire_session_token");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Except:'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    $arr_result = json_decode($result,true);
    return $arr_result;
}

function get_current_listener_options($empire_ip, $empire_port, $empire_session_token)
{
    $ch = curl_init("https://$empire_ip:$empire_port/api/listeners/options?token=$empire_session_token");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Except:'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    $arr_result = json_decode($result,true);
    return $arr_result;
}

function create_listener($empire_ip, $empire_port, $empire_session_token, $arr_data)
{
    $data = $arr_data;
    $data_string = json_encode($data);
    $ch = curl_init("https://$empire_ip:$empire_port/api/listeners?token=$empire_session_token");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string),'Except:'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    $arr_result = json_decode($result, true);
    return $arr_result;
}

function kill_listener($empire_ip, $empire_port, $empire_session_token, $kill_listener)
{
    $ch = curl_init("https://$empire_ip:$empire_port/api/listeners/$kill_listener?token=$empire_session_token");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Except:'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    $arr_result = json_decode($result,true);
    return $arr_result;
}

function get_all_stagers($empire_ip, $empire_port, $empire_session_token)
{
    $ch = curl_init("https://$empire_ip:$empire_port/api/stagers?token=$empire_session_token");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Except:'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    $arr_result = json_decode($result,true);
    return $arr_result;
}

function search_stager_name($empire_ip, $empire_port, $empire_session_token, $search_term)
{
    $ch = curl_init("https://$empire_ip:$empire_port/api/stagers/$search_term?token=$empire_session_token");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Except:'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    $arr_result = json_decode($result,true);
    return $arr_result;
}

function generate_stager($empire_ip, $empire_port, $empire_session_token, $arr_data)
{
    $data = $arr_data;
    $data_string = json_encode($data);
    $ch = curl_init("https://$empire_ip:$empire_port/api/stagers?token=$empire_session_token");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string),'Except:'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    $arr_result = json_decode($result, true);
    return $arr_result;
}

function get_all_agents($empire_ip, $empire_port, $empire_session_token)
{
    $ch = curl_init("https://$empire_ip:$empire_port/api/agents?token=$empire_session_token");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Except:'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    $arr_result = json_decode($result,true);
    return $arr_result;
}

function search_agent_name($empire_ip, $empire_port, $empire_session_token, $search_term)
{
    $ch = curl_init("https://$empire_ip:$empire_port/api/agents/$search_term?token=$empire_session_token");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Except:'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    $arr_result = json_decode($result,true);
    return $arr_result;
}

function get_stale_agents($empire_ip, $empire_port, $empire_session_token)
{
    $ch = curl_init("https://$empire_ip:$empire_port/api/agents/stale?token=$empire_session_token");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Except:'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    $arr_result = json_decode($result,true);
    return $arr_result;
}

function remove_stale_agents($empire_ip, $empire_port, $empire_session_token)
{
    $ch = curl_init("https://$empire_ip:$empire_port/api/agents/stale?token=$empire_session_token");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Except:'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    $arr_result = json_decode($result,true);
    return $arr_result;
}

function remove_agent($empire_ip, $empire_port, $empire_session_token, $remove_agent)
{
    $ch = curl_init("https://$empire_ip:$empire_port/api/agents/$remove_agent?token=$empire_session_token");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Except:'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    $arr_result = json_decode($result,true);
    return $arr_result;
}

function execute_shell_cmd_agent($empire_ip, $empire_port, $empire_session_token, $agent_name, $agent_cmd)
{
    $data = array("command" => $agent_cmd);
    $data_string = json_encode($data);
    $ch = curl_init("https://$empire_ip:$empire_port/api/agents/$agent_name/shell?token=$empire_session_token");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string),'Except:'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    $arr_result = json_decode($result, true);
    return $arr_result;
}

function show_agent_results($empire_ip, $empire_port, $empire_session_token, $agent_name)
{
    $ch = curl_init("https://$empire_ip:$empire_port/api/agents/$agent_name/results?token=$empire_session_token");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Except:'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    $arr_result = json_decode($result,true);
    return $arr_result;
}

function show_agent_screenshots($empire_ip, $empire_port, $empire_session_token, $agent_name) {
    
}

function delete_agent_results($empire_ip, $empire_port, $empire_session_token, $agent_name)
{
    $ch = curl_init("https://$empire_ip:$empire_port/api/agents/$agent_name/results?token=$empire_session_token");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Except:'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    $arr_result = json_decode($result,true);
    return $arr_result;
}

function clear_agent_task_queue($empire_ip, $empire_port, $empire_session_token, $agent_name)
{
    $ch = curl_init("https://$empire_ip:$empire_port/api/agents/$agent_name/clear?token=$empire_session_token");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Except:'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    $arr_result = json_decode($result,true);
    return $arr_result;
}

function rename_agent($empire_ip, $empire_port, $empire_session_token, $current_agent_name, $agent_newname)
{
    $data = array("newname" => $agent_newname);
    $data_string = json_encode($data);
    $ch = curl_init("https://$empire_ip:$empire_port/api/agents/$current_agent_name/rename?token=$empire_session_token");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string),'Except:'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    $arr_result = json_decode($result, true);
    return $arr_result;
}

function kill_agent($empire_ip, $empire_port, $empire_session_token, $kill_agent)
{
    $ch = curl_init("https://$empire_ip:$empire_port/api/agents/$kill_agent/kill?token=$empire_session_token");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Except:'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    $arr_result = json_decode($result,true);
    return $arr_result;
}

function get_all_modules($empire_ip, $empire_port, $empire_session_token)
{
    $ch = curl_init("https://$empire_ip:$empire_port/api/modules?token=$empire_session_token");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Except:'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    $arr_result = json_decode($result,true);
    return $arr_result;
}

function search_module_name($empire_ip, $empire_port, $empire_session_token, $search_term)
{
    $ch = curl_init("https://$empire_ip:$empire_port/api/modules/$search_term?token=$empire_session_token");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Except:'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    $arr_result = json_decode($result,true);
    return $arr_result;
}

function search_module($empire_ip, $empire_port, $empire_session_token, $search_term)
{
    $data = array("term" => $search_term);
    $data_string = json_encode($data);
    $ch = curl_init("https://$empire_ip:$empire_port/api/modules/search?token=$empire_session_token");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string),'Except:'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    $arr_result = json_decode($result, true);
    return $arr_result;
}

function execute_module($empire_ip, $empire_port, $empire_session_token, $arr_data, $module_name)
{
    $data = $arr_data;
    $data_string = json_encode($data);
    $ch = curl_init("https://$empire_ip:$empire_port/api/modules/$module_name?token=$empire_session_token");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string),'Except:'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    $arr_result = json_decode($result, true);
    return $arr_result;
}

function get_credentials($empire_ip, $empire_port, $empire_session_token)
{
    $ch = curl_init("https://$empire_ip:$empire_port/api/creds?token=$empire_session_token");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Except:'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    $arr_result = json_decode($result,true);
    return $arr_result;
}

function get_all_logged_events($empire_ip, $empire_port, $empire_session_token)
{
    $ch = curl_init("https://$empire_ip:$empire_port/api/reporting?token=$empire_session_token");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Except:'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    $arr_result = json_decode($result,true);
    return $arr_result;
}

function get_agent_logged_events($empire_ip, $empire_port, $empire_session_token, $agent_name)
{
    $ch = curl_init("https://$empire_ip:$empire_port/api/reporting/agent/$agent_name?token=$empire_session_token");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Except:'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    $arr_result = json_decode($result,true);
    return $arr_result;
}

function get_type_logged_events($empire_ip, $empire_port, $empire_session_token, $event_type)
{
    $ch = curl_init("https://$empire_ip:$empire_port/api/reporting/type/$event_type?token=$empire_session_token");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Except:'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    $arr_result = json_decode($result,true);
    return $arr_result;
}

function get_msg_logged_events($empire_ip, $empire_port, $empire_session_token, $event_msg)
{
    $ch = curl_init("https://$empire_ip:$empire_port/api/reporting/msg/$event_msg?token=$empire_session_token");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Except:'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    $arr_result = json_decode($result,true);
    return $arr_result;
}

?>