<?php

if(isset($_GET['msg']))
{
    $n = (isset($_GET['msg'])) ? $_GET['msg'] : '';

    if($n == 1)
        $msg = "Actualización de datos personales realizado correctamente";

    else if($n == 2)
        $msg = "Familiar añadido correctamente";

    else if($n == 3)
        $msg = "Familiar eliminado correctamente";     
        
    else if($n == 4)
        $msg = "Familiar actualizado correctamente";     
        
    else if($n == 5)
        $msg = "Información educativa personal actualizado correctamente";
        
    else if($n == 6)
        $msg = "Registro educativo ingresado correctamente";
        
    else if($n == 7)
        $msg = "Registro educativo eliminado correctamente";  
        
    else if($n == 7)
        $msg = "Documento educativo añadido correctamente";          
?>

    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <img style='width: 30px' src="https://remake.siifusalmo.org/assets/images/LogoFusalmo.png" class="rounded me-2" alt="...">
                <strong class="me-auto">Notificación del SIIF</strong>
                <small>Hace poco</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
            <?=$msg?>
            </div>
        </div>
    </div>

    <script>    
        var toastLiveExample = document.getElementById('liveToast')
        var toast = new bootstrap.Toast(toastLiveExample)
        toast.show()
    </script>

<?php }?>