<? 
include('includes/session.php');
include('includes/db.php'); 
include('includes/funciones.php');

$id = $_GET['id_usuario'];

if($id>0):
	$id_usuario = $id;
endif;
?>
<div class="alert alert-danger " style="display: none;" role="alert" id="msg_error"></div>
<form class="inbox-compose form-horizontal" id="fileupload" action="#" method="POST" enctype="multipart/form-data">

    <div class="inbox-form-group">
        <label class="control-label" style="width: 120px;">Asunto:</label>
        <div class="controls" style="margin-left: 125px;">
	        <input type="text" class="form-control" name="asunto" autofocus id="asunto" autocomplete="off">
	    </div>
    </div>
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
				<option selected disabled>Seleccione un usuario</option>
				<?
					$sq="SELECT * FROM usuarios WHERE activo=1 AND id_usuario !=$s_id_usuario ORDER BY nombre ASC";
					$q=mysql_query($sq);
					while($datos=mysql_fetch_assoc($q)):
					
						if($id_usuario==$datos['id_usuario']):
							$s = 'selected="selected"';
						else:
							unset($s);
						endif;
					
				?>
				<option <?= $s ?> value="<?=$datos['id_usuario']?>"><?=$datos['nombre']?></option>
				<? endwhile; ?>
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
	        <input class="form-control fecha" name="fecha_limite" type="text" autocomplete="off" />
	    </div>
    </div>

    
    <div class="inbox-form-group">
        <textarea class="inbox-editor  form-control" name="mensaje" rows="12" placeholder="Descripción de la tarea"></textarea>
    </div>

    <div class="inbox-compose-attachment">
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <span class="btn green btn-outline fileinput-button">
            <i class="fa fa-plus"></i>
            <span> Agregar archivos... </span>
            <input type="file" name="files[]" multiple> </span>
        <!-- The table listing the files available for upload/download -->
        <table role="presentation" class="table table-striped margin-top-10">
            <tbody class="files"> </tbody>
        </table>
    </div>
      
    <!-- The blueimp Gallery widget -->
	<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
	    <div class="slides"> </div>
	    <h3 class="title"></h3>
	    <a class="prev"> ‹ </a>
	    <a class="next"> › </a>
	    <a class="close white"> </a>
	    <a class="play-pause"> </a>
	    <ol class="indicator"> </ol>
	</div>
    <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
    <script id="template-upload" type="text/x-tmpl"> {% for (var i=0, file; file=o.files[i]; i++) { %}
    	<tr class="template-upload fade">
		    <td width="100">
		        <span class="preview"></span>
		    </td>
		    <td align="left" valign="top">
		        {%=file.name%}
		        <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
		            <div class="progress-bar progress-bar-success" style="width:0%;"></div>
		        </div>
		        <strong class="error text-danger label label-danger"></strong>
		        
		    </td>
		    <td width="150">
		        <p class="size">Processing...</p>
		    </td>
		    <td align="right" width="100"> {% if (!i && !o.options.autoUpload) { %}
		        <button class="btn blue start" disabled>
		            <i class="fa fa-upload"></i>
		            <span>Subir</span>
		        </button> {% } %} {% if (!i) { %}
		        <button class="btn red cancel">
		            <i class="fa fa-ban"></i>
		            <span>Cancelar</span>
		        </button> {% } %} </td>
		</tr> {% } %} </script>
        <!-- The template to display files available for download -->
		<script id="template-download" type="text/x-tmpl"> {% for (var i=0, file; file=o.files[i]; i++) { %}
		    <tr class="template-download fade">
		        <td width="100">
			        <input type="hidden" name="archivos[]" value="{%=file.name%}" />
		            <span class="preview"> {% if (file.thumbnailUrl) { %}
		                <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery>
		                    <img src="{%=file.thumbnailUrl%}">
		                </a> {% } %} </span>
		        </td>
		        <td align="left" valign="top">
		             {% if (file.url) { %}
		                <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl? 'data-gallery': ''%}>{%=file.name%}</a> {% } else { %}
		                <span>{%=file.name%}</span> {% } %}  {% if (file.error) { %}
		            <div>
		                <span class="label label-danger">Error</span> {%=file.error%}</div> {% } %} </td>
		        <td width="150">
		            <span class="size" style="margin-top: 0px;">{%=o.formatFileSize(file.size)%}</span>
		        </td>
		        <td width="100" align="right"> {% if (file.deleteUrl) { %}
		            <button class="btn red delete btn-sm" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}" {% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'
		                {% } %}>
		                <i class="fa fa-trash-o"></i>
		                <span>Borrar</span>
		            </button>
		            {% } else { %}
		            <button class="btn yellow cancel btn-sm">
		                <i class="fa fa-ban"></i>
		                <span>Cancelar</span>
		            </button> {% } %} </td>
		    </tr> {% } %} </script>


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
	
	var datos=$('#fileupload').serialize();
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