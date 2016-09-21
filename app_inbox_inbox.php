<?
$tipo = $_GET['tipo']; //Recibidas Enviadas;

$sql = "SELECT*FROM tareas WHERE id_destino = $s_id_usuario AND activo = 1 AND terminado_creador = 0 AND terminado_destino = 0 ORDER BY leido ASC, fecha_hora_limite DESC";
$q = mysql_query($sql);
$tareas = array();

while($datos = mysql_fetch_object($q)):
	$tareas[] = $datos;

endwhile;

?>
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
                            <a href="javascript:;">
                                <i class="fa fa-pencil"></i> Ver Pendientes </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                <i class="fa fa-ban"></i> Ver Completadas </a>
                        </li>
                    </ul>
                </div>
            </th>
        </tr>
    </thead>
    <tbody>
	    
	    
<? foreach($tareas as $tarea): 

	$fecha = $tarea->fecha_hora_creacion;
	$fecha = fechaLetraDos(substr($fecha,0,10));

	if($tarea->leido == '0'): $l = 'unread'; $estrella = '<i class="fa fa-star"></i>'; else: $l = ''; $estrella = ''; endif;

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
	            <?= $s_nombre ?>
			</td>
            <td class="view-message "> 
	            <?= $tarea->asunto ?>
            </td>
            <td class="view-message inbox-small-cells">
                 <span class="badge badge-<?=$class?>">
                 	<?=$prioridad?>
                 </span>
            </td>
            <td class="view-message text-right"> 
	            <?=$fecha?> 
	        </td>
        </tr>


<? endforeach; ?>
         
    </tbody>
</table>




