<?php

$authent = (isset($_SESSION['iu'])) ? True : False;
$view = (isset($_GET['view'])) ? $_GET['view'] : '';

include("template/breadcrumbles.php");

// Public
if($view == '')
    include("view/public.php"); 

// Login de ACceso    
else if($view == 'login')
    include("view/login/login.php");    

// Página de Inicio    
else if($view == "main" && $authent)
    include("view/main.php");

// Página de Expedientes     
else if($view == "transcript" && $authent)
    include("view/transcript/transcript.php");    

// Página de cuestionario de necesidades     
else if($view == "needs" && $authent)
    include("view/needs/needs.php");        

// Gestión de Usuarios 
else if($view == "user" && $authent)
    include("view/users/user.php"); 
    
// Gestión de Áreas 
else if($view == "area" && $authent)
    include("view/work_area/work_area.php");

// Gestión de Empleados 
else if($view == "employee" && $authent)
    include("view/employees/employees.php");

// Página de Perfil
else if($view == "profile" && $authent)
    include("view/profile/profile.php");

// Verificación de Acciones de Usuarios
else if($view == "log" && $authent)
    include("view/log/log.php"); 
    
// Verificación de Acciones de Usuarios
else if($view == "personnelactions" && $authent)
    include("view/personnelactions/personnelactions.php");       
    
// Gestión de Inventario
else if($view == "inventory" && $authent)  
    include("view/inventory/inventory.php"); 

    

else if($view == "logoff")
{
    session_destroy();    
    registerLog($net_rrhh, "Login", "Login", "Logoff", "Cerrar de Sesión");
    redirection("../?view=login&n=2");
}
else
    redirection("../?view=login&n=3");

?>