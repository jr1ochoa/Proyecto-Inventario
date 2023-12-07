<?php
    include("../../config/net.php");
    
    if(isset($_SESSION['iu']) && $_SESSION['type'] == "Administrador") 
    {
        if(isset($_REQUEST['iu']))
        {
            $iu = $_REQUEST['iu'];
            $state = $_REQUEST['state'];
            $action = ($state == 1) ? "disableUsers" : "enableUsers";            

            $query = "SELECT * FROM users WHERE id = $iu";
            $enable = $net_rrhh->prepare($query);
            $enable->execute();
            $dataE = $enable->fetch();
        }
        
        ?>

        <form action="process/" method="post" id="form">
            <input type="hidden" class="form-control" name="process" value="Users">
            <input type="hidden" class="form-control" name="action" value="<?=$action;?>" />
            <input type="hidden" name="iu" value="<?= $iu ?>" />

            <?php if($state == 1){ ?>
                <h2 class="text-uppercase fw-bolder">Deshabilitar usuario</h2>
                <p>¿Está seguro que desea deshabilitar el usuario <b><?=$dataE[1];?></b>?</p>
            <?php } else { ?>
                <h2 class="text-uppercase fw-bolder">Habilitar usuario</h2>
                <p>¿Está seguro que desea habilitar el usuario <b><?=$dataE[1];?></b>?</p>
            <?php } ?>
        </form>

        <?php    
    }
?>