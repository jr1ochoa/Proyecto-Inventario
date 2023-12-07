<!-- DOCUMENTOS DE ASIGNACIONES -->
 <?php include("../../config/net.php"); //Conexión con la BDD
    $assignationID = $_REQUEST["id"];
 ?>
<div id="tabDocs">

<!-- Formulario para subir archivos -->
    <p class="fs-5 text-center text-uppercase mb-3">Subir Archivos</p>
    <div class="mb-3">
        <label for="cboType" class="form-label">Tipo de Documento:</label>
        <select class="form-select" id="cboType" aria-label="Default select example">
            <option></option>
            <option value="Memorándum de Entrega">Memorándum de Entrega</option>
            <option value="Descargar">Descargar</option>
            <option value="Préstamo">Préstamo</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="txtFile" class="form-label">Seleccione un archivo:</label>
        <input class="form-control" type="file" id="txtFile" accept=".doc,.docx, .pdf">
    </div>
    <button class="btn btn-success mb-5 d-block mx-auto" id="btnFiles">Subir</button>

    <!-- Listado de Documentos -->
    <p class="fs-5 text-center mb-3 text-uppercase">Documentos</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Tipo de Documento</th>
                <th>Documento</th>
                <th>Archivo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                //Imprimir listado de documentos
                $query = "SELECT * FROM inventory_files where assignation = $assignationID";
                $docs = $net_rrhh->prepare($query);
                $docs->execute();
                $cont = 0;

                if ($docs->rowCount() > 0) {
                    while($dataD = $docs->fetch()) {
                        $cont++;
                        echo "<tr>
                                <td>$cont</td>
                                <td>$dataD[1]</td>
                                <td>
                                    <a href='process/documents/$dataD[2]' target='_blank' rel='noopener noreferrer'>Descargar</a>
                                </td>    
                                <td>$dataD[3]</td>
                                <td>
                                    <a role='button' class='btn btn-danger btn-sm' onclick='deleteFile($dataD[0])'>
                                        <i class='bi bi-trash3-fill'></i>
                                    </a>
                                </td>
                            </tr>";
                    }
                }else{
                    echo "<tr>
                            <td class='text-danger text-center' colspan='5'>¡No hay documentos para esta asignación!</td>
                        </tr>";
                }
            ?>
        </tbody>
    </table>
</div>
<script>
    //Guardar archivos
    $("#btnFiles").click(function(){ 
        var form_data = new FormData();
        var file_data = $("#txtFile").prop("files")[0];

        form_data.append("file", file_data);
        form_data.append("process", "inventory");
        form_data.append("action", "Add File");
        form_data.append("type", $("#cboType option:selected").val());
        form_data.append("assignation", "<?=$assignationID?>");

        console.log(form_data);

        $.ajax({
            cache: false,
            contentType: false,
            data: form_data,
            enctype: 'multipart/form-data',
            processData: false,
            method: "POST",
            url: "view/inventory/process/index.php",
            success: function (data) {
                alert(data);
                $("#LoadForm").load("view/inventory/inventory.documents.php", { id : "<?=$assignationID?>" });
            }
        });
    }); 

    //Eliminar archivos
    function deleteFile(id){
        if(confirm('Desea realmente eliminar el archivo?'))
        {
            $.post("view/inventory/process/index.php", 
                { 
                    process: 'inventory',
                    action: 'Delete File',
                    id: id
                },
                function(response){
                    alert(response);  
                    $("#LoadForm").load("view/inventory/inventory.documents.php", { id : "<?=$assignationID?>" });
                }
            );
        }
    };

</script>