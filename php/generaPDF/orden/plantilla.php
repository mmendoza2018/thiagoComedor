<?php 
 function plantilla ($idOrden) {
	 require("../../conexion.php");
     require_once("../../ordenes/consulta_saldos.php");
     $consulta="SELECT *, DATE(ORD_fecha_creacion) as fechaCreacion FROM ordenes o INNER JOIN personas p ON o.PER_id01 = p.PER_id INNER JOIN centros_costo co ON o.CECO_id01 = co.CECO_id INNER JOIN empresas e ON o.EMP_id01=e.EMP_id WHERE ORD_id='$idOrden'";
     $resConsulta= mysqli_query($conexion,$consulta);
     $hoy = date("d-m-Y");
     foreach ($resConsulta as $x) {
          
          $fechaCreacion=$x["fechaCreacion"];
          $estado=$x["ORD_estado"];
          $nombres=$x["PER_nombres"];
          $dni=$x["PER_dni"];
          $cuentaSoles=$x["PER_cuenta"];
          $cuentaDolares=$x["PER_cuenta_dolares"];
          $bancoSoles=$x["PER_banco"];
          $bancoDolares=$x["PER_banco_dolares"];
          $moneda=$x["ORD_tipomoneda"];
          $transaccion=$x["ORD_numtransaccion"];
          $ftransaccion=$x["ORD_fechatransaccion"];
          $cci=$x["PER_cci"];
          $motivo=$x["ORD_motivo"];
          $cCosto=$x["CECO_descripcion"];
          $fInicio=$x["ORD_finicio"];
          $fFinal=$x["ORD_ffin"];
          $aprobacion1=$x["ORD_aprobacion1"];
          $fAprobacion1=$x["ORD_aprofecha1"];
          $aprobacion2=$x["ORD_aprobacion2"];
          $fAprobacion2=$x["ORD_aprofecha2"];
          $aprobacion3=$x["ORD_aprobacion3"];
          $fAprobacion3=$x["ORD_aprofecha3"];
          $usuario=$x["ORD_usuario"];
          $imagenEmpresa= $x["EMP_imagen"];
          $nombreEmpresa= $x["EMP_descripcion"];

          if ($moneda=="SOLES") {
            $numCuenta = $cuentaSoles;
            $banco = $bancoSoles;
          }else{
            $banco = $bancoDolares;
            $numCuenta = $cuentaDolares; 
          }  
     }
     $header ='<header>
     <table>
     <tr style="margin-bottom:150px">
     <td><img src="../images/'.$imagenEmpresa.'" alt="" width="20%"></td>
     <td align="center"><h2>ORDEN DE PEDIDO</h2></td>
     <td>
     <table>
     <tr><td> <b># de OP</b></td><td>: '.$idOrden.'</td></tr>
     <tr><td><b>Fecha</b></td><td>: '.$fechaCreacion.'</td></tr>
     <tr><td><b>Estado OP</b></td><td>: '.$estado.'</td></tr>
     </table>
     </td>
     </tr>
     </table>
     </header>';
     $plantilla = '<body>
 <hr>
     <table >
             <tr style="width:720px;">
                 <td class="td_subtitulos letra">
                 DATOS DE SOLICITANTE
                 </td>
             </tr>
     </table>
 <hr>
 <table>
 <tr>
 <td style="width:20px;"></td>
 <td class="tabla_datos" style="width:140px;"> DNI </td>
 <td colspan="2"> : '.$dni.' </td>
 </tr>
 <tr>
 <td style="width:20px;"></td>
 <td class="tabla_datos" style="width:140px;"> NOMBRES </td>
 <td colspan="3"> : '.$nombres.' </td>
 </tr>
 <tr>
 <td style="width:20px;"></td>
 <td class="tabla_datos" style="width:140px;"> EMPRESA </td>
 <td colspan="3"> : '.$nombreEmpresa.' </td>
 </tr>
 <tr>
 <td style="width:20px;"></td>
 <td class="tabla_datos" style="width:140px;"> BANCO </td>
 <td colspan="2"> : '.$banco.' </td>
 </tr>
 <tr>
 <td style="width:20px;"></td>
 <td class="tabla_datos" style="width:140px;"> CUENTA </td>
 <td> : '.$numCuenta.' </td>
 <td class="tabla_datos" style="width:50px;"> CCI </td>
 <td > : '.$cci.' </td>
 </tr>
 <tr>
 <td style="width:20px;"></td>
 <td class="tabla_datos" style="width:140px;"> MONEDA </td>
 <td> : '.$moneda.' </td>
 </tr>
 <tr>
 <td style="width:20px;"></td>
 <td class="tabla_datos" style="width:140px;"> # TRANSACCION </td>
 <td> : '.$transaccion.' </td>
 </tr>
 <tr>
 <td style="width:20px;"></td>
 <td class="tabla_datos" style="width:140px;"> F. TRANSACCION </td>
 <td > : '.$ftransaccion.' </td>
 </tr>
 </table>
 <hr style="margin-top:20px">
     <table >
             <tr style="width:720px;">
                 <td class="td_subtitulos letra">
                 DATOS DE LA ORDEN
                 </td>
             </tr>
     </table>
 <hr>
<table>
 <tr>
 <td style="width:20px;"></td>
 <td class="tabla_datos" style="width:140px;"> MOTIVO </td>
 <td> : '.$motivo.' </td>
 <td class="tabla_datos" style="width:100px;"> F. DE INICIO </td>
 <td > : '.$fInicio.' </td>
 </tr>
 <tr>
 <td style="width:20px;"></td>
 <td class="tabla_datos" style="width:140px;"> C. DE COSTO </td>
 <td> : '.$cCosto.' </td>
 <td class="tabla_datos" style="width:100px;"> F. FIN </td>
 <td > : '.$fFinal.' </td>
 </tr>
 </table>

 <hr style="margin-top:20px">
     <table >
             <tr style="width:720px;">
                 <td class="td_subtitulos letra">
                 DETALLES DE ORDEN DE PEDIDO
                 </td>
             </tr>
     </table>
 <hr>
 <table cellspacing="0" style="font-size:12px; width:100%;">
			<tr style="background: #B2B2B2; height:32px; width:800px;">
				<td class="bookBy"><b>#</b></td>
				<td class="bookBy"><b>CONCEPTO</b></td>
				<td class="bookBy"><b>OBSERVACIONES</b></td>
				<td class="bks"><b>FECHA</b></td>
				<td class="bks"><b>D</b></td>
				<td class="bks"><b>H</b></td>
				<td class="bks"><b>R</b></td>
				<td class="bks"><b>D</b></td>
			</tr>';
            $resConDetalleOrden=mysqli_query($conexion,"SELECT *, DATE(DEOR_fecha) as fecha  FROM detalleorden do INNER JOIN concepto_orden co ON do.COOR_id01 = co.COOR_id WHERE ORD_id01='$idOrden'");
            
			foreach ($resConDetalleOrden as $f) {
                $debe = ($f["DEOR_operacion"]=="DEBE") ? $f["DEOR_monto"] : " ";
                $haber =($f["DEOR_operacion"]=="HABER") ? $f["DEOR_monto"] : " ";
                $reintegro = ($f["DEOR_operacion"]=="REINTEGRO") ? $f["DEOR_monto"] : " ";
                $devolucion = ($f["DEOR_operacion"]=="DEVOLUCIÓN") ? $f["DEOR_monto"] : " ";
			$plantilla.='<tr>
				<td style="font-family: \'Roboto\', sans-serif;  text-transform:uppercase;  text-align:center; border-right:1px solid #D4D3D3">'.$f["DEOR_id"].'</td>
				<td style="font-family: \'Roboto\', sans-serif;  text-transform:uppercase;  text-align:center; border-right:1px solid #D4D3D3">'.$f["COOR_descripcion"].'</td>
                <td style="font-family: \'Roboto\', sans-serif;  text-transform:uppercase;  text-align:center; border-right:1px solid #D4D3D3">'.$f["DEOR_observaciones"].'</td>
				<td style="font-family: \'Roboto\', sans-serif;  text-transform:uppercase;  text-align:center; border-right:1px solid #D4D3D3">'.$f["fecha"].'</td>
				<td style="font-family: \'Roboto\', sans-serif;  text-transform:uppercase;  text-align:center; border-right:1px solid #D4D3D3">'.$debe.'</td>
				<td style="font-family: \'Roboto\', sans-serif;  text-transform:uppercase;  text-align:center; border-right:1px solid #D4D3D3">'.$haber.'</td>
				<td style="font-family: \'Roboto\', sans-serif;  text-transform:uppercase;  text-align:center; border-right:1px solid #D4D3D3">'.$reintegro.'</td>
                <td style="font-family: \'Roboto\', sans-serif;  text-transform:uppercase;  text-align:center; border-right:1px solid #D4D3D3">'.$devolucion.'</td>';
		}
        
			$plantilla.= '</tr>

</table>
<table style="margin-top:20px;">
 <tr>
 <td style="width:20px;"></td>
 <td class="tabla_datos" style="width:180px;"> TOTAL DEPOSITADO </td>
 <td> : '.$totalDepositado.'  </td>
 <td class="tabla_datos" style="width:150px;"> POR RENDIR </td>
 <td > : '.$porRendir.' </td>
 </tr>
 <tr>
 <td style="width:20px;"></td>
 <td class="tabla_datos" style="width:180px;"> TOTAL RENDIDO </td>
 <td> : '.$totalRendido.' </td>
 <td class="tabla_datos" style="width:150px;"> POR REINTEGRAR </td>
 <td > : '.$porReintegrar.' </td>
 </tr>
 </table>
 </body>';
 $footer = '<footer> <table style="font-size:10px">
 <th>
 <tr>
    <td><b>PRIMERA APROBACIÓN</b></td>
    <td><b>CIERRE DE OP</b></td>
    <td><b>CONFORMIDAD</b></td>
</tr>
 </th>
 <tr>
     <td>'.$aprobacion1.'</td>
     <td>'.$aprobacion2.'</td>
     <td>'.$aprobacion3.'</td>
 </tr>
 <tr>
 <td>'.$fAprobacion1.'</td>
 <td>'.$fAprobacion2.'</td>
 <td>'.$fAprobacion3.'</td>
</tr>
 </table></footer>';

 return [$plantilla,$header,$footer];
 }
 ?>