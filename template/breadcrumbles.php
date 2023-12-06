<?php

$breadcrumb = array();

// Página de Inicio    
if($view == "main" && $authent)
    $breadcrumb = array("Inicio" => "main");

// Página de Expedientes     
else if($view == "transcript" && $authent)
    $breadcrumb = array("Inicio" => "main", "Expediente Personal" => "transcript");

// Página de cuestionario de necesidades     
else if($view == "needs" && $authent)
    $breadcrumb = array("Inicio" => "main", "Cuestionario de Necesidades" => "transcript");

// Gestión de Usuarios    
else if($view == "user" && $authent)
    $breadcrumb = array("Inicio" => "main", "Usuarios" => "user"); 

// Gestión de Áreas 
else if($view == "area" && $authent)
$breadcrumb = array("Inicio" => "main", "Áreas" => "area"); 

// Gestión de Empleados 
else if($view == "employee" && $authent)
$breadcrumb = array("Inicio" => "main", "Buscador Empleados" => "employee");

// Página de Perfil
else if($view == "profile" && $authent) 
    $breadcrumb = array("Inicio" => "main", "Perfil" => "profile");    

// Página de Permisos
else if($view == "permissions" && $authent) 
    $breadcrumb = array("Inicio" => "main", "Procesos Administrativos" => "permissions", "Permisos" => "permissions"); 

else if($view == "permissionAnswer") 
    $breadcrumb = array("Inicio" => "main", "Permisos" => "permissionAnswer"); 

// Log de Registro de acciones     
else if($view == "log" && $authent)
    $breadcrumb = array("Inicio" => "main", "Log de Registros" => "log");

// Log de Registro de acciones     
else if($view == "personnelactions" && $authent)
    $breadcrumb = array("Inicio" => "main", "Acciones de Personal" => "personnelactions");  


// Log de Registro de acciones     
else if($view == "personnelactions" && $authent)
    $breadcrumb = array("Inicio" => "main", "Acciones de Personal" => "personnelactions");  

    
else
    $breadcrumb = "";


if(!$breadcrumb == ""){ ?>
<nav class='inner mt-5' aria-label="breadcrumb">
  <ol class="breadcrumb">
    <?php
        foreach($breadcrumb as $key => $value)
            echo "<li class='breadcrumb-item'>
                    <a href='?view=$value' style='text-decoration: none; font-weight: 500;'>$key</a>
                  </li>";
    ?>
  </ol>
</nav>
<?php } ?>