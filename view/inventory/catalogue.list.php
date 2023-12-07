<!-- LISTADO DEL CATÁLOGO UNA VEZ SELECCIONADO EL TIPO -->

<?php include("../../config/net.php"); //Conexión con la BDD

    //Cargar catálogo según el tipo
    $type = $_REQUEST["type"];
    $query = "SELECT * FROM catalogue WHERE type = '$type'";
    $catalogue = $net_rrhh->prepare($query);
    $catalogue->execute();   

    if ($type != ""){
?>

<!-- Agregar un nuevo elemento al catálogo -->
<p class="fs-5 text-center">Agregar Nuevo <?=$type?></p>
<div class="mb-3">
    <div class="row">
        <div class="col-md-9">
            <input class="form-control" id="txtNew" type="text" aria-label="default input example">
        </div>
        <div class="col-md-3 text-center">
            <button type="button" class="btn btn-success" id="btnSaveCatalogue">Guardar</button>
        </div>
    </div>
</div>

<hr/>

<!-- Imprimir listado del catálogo -->
<p class="fs-5 text-center">Listado de <?=$type?>s</p>
<table class="table table-bordered" id="catalogueTable">
    <thead>
        <tr>
            <th>#</th>
            <th><?=$type?></th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if ($catalogue->rowCount() > 0) {
                $i=0;
                while ($dataC = $catalogue->fetch()) {
                    $i++;
                    echo "<tr>
                            <td>$i</td>
                            <td>$dataC[2]</td>
                            <td>
                                <a role='button' class='btn btn-danger btn-sm' onclick='deleteElement($dataC[0])'><i class='bi bi-trash3-fill'></i> Eliminar</a>
                            </td>
                        </tr>";
                }
            }else{
                echo "<tr>
                        <td class='text-danger text-center' colspan='3'>¡No se han encontrado registros!</td>
                    </tr>";
            }
        ?>
    </tbody>
</table>

<script>

    //Agregar nuevo elemento al catálogo
    $("#btnSaveCatalogue").click(function(){
        $.post("view/inventory/process/index.php", 
            {                            
                process: 'catalogue',
                action: 'Add Catalogue',
                type: "<?=$type?>",
                value: $("#txtNew").val()
            },
            function(response)
            {
                alert(response);  
                $("#fillList").load("view/inventory/catalogue.list.php", { type : "<?=$type?>" });
            }
        );
    });

    //Eliminar un elemento del catálogo
    function deleteElement(id){
        if(confirm('Desea realmente eliminar el registro?'))
        {
            $.post("view/inventory/process/index.php", 
                { 
                    process: 'catalogue',
                    action: 'Delete Catalogue',
                    id: id
                },
                function(response){
                    alert(response);  
                    $("#fillList").load("view/inventory/catalogue.list.php", { type : "<?=$type?>" });
                }
            );
        }
    };
</script>

<?php } ?>