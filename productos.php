<?
$sql="SELECT productos.*,productos_categorias.categoria  FROM productos 
JOIN productos_categorias ON productos_categorias.id_producto_categoria=productos.id_producto_categoria
ORDER BY producto ASC";
$q=mysql_query($sql);

$productos = array();

while($datos=mysql_fetch_object($q)):
	$productos[] = $datos;
endwhile;
$val=count($productos);


$sq="SELECT * FROM productos_categorias WHERE activo=1";
$q=mysql_query($sq);
$categorias = array();

while($datos=mysql_fetch_object($q)):
	$categorias[] = $datos;
endwhile; 
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
			  <? if($_GET['msg']==1): ?>
			  		<br>
			  		<div class="alert alert-dismissable alert-success">
				  		<button type="button" class="close" data-dismiss="alert">×</button>
				  		<p>El prodcuto se ha agregado</p>
				  	</div>
			  <? endif;
				 if($_GET['msg']==2): ?>
			  		<br>
			  		<div class="alert alert-dismissable alert-info">
				  		<button type="button" class="close" data-dismiss="alert">×</button>
				  		<p>El producto se ha editado</p>
				  	</div>
			  <? endif; ?>
			  <!-- Contenido -->
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light  portlet-fit">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-layers font-dark"></i>
						<span class="caption-subject font-dark bold uppercase">Productos</span>
					</div>
					<div class="actions btn-set">
						<a href="javascript:;" class="btn btn-sm blue " data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#NuevoProducto"><i class="fa fa-plus"></i> Agregar producto </a>
					</div>
				</div>
				<div class="portlet-body">
					<? if($val>0): ?>
					<table class="table table-striped table-bordered table-hover order-column" id="tabla_productos">
						<thead>
					        <tr>
					        	<th>Producto</th>
								<th>Categoria</th>
								<th width="180"></th>
					        </tr>
					    </thead>
					    <tbody>
							<? foreach($productos as $producto): ?>
					        <tr>
					        	<td><?=$producto->producto?></td>
								<td><?=$producto->categoria?></td>
								<td align="right">
					          		<img src="assets/global/img/loading-spinner-grey.gif" border="0" id="load_<?=$producto->id_producto?>" width="19" class="oculto" />
					          	<? if($producto->activo==1): ?>
					          		<span class="label label-success link btn_<?=$producto->id_producto?>" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#EditaProducto" data-id="<?=$producto->id_producto?>">Editar</span> &nbsp; &nbsp; 
					          		<span class="label label-danger link btn_<?=$producto->id_producto?>" onclick="javascript:Desactiva(<?=$producto->id_producto?>)">Desactivar</span>
					          	<? else: ?>
					          		<span class="label label-warning link btn_<?=$producto->id_producto?>" onclick="javascript:Activa(<?=$producto->id_producto?>)">Activar</span>
					          	<? endif; ?>
					        	</td>
					        </tr>
							<? endforeach; ?>
					      </tbody>
					</table>
					<? else: ?>
					<div class="alert alert-dismissable alert-warning">
				  		<button type="button" class="close" data-dismiss="alert">×</button>
				  		<p>Aún no se han creado productos</p>
				  	</div>
					<? endif; ?>
				</div>
			</div>
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
	</div>
</div>













<!-- Modal -->
<div class="modal fade" id="NuevoProducto">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
        <h4 class="modal-title">Nuevo Producto</h4>
      </div>
      <div class="modal-body">
      	<div class="alert alert-danger oculto" role="alert" id="msg_error"></div>
<!--Formulario -->
		<form id="frm_guarda" class="form-horizontal">
			
			<div class="form-group">
				<label for="nombre" class="col-md-3 control-label">Producto</label>
				<div class="col-md-9">
					<input type="text" maxlength="64" class="form-control dat" name="producto" id="nuevo_producto" autocomplete="off">
				</div>
			</div>
			
			<div class="form-group">
				<label for="nombre" class="col-md-3 control-label">Categoría</label>
				<div class="col-md-9">
					<select class="form-control" name="id_producto_categoria" id="id_producto_categoria2">
                    	<option value="0">Seleccione una</option>
                    	<? foreach($categorias as $categoria): ?>
						<option value="<?=$categoria->id_producto_categoria?>"><?=$categoria->categoria?></option>
						<? endforeach ?>
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label for="precio_venta" class="col-md-3 control-label">Foto</label>
				<div class="col-md-9" id="fotos">
					<div id="upload_dropzone" class="dropzone" style="border:none; background-color:white"></div>
				</div>
			</div>
			
			

		</form>
		      
      </div>
      <div class="modal-footer">
      	<img src="assets/global/img/loading-spinner-grey.gif" border="0" id="load" width="25" class="oculto" />
        <button type="button" class="btn btn-default btn_ac" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success btn_ac" onclick="NuevoProducto()">Guardar Producto</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->




<!-- Modal -->
<div class="modal fade" id="EditaProducto">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
        <h4 class="modal-title">Edita Producto</h4>
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
				<label for="nombre" class="col-md-3 control-label">Producto</label>
				<div class="col-md-9">
					<input type="text" maxlength="64" class="form-control edit" id="producto" name="producto" autocomplete="off">
				</div>
			</div>
			
			<div class="form-group">
				<label for="nombre" class="col-md-3 control-label">Categoría</label>
				<div class="col-md-9">
					<select class="form-control" name="id_producto_categoria" id="id_producto_categoria">
                    	<option value="0">Seleccione una</option>
                    	<? foreach($categorias as $categoria): ?>
						<option value="<?=$categoria->id_producto_categoria?>"><?=$categoria->categoria?></option>
						<? endforeach ?>
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label for="fotos2" class="col-md-3 control-label">Foto</label>
				<div class="col-md-9" id="fotos2">
					<center><img class="media-object" style="height: 92px;" src="" id="foto_edita"></center>
					<div id="upload_dropzone_2" class="dropzone" style="border:none; background-color:white"></div>
					<input type="hidden" name="foto_final" id="foto-usuario-edita">
				</div>
			</div>
			
			<input type="hidden" name="id_producto" id="id_producto" />
		</form>
		      
      </div>
      <div class="modal-footer">      	
      	<img src="assets/global/img/loading-spinner-grey.gif" border="0" id="load2" width="25" class="oculto" />
        <button type="button" class="btn btn-default btn_ac btn-modal" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success btn_ac btn-modal" onclick="EditaProducto()">Actualizar Producto</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script src="js/dropzone.js"></script>		    
		    
<!--- Js -->
<script>
$(function(){
	$('form').submit(function(e){
		e.preventDefault();	
	});
	
	$(document).on('click', '[data-id]', function () {
		$('.edit').val("");
		$('.btn-modal').hide();
		$('#frm_edita').hide();
		$('#load_big').show();
	    var data_id = $(this).attr('data-id');
	    $.ajax({
	   	url: "data/productos.php",
	   	data: 'id_producto='+data_id,
	   	success: function(data){
	   		var datos = data.split('|');
	   		var id_producto_categoria=datos[0];
	   		var producto=datos[1];
	   		$('#foto_edita').attr('src','files/'+datos[2]);
	   		$('#foto-usuario-edita').val(datos[2]);
	   		
	   		$('#id_producto_categoria').val(id_producto_categoria);
	   		$('#producto').val(producto);
	   		$('#id_producto').val(data_id);
	   		
	   		
	   		$('#load_big').hide();
	   		$('#frm_edita').show();
	   		$('.btn-modal').show();
	  	
	   	},
	   	cache: false
	   });
	});
	
	
	$('#NuevoProducto').on('shown.bs.modal',function(e){
		$('#nuevo_producto').focus();
	});
	
	$('#NuevoProducto').on('hidden.bs.modal',function(e){
		$('#id_producto_categoria2').val("0");
		$('.dat').val("");
		$('#msg_error2').hide();
		$('#msg_error').hide();
		$('#ver_permisos').hide();
	});
	
	$('#EditaProducto').on('hidden.bs.modal',function(e){
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

function EditaProducto(){
	$('#msg_error2').hide('Fast');
	$('.btn_ac').hide();
	$('#load2').show();
	var datos=$('#frm_edita').serialize();
	$.post('ac/edita_producto.php',datos,function(data){
	    if(data==1){
			window.open("?Modulo=Productos&msg=2", "_self");
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
	$.post('ac/activa_desactiva_producto.php', { tipo: "0", id_usuario: ""+id+"" },function(data){
		if(data==1){
			window.open("?Modulo=Productos", "_self");
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
	$.post('ac/activa_desactiva_producto.php', { tipo: "1", id_usuario: ""+id+"" },function(data){
		if(data==1){
			window.open("?Modulo=Productos", "_self");
		}else{
			$("#load_"+id+"").hide();
			$(".btn_"+id+"").show();
			alert(data);
		}
	});
}
function NuevoProducto(){
	$('#msg_error').hide('Fast');
	$('.btn_ac').hide();
	$('#load').show();
	var datos=$('#frm_guarda').serialize();
	$.post('ac/nuevo_producto.php',datos,function(data){
	    if(data==1){
			window.open("?Modulo=Productos&msg=1", "_self");
	    }else{
	    	$('#load').hide();
			$('.btn').show();
			$('#msg_error').html(data);
			$('#msg_error').show('Fast');
	    }
	});
}
</script>