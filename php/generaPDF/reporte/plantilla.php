<?php 
 function plantilla ($trabajador,$fInicio,$fFinal,$estado) {
    require("../../conexion.php");
    include("../../calculo_tiempo.php");
    $idOrden=1;
    $whereOrden ="";
    $whereTrabajador=($trabajador==NULL) 
        ? "WHERE ORD_aprofecha0 is not null and ORD_aprofecha1 is not null AND ORD_fecha_creacion BETWEEN '$fInicio' AND '$fFinal'" 
        : "WHERE ORD_aprofecha0 is not null and ORD_aprofecha1 is not null AND PER_dni=$trabajador AND ORD_fecha_creacion BETWEEN '$fInicio' AND '$fFinal'";
    ($estado==NULL) 
    ? $whereOrden="AND ORD_fecha_creacion BETWEEN '$fInicio' AND '$fFinal'"
    : $whereOrden="AND ORD_estado='$estado' AND ORD_fecha_creacion BETWEEN '$fInicio' AND '$fFinal'";
   
	$plantilla = '<body>
    <hr>';
     $consulta="SELECT ORD_motivo,PER_nombres,PER_dni,PER_id FROM ordenes o inner join personas p ON p.PER_id=o.PER_id01 $whereTrabajador group by PER_id ";
     $resConsulta= mysqli_query($conexion,$consulta);
     $hoy = date("d-m-Y");
     foreach ($resConsulta as $x) {
          $nombres=$x["PER_nombres"];
          $dni=$x["PER_dni"];
          $plantilla.='<table>
    <tr>
    <td class="tabla_datos" style="width:140px;"> DNI </td>
    <td colspan="2"> : '.$dni.' </td>
    </tr>
    <tr>
    <tr>
    <td class="tabla_datos" style="width:140px;"> NOMBRES </td>
    <td colspan="3"> : '.$nombres.' </td>
    </tr>
    </table>';
    $plantilla.='<table cellspacing="0" style="font-size:12px; width:100%;">
			<tr style="background: #B2B2B9; height:32px; width:800px;">
				<td class="bookBy"><b># OP</b></td>
				<td class="bookBy"><b>FECHA OP</b></td>
				<td class="bookBy"><b>DESCRIPCNIÓN</b></td>
				<td class="bks"><b>MONEDA</b></td>
				<td class="bks"><b>TOTAL DEPOSITADO</b></td>
				<td class="bks"><b>ESTADO</b></td>
				<td class="bks"><b>PLAZO</b></td>
			</tr>';
            $consultaOrdenes= "SELECT *,DATE(ORD_fecha_creacion) as fecha, SUM(DEOR_monto) as sumaDebes, sum(if(ORD_tipomoneda = 'SOLES',DEOR_monto,0)) as sumaSoles,sum(if(ORD_tipomoneda = 'DOLARES',DEOR_monto,0)) as sumaDolares FROM detalleorden do INNER JOIN ordenes o ON do.ORD_id01 = o.ORD_id WHERE PER_id01 =".$x["PER_id"]." AND DEOR_operacion='DEBE' $whereOrden GROUP BY ORD_id";
            $resConDetalleOrden=mysqli_query($conexion, $consultaOrdenes);
            $sumaTotal=0;
            $sumaSoles = 0;
            $sumaDolares = 0;
			foreach ($resConDetalleOrden as $f) {
                $fI = new DateTime(date("Y-m-d"));
                $fFin = new DateTime($f["ORD_ffin"]);
                $sumaSoles += $f["sumaSoles"];
                $sumaDolares += $f["sumaDolares"];
                $sumaTotal += $f["sumaDebes"];
                $diff = $fI->diff($fFin);
                $tiempo = ($f["ORD_estado"]=="CERRADO" || $f["ORD_estado"]=="ANULADO") ? "" : calculoTiempo($diff);
			$plantilla.='<tr>
				<td style="font-family: \'Roboto\', sans-serif;  text-transform:uppercase;  text-align:center; border-right:1px solid #D4D3D3">'.$f["ORD_id"].'</td>
				<td style="font-family: \'Roboto\', sans-serif;  text-transform:uppercase;  text-align:center; border-right:1px solid #D4D3D3">'.$f["fecha"].'</td>
                <td style="font-family: \'Roboto\', sans-serif;  text-transform:uppercase;  text-align:center; border-right:1px solid #D4D3D3">'.$f["ORD_motivo"].'</td>
				<td style="font-family: \'Roboto\', sans-serif;  text-transform:uppercase;  text-align:center; border-right:1px solid #D4D3D3">'.$f["ORD_tipomoneda"].'</td>
				<td style="font-family: \'Roboto\', sans-serif;  text-transform:uppercase;  text-align:center; border-right:1px solid #D4D3D3">'.$f["sumaDebes"].'</td>
				<td style="font-family: \'Roboto\', sans-serif;  text-transform:uppercase;  text-align:center; border-right:1px solid #D4D3D3">'.$f["ORD_estado"].'</td>
                <td style="font-family: \'Roboto\', sans-serif;  text-transform:uppercase;  text-align:center; border-right:1px solid #D4D3D3">'.$tiempo.'</td>
                </tr>';
		}
        
			$plantilla.= '
            <tr>
            <td colspan="3"></td>
            <td><b>S. SOLES</b></td>
            <td style="font-family: \'Roboto\', sans-serif;  text-transform:uppercase;  text-align:center; border-right:1px solid #707070">'.$sumaSoles.'</td>
            </tr>
            <tr>
            <td colspan="3"></td>
            <td><b>S. DOLARES</b></td>
            <td style="font-family: \'Roboto\', sans-serif;  text-transform:uppercase;  text-align:center; border-right:1px solid #707070">'.$sumaDolares.'</td>
            </tr>
            <tr>
            <td colspan="3"></td>
            <td><b>S. TOTAL</b></td>
            <td style="font-family: \'Roboto\', sans-serif;  text-transform:uppercase;  text-align:center; border-right:1px solid #707070">'.$sumaTotal.'</td>
            </tr>
            </table> <hr style="color:rgb(184, 184, 184)">';
     }
    
 $plantilla.='</body>';
 $header ='<header>
 <table>
 <tr style="margin-bottom:150px">
 <td><img src="../images/gyt.png" alt="" width="20%"></td>
 <td align="center"><h2>REPORTE ORDEN DE PEDIDO</h2></td>
 <td>
 <table>
 <tr><td> <b>F. Inicio</b></td><td>: '.$fInicio.'</td></tr>
 <tr><td><b>F. Final</b></td><td>: '.$fFinal.'</td></tr>
 </table>
 </td>
 </tr>
 </table>
 </header>';
 $footer = '<footer> <table style="font-size:11px">
 </table></footer>';

 return [$plantilla,$header,$footer];
 }
 ?>