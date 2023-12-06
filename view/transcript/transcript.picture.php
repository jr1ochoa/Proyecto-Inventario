<?php 
    //session_start();
    include("../../config/net.php");

    $query = "SELECT picture FROM employee_picture WHERE idemployee = " . $_REQUEST['iu'];
    $picture = $net_rrhh->prepare($query);
    $picture->execute();

    if($picture->rowCount() > 0)
    {
        $dataI = $picture->fetch();
        $img = $dataI[0];
    }
    else
        $img = "h.jpg";    
?>
<section>
    <form method="post" action="process/" enctype="multipart/form-data">
                
    <div class="row gtr-uniform">

        <div class="col-12 col-12-xsmall">
            <h2>IMAGEN DEL EMPLEADO</h2>
        </div>

        <div class="col-4 col-4-xsmall">
            <img id="img1" src="process/pictures/<?=$img?>" style='width: 100%'/>
        </div>

    
            <input type="hidden" name="process" value="Transcript File">
            <input type="hidden" name="action" value="Change Picture">  
            <input type="hidden" name="iu" value="<?=$_REQUEST['iu']?>">

            <div class="col-8 col-8-xsmall">  
                <h3>Seleccione la nueva imagen del empleado</h3>          
                <input id="inputFile" type="file" class="form-control" name='NewPicture' accept="image/*">

                <ul class="actions fixed mt-5">
                    <li><input type="submit" value="Actualizar Fotografía"></li>
                </ul>
            </div>     
               

        <script>
            $seleccionArchivos = document.querySelector("#inputFile");
            $imagenPrevisualizacion = document.querySelector("#img1");

            $seleccionArchivos.addEventListener("change", () => {

                const archivos = $seleccionArchivos.files;

                if (!archivos || !archivos.length) {
                    $imagenPrevisualizacion.src = "";
                    return;
                }

                const primerArchivo = archivos[0];
                const objectURL = URL.createObjectURL(primerArchivo);
                $imagenPrevisualizacion.src = objectURL;
                
            }); 
                  
        </script>

    </div>

    </form>
    
</section>
<style>
td {
font-size: 15px;
}
</style>