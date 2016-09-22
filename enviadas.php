<?
$sql = "SELECT tareas.*, usuarios.nombre FROM tareas JOIN usuarios ON tareas.id_destino = usuarios.id_usuario WHERE id_remite = $s_id_usuario AND tareas.activo = 1 AND terminado_creador = 0 AND terminado_destino = 0 ORDER BY leido ASC, fecha_limite ASC";
$q = mysql_query($sql);

$tareas = array();

while($datos = mysql_fetch_object($q)):
	$tareas[] = $datos;

endwhile; 
?>

<div class="col-md-9">
	<div class="inbox-body">
	    <div class="inbox-header">
	        <h1 class="pull-left">Enviadas</h1>
	        
	    </div>
	    <div class="inbox-content">
		    
			<table class="table table-striped table-advance table-hover">
			    <thead>
			        <tr>
			            <th colspan="3">
			
			            </th>
			            <th class="pagination-control" colspan="3">
			                <div class="btn-group input-actions">
			                    <a class="btn btn-sm blue btn-outline dropdown-toggle sbold" href="javascript:;" data-toggle="dropdown"> Filtrar
			                        <i class="fa fa-angle-down"></i>
			                    </a>
			                    <ul class="dropdown-menu">
			                        <li>
			                            <a href="?Modulo=Tareas&tipo=enviadas&f=completadas">
			                                <i class="fa fa-check"></i> Ver Completadas </a>
			                        </li>

			                    </ul>
			                </div>
			            </th>
			        </tr>
			    </thead>
			    <tbody>
				    
				    
			<? foreach($tareas as $tarea): 
			
				if($tarea->leido == '0'): $l = 'unread'; $estrella = '<i class="fa fa-star"></i>'; else: $l = ''; $estrella = ''; endif;

				$fecha = $tarea->fecha_limite;
			
				if($fecha==date('Y-m-d')):
					$mostrar_fecha = 'Hoy';
				else:
					$mostrar_fecha = fechaLetraAlt($fecha);
				endif;
							
			
				switch($tarea->prioridad):
				case '1':
					$prioridad = 'BAJA';
					$class = 'success';
				break;
				case '2':
					$prioridad = 'MEDIA';
					$class = 'warning';
				break;
				case '3':
					$prioridad = 'ALTA';
					$class = 'danger';
				break;
				endswitch; 
			?>
			
			        <tr class="<?= $l ?>" data-messageid="1">
			            <td class="inbox-small-cells">
			            </td>
			            <td class="inbox-small-cells">
			                <?= $estrella ?>
			            </td>
			            <td class="view-message hidden-xs"> 
				            <?= mayus($tarea->nombre) ?>
						</td>
			            <td class="view-message "> 
				            <?= $tarea->asunto ?>
			            </td>
			            <td class="view-message inbox-small-cells">
			                 <span class="badge badge-<?= $class ?>">
			                 	<?= $prioridad ?>
			                 </span>
			            </td>
			            <td class="view-message text-right"> 
				            <?= $mostrar_fecha ?> 
				        </td>
			        </tr>
			
			
			<? endforeach; ?>
			         
			    </tbody>
			</table>
		    
	    </div>
	</div>
</div>
