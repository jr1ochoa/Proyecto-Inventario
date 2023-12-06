<style>
    table th, td {
        font-size: 16px;
    }
</style>
<section>
    <div class="row gtr-uniform">
        <div class="col-12 col-12-xsmall">
            <h2>Documento relacionados guardados en tu perfil</h2>
        </div>  
        <div class="col-12 col-12-xsmall">
            <table class="table table-bordered">
                <tr>
                    <th>Archivo</th>
                    <th></th>
                    <th style='text-align: right; color: blue'>
                        <a data-bs-toggle="modal" data-bs-target="#FormModal">
                            Añadir Documento
                        </a>
                    </th>
                </tr>
                <?php
                    
                    $query = "SELECT f.* FROM employee_files as f
                                WHERE f.type = 'Documents' AND f.idemployee = ". $_SESSION['iu'];                                            

                    $Files = $net_rrhh->prepare($query);
                    $Files->execute();
                    
                    if($Files->rowCount() > 0)
                    {
                        while($data = $Files->fetch())
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
                                            <input type='hidden' name='type' value='Documents'>  
                                            <input type='hidden' name='idf' value='$data[0]'>                                          
                                            <a onclick='DeleteFile(this)'>
                                                <i class='fa fa-trash'></i>
                                                Eliminar
                                            </a>
                                        </form>
                                    </th>
                                    </tr>";
                        }
                    }
                    else
                    {
                        echo "<tr>
                                <th colspan='3'>
                                    <b>No se encuentran documentos registrados</b>
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
    </div>
</section>



<!-- Modal -->
<div class="modal fade" id="FormModal" tabindex="-1" aria-labelledby="FormModal" aria-hidden="true">  
<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">Añadir nuevo documento
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <div class="row gtr-uniform">

                <!-- Break -->
                <form method="post" action="process/" enctype="multipart/form-data" style="margin-top: 0px;">
                    
                    <input type="hidden" name="process" value="Transcript File">
                    <input type="hidden" name="action" value="Add File">                     
                    <input type="hidden" name="type" value="Documents">
                    
                    <div class="col-12 mt-3">
                        Documento permitidos: 
                        <select class="form-control" name="filename">
                            <option value="DUI">DUI</option>
                            <option value="NIT">NIT</option>
                            <option value="Licencia de Conducir">Licencia de Conducir</option>
                            <option value="Cartilla de Vacunación">Cartilla de Vacunación</option>
                            <option value="Curriculum Vitae">Curriculum Vitae</option>
                            <option value="Otro documento personales">Otro documento personales requeridos</option>
                        </select>
                    </div>  

                    <div class="col-12 mt-3">
                        Busque su archivo
                        <input type="file" class="form-control" name="file" accept="image/*,.pdf,.doc,.docx" />
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
</div>
