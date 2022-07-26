<?php
require_once("../conexion.php");
$resComensales = "SELECT COME_id, COME_nombres FROM comensales WHERE COME_estado=1";
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
    $conSalidas = "SELECT DATE(REAL_fecha) as fechaRegistro, REAL_id,TIAL_descripcion FROM registros_alimentacion ra
                   LEFT JOIN tipo_alimentos ta ON ra.TIAL_id01=ta.TIAL_id
                   WHERE COME_id01=" . $x["COME_id"] . " AND TIAL_id01=" . $k["TIAL_id"] . " AND REAL_estado=1";
    $resSalidas = mysqli_query($conexion, $conSalidas);
    if (mysqli_num_rows($resSalidas) > 0) {
      $arrayDiasSalidaPorComensal[$contadorAlimentos] =  [];
      //var_dump($arrayDiasSalidaPorComensal);
      //var_dump($arrayDiasSalidaPorComensal[$contadorAlimentos][$k['TIAL_descripcion']]);
      foreach ($resSalidas as $t) {
        //var_dump($arrayDiasSalidaPorComensal[$k['TIAL_id']]);
        array_push($arrayDiasSalidaPorComensal[$contadorAlimentos],  $t['fechaRegistro']);
      }
    } else {
      array_push($arrayDiasSalidaPorComensal, []);
    }

    $contadorAlimentos++;
  }
  /*   echo "<pre>";
  var_dump($arrayDiasSalidaPorComensal);
  echo "<pre>"; */
  #var_dump($arrayDiasSalidaPorComensal);
  $sumaDesayuno = count($arrayDiasSalidaPorComensal[0]);
  $sumaAlmuerzo = count($arrayDiasSalidaPorComensal[1]);
  $sumaCena = count($arrayDiasSalidaPorComensal[2]);

  $existenRegistrosComensal =  $sumaDesayuno + $sumaAlmuerzo + $sumaCena;
  if ($existenRegistrosComensal > 0) {
    array_push($arrayDiasRegistroComensales, [
      'id' => $x['COME_id'],
      'nombres' => $x['COME_nombres'],
      'diasRegistro' => $arrayDiasSalidaPorComensal,
    ]);
  }
}
 #echo "<pre>"; var_dump($arrayDiasRegistroComensales); echo "<pre>";

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
foreach ($arrayDiasRegistroComensales as $x) {
  $contadorComensales2=0;
  array_push($arrayDiasGeneralComensales, [
    'nombres' => $x['nombres'],
    'diasRegistro' => [],
  ]);
  foreach ($arrayDiasSelecionados as $y) {
    $contadorDiasSeleccionados=0;
    $contador = 0;  
    foreach ($x['diasRegistro'] as $i) {
/* echo "<pre>"; var_dump($i); echo "<pre>"; */
      $arrayDiasAuxiliar[$contador] =  null;
      if (array_search($y['fecha'], $i) !== false) {
        $arrayDiasAuxiliar[$contador]= 1;
      } else {
        #array_push($arrayDiasAuxiliar[$contador], 0);
        $arrayDiasAuxiliar[$contador]= 0;
      }
      $contador++;
    }
    array_push($arrayDiasGeneralComensales[$contadorComensales2]['diasRegistro'],$arrayDiasAuxiliar);
  }
  $contadorDiasSeleccionados++;
  $contadorComensales2++;
}
echo "<pre>";
var_dump($arrayDiasGeneralComensales);
echo "<pre>";