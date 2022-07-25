<?php
require_once("../conexion.php");
$resComensales = "SELECT COME_id, COME_nombres FROM comensales WHERE COME_estado=1";
$resComesal = mysqli_query($conexion, $resComensales);
$auxiliar = null;
$arrayDiasRegistroComensales = [];
$arrayDiasGeneralComensales = [];
$resTipoAlimento = mysqli_query($conexion, "SELECT * FROM tipo_alimentos WHERE TIAL_principal=1 AND TIAL_estado =1");
foreach ($resComesal as $x) {
  $arrayDiasSalidaPorComensal = [];
  //0 =>[],1=>[],2=>[],3=>[]
  foreach ($resTipoAlimento as $k) {
    echo "entre";
    $conSalidas = "SELECT DATE(REAL_fecha) as fechaRegistro, REAL_id,TIAL_descripcion FROM registros_alimentacion ra
                   LEFT JOIN tipo_alimentos ta ON ra.TIAL_id01=ta.TIAL_id
                   WHERE COME_id01='199' AND TIAL_id01=".$k["TIAL_id"]." AND REAL_estado=1";
    $resSalidas = mysqli_query($conexion, $conSalidas);
    if (mysqli_num_rows($resSalidas) > 0) {
      array_push($arrayDiasSalidaPorComensal, [$k['TIAL_id'] => []]);
      var_dump($arrayDiasSalidaPorComensal[2]);
      echo $k['TIAL_descripcion'];
      foreach ($resSalidas as $t) {
        echo $t['fechaRegistro'];
        var_dump($arrayDiasSalidaPorComensal[$k['TIAL_id']]);
        array_push($arrayDiasSalidaPorComensal[$k['TIAL_id']], [$k['TIAL_descripcion'] => $t['fechaRegistro']]);
      }
    }else {
      array_push($arrayDiasSalidaPorComensal, [$k['TIAL_id'] => null]);
    }
    
    echo "<pre>"; 
    var_dump($arrayDiasSalidaPorComensal);
    echo "<pre>-----------";
  }
/*   echo "<pre>";
  var_dump($arrayDiasSalidaPorComensal);
  echo "<pre>"; */
  die();
  #var_dump($arrayDiasSalidaPorComensal);
  if (count($arrayDiasSalidaPorComensal) > 0) {
    array_push($arrayDiasRegistroComensales, [
      'id' => $x['COME_id'],
      'nombres' => $x['COME_nombres'],
      'diasRegistro' => $arrayDiasSalidaPorComensal,
    ]);
  }
}
echo "<pre>";
var_dump($arrayDiasRegistroComensales);
echo "<pre>";
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
$contador=0;
$arrayDiasGeneralComensales = [];
$arrayDiasSelecionados = createDateRangeArray('2022-07-01', '2022-07-31', $diasEspanol);
foreach ($arrayDiasRegistroComensales as $x) {
  array_push($arrayDiasGeneralComensales,[
    'nombres'=> $x['nombres'],
    'diasTrabajo'=> [],
  ]);
  foreach ($arrayDiasSelecionados as $y) {
    if (array_search($y['fecha'], $x['diasTrabajo']) !== false) {
      array_push($arrayDiasGeneralComensales[$contador]['diasTrabajo'], 1);
    }else {
      array_push($arrayDiasGeneralComensales[$contador]['diasTrabajo'], 0);
    }
  }
  $contador++;
}
echo "<pre>";
var_dump($arrayDiasGeneralComensales);
echo "<pre>";

/* echo "<pre>";
var_dump(createDateRangeArray('2022-06-10', '2022-07-28', $diasEspanol));
echo "<pre>"; */
/*   if (array_search($y['fecha'], $x['diasTrabajo']) !== false) {
    array_push($arrayDiasGeneralComensales,[
      'nombres' => 'fgdsg'
    ]);
  } */
