<?php 
    include("../../config/net.php");
    
    if(isset($_SESSION['iu']) && $_SESSION['type'] == "Administrador") 
    { 
        $iu = $_REQUEST['iu'];
?>

    <form action="process/" method="post" id="form">
        <h2 class="text-uppercase fw-bolder">Actualizar Contraseña</h2>
        <input type="hidden" class="form-control" name="process" value="Users">
        <input type="hidden" class="form-control" name="action" value="updatePassword" />
        <input type="hidden" name="iu" value="<?= $iu; ?>" />

        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Nueva Contraseña:</label>
            <input type="password" class="form-control" name="pass">
        </div>
        
    </form>

<?php
    }
?>