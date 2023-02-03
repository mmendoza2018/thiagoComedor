<?php
function plantilla($idPersona)
{
	require_once("../../conexion.php");

	$consultaPer = "SELECT *, CONCAT(PER_nombres, ' ', PER_apellidos ) as nombres FROM personas WHERE PER_id='$idPersona'";
	$resListaPersonas = mysqli_query($conexion, $consultaPer);
	$arrayResultado = mysqli_fetch_assoc($resListaPersonas);

	$consultaDocs = "SELECT * FROM documentos d
							INNER JOIN tipo_documentos td ON d.TIDO_id01 = td.TIDO_id
							INNER JOIN personas p ON d.PER_id01 = p.PER_id WHERE d.PER_id01=$idPersona";

	function calculaEdad($fechanacimiento){
			list($ano,$mes,$dia) = explode("-",$fechanacimiento);
			$ano_diferencia  = date("Y") - $ano;
			$mes_diferencia = date("m") - $mes;
			$dia_diferencia   = date("d") - $dia;
			if ($dia_diferencia < 0 || $mes_diferencia < 0)
				$ano_diferencia--;
		return $ano_diferencia;
	}
	$edadActual = calculaEdad($arrayResultado['PER_fecha_nacimiento']);
	$resDocsPersona = mysqli_query($conexion, $consultaDocs);
	$header = '';
	$plantilla = '
	
	<body style="margin-top:0px" > 

		<table class="border-collapse border-table w-100">
      <tr>
        <td class="w-20 text-center" rowspan="3">
          <img src="../../../assets/img/thiago.jpeg" style="width:100px" alt="">
        </td>
        <td class="w-60 text-center">SISTEMA INTEGRADO DE GESTIÓN THIAGO & ARIS E.I.R.L.</td>
        <td class="w-20">Código: FOR.TA.033</td>
      </tr>
      <tr>
        <td class="w-60 text-center fw-bold" rowspan="2">DECLARACIÓN JURADA DE DATOS DEL PERSONAL SELECCIONADO</td>
        <td class="w-20">Versión: 01</td>
      </tr>
      <tr>
        <td class="w-20">F.A.: 01-06-2021</td>
      </tr>
    </table>

		<div class="subtitle-box">
			DOCUMENTOS DEL PERSONAL
		</div>

		<table class="w-100">
			<tr>
				<th class="w-20 text-start">Número Documento</th>
				<td class="w-70">: '.$arrayResultado['PER_usuario'] .'</td>
			</tr>
			<tr>	
				<th class="text-start">Nombres y Apellidos</th>
				<td>: '.$arrayResultado['nombres'] .'</td>
			</tr>
			<tr>
				<th class="text-start">Fecha de Nacimiento</th>
				<td>: '.$arrayResultado['PER_fecha_nacimiento'] .'</td>
			</tr>
			<tr>
				<th class="text-start">Edad</th>
				<td>: '. $edadActual .'</td>
			</tr>
			<tr>
				<th class="text-start">Teléfono</th>
				<td>: '.$arrayResultado['PER_telefono'] .'</td>
			</tr>
		</table>
		<table class="border-collapse border-table w-100 mt-4">
			<tr>
					<th class="bg-orange">#</th>
					<th class="bg-orange">DOCUMENTO</th>
					<th class="bg-orange">NUMERO DOCUMENTO</th>
					<th class="bg-orange">FECHA EMISION</th>
					<th class="bg-orange">FECHA VENCIMIENTO</th>
			</tr>';
			$contador = 1;
			foreach ($resDocsPersona as $y) {
				$plantilla .= '<tr>
				<td class="w-10">' . $contador . '</td>
				<td class="w-40">' . $y["TIDO_descripcion"] . '</td>
				<td class="w-30">' . $y["DOCU_numero"] . '</td>
				<td class="w-10" >' . $y["DOCU_fecha_ingreso"] . '</td>
				<td class="w-10">' . $y["DOCU_fecha_vencimiento"] . '</td>
				</tr>';
				$contador ++; }
			$plantilla .= '
		</table>';

		$plantilla .= '<br>
		</body>';

	$footer = '<footer>
		<span class="texto-secundario"> Responsable: ' . $_SESSION["datos_trabajador"][0]["nombres"] . '</span>
		</footer>';
	return [$plantilla, $header, $footer, 'documentos'];
}
