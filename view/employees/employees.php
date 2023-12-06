<script src="https://code.jquery.com/jquery-3.5.1.js"></script>    
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href='https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css'/>

<!-- Main -->
<div id="main">
    <div class="inner">
        
    <!-- Content -->
        <div id="content">
            <h2 class="title mt-5">Empleados</h2>
            <hr style='margin-top: 0px; padding-top: 0px;'/> 
            <div class="row mb-4">
                <div class="col-12">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon3">Buscador</span>
                        <input type="text" class="form-control" name="busqueda" id="txtBusqueda" autocomplete="off">
                    </div>
                </div>
            </div>   
            
            <div id="salida"></div>

        </div>
    </div>
</div>


<script>
    $(document).ready(function(){
         $("#txtBusqueda").keyup(function(){
            $("#salida").load("/view/employees/employees.search.php", {
                search: $("#txtBusqueda").val()
            });
         })
    })   
</script>                    