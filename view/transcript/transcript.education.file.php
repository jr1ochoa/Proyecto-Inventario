<?php
if(isset($_REQUEST['ide']))
{
    session_start();
    include("../../config/net.php");  
    $ide = $_REQUEST['ide'];
}
?>
<style>
    td, div
    {
        font-size: 15px;
    }
</style>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <div class="row gtr-uniform">
                <div class="col-12 col-12-xsmall">
                    <h2>Documento relacionados con tu registro educativo</h2>
                    <p>Esta información confirma tu registro educativo</p>
                    <table class="table table-bordered">
                        <tr>
                            <th>Archivo</th>
                            <th></th>
                            <th></th>
                        </tr>
                    <?php
                        
                        $query = "SELECT f.* FROM employee_files as f
                                  WHERE f.type = 'Education' AND extra = '$ide' AND f.idemployee = ". $_SESSION['iu'];                                            

                        $FileEducation = $net_rrhh->prepare($query);
                        $FileEducation->execute();
                        
                        while($data = $FileEducation->fetch())
                        {
                            echo "<tr>
                                    <th>$data[2]</th>
                                    <th>
                                        <a href='process/documents/$data[3]' target='_blank'>
                                            <i class='fa fa-file'></i>
                                            Descargar
                                        <a>
                                    </th>
                                    <th>
                                        <form action='process/' method='post'>
                                            <input type='hidden' name='process' value='Transcript File'>
                                            <input type='hidden' name='action' value='Delete File'>                     
                                            <input type='hidden' name='type' value='Education'>  
                                            <input type='hidden' name='idf' value='$data[0]'>                                          
                                            <a onclick='DeleteFile(this)'>
                                                <i class='fa fa-trash'></i>
                                                Eliminar
                                            </a>
                                        </form>
                                    </th>
                                  </tr>";
                        }
                    ?>
                    </table>
                    <script>
                        function DeleteFile(a)
                        {
                            if(confirm("¿Estas seguro de Eliminar el archivo?"))
                                $(a).parent().submit()
                        }                        
                    </script>
                </div>

                <!-- Break -->
                <form method="post" action="process/" class='mt-5' enctype="multipart/form-data">
                    
                    <input type="hidden" name="process" value="Transcript File">
                    <input type="hidden" name="action" value="Add File">                     
                    <input type="hidden" name="type" value="Education">  
                    <input type="hidden" name="ide" value="<?=$ide?>">  
                    
                    <div class="col-12 mt-3">
                        <h2>Añadir nuevo documento</h2>
                    </div>
                    
                    <div class="col-12 mt-3">
                        Documento
                        <input type="text" class="form-control" name="filename" />
                    </div>  

                    <div class="col-12 mt-3">
                        Busque su archivo
                        <input type="file" class="form-control" name="file" />
                    </div>

                    <div class="col-12 mt-5">
                        <ul class="actions fixed">
                            <li><input type="submit" value="Añadir Documento"></li>
                        </ul>
                    </div>
                </form>                
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>