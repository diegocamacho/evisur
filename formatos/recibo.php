<? set_time_limit(0); 
include('../includes/db.php');
include('../includes/session.php');
include('../includes/funciones.php');
ob_start();
$id_pago=$_GET['id'];
$sql="SELECT *, alumnos.nombre AS alumno, tutores.nombre AS tutor, salones.nombre AS salon, pagos.fecha_hora AS fechahora FROM alumnos 
JOIN inscripcion ON inscripcion.id_alumno=alumnos.id_alumno 
JOIN tutores ON tutores.id_tutor=inscripcion.id_tutor 
JOIN salones ON salones.id_salon=inscripcion.id_salon 
JOIN pagos ON pagos.id_alumno=alumnos.id_alumno 
WHERE id_pago=$id_pago";
$q=mysql_query($sql);
$ft=mysql_fetch_assoc($q);
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
</style>

<page backtop="28mm" backbottom="10mm" backleft="10mm" backright="10mm" >
<!-- header -->	
	<page_header>
	<table class="page_header" width="760">
		<tr>
			<td align="center">
				<img src="head.png" width="790" />
			</td>
		</tr>
	</table>
	</page_header>
<!-- Footer -->
	<page_footer>
	<table class="page_footer" width="760">
		<tr>
			<td align="center" >
				<img src="footer.png" width="790" />
			</td>
		</tr>
	</table>
	</page_footer>

<!-- Contenido -->

	<h3 style="text-align: center">COMPROBANTE DE PAGO</h3>
	
	<h5 style="text-align: left">FECHA: <?=devuelveFechaHora($ft['fechahora'])?></h5>
	<table width="760" border=".5" cellpadding="0" cellspacing="0" class="f13">
		<tr>
			<td width="500" height="15">PADRE O TUTOR: <b><?=$ft['tutor']?> (<?=$ft['parentesco']?>)</b></td>
			<td width="200" height="15">TEL&Eacute;FONO CEL: <b><?=$ft['telefono1']?></b></td>
		</tr>
		<tr>
			<td width="500" height="15">DIRECCI&Oacute;N: <b><?=$ft['direccion']?></b></td>
			<td width="200" height="15">TEL&Eacute;FONO CASA: <b><?=$ft['telefono2']?></b></td>
		</tr>
		<tr>
			<td width="500" height="15">EMAIL: <b><?=$ft['email']?></b></td>
			<td width="200" height="15">TEL&Eacute;FONO OFI: <b><?=$ft['telefono3']?></b></td>
		</tr>
		
		<tr>
			<td width="700" height="15" colspan="2">ALUMNO: <b><?=$ft['alumno']?></b></td>
		</tr>
		<tr>
			<td width="500" height="15">SAL&Oacute;N: <b><?=$ft['salon']?></b></td>
			<td width="200" height="15">ENTRADA: <b><?=substr($ft['horario'],0,5)?> HRS.</b></td>
		</tr>
	</table>
	
	<br><br>
	<h3 style="text-align: center">PAGO</h3>
	<table width="760" border=".5" cellpadding="0" cellspacing="0" class="f16">
		
		<tr>
			<td width="700" height="15">PAGO: <b><?=number_format($ft['monto'],2)?></b> </td>
		</tr>
		<tr>
			<td width="700" height="15">
				<? if($ft['observacion']){ echo "CONCEPTO: <b>".$ft['observacion']."</b>"; }?>
			</td>
		</tr>
	</table>
	
	
	<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	<table width="760" align="center" border="0" cellpadding="0" cellspacing="0" class="f13">
		<tr>
			
			<td width="350" align="center">
				__________________________________________<br>
				<?=$ft['tutor']?>
			</td>
			
			<td width="350" align="center">
				__________________________________________<br>
				<?=$s_nombre?>
			</td>
		</tr>
	</table>
			

</page>


<?php

	$content_html = ob_get_clean();

	// initialisation de HTML2PDF
	require_once(dirname(__FILE__).'/pdf/html2pdf.class.php');
	try
	{
		$html2pdf = new HTML2PDF('P','letter','es', true, 'UTF-8', array(2, 0, 0, 0));
		$html2pdf->pdf->SetDisplayMode('fullpage');
		
		$html2pdf->addFont("sf");
		$html2pdf->addFont("sfsemi");
		//$html2pdf = new HTML2PDF('L','A4','es', false, 'utf-8', array(0, 0, 0, 0));
		$html2pdf->writeHTML($content_html, isset($_GET['vuehtml']));
//		$html2pdf->createIndex('Sommaire', 25, 12, false, true, 1);
		$html2pdf->Output('Inscripcion_'.$id_alumno.'.pdf');
	}
	catch(HTML2PDF_exception $e) { echo $e; }

?>