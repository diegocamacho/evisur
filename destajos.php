<?
$id_prototipo=$_GET['id'];
$sql="SELECT * FROM categorias_mano_obra ORDER BY orden ASC ";
$q=mysql_query($sql);

$categorias = array();

while($datos=mysql_fetch_object($q)):
	$categorias[] = $datos;
endwhile;

$sq="SELECT * FROM prototipos WHERE id_prototipo=$id_prototipo";
$q=mysql_query($sq);
$ft=mysql_fetch_assoc($q);
$prototipo=$ft['prototipo'];
?>
<style>
.oculto{
	display: none;
}
.link{
	cursor: pointer;
}
</style>

<div class="container" id="contenido">
	<div class="row">
		<div class="col-md-12">
			<!-- Confirmación -->
			  <? if($_GET['msg']==1){ ?>
			  		<br>
			  		<div class="alert alert-dismissable alert-success">
				  		<button type="button" class="close" data-dismiss="alert">×</button>
				  		<p>El destajo se actualizó</p>
				  	</div>
			  <? } ?>
			  <!-- Contenido -->
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light  portlet-fit">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-map font-dark"></i>
						<span class="caption-subject font-dark bold uppercase">Mano de obra de prototipo: <?= $prototipo ?></span>
					</div>
					<div class="actions btn-set">
						<!--<a href="javascript:;" class="btn btn-sm blue " data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#NuevoPrototipo"><i class="fa fa-plus"></i> Agregar prototipo </a>-->
					</div>
				</div>
				<div class="portlet-body">
					
					<form id="frm_guarda">
					<div class="alert alert-danger oculto" role="alert" id="msg_error"></div>
					
					<div class="panel-group accordion scrollable" id="accordion2">
                        <? foreach($categorias as $categoria): 
								$id_categoria=$categoria->id_categoria_mo;
                        ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#muestra_<?=$categoria->id_categoria_mo?>"> <?=$categoria->categoria?> (<?=$categoria->codigo?>)
                                    <small style="float: right;font-size: 16px;" id="muestra_total_<?=$id_categoria?>"></small></a>
                                </h4>
                            </div>
                            <div id="muestra_<?=$categoria->id_categoria_mo?>" class="panel-collapse collapse">
                                <div class="panel-body">
	                                <?
		                              $sq="SELECT * FROM productos_mano_obra WHERE id_categoria_mo=$id_categoria";
		                              $q=mysql_query($sq);
		                              
		                              $productos = array();
		                              
		                              while($ft=mysql_fetch_object($q)):
			                          	$productos[]=$ft;   
			                          endwhile;
			                          unset($total_presupuesto);
	                                ?>
	                                
                                    	<table class="table table-striped table-bordered table-hover">
											<thead>
										        <tr>
											        <th width="40"></th>
											        <th width="120">Código</th>
													<th>Prototipo</th>
													<th width="100">Cantidad</th>
													<th width="100">Precio</th>
										        </tr>
										      </thead>
										      <tbody>
										      <? foreach($productos as $producto): 
											      $id_producto_mo=$producto->id_productos_mo;
											      $sq="SELECT * FROM prototipos_mano_obra WHERE id_producto_mo=$id_producto_mo AND id_prototipo=$id_prototipo";
											      $q=mysql_query($sq);
											      $dat=mysql_fetch_assoc($q);
											      $val=mysql_num_rows($q);
											      
											      $checked=($val) ? 'checked="checked"' : '';
											      $total_presupuesto+=$dat['cantidad']*$dat['precio_unitario'];
										      ?>
										        <tr>
											        <td style="text-align: center;">
												        <label class="mt-checkbox mt-checkbox-outline ">
												        	<input type="checkbox" <?= $checked ?> name="activo[<?= $producto->id_productos_mo ?>]"  />
												        <span>
												    </td>
												    <td><?= $producto->codigo ?></td>
										          	<td><?= $producto->descripcion ?></td>
										          	<td><div class="form-group"><input type="text" class="form-control input-xsmall" placeholder="Cant." name="cantidad[<?= $id_producto_mo ?>]" value="<?= $dat['cantidad'] ?>"> </div></td>
										          	<td><div class="form-group"><input type="text" class="form-control input-xsmall" placeholder="Precio" name="precio[<?= $id_producto_mo ?>]" value="<?= $dat['precio_unitario'] ?>"> </div></td>
										        </tr>
										      <? endforeach; ?>
										      <script>
											  $(function() {
											  		$('#muestra_total_<?=$id_categoria?>').html('Total: <?=number_format($total_presupuesto,2)?>');
											  });
											  
											      
											  </script>
										      </tbody>
										</table>
										
									
									
                                </div>
                            </div>
                        </div>
                        <?
	                        
	                        unset($total_presupuesto);
	                        
	                         endforeach; ?>
                    </div>
                    <div class="row">
						<div class="col-md-12" style="text-align: right;">
							<button type="button" class="btn btn-success btn_ac" onclick="Guarda(<?=$id_categoria?>)">Guardar</button>
						</div>
					</div>
					<input type="hidden" name="id_prototipo" value="<?=$id_prototipo?>" />
                    </form>
                    
				</div>
			</div>
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
	</div>
</div>



<!--- Js -->
<script>
$(function(){
	var total = $('#total_presupuesto').val();
	$('#muestra_total').html(total);
});
function Guarda(){
	App.blockUI(
		{
            boxed: true,
            message: 'Guardando...'
        }
	);
	var datos=$('#frm_guarda').serialize();
	$.post('ac/guarda_prototipo_mano.php',datos,function(data){
	    if(data==1){
		    App.unblockUI();
		    window.open("?Modulo=Destajos&id=<?=$id_prototipo?>&msg=1", "_self");
	    }else{
	    	App.unblockUI();
			$('#msg_error').html(data);
			$('#msg_error').show('Fast');
	    }
	});
}

</script>