<!-- FORMULARIO DE SUBIDA DE ARCHIVOS -->
<form id="formProfile" method="post" action="process/" enctype="multipart/form-data" style="margin-top: 0px;">

    <input type="hidden" name="process" value="Profile">
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
        <input type="file" class="form-control" name="file" accept="image/*,.pdf, .doc, .docx" />
    </div>
</form> 