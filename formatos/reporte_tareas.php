<? set_time_limit(0); 
include('../includes/db.php');
include('../includes/session.php');
include('../includes/funciones.php');
ob_start();
$id_usuario=$_GET['id'];
$sq="SELECT nombre FROM usuarios WHERE id_usuario=$id_usuario";
$q=mysql_query($sq);
$dat=mysql_fetch_assoc($q);
$nombre=$dat['nombre'];

$sql="SELECT usuarios.nombre AS usuario, tareas.* FROM tareas 
JOIN usuarios ON usuarios.id_usuario=tareas.id_remite
WHERE id_destino=$id_usuario AND terminado_creador=0 AND terminado_destino=0";

$sql2="SELECT usuarios.nombre AS usuario, tareas.* FROM tareas 
JOIN usuarios ON usuarios.id_usuario=tareas.id_remite
WHERE id_destino=$id_usuario AND terminado_creador=0 AND terminado_destino=1";

$sql3="SELECT usuarios.nombre AS usuario, tareas.* FROM tareas 
JOIN usuarios ON usuarios.id_usuario=tareas.id_remite
WHERE id_destino=$id_usuario AND terminado_creador=1 AND terminado_destino=1";
?>
<style>
.titulos{
	background-color: #000000;
	color: #FFF;
	/*padding-left: 5px;*/
	/*Rojo claro #D90909
	Rojo obscuro #AC0000	
		
	*/
}
.borde-azul{
	border: #000000 1px solid ;
}
.borde-iz{
	border-left: #000000 1px solid;
}
.borde-der{
	border-right: #000000 1px solid;
}
.borde-bot{
	border-bottom: #000000 1px solid;
}
b{
	font-family: sfsemi;
}
h3{
	font-family: sfsemi;
	color: #333;
}
table{
	font-family: sf;
	text-transform: uppercase;
}
.f11{
	font-size: 11px;
}
.f13{
	font-size: 13px;
}
.f16{
	font-size: 16px;
}
.f10{
	font-size: 10px;
}
.centro{
	text-align: center;
}
</style>

<page backtop="25mm" backbottom="10mm" backleft="5mm" backright="5mm" >
<!-- header -->	
	<page_header>
	<table class="page_header" width="965">
		<tr>
			<td width="400" height="100" valign="middle" align="left">
				<img src="../logo.png" width="230" style="margin-left: 20px;" />
			</td>
			<td width="615" height="100" valign="middle" align="right">
				Rereporte de Tareas para <b><?=$nombre?></b><br>
				Creado: <?=devuelveFechaHora($fechahora)?>
			</td>
			
		</tr>
	</table>
	</page_header>
<!-- Footer -->
	<page_footer>
	<table class="page_footer" width="965">
		<tr>
			<td class="centro f10" width="965" height="30" valign="middle" >
				<b>Evisur App</b> |Reporte de Tareas| - Desarrollado por Epicmedia (www.epicmedia.pro)
			</td>
		</tr>
	</table>
	</page_footer>

<!-- Contenido -->
	
	<?
		// Resultados en tareas terminadas
		$q1=mysql_query($sql);
		$val1=mysql_num_rows($q1);
		if($val1){
	?>
	<h3 style="text-align: left">TAREAS PENDIENTES (<?=$val1?>)</h3>
	<table width="965" border=".5" cellpadding="0" cellspacing="0" class="f11">
		<tr>
			<td width="115" height="15">Fecha CreaciÓn</td>
			<td width="100" height="15">Fecha LÍmite</td>
			<td width="80" height="15">Prioridad</td>
			<td width="150" height="15">Remitente</td>
			<td width="150" height="15">Proyecto</td>
			<td width="320" height="15">Asunto</td>
			<td width="50" height="15">LeÍdo</td>
		</tr>
		<? while($ft=mysql_fetch_assoc($q1)){ ?>
		<tr>
			<td width="115" height="15"><?=devuelveFechaHora($ft['fecha_hora_creacion'])?></td>
			<td width="100" height="15"><?=fechaLetraDos($ft['fecha_limite'])?></td>
			<td width="80" height="15"><?=prioridad($ft['prioridad'])?></td>
			<td width="150" height="15"><?=$ft['usuario']?></td>
			<td width="150" height="15"><?=dameProyecto($ft['id_proyecto'])?></td>
			<td width="320" height="15"><?=$ft['asunto']?></td>
			<td width="50" align="center" height="15"><? if($ft['leido']==1){ echo "Si"; }else{ echo "No"; }?></td>
		</tr>
		<? } ?>
	</table>
	
	<br><br>
	<? } ?>
	
	<?
		// Resultados en tareas terminadas
		$q2=mysql_query($sql2);
		$val2=mysql_num_rows($q2);
		if($val2){
	?>
	<h3 style="text-align: left;">TAREAS PENDIENTES DE REVISIÓN (<?=$val2?>)</h3>
	<table width="965" border=".5" cellpadding="0" cellspacing="0" class="f11">
		<tr>
			<td width="115" height="15">Fecha CreaciÓn</td>
			<td width="100" height="15">Fecha LÍmite</td>
			<td width="80" height="15">Prioridad</td>
			<td width="150" height="15">Remitente</td>
			<td width="150" height="15">Proyecto</td>
			<td width="320" height="15">Asunto</td>
			<td width="50" height="15">LeÍdo</td>
		</tr>
		<? while($ft=mysql_fetch_assoc($q2)){ ?>
		<tr>
			<td width="115" height="15"><?=devuelveFechaHora($ft['fecha_hora_creacion'])?></td>
			<td width="100" height="15"><?=fechaLetraDos($ft['fecha_limite'])?></td>
			<td width="80" height="15"><?=prioridad($ft['prioridad'])?></td>
			<td width="150" height="15"><?=$ft['usuario']?></td>
			<td width="150" height="15"><?=dameProyecto($ft['id_proyecto'])?></td>
			<td width="320" height="15"><?=$ft['asunto']?></td>
			<td width="50" align="center" height="15"><? if($ft['leido']==1){ echo "Si"; }else{ echo "No"; }?></td>
		</tr>
		<? } ?>
	</table>
	
	<br><br>
	<? } ?>
	
	
	
	
	<?
		// Resultados en tareas terminadas
		$q3=mysql_query($sql3);
		$val3=mysql_num_rows($q3);
		if($val3){
	?>
	<h3 style="text-align: left">TAREAS TERMINADAS (<?=$val3?>)</h3>
	<table width="965" border=".5" cellpadding="0" cellspacing="0" class="f11">
		<tr>
			<td width="115" height="15">Fecha CreaciÓn</td>
			<td width="100" height="15">Fecha LÍmite</td>
			<td width="80" height="15">Prioridad</td>
			<td width="150" height="15">Remitente</td>
			<td width="150" height="15">Proyecto</td>
			<td width="255" height="15">Asunto</td>
			<td width="115" height="15">Termino</td>
		</tr>
		<? while($ft=mysql_fetch_assoc($q3)){ ?>
		<tr>
			<td width="115" height="15"><?=devuelveFechaHora($ft['fecha_hora_creacion'])?></td>
			<td width="100" height="15"><?=fechaLetraDos($ft['fecha_limite'])?></td>
			<td width="80" height="15"><?=prioridad($ft['prioridad'])?></td>
			<td width="150" height="15"><?=$ft['usuario']?></td>
			<td width="150" height="15"><?=dameProyecto($ft['id_proyecto'])?></td>
			<td width="255" height="15"><?=$ft['asunto']?></td>
			<td width="115" height="15"><?=devuelveFechaHora($ft['fecha_hora_terminado'])?></td>
		</tr>
		<? } ?>
	</table>
	<? } ?>	
	
	<? if((!$val1)&&(!$val2)&&(!$val3)){ ?>
	
	<h3 style="text-align: center;margin-top: 200px;text-transform: uppercase;">No se han creado tareas para este usuario</h3>
	<? } ?>

</page>


<?php

	$content_html = ob_get_clean();

	// initialisation de HTML2PDF
	require_once(dirname(__FILE__).'/pdf/html2pdf.class.php');
	try
	{
		//$html2pdf = new HTML2PDF('P','letter','es', true, 'UTF-8', array(2, 0, 0, 0));
		$html2pdf = new HTML2PDF('L','letter','es', true, 'UTF-8', array(2, 0, 0, 0));
		$html2pdf->pdf->SetDisplayMode('fullpage');
		
		$html2pdf->addFont("sf");
		$html2pdf->addFont("sfsemi");
		
		$html2pdf->writeHTML($content_html, isset($_GET['vuehtml']));
//		$html2pdf->createIndex('Sommaire', 25, 12, false, true, 1);
		$html2pdf->Output('Inscripcion_'.$id_alumno.'.pdf');
	}
	catch(HTML2PDF_exception $e) { echo $e; }

?>