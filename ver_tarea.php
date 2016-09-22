<? 
extract($_GET);


$sql = "
SELECT tareas.*,proyectos.proyecto 
FROM tareas 
LEFT JOIN proyectos ON proyectos.id_proyecto = tareas.id_proyecto
WHERE tareas.id_tarea = $tarea AND (id_remite = $s_id_usuario OR id_destino = $s_id_usuario)
";

$q = mysql_query($sql);
$tarea = mysql_fetch_object($q);

if($tarea->proyecto): 
	$proyecto = '['.$tarea->proyecto.']'; 
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

$fecha_c = $tarea->fecha_hora_creacion;
$fecha_c = explode(' ', $fecha_c);

$hora = substr($fecha_c[1],0,5);
$f_ex = explode('-', $fecha_c[0]);


$dia = $f_ex[2];
$mes = soloMes($f_ex[1]);
$anio = $f_ex[0];

$string_fecha = "$dia de $mes de $anio";

$id_remite = $tarea->id_remite;

$sql = "SELECT*FROM usuarios WHERE id_usuario = $id_remite";
$q = mysql_query($sql);
$remitente = mysql_fetch_object($q);



?>

<style>
.item-label{
color: #96a5aa !important;
font-size: 13px !important;
}
.item-body{
color: #666 !important;
}
</style>
<div class="col-md-9"> 
	<div class="inbox-body">
		<div class="inbox-header inbox-view-header">
			<h1 class="pull-left">
				<?= $proyecto ?> <?= $tarea->asunto ?>
			<span class="badge badge-<?= $class ?>">
				<?= $prioridad ?>
			</span>
			</h1>
			<div class="pull-right">
	        	<!--
		        <a href="javascript:;" class="btn btn-icon-only dark btn-outline"><i class="fa fa-print"></i></a>
				-->
	    	</div>
		</div>


		<div class="inbox-view-info">
		    <div class="row">
		        <div class="col-md-12">
		            <img src="http://localhost/evisur/assets/pages/media/users/avatar6.jpg" class="inbox-author">
		            Por <span class="sbold"><?= mayus($remitente->nombre) ?> </span> · 
		            <span class="sbold"><?= $string_fecha ?></span> a las <?= $hora ?>
		        </div>
		    </div>
		</div>

		<div class="inbox-view">
			<div class="alert alert-info">
				Fecha de Entrega: </strong> 13 de Octubre de 2016 (en 16 días)
			</div>                                                            
		    <p style="font-size: 16px;line-height: 30px"><?= $tarea->descripcion ?> 
		    </p>
		</div>

		<hr>
		
		<div class="inbox-attached">
		    <div class="margin-bottom-10">
		        <span class="item-body">Archivos adjuntos: </span>
		    </div>
		    <div>
				<strong>
					<a href="javascript:;">DOCUMENTO EN ZIP (1).docx</a><br/>
					<a href="javascript:;">Balanza VIVANCO.xlsx</a>
				</strong>
		    </div>
		</div>
		
<!-- empiezan comentarios -->

<hr>
		<div class="">
		    <div class="portlet-title">
		        <div class="caption caption-md">
		            <i class="icon-bar-chart font-dark hide"></i>
		            <span class="caption-subject font-green-steel bold uppercase">Comentarios</span>
		            <span class="caption-helper"><!--HELPER--></span>
		        </div>
		    </div>
		    <div class="portlet-body">
		        <div data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
		            <div class="general-item-list">
			            
		                <div class="item">
		                    <div class="item-head">
		                        <div class="item-details">
		                            <img class="item-pic rounded" src="http://localhost/evisur/display.jpeg">
		                            <a href="" class="item-name primary-link">Evisur App</a>
		                            <span class="item-label">11 Oct 16 · 16:40</span>
		                        </div>
		                        <span class="item-status">
		                            <span class="badge badge-empty badge-danger"></span><!--status--></span>
		                    </div>
		                    <div class="item-body"> Tarea leída por Sharon Vivanco. </div>
		                </div>
		                
		                
			            
		                <div class="item">
		                    <div class="item-head">
		                        <div class="item-details">
		                            <img class="item-pic rounded" src="http://localhost/evisur/assets/pages/media/users/avatar6.jpg">
		                            <a href="" class="item-name primary-link">Sharon Vivanco</a>
		                            <span class="item-label">3 hrs ago</span>
		                        </div>
		                        <span class="item-status">
		                            <span class="badge badge-empty badge-success"></span> <!--status--></span>
		                    </div>
		                    <div class="item-body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </div>
		                </div>
		                <div class="item">
		                    <div class="item-head">
		                        <div class="item-details">
		                            <img class="item-pic rounded" src="http://localhost/evisur/assets/pages/media/users/avatar6.jpg">
		                            <a href="" class="item-name primary-link">Oscar Vivanco</a>
		                            <span class="item-label">5 hrs ago</span>
		                        </div>
		                        <span class="item-status">
		                            <span class="badge badge-empty badge-warning"></span><!--status--></span>
		                    </div>
		                    <div class="item-body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat tincidunt ut laoreet. </div>
		                </div>
		
		                <div class="item">
		                    <div class="item-head">
		                        <div class="item-details">
		                            <img class="item-pic rounded" src="http://localhost/evisur/display.jpeg">
		                            <a href="" class="item-name primary-link">Evisur App</a>
		                            <span class="item-label">hace 10 minutos</span>
		                        </div>
		                        <span class="item-status">
		                            <span class="badge badge-empty badge-danger"></span><!--status--></span>
		                    </div>
		                    <div class="item-body"> Tarea reabierta por Oscar Vivanco. </div>
		                </div>
		
		            </div>
		        </div>
		    </div>
		</div>

	<div class="portlet light ">
		<div class="portlet-title">
			<div class="caption caption-md">
				<i class="icon-bar-chart font-dark hide"></i>
				<span class="caption-subject font-green-steel bold uppercase">Nuevo Comentario</span>
			</div>
		</div>
        
	<div class="portlet-body">
			<div class="general-item-list">
				<textarea class="inbox-editor  form-control" name="mensaje" rows="6" placeholder="Escriba un comentario..."></textarea>
				<p><br/><a role="button" class="btn green"><i class="fa fa-check"></i>Enviar</a></p>
			</div>

	</div>
</div>
                                                
                                                
<!-- Termina inbox body y col-md-9 -->		
	</div>
</div>
