<?
$sql="SELECT * FROM productos_categorias ORDER BY categoria ASC";
$q=mysql_query($sql);
$val=mysql_num_rows($q);
?>
<style>
.oculto{
	display: none;
}
.link{
	cursor: pointer;
}
</style>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<!-- Confirmación -->
			  <? if($_GET['msg']==1){ ?>
			  		<br>
			  		<div class="alert alert-dismissable alert-success">
				  		<button type="button" class="close" data-dismiss="alert">×</button>
				  		<p>La categoría se ha agregado</p>
				  	</div>
			  <? }if($_GET['msg']==2){ ?>
			  		<br>
			  		<div class="alert alert-dismissable alert-info">
				  		<button type="button" class="close" data-dismiss="alert">×</button>
				  		<p>La categoría se ha editado</p>
				  	</div>
			  <? } ?>
			  <!-- Contenido -->
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light  portlet-fit">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-grid font-dark"></i>
						<span class="caption-subject font-dark bold uppercase">Categorías</span>
					</div>
					<div class="actions btn-set">
						<a href="javascript:;" class="btn btn-sm blue " data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#NuevaCategoria"><i class="fa fa-plus"></i> Agregar Categoría </a>
					</div>
				</div>
				<div class="portlet-body">
					<? if($val): ?>
					<table class="table table-striped table-bordered table-hover">
						<thead>
					        <tr>
					          <th>Nombre</th>

					          <th width="180"></th>
					        </tr>
					      </thead>
					      <tbody>
					      <? while($ft=mysql_fetch_assoc($q)){ ?>
					        <tr>
					          <td><?=$ft['categoria']?></td>
					          <td align="right">
					          		<img src="assets/global/img/loading-spinner-grey.gif" border="0" id="load_<?=$ft['id_producto_categoria']?>" width="19" class="oculto" />
					          	<? if($ft['activo']==1){ ?>
					          		<span class="label label-success link btn_<?=$ft['id_producto_categoria']?>" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#EditaCategoria" data-id="<?=$ft['id_producto_categoria']?>">Editar</span> &nbsp; &nbsp; 
					          		<span class="label label-danger link btn_<?=$ft['id_producto_categoria']?>" onclick="javascript:Desactiva(<?=$ft['id_producto_categoria']?>)">Desactivar</span>
					          	<? }else{ ?>
					          		<span class="label label-warning link btn_<?=$ft['id_producto_categoria']?>" onclick="javascript:Activa(<?=$ft['id_producto_categoria']?>)">Activar</span>
					          	<? } ?>
					          </td>
					        </tr>
					      <? } ?>
					      </tbody>
					</table>
					<? else: ?>
					<div class="alert alert-dismissable alert-warning">
				  		<p>Aún no se han creado <b>Categorías</b></p>
				  	</div>
					<? endif ?>
				</div>
			</div>
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
	</div>
</div>













<!-- Modal -->
<div class="modal fade" id="NuevaCategoria">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
        <h4 class="modal-title">Nueva Categoría</h4>
      </div>
      <div class="modal-body">
      	<div class="alert alert-danger oculto" role="alert" id="msg_error"></div>
<!--Formulario -->
		<form id="frm_guarda" class="form-horizontal">
			
			<div class="form-group">
				<label for="nombre" class="col-md-4 control-label">Nombre de la Categoría</label>
				<div class="col-md-8">
					<input type="text" maxlength="64" class="form-control dat" name="nombre" id="nuevo_nombre" autocomplete="off">
				</div>
			</div>
		</form>
		      
      </div>
      <div class="modal-footer">
      	<img src="assets/global/img/loading-spinner-grey.gif" border="0" id="load" width="25" class="oculto" />
        <button type="button" class="btn btn-default btn_ac" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success btn_ac" onclick="NuevaCategoria()">Guardar Categoría</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->




<!-- Modal -->
<div class="modal fade" id="EditaCategoria">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
        <h4 class="modal-title">Edita Categoría</h4>
      </div>
      <div class="modal-body">
      	<div class="alert alert-danger oculto" role="alert" id="msg_error2"></div>
<!-- Loader -->
		<div class="row oculto" id="load_big">
			<div class="col-md-12 text-center" >
				<img src="assets/global/img/ajax-loading.gif" border="0"  />
			</div>
		</div>
<!--Formulario -->
		<form id="frm_edita" class="form-horizontal">
			
			<div class="form-group">
				<label for="nombre" class="col-md-4 control-label">Nombre de la Categoría</label>
				<div class="col-md-8">
					<input type="text" maxlength="64" class="form-control edit" id="nombre" name="nombre" autocomplete="off">
				</div>
			</div>
			
			<input type="hidden" name="id_producto_categoria" id="id_producto_categoria" />
		</form>
		      
      </div>
      <div class="modal-footer">      	
      	<img src="assets/global/img/loading-spinner-grey.gif" border="0" id="load2" width="25" class="oculto" />
        <button type="button" class="btn btn-default btn_ac btn-modal" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success btn_ac btn-modal" onclick="EditaCategoria()">Actualizar Categoría</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script src="js/dropzone.js"></script>		    
		    
<!--- Js -->
<script>
$(function(){
	$(document).on('click', '[data-id]', function () {
		$('.edit').val("");
		$('.btn-modal').hide();
		$('#frm_edita').hide();
		$('#load_big').show();
	    var data_id = $(this).attr('data-id');
	    $.ajax({
	   	url: "data/categorias.php",
	   	data: 'id='+data_id,
	   	success: function(data){
	   		$('#nombre').val(data);
	   		$('#id_producto_categoria').val(data_id);
	   		
	   		$('#load_big').hide();
	   		$('#frm_edita').show();
	   		$('.btn-modal').show();
	  	
	   	},
	   	cache: false
	   });
	});
	
	
	$('#NuevaCategoria').on('shown.bs.modal',function(e){
		$('#nuevo_nombre').focus();
	});
	
	$('#NuevaCategoria').on('hidden.bs.modal',function(e){
		$('#id_tipo_usuario').val("0");
		$('.dat').val("");
		$('#msg_error2').hide();
		$('#msg_error').hide();
		$('#ver_permisos').hide();
	});
	
	$('#EditaCategoria').on('hidden.bs.modal',function(e){
		$('.edit').val("");
		$('#msg_error2').hide();
		$('#msg_error').hide();
	});
	
	//DROPZONE
    $("#upload_dropzone").dropzone({ 
        url: "upload_foto.php",
        paramName: "archivo",
        maxFiles: 1,
        maxFilesize: 10,
        acceptedFiles: "image/jpg,image/jpeg,image/png",
        dictDefaultMessage: "<a class='btn btn-circle btn-info btn-sm'>Arrastre o de Clic para cambiar la foto</a><br><p><i>Solo imagenes en formato jpg o png</i></p>",
        dictInvalidFileType: "No puede subir este tipo de archivo, seleccione uno válido",
        dictFileTooBig: "El tamaño del archivo excede el permitido (10 Mb)",
        dictMaxFilesExceeded:"Solo puede subir una imagen a la vez",
        addRemoveLinks: true,
        dictRemoveFile: "Eliminar Archivo",
        dictCancelUpload: "Cancela",
        success: function (file, response) {
            var imgName = response;
            //$('.fotos').hide();
            $('#foto-usuario').remove();
            //$('#foto-usuario').attr('src',imgName);
            setTimeout(function(){ $('#fotos').append('<input type="hidden" value="'+imgName+'" name="foto_final" id="foto-usuario">'); }, 1000);         
        }});

	//DROPZONE
    $("#upload_dropzone_2").dropzone({ 
        url: "upload_foto.php",
        paramName: "archivo",
        maxFiles: 1,
        maxFilesize: 10,
        acceptedFiles: "image/jpg,image/jpeg,image/png",
        dictDefaultMessage: "<a class='btn btn-circle btn-info btn-sm'>Arrastre o de Clic para cambiar la foto</a><br><p><i>Solo imagenes en formato jpg o png</i></p>",
        dictInvalidFileType: "No puede subir este tipo de archivo, seleccione uno válido",
        dictFileTooBig: "El tamaño del archivo excede el permitido (10 Mb)",
        dictMaxFilesExceeded:"Solo puede subir una imagen a la vez",
        addRemoveLinks: true,
        dictRemoveFile: "Eliminar Archivo",
        dictCancelUpload: "Cancela",
        success: function (file, response) {
            var imgName = response;
            $('#foto_edita').remove();
            $('#foto-usuario-edita').remove();
            //$('#foto-usuario').attr('src',imgName);
            setTimeout(function(){ $('#fotos2').append('<input type="hidden" value="'+imgName+'" name="foto_final" id="foto-usuario-edita">'); }, 1000);         
        }});

});

function EditaCategoria(){
	$('#msg_error2').hide('Fast');
	$('.btn_ac').hide();
	$('#load2').show();
	var datos=$('#frm_edita').serialize();
	$.post('ac/edita_categoria.php',datos,function(data){
	    if(data==1){
			window.open("?Modulo=Categorias&msg=2", "_self");
	    }else{
	    	$('#load2').hide();
			$('.btn').show();
			$('#msg_error2').html(data);
			$('#msg_error2').show('Fast');
	    }
	});
}
function Desactiva(id){
	$(".btn_"+id+"").hide();
	$("#load_"+id+"").show();
	$.post('ac/activa_desactiva_categoria.php', { tipo: "0", id_producto_categoria: ""+id+"" },function(data){
		if(data==1){
			window.open("?Modulo=Categorias", "_self");
		}else{
			$("#load_"+id+"").hide();
			$(".btn_"+id+"").show();
			alert(data);
		}
	});
}
function Activa(id){
	$(".btn_"+id+"").hide();
	$("#load_"+id+"").show();
	$.post('ac/activa_desactiva_categoria.php', { tipo: "1", id_producto_categoria: ""+id+"" },function(data){
		if(data==1){
			window.open("?Modulo=Categorias", "_self");
		}else{
			$("#load_"+id+"").hide();
			$(".btn_"+id+"").show();
			alert(data);
		}
	});
}
function NuevaCategoria(){
	$('#msg_error').hide('Fast');
	$('.btn_ac').hide();
	$('#load').show();
	var datos=$('#frm_guarda').serialize();
	$.post('ac/nueva_categoria.php',datos,function(data){
	    if(data==1){
			window.open("?Modulo=Categorias&msg=1", "_self");
	    }else{
	    	$('#load').hide();
			$('.btn').show();
			$('#msg_error').html(data);
			$('#msg_error').show('Fast');
	    }
	});
}
</script>