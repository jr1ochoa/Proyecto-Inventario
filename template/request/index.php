<?php

include("../config/net.php"); 

$process = isset($_REQUEST['process']) ? $_REQUEST['process'] : "";
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";

if($process == "evaluations")
    include("evaluations.php");

?>