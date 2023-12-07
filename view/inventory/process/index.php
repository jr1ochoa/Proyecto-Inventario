<!-- CONTROL DE PROCESOS DEL INVENTARIO -->
<?php include("../../../config/net.php"); //Conexión con la BDD

    //Recibir datos del módulo a redirigir
    $process = (isset($_POST['process'])) ? $_POST['process'] : "";
    $action = (isset($_POST['action'])) ? $_POST['action'] : "";

    //Cargar procesos del módulo
    if($process == "inventory")
        include("inventories.php");
     
    elseif($process == "catalogue")
        include("catalogue.php");

    else
        echo "Fail";
?>