<?
$sql="SELECT * FROM casas 
JOIN prototipos ON prototipos.id_prototipo=casas.id_prototipo
JOIN proyectos ON proyectos.id_proyecto=casas.id_proyecto
ORDER BY proyecto ASC";
$q=mysql_query($sql);

$casas = array();

while($datos=mysql_fetch_object($q)):
	$casas[] = $datos;
endwhile;
$val=count($casas);


//Prototipos
$sq="SELECT * FROM prototipos WHERE activo=1";
$q=mysql_query($sq);
$prototipos = array();

while($datos=mysql_fetch_object($q)):
	$prototipos[] = $datos;
endwhile;

//Proyectos
$sq="SELECT * FROM proyectos WHERE activo=1";
$q=mysql_query($sq);
$proyectos = array();

while($datos=mysql_fetch_object($q)):
	$proyectos[] = $datos;
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
			  <? if($_GET['msg']==1){ ?>
			  		<br>
			  		<div class="alert alert-dismissable alert-success">
				  		<button type="button" class="close" data-dismiss="alert">×</button>
				  		<p>La casa se ha agregado</p>
				  	</div>
			  <? }if($_GET['msg']==2){ ?>
			  		<br>
			  		<div class="alert alert-dismissable alert-info">
				  		<button type="button" class="close" data-dismiss="alert">×</button>
				  		<p>La casa se ha editado</p>
				  	</div>
			  <? } ?>
			  <!-- Contenido -->
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light  portlet-fit">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-home font-dark"></i>
						<span class="caption-subject font-dark bold uppercase">Casas</span>
					</div>
					<div class="actions btn-set">
						<a href="javascript:;" class="btn btn-sm blue " data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#NuevaCasa"><i class="fa fa-plus"></i> Agregar casa</a>
					</div>
				</div>
				<div class="portlet-body">
					<? if($val>0): ?>
					<!--<div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <button id="sample_editable_1_new" class="btn sbold green"> Add New
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="btn-group pull-right">
                                    <button class="btn green  btn-outline dropdown-toggle" data-toggle="dropdown">Tools
                                        <i class="fa fa-angle-down"></i>
                                    </button>
                                    <ul class="dropdown-menu pull-right">
                                        <li>
                                            <a href="javascript:;">
                                                <i class="fa fa-print"></i> Print </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <i class="fa fa-file-pdf-o"></i> Save as PDF </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <i class="fa fa-file-excel-o"></i> Export to Excel </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>-->
					<table class="table table-striped table-bordered table-hover order-column" id="tabla_casas">
						<thead>
					        <tr>
					          <th>Proyecto</th>
					          <th>Prototipo</th>
					          <th>Calle</th>
					          <th>Manzana</th>
					          <th>Lote</th>
					          <th>Número</th>
					          <th width="140"></th>
					        </tr>
					      </thead>
					      <tbody>
					      <? foreach($casas as $casa): ?>
					        <tr>
					          <td><?=$casa->proyecto?></td>
					          <td><?=$casa->prototipo?></td>
					          <td><?=$casa->calle?></td>
					          <td><?=$casa->manzana?></td>
					          <td><?=$casa->lote?></td>
					          <td><?=$casa->numero?></td>
					          <td align="right">
					          		<img src="assets/global/img/loading-spinner-grey.gif" border="0" id="load_<?=$casa->id_casa?>" width="19" class="oculto" />
					          	<? if($casa->activo==1): ?>
					          		<span class="label label-success link btn_<?=$casa->id_casa?>" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#EditaCasa" data-id="<?=$casa->id_casa?>">Editar</span> &nbsp; &nbsp; 
					          		<span class="label label-danger link btn_<?=$casa->id_casa?>" onclick="javascript:Desactiva(<?=$casa->id_casa?>)">Desactivar</span>
					          	<? else: ?>
					          		<span class="label label-warning link btn_<?=$casa->id_casa?>" onclick="javascript:Activa(<?=$casa->id_casa?>)">Activar</span>
					          	<? endif; ?>
					          </td>
					        </tr>
					      <? endforeach; ?>
					      </tbody>
					</table>
					<? else: ?>
					<div class="alert alert-dismissable alert-warning">
				  		<button type="button" class="close" data-dismiss="alert">×</button>
				  		<p>Aún no se han creado casas</p>
				  	</div>
					<? endif; ?>
				</div>
			</div>
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
	</div>
</div>













<!-- Modal -->
<div class="modal fade" id="NuevaCasa">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
        <h4 class="modal-title">Nueva Casa</h4>
      </div>
      <div class="modal-body">
      	<div class="alert alert-danger oculto" role="alert" id="msg_error"></div>
<!--Formulario -->
		<form id="frm_guarda" class="form-horizontal">
			
			<div class="form-group">
				<label for="nombre" class="col-md-3 control-label">Prototipo</label>
				<div class="col-md-9">
					<select class="form-control" name="id_prototipo" id="id_prototipo2" >
                    	<option value="0">Seleccione uno</option>
                    	<? foreach($prototipos as $prototipo): ?>
						<option value="<?=$prototipo->id_prototipo?>"><?=$prototipo->prototipo?></option>
						<? endforeach ?>
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label for="nombre" class="col-md-3 control-label">Proyecto</label>
				<div class="col-md-9">
					<select class="form-control" name="id_proyecto" id="id_proyecto2" >
                    	<option value="0">Seleccione uno</option>
                    	<? foreach($proyectos as $proyecto): ?>
						<option value="<?=$proyecto->id_proyecto?>"><?=$proyecto->proyecto?></option>
						<? endforeach ?>
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label for="nombre" class="col-md-3 control-label">Manzana</label>
				<div class="col-md-9">
					<input type="text" maxlength="64" class="form-control dat" name="manzana" autocomplete="off">
				</div>
			</div>
			
			<div class="form-group">
				<label for="nombre" class="col-md-3 control-label">Lote</label>
				<div class="col-md-9">
					<input type="text" maxlength="64" class="form-control dat" name="lote"  autocomplete="off">
				</div>
			</div>
			
			<div class="form-group">
				<label for="nombre" class="col-md-3 control-label">Calle</label>
				<div class="col-md-9">
					<input type="text" maxlength="64" class="form-control dat" name="calle" autocomplete="off">
				</div>
			</div>
			
			<div class="form-group">
				<label for="nombre" class="col-md-3 control-label">Número</label>
				<div class="col-md-9">
					<input type="text" maxlength="64" class="form-control dat" name="numero" autocomplete="off">
				</div>
			</div>

		</form>
		      
      </div>
      <div class="modal-footer">
      	<img src="assets/global/img/loading-spinner-grey.gif" border="0" id="load" width="25" class="oculto" />
        <button type="button" class="btn btn-default btn_ac" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success btn_ac" onclick="NuevaCasa()">Guardar Casa</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->




<!-- Modal -->
<div class="modal fade" id="EditaCasa">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
        <h4 class="modal-title">Edita Casa</h4>
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
				<label for="nombre" class="col-md-3 control-label">Prototipo</label>
				<div class="col-md-9">
					<select class="form-control" name="id_prototipo" id="id_prototipo" >
                    	<option value="0">Seleccione uno</option>
                    	<? foreach($prototipos as $prototipo): ?>
						<option value="<?=$prototipo->id_prototipo?>"><?=$prototipo->prototipo?></option>
						<? endforeach ?>
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label for="nombre" class="col-md-3 control-label">Proyecto</label>
				<div class="col-md-9">
					<select class="form-control" name="id_proyecto" id="id_proyecto" >
                    	<option value="0">Seleccione uno</option>
                    	<? foreach($proyectos as $proyecto): ?>
						<option value="<?=$proyecto->id_proyecto?>"><?=$proyecto->proyecto?></option>
						<? endforeach ?>
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label for="nombre" class="col-md-3 control-label">Manzana</label>
				<div class="col-md-9">
					<input type="text" maxlength="64" class="form-control edit" name="manzana" id="manzana" autocomplete="off">
				</div>
			</div>
			
			<div class="form-group">
				<label for="nombre" class="col-md-3 control-label">Lote</label>
				<div class="col-md-9">
					<input type="text" maxlength="64" class="form-control edit" name="lote" id="lote"  autocomplete="off">
				</div>
			</div>
			
			<div class="form-group">
				<label for="nombre" class="col-md-3 control-label">Calle</label>
				<div class="col-md-9">
					<input type="text" maxlength="64" class="form-control edit" name="calle" id="calle" autocomplete="off">
				</div>
			</div>
			
			<div class="form-group">
				<label for="nombre" class="col-md-3 control-label">Número</label>
				<div class="col-md-9">
					<input type="text" maxlength="64" class="form-control edit" name="numero" id="numero" autocomplete="off">
				</div>
			</div>
			
			<input type="hidden" name="id_casa" id="id_casa" />
		</form>
		      
      </div>
      <div class="modal-footer">      	
      	<img src="assets/global/img/loading-spinner-grey.gif" border="0" id="load2" width="25" class="oculto" />
        <button type="button" class="btn btn-default btn_ac btn-modal" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success btn_ac btn-modal" onclick="EditaCasa()">Actualizar Casa</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



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
	   	url: "data/casas.php",
	   	data: 'id_casa='+data_id,
	   	success: function(data){
	   		var datos = data.split('|');
	   		var id_prototipo=datos[0];
	   		var id_proyecto=datos[1];
	   		var manzana=datos[2];
	   		var lote=datos[3];
	   		var calle=datos[4];
	   		var numero=datos[5];
	   		
	   		$('#id_prototipo').val(id_prototipo);
	   		$('#id_proyecto').val(id_proyecto);
	   		$('#manzana').val(manzana);
	   		$('#lote').val(lote);
	   		$('#calle').val(calle);
	   		$('#numero').val(numero);
	   		$('#id_casa').val(data_id);
	   		
	   		
	   		$('#load_big').hide();
	   		$('#frm_edita').show();
	   		$('.btn-modal').show();
	  	
	   	},
	   	cache: false
	   });
	});
	
	$('#NuevaCasa').on('shown.bs.modal',function(e){
		//$('#nuevo_nombre').focus();
	});
	
	$('#NuevaCasa').on('hidden.bs.modal',function(e){
		$('#id_prototipo2').val("0");
		$('#id_proyecto2').val("0");
		$('.dat').val("");
		$('#msg_error2').hide();
		$('#msg_error').hide();
	});
	
	$('#EditaCasa').on('hidden.bs.modal',function(e){
		$('#id_prototipo').val("0");
		$('#id_proyecto').val("0");
		$('.edit').val("");
		$('#msg_error2').hide();
		$('#msg_error').hide();
	});
	
	$('form').submit(function(e){
		e.preventDefault();	
	});
});

function EditaCasa(){
	$('#msg_error2').hide('Fast');
	$('.btn_ac').hide();
	$('#load2').show();
	var datos=$('#frm_edita').serialize();
	$.post('ac/edita_casa.php',datos,function(data){
	    if(data==1){
			window.open("?Modulo=Casas&msg=2", "_self");
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
	$.post('ac/activa_desactiva_casa.php', { tipo: "0", id_prototipo: ""+id+"" },function(data){
		if(data==1){
			window.open("?Modulo=Casas", "_self");
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
	$.post('ac/activa_desactiva_casa.php', { tipo: "1", id_prototipo: ""+id+"" },function(data){
		if(data==1){
			window.open("?Modulo=Casas", "_self");
		}else{
			$("#load_"+id+"").hide();
			$(".btn_"+id+"").show();
			alert(data);
		}
	});
}
function NuevaCasa(){
	$('#msg_error').hide('Fast');
	$('.btn_ac').hide();
	$('#load').show();
	var datos=$('#frm_guarda').serialize();
	$.post('ac/nueva_casa.php',datos,function(data){
	    if(data==1){
			window.open("?Modulo=Casas&msg=1", "_self");
	    }else{
	    	$('#load').hide();
			$('.btn').show();
			$('#msg_error').html(data);
			$('#msg_error').show('Fast');
	    }
	});
}
</script>