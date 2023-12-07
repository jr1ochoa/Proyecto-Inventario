<!-- DataTables-->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

<!-- Main -->
<div id="main">
    <div class="inner">
        
    <!-- Content -->
        <div id="content">
            <h2 class="title mt-5">Usuarios</h2>
            <hr style='margin-top: 0px; padding-top: 0px;'/>  
            <div class="col-12" style="margin-bottom: 2%;">
                <button type="button" class="btn btn-primary" data-bs-toggle='modal' data-bs-target='#FormModal' id="btnAdd">Añadir Usuario</button>
            </div>          
            <?php include("view/users/user.list.php");?>
        </div>
    </div>
</div>

<div class="modal fade" id="FormModal" tabindex="-1" aria-labelledby="FormModal" aria-hidden="true">  
    <?php include("view/users/user.modal.php");?>
</div> 

<script>
    
    $(document).ready(function () {
        $("#btnAdd").click(function () {
            $("#loadModal").load("view/users/user.form.php");
            $("#btnAction").removeClass().addClass('btn btn-success');
            $("#btnAction").text('Guardar');
        });
    });

    function edit(iu){
        $("#loadModal").load("view/users/user.form.php", {iu: iu} );
        $("#btnAction").removeClass().addClass('btn btn-primary');
        $("#btnAction").text('Actualizar');
    } 

    function pass(iu){
        $("#loadModal").load("view/users/user.form.pass.php", {iu: iu} );
        $("#btnAction").removeClass().addClass('btn btn-primary');
        $("#btnAction").text('Actualizar');
    }

    function enable(iu, state){
        $("#loadModal").load("view/users/user.form.enable.php", {iu: iu, state: state} );
        if(state == 1){
            $("#btnAction").removeClass().addClass('btn btn-danger');
            $("#btnAction").text('Deshabilitar');
        }else{
            $("#btnAction").removeClass().addClass('btn btn-success');
            $("#btnAction").text('Habilitar');
        }
    }    
</script>                    
