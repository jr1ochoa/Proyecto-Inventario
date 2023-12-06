<?php

include("../config/net.php");

$process = (isset($_POST['process'])) ? $_POST['process'] : "";
$action = (isset($_POST['action'])) ? $_POST['action'] : "";

if($process == "LogIn")
    include("login.php");

else if($process == "Transcript")
    include("transcript.php");

else if($process == "Transcript File")
    include("transcript.file.php");

else if($process == "Needs")
    include("need.php");    
    
else if($process == "Users")
    include("users.php");

else if($process == "Area")
    include("workarea.php"); 

else if($process == "Profile")
    include("profile.php"); 

else if($process == "Permissions")
    include("permissions.php"); 

else if($process == "PersonnelActions")
    include("personnelactions.php"); 

else if($process == "Email")
    include("email.php");
    

?>