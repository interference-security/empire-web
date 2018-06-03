<?php
// include files
require_once("includes/check-authorize.php");
require_once("includes/functions.php");

$empire_delete_agent_results = "";
$empire_show_agent_results = "";
if(strtolower($_SERVER['REQUEST_METHOD']) == 'post')
{
    if(isset($_POST['agent_name']) && strlen($_POST['agent_name'])>0)
    {
        //Get agent results
        $agent_name = html_entity_decode(urldecode($_POST['agent_name']));
        $arr_result = show_agent_results($sess_ip, $sess_port, $sess_token, $agent_name);
        if(!empty($arr_result))
        {
            if(array_key_exists("results",$arr_result))
            {
                for ($i=0; $i<sizeof($arr_result["results"]); $i++)
                {
                    if(array_key_exists("AgentName", $arr_result["results"][$i]) && array_key_exists("AgentResults", $arr_result["results"][$i]))
                    {
                        $val_agent_name = htmlentities($arr_result["results"][$i]["AgentName"]);
                        if (sizeof($arr_result["results"][$i]["AgentResults"])>0)
                        {
                            //for($j=0; $j<sizeof($arr_result["results"][$i]["AgentResults"]); $j++)
                            for($j=(sizeof($arr_result["results"][$i]["AgentResults"])-1); $j>=0; $j--)
                            {
                                $agent_result_cmd = $arr_result["results"][$i]["AgentResults"][$j]["command"];
                                $agent_result_taskid = $arr_result["results"][$i]["AgentResults"][$j]["taskID"];
                                $agent_result_cmd_result = $arr_result["results"][$i]["AgentResults"][$j]["results"];
                                $val_agent_results = str_replace("\\r\\n", "<br>", $agent_result_cmd_result);
                                $val_agent_results = (strlen($val_agent_results)>0 ? $val_agent_results : "No results");
                                $empire_show_agent_results .= "<pre style='display: block; padding: 9.5px; margin: 0 0 10px; font-size: 13px; line-height: 1.42857143; color: #333; word-break: break-all; word-wrap: break-word; background-color: #f5f5f5; border: 1px solid #ccc; border-radius: 4px;'><code><b><font color=blue>[$agent_result_taskid]</font> <font color=red>$val_agent_name</font> &gt; $agent_result_cmd</b><br>$val_agent_results</code></pre>";
                            }
                        }
                        else
                        {
                            $empire_show_agent_results .= "Empty Result";
                        }
                    }
                    else
                    {
                        $empire_show_agent_results = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
                    }
                }
            }
            elseif(array_key_exists("error",$arr_result))
            {
                $empire_show_agent_results = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> ".ucfirst(htmlentities($arr_result['error']))."</div>";
            }
            else
            {
                $empire_show_agent_results = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
            }
        }
        else
        {
            $empire_show_agent_results = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
        }
        echo $empire_show_agent_results;
    }
}
?>
