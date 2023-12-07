<!-- Select 2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Main -->
<div id="main">
    <div class="inner">
        
    <!-- Content -->
        <div id="content">
        <?php
            if(isset($_REQUEST['pst'])){
                echo '<h2 class="title mt-5">Cargos</h2>';
            }elseif(isset($_REQUEST['pp'])){
                echo '<h2 class="title mt-5">Perfil del Cargo</h2>';
            }else{
                echo '<h2 class="title mt-5">Áreas</h2>';
            }
        ?>
            <hr style='margin-top: 0px; padding-top: 0px;'/>  
            <div class="col-12" style="margin-bottom: 2%;">
                <?php 
                    if(isset($_REQUEST['list']))
                    {
                        echo '<button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#FormModal" id="btnAdd" onclick="add()">Añadir Área</button>
                        <a href="/?view=area"><button type="button" class="btn btn-info ms-3" >Áreas Habilitadas</button></a>';
                    }
                    elseif(isset($_REQUEST['pst']))
                    {
                        echo '<button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#FormModal" onclick="addPosition('.$_REQUEST['pst'].')">Añadir Cargo</button>
                        <a href="/?view=area"><button type="button" class="btn btn-info ms-3">Áreas</button></a>';
                    }
                    elseif(isset($_REQUEST['pp']))
                    {
                        echo '';
                    }
                    else
                    {
                        echo '<button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#FormModal" id="btnAdd" onclick="add()">Añadir Área</button>
                        <a href="/?view=area&list=0"><button type="button" class="btn btn-info ms-3">Áreas Deshabilitadas</button></a>';
                    }
                ?>
            </div>          
            <?php 
                if(isset($_REQUEST['list']))
                {
                    include("view/work_area/work_area.list.disable.php");
                }
                elseif(isset($_REQUEST['pst']))
                {
                    include("view/work_area/work_area.positions.php");
                }
                elseif(isset($_REQUEST['pp']))
                {
                    include("view/work_area/work_area.position.profile.php");
                }
                else
                {
                    include("view/work_area/work_area.list.php");
                }
            ?>
        </div>
    </div>
</div>

<div class="modal fade" id="FormModal" tabindex="-1" aria-labelledby="FormModal" aria-hidden="true">  
    <?php include("view/work_area/work_area.modal.php");?>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.js"></script>    
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>


<script>
    $(document).ready(function () {
        $.noConflict();
        $('#UserTable').DataTable( {
            "order": [[ 0, "asc" ]], 
            "language": { "url": "https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json" }
        });

        $("#btnAdd").click(function () {
            $("#loadModalArea").load("/view/work_area/work_area.form.php");
            $("#btnActionArea").css("display", "block");
            $("#btnActionArea").removeClass().addClass('btn btn-success');
            $("#btnActionArea").text('Guardar');
        });

    });

    function add(){
        $("#loadModalArea").load("/view/work_area/work_area.form.php");
            $("#btnActionArea").css("display", "block");
            $("#btnActionArea").removeClass().addClass('btn btn-success');
            $("#btnActionArea").text('Guardar');
    }
    
    function edit(iu){
        $("#loadModalArea").load("view/work_area/work_area.form.php", {iu: iu} );
        $("#btnActionArea").css("display", "block");
        $("#btnActionArea").removeClass().addClass('btn btn-primary');
        $("#btnActionArea").text('Actualizar');
    } 

    function enable(iu, visible){
        $("#loadModalArea").load("view/work_area/work_area.form.visible.php", {iu: iu, visible: visible} );
        $("#btnActionArea").css("display", "block");
        if(visible == 1){
            $("#btnActionArea").removeClass().addClass('btn btn-danger');
            $("#btnActionArea").text('Deshabilitar');
        }else{
            $("#btnActionArea").removeClass().addClass('btn btn-success');
            $("#btnActionArea").text('Habilitar');
        }
    }    

    function editPosition(iu, area, typeA){
        $("#loadModalArea").load("view/work_area/work_area.position.form.php", {iu: iu, area: area, typeA: typeA} );
        $("#btnActionArea").css("display", "block");
        $("#btnActionArea").removeClass().addClass('btn btn-primary');
        $("#btnActionArea").text('Actualizar');
    } 

    function addPosition(area) {
        $("#loadModalArea").load("view/work_area/work_area.position.form.php", {area: area});
        $("#btnActionArea").css("display", "block");
        $("#btnActionArea").removeClass().addClass('btn btn-success');
        $("#btnActionArea").text('Guardar');
    };

    function addBossPosition(type, idp) {
        $("#loadModalArea").load("view/work_area/work_area.p.profile.form.php", {type: type, idp: idp});
        if(type == "boss"){
            $("#btnActionArea").css("display", "none");
        }else{
            $("#btnActionArea").css("display", "block");
            $("#btnActionArea").removeClass().addClass('btn btn-success');
            $("#btnActionArea").text('Asignar');
        }        
    };

    function editBossPosition(type, idp, ida) {
        $("#loadModalArea").load("view/work_area/work_area.p.profile.form.php", {type: type, idp: idp, ida: ida});
        if(type == "boss"){
            $("#btnActionArea").css("display", "none");
        }else{
            $("#btnActionArea").css("display", "block");
            $("#btnActionArea").removeClass().addClass('btn btn-success');
            $("#btnActionArea").text('Asignar');
        }        
    };    

</script>                    
<link rel="stylesheet" href='https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css'/>