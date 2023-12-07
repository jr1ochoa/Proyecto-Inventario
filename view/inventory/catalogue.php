<!-- Vista Principal del Catálogo -->

<h2>Catálogo</h2>

<div class="mb-3">
    <label for="cboType" class="form-label">Tipo:</label>
    <select class="form-select" aria-label="Default select example" id="cboType">
        <option></option>
        <option value="Tipo">Tipo</option>
        <option value="Marca">Marca</option>
        <option value="Estado">Estado</option>
        <option value="Financiamiento">Financiamiento</option>
    </select>
</div>

<hr/>

<!-- Contenedor para cargar listado -->
<div id="fillList"></div>

<script>
    //Cargar listado en el contenedor
    $("#cboType").change(function(){
        $("#fillList").load("view/inventory/catalogue.list.php",{
            type: $("#cboType").val()
        });
    })
</script>
