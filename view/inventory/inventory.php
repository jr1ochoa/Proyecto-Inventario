<!-- VISTA PRINCIPAL DEL INVENTARIO -->

<!-- jQuery 3.6.1-->
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<!-- Bootstrap Icons-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
<!-- DataTables-->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<!-- Select 2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

<div class='container mb-5'>

    <!-- Funciones -->
    <div class="mt-5">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <h2 style="margin-bottom: 0;" class="text-uppercase">Gestión de Inventario</h2>
            </div>
            <div class="col-md-6 col-sm-12 text-end">
                
                <button id='btnCatalogue' type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">
                    Catálogo
                </button>  

                <button type="button" class="btn btn-primary" onclick="active('add', 0)" data-bs-toggle="modal" data-bs-target="#modal">
                    Añadir nuevo activo 
                </button> 

                <button type="button" class="btn btn-success" id="btnExport">
                    <i class="bi bi-file-earmark-spreadsheet"></i>
                </button> 
            </div>
        </div>
    </div>
    
    <hr>    

    <!-- Buscadores -->
    <div class="row my-4">
        <div class="col-md-6">
            <label for="cboLoan" class="form-label">Buscador por Préstamo:</label>
            <select id="cboLoan" class="form-control" style="width: 100%;">
                <option value='All' selected>Ver Todos</option>
                <option value="Loan">En préstamo</option>
            </select>
        </div>

        <div class="col-md-6">
            <label for="cboSearch" class="form-label">Buscador por Área:</label>
            <select id="cboSearch" class="js-example-basic-single" style="width: 100%;">
                <option value='' selected>Ver Todos</option>
                <?php
                    $query = "SELECT * FROM workarea where visible = 1";
                    
                    $workarea = $net_rrhh->prepare($query);  
                    $workarea->execute();

                    while($data = $workarea->fetch())
                    {
                        if($data[0] == $areaP)
                            echo "<option value='$data[0]' selected='selected'>".utf8_encode($data[1])."</option>";
                        else
                            echo "<option value='$data[0]'>".utf8_encode($data[1])."</option>";
                    }
                ?>
            </select>
        </div>
        
    </div>

    
</div>

<!-- Contenedor del listado -->
<div id="inventoryList" class="px-5 mx-4 pb-5"></div>
    
<!--SECCION DE LA VENTANA MODAL-->

<!-- Modal -->
<div class="modal fade" id="modal" aria-labelledby="Modal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="TitleModal"></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id='LoadForm'>  
      </div>
      <div class="modal-footer"> 
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>  
</div> 

<script>
    $(document).ready(function(){

        //Cargar Inventario
        $('#inventoryList').load('view/inventory/inventory.list.php',{
            loan: $('#cboLoan').val()
        });

        //Cargar listado según buscador por área 
        $('#cboSearch').change(function(){
            $('#inventoryList').load('view/inventory/inventory.list.php',
            {
                area: $(this).val(),
                loan: $('#cboLoan').val()
            });
        });

        //Cargar listado según buscador por préstamo
        $('#cboLoan').change(function(){
            $('#inventoryList').load('view/inventory/inventory.list.php',
            {
                loan: $(this).val()
            });
        });

        //Declarar como contenedor padre el contenedor
        $('#cboSearch').select2({
            dropdownParent: $('.container')
        });

        //Cargar modal del catálogo
        $("#btnCatalogue").click(function(){
            $("#LoadForm").load("view/inventory/catalogue.php");
        }); 

        //Exportar los registros en excel
        $("#btnExport").click(function(){
            window.open('view/inventory/inventory.report.php', '_blank'); 
        });
        
    });

    /* CARGA DE FORMULARIOS */

    //Agregar, editar o eliminar activos
    function active(action, data){
        $("#TitleModal").text("Formulario de Inventario");

        if(action == 'add'){
            $("#btnForm").text("Añadir nuevo Activo");
            $("#LoadForm").load("view/inventory/inventory.form.php", { action : "Add" });

        }else if(action == 'update'){
            $("#btnForm").text("Editar Activo");
            $("#LoadForm").load("view/inventory/inventory.form.php", { action : "Update", idi: data });

        }else{
            $("#btnForm").text("Eliminar Activo");
            $("#LoadForm").load("view/inventory/inventory.form.php", { action : "Delete", idi: data });
        }
    }

    //Información Complementaria
    function loadExtra(idActive){
        $("#TitleModal").text("Información Complementaria de Activo");
        $("#btnForm").text("Guardar");
        $("#LoadForm").load("view/inventory/inventory.extra.php", { ida : idActive });
    }

    //Asignaciones
    function loadAssignation(id){
        $("#TitleModal").text("Asignaciones del Equipo");
        $("#btnForm").text("Asignar");
        $("#LoadForm").load("view/inventory/inventory.assignation.php", { id : id, action : "add" });
    }
    
    //Mantenimiento
    function loadMaintenance(id){
        $("#TitleModal").text("Mantenimientos del Equipo");
        $("#btnForm").text("Guardar");
        $("#LoadForm").load("view/inventory/inventory.maintenance.php", { id : id, action : "add" });
    }

    //Documentos
    function loadDocuments(id){
        $("#TitleModal").text("Documentos");
        $("#btnForm").text("Guardar");
        $("#LoadForm").load("view/inventory/inventory.documents.php", { id : id });
    }
</script>
    