<? 
include('includes/db.php'); 
include('includes/funciones.php');
?>
<div class="alert alert-danger " style="display: none;" role="alert" id="msg_error"></div>
<form class="inbox-compose form-horizontal" id="frm_guarda" >

<!--
    <div class="inbox-compose-btn">
        <button class="btn green">
            <i class="fa fa-check"></i>Send</button>
        <button class="btn default inbox-discard-btn">Discard</button>
        <button class="btn default">Draft</button>
    </div>
    <div class="inbox-form-group mail-to">
        <label class="control-label">To:</label>
        <div class="controls controls-to">
            <input type="text" class="form-control" name="to">
            <span class="inbox-cc-bcc">
                <span class="inbox-cc"> Cc </span>
                <span class="inbox-bcc"> Bcc </span>
            </span>
        </div>
    </div>
    <div class="inbox-form-group input-cc display-hide">
        <a href="javascript:;" class="close"> </a>
        <label class="control-label">Cc:</label>
        <div class="controls controls-cc">
            <input type="text" name="cc" class="form-control"> </div>
    </div>
    <div class="inbox-form-group input-bcc display-hide">
        <a href="javascript:;" class="close"> </a>
        <label class="control-label">Bcc:</label>
        <div class="controls controls-bcc">
            <input type="text" name="bcc" class="form-control"> </div>
    </div>-->
    
    <div class="inbox-form-group">
        <label class="control-label" style="width: 120px;">Asunto:</label>
        <div class="controls" style="margin-left: 125px;">
	        <input type="text" class="form-control" name="asunto">
	    </div>
    </div>
    <!--
    <div class="inbox-form-group">
        <label class="control-label" style="width: 120px;">Descripción:</label>
        <div class="controls" style="margin-left: 125px;">
	        <input type="text" class="form-control" name="descripcion">
	    </div>
    </div>
    -->
    <div class="inbox-form-group">
        <label class="control-label" style="width: 120px;">Prioridad:</label>
        <div class="controls" style="margin-left: 135px;">
	        <select class="form-control" name="prioridad">
			    <option value="1">Baja</option>
			    <option value="2">Media</option>
			    <option value="3">Alta</option>
			</select>
	    </div>
    </div>
    
    <div class="inbox-form-group">
        <label class="control-label" style="width: 120px;">Destinatario:</label>
        <div class="controls" style="margin-left: 135px;">
			<select id="single" class="form-control select2" name="id_destino">
				<option value="0">Seleccione un usuario</option>
				<?
					$sq="SELECT * FROM usuarios WHERE activo=1 ORDER BY nombre ASC";
					$q=mysql_query($sq);
					while($datos=mysql_fetch_assoc($q)){ 
				?>
				<option value="<?=$datos['id_usuario']?>"><?=$datos['nombre']?></option>
				<? } ?>
			</select>                                                											
	    </div>
    </div>
    
    <div class="inbox-form-group">
        <label class="control-label" style="width: 120px;">Proyecto:</label>
        <div class="controls" style="margin-left: 135px;">
			<select id="single" class="form-control select2" name="id_proyecto">
				<option value="0">Sin Proyecto</option>
				<?
					$sq="SELECT * FROM proyectos WHERE activo=1 ORDER BY proyecto ASC";
					$q=mysql_query($sq);
					while($datos=mysql_fetch_assoc($q)){ 
				?>
				<option value="<?=$datos['id_proyecto']?>"><?=$datos['proyecto']?></option>
				<? } ?>
			</select>                                                											
	    </div>
    </div>

    <div class="inbox-form-group">
        <label class="control-label" style="width: 120px;">Fecha límite:</label>
        <div class="controls" style="margin-left: 125px;">
	        <input class="form-control fecha" name="fecha_limite" type="text" />
	    </div>
    </div>

    
    <div class="inbox-form-group">
        <textarea class="inbox-editor inbox-wysihtml5 form-control" name="mensaje" rows="12"></textarea>
    </div>
    <!--
    <div class="inbox-compose-attachment">
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload --
        <span class="btn green btn-outline fileinput-button">
            <i class="fa fa-plus"></i>
            <span> Add files... </span>
            <input type="file" name="files[]" multiple> </span>
        <!-- The table listing the files available for upload/download --
        <table role="presentation" class="table table-striped margin-top-10">
            <tbody class="files"> </tbody>
        </table>
    </div>
    -->
    <!--
    <script id="template-upload" type="text/x-tmpl"> {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-upload fade">
            <td class="name" width="30%">
                <span>{%=file.name%}</span>
            </td>
            <td class="size" width="40%">
                <span>{%=o.formatFileSize(file.size)%}</span>
            </td> {% if (file.error) { %}
            <td class="error" width="20%" colspan="2">
                <span class="label label-danger">Error</span> {%=file.error%}</td> {% } else if (o.files.valid && !i) { %}
            <td>
                <p class="size">{%=o.formatFileSize(file.size)%}</p>
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                </div>
            </td> {% } else { %}
            <td colspan="2"></td> {% } %}
            <td class="cancel" width="10%" align="right">{% if (!i) { %}
                <button class="btn btn-sm red cancel">
                    <i class="fa fa-ban"></i>
                    <span>Cancel</span>
                </button> {% } %}</td>
        </tr> {% } %} </script>
    <!-- The template to display files available for download --
    <script id="template-download" type="text/x-tmpl"> {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-download fade"> {% if (file.error) { %}
            <td class="name" width="30%">
                <span>{%=file.name%}</span>
            </td>
            <td class="size" width="40%">
                <span>{%=o.formatFileSize(file.size)%}</span>
            </td>
            <td class="error" width="30%" colspan="2">
                <span class="label label-danger">Error</span> {%=file.error%}</td> {% } else { %}
            <td class="name" width="30%">
                <a href="{%=file.url%}" title="{%=file.name%}" data-gallery="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
            </td>
            <td class="size" width="40%">
                <span>{%=o.formatFileSize(file.size)%}</span>
            </td>
            <td colspan="2"></td> {% } %}
            <td class="delete" width="10%" align="right">
                <button class="btn default btn-sm" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}" {% if (file.delete_with_credentials) { %} data-xhr-fields='{"withCredentials":true}' {% } %}>
                    <i class="fa fa-times"></i>
                </button>
            </td>
        </tr> {% } %} </script>-->
    <div class="inbox-compose-btn">
        <a role="button" class="btn green" onclick="guardaTarea()"><i class="fa fa-check"></i>Enviar</a>
        <!--<button class="btn default">Cancelar</button>-->
    </div>
</form>
<script src="assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>

<script>
$(function(){
	$('.fecha').datepicker({
	    orientation: "left",
	    autoclose: true,
	    format: 'yyyy-mm-dd',
	    language: 'es'
	});
});
function guardaTarea(){
	$('#msg_error').hide('Fast');
	App.blockUI(
		{
            message: 'Enviando...'
        }
	);

	var datos=$('#frm_guarda').serialize();
	$.post('ac/nueva_tarea.php',datos,function(data){
	    if(data==1){
			window.open("?Modulo=Tareas", "_self");
	    }else{
			$('#msg_error').html(data);
			$('#msg_error').show('Fast');
			App.unblockUI();
	    }
	});
}
</script>