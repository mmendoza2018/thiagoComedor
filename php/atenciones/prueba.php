<?php
require_once("../conexion.php");
$resComensales = "SELECT COME_id, COME_nombres, AREA_descripcion, COME_dni FROM comensales co 
                  INNER JOIN areas ar ON co.AREA_id01=ar.AREA_id WHERE COME_estado=1";
# AND COME_id=199
$resComesal = mysqli_query($conexion, $resComensales);
$auxiliar = null;
$arrayDiasRegistroComensales = [];
$arrayDiasGeneralComensales = [];
$resTipoAlimento = mysqli_query($conexion, "SELECT * FROM tipo_alimentos WHERE TIAL_principal=1 AND TIAL_estado =1");
foreach ($resComesal as $x) {
  $arrayDiasSalidaPorComensal = [];
  $contadorAlimentos = 0;
  foreach ($resTipoAlimento as $k) {
    $conSalidas = "SELECT DATE(REAL_fecha) as fechaRegistro, REAL_id,CEDE_descripcion,REAL_precio_comida FROM registros_alimentacion ra
                   INNER JOIN cedes ce ON ra.CEDE_id01=ce.CEDE_id
                   WHERE COME_id01=" . $x["COME_id"] . " AND TIAL_id01=" . $k["TIAL_id"] . " AND REAL_estado=1";
    $resSalidas = mysqli_query($conexion, $conSalidas);
    if (mysqli_num_rows($resSalidas) > 0) {
      $arrayDiasSalidaPorComensal[$contadorAlimentos] =  ["fecha" => [], "precio"=> []];
      //var_dump($arrayDiasSalidaPorComensal);
      //var_dump($arrayDiasSalidaPorComensal[$contadorAlimentos][$k['TIAL_descripcion']]);
      foreach ($resSalidas as $t) {
        $cedeSalida = $t['CEDE_descripcion'];
        array_push($arrayDiasSalidaPorComensal[$contadorAlimentos]["fecha"],$t['fechaRegistro']);
        array_push($arrayDiasSalidaPorComensal[$contadorAlimentos]["precio"],floatval($t['REAL_precio_comida']));

      }
    } else {
      array_push($arrayDiasSalidaPorComensal, ["fecha" => [], "precio"=> []]);
    }
    $contadorAlimentos++;
  }
  #var_dump($arrayDiasSalidaPorComensal);
  $sumaDesayuno = count($arrayDiasSalidaPorComensal[0]["fecha"]);
  $sumaAlmuerzo = count($arrayDiasSalidaPorComensal[1]["fecha"]);
  $sumaCena = count($arrayDiasSalidaPorComensal[2]["fecha"]);

  $existenRegistrosComensal =  $sumaDesayuno + $sumaAlmuerzo + $sumaCena;
  
  if ($existenRegistrosComensal > 0) {
    array_push($arrayDiasRegistroComensales, [
      'nombres' => $x['COME_nombres'],
      'dni' => $x['COME_dni'],
      'cargo' => $x['AREA_descripcion'],
      'cede' => $cedeSalida,
      'diasRegistro' => $arrayDiasSalidaPorComensal,
    ]); 
  }
}
 echo "<pre>"; var_dump($arrayDiasRegistroComensales); echo "<pre>";
die();
/* --------------------------------- */

$diasEspanol = array(
  'Monday' => 'Lunes',
  'Tuesday' => 'Martes',
  'Wednesday' => 'Miércoles',
  'Thursday' => 'Jueves',
  'Friday' => 'Viernes',
  'Saturday' => 'Sábado',
  'Sunday' => 'Domingo'
);
function createDateRangeArray($strDateFrom, $strDateTo, $diasEspanol)
{
  // takes two dates formatted as YYYY-MM-DD and creates an
  // inclusive array of the dates between the from and to dates.

  // could test validity of dates here but I'm already doing
  $aryRange = [];

  $iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
  $iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));

  if ($iDateTo >= $iDateFrom) {
    $nameDay = $diasEspanol[date('l', strtotime(date('Y-m-d', $iDateFrom)))];
    array_push($aryRange, ['nombre' => $nameDay, 'fecha' => date('Y-m-d', $iDateFrom)]);
    while ($iDateFrom < $iDateTo) {
      $iDateFrom += 86400; // add 24 hours
      $nameDay = $diasEspanol[date('l', strtotime(date('Y-m-d', $iDateFrom)))];
      array_push($aryRange, ['nombre' => $nameDay, 'fecha' => date('Y-m-d', $iDateFrom)]);
    }
  }
  return $aryRange;
}
$arrayDiasGeneralComensales = [];
$arrayDiasAuxiliar = [];
$arrayDiasSelecionados = createDateRangeArray('2022-07-01', '2022-07-31', $diasEspanol);
$contadorComensales2=0;
foreach ($arrayDiasRegistroComensales as $x) {
  $contadorDiasSeleccionados=0;
  array_push($arrayDiasGeneralComensales, [
    'nombres' => $x['nombres'],
    'dni' => $x['dni'],
    'cargo' => $x['cargo'],
    'cede' => $cedeSalida,
    'diasRegistro' => [],
  ]);
  foreach ($arrayDiasSelecionados as $y) {
    $contador = 0;  
    foreach ($x['diasRegistro'] as $i) {
//echo "<pre>"; var_dump($i); echo "<pre>";
      $arrayDiasAuxiliar[$contador] =  null;
      if (array_search($y['fecha'], $i["fecha"]) !== false) {
        $arrayDiasAuxiliar[$contador]= 1;
      } else {
        $arrayDiasAuxiliar[$contador]= 0;
      }
      $contador++;
    }
    array_push($arrayDiasGeneralComensales[$contadorComensales2]['diasRegistro'],$arrayDiasAuxiliar);
    $contadorDiasSeleccionados++;
  }
  $contadorComensales2++;
}
echo "<pre>"; var_dump($arrayDiasGeneralComensales); echo "<pre>";
//echo count($arrayDiasSelecionados);
/* echo "<pre>";
var_dump($arrayDiasGeneralComensales);
echo "<pre>";
foreach ($arrayDiasSelecionados as $f) {
  echo $f['fecha'];
}
for ($column = 1; $column < count($arrayDiasSelecionados); $column++) {
  echo $arrayDiasSelecionados[$column]['fecha'];
} */