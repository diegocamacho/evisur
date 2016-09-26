<?
$sql="SELECT * FROM usuarios 
JOIN tipo_usuario ON tipo_usuario.id_tipo_usuario=usuarios.id_tipo_usuario
ORDER BY usuarios.nombre ASC";
$q=mysql_query($sql);

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
			
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light  portlet-fit">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-users font-dark"></i>
						<span class="caption-subject font-dark bold uppercase">Reporte de Tareas por Usuario</span>
					</div>
					<div class="actions btn-set">
						
					</div>
				</div>
				<div class="portlet-body">
					<table class="table table-striped table-bordered table-hover">
						<thead>
					        <tr>
					          <th>Nombre</th>
					          <th>Tipo</th>
					          <th>Celular</th>
					          <th>Email</th>
					          <th>Último Acceso</th>
					          <th width="180"></th>
					        </tr>
					      </thead>
					      <tbody>
					      <? while($ft=mysql_fetch_assoc($q)){ ?>
					        <tr>
					          <td><?=$ft['nombre']?></td>
					          <td><?=$ft['tipo_usuario']?></td>
					          <td><?=$ft['celular']?></td>
					          <td><?=$ft['email']?></td>
					          <td><? if($ft['ultimo_acceso']){ echo devuelveFechaHora($ft['ultimo_acceso']); }else{ echo "NUNCA"; }?></td>
					          <td align="right">
					          	<a role="button" class="btn btn-success btn-xs" href="formatos/reporte_tareas.php?id=<?=$ft['id_usuario']?>" target="_blank">Ver Reporte</a>
					          </td>
					        </tr>
					      <? } ?>
					      </tbody>
					</table>
				</div>
			</div>
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
	</div>
</div>