<!-- ESTRUCTURA DEL MODAL -->
<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div id='loadModalProfile' class="modal-body">
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnDismiss">Cerrar</button>
        <button id="btnActionProfile" type="button" class="btn btn-primary" onclick="saveForm()" >Guardar</button>
      </div>
    </div>
  </div> 

  <script>

    function saveForm(){

        
        $('#formProfile').submit();
            
    }
  </script>