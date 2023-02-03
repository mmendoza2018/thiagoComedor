<?php
function plantilla($idPersona)
{
  require("../../conexion.php");
  $consulta = "SELECT *, di1.DISTRI_descripcion as distrito_nac, 
                         di2.DISTRI_descripcion as distrito, 
                         pro1.PROVI_descripcion as provincia_nac, 
                         pro2.PROVI_descripcion as provincia, 
                         de1.DEPA_descripcion as departamento_nac, 
                         de2.DEPA_descripcion as departamento
               FROM personas p
               LEFT JOIN distritos di1 ON p.PER_distrito_nac   = di1.DISTRI_id 
               LEFT JOIN distritos di2 ON p.PER_distrito = di2.DISTRI_id 
               LEFT JOIN provincias pro1 ON p.PER_provincia_nac  = pro1.PROVI_id 
               LEFT JOIN provincias pro2 ON p.PER_provincia  = pro2.PROVI_id 
               LEFT JOIN departamentos de1 ON p.PER_departamento_nac = de1.DEPA_id 
               LEFT JOIN departamentos de2 ON p.PER_departamento = de2.DEPA_id 
               WHERE PER_id=$idPersona";

  $resPersona = mysqli_query($conexion, $consulta);
  $arrayPersona = mysqli_fetch_assoc($resPersona);
//custom data 
 $arrayEstudios = json_decode($arrayPersona["PER_estudios"], true);
 $arrayOtrosEstudios = json_decode($arrayPersona["PER_otros_estudios"], true);
 $arrayDerechoHabientes = json_decode($arrayPersona["PER_derecho_habientes"], true);
 $arrayExperiencia = json_decode($arrayPersona["PER_experiencia"], true);
  $header = '';
  $plantilla = '
  <body>
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
      1. DATOS PERSONALES
    </div>
    <table class="border-table-none w-100 p-0">
      <tr>
        <td class="w-85 border-none p-0" style="border-none">
          <table class="border-collapse border-table w-100">
            <tr>
              <td class="bg-orange text-center">APELLIDO PATERNO</td>
              <td class="bg-orange text-center">APELLIDO MATERNO</td>
              <td class="bg-orange text-center">NOMBRES</td>
            </tr>
            <tr>
              <td>'.explode(" ",$arrayPersona["PER_apellidos"])[0].'</td>
              <td>'.explode(" ",$arrayPersona["PER_apellidos"])[1] .'</td>
              <td>'.$arrayPersona["PER_nombres"].'</td>
            </tr>
          </table>

          <table class="border-collapse border-table w-100 mt-2">
            <tr>
              <td class="bg-orange text-center">FECHA DE NACIMIENTO</td>
              <td class="bg-orange text-center" colspan="3">LUGAR DE NACIMIENTO</td>
            </tr>
            <tr>
              <td class="w-25">'.$arrayPersona["PER_fecha_nacimiento"].'</td>
              <td class="w-25">'.$arrayPersona["departamento_nac"].'</td>
              <td class="w-25">'.$arrayPersona["provincia_nac"].'</td>
              <td class="w-25">'.$arrayPersona["distrito_nac"].'</td>
            </tr>
            <tr>
              <td class="text-center w-25 bg-orange">DIA/MES/AÑO</td>
              <td class="text-center w-25 bg-orange">DISTRITO</td>
              <td class="text-center w-25 bg-orange">PROVINCIA</td>
              <td class="text-center w-25 bg-orange">DEPARTAMENTO</td>
            </tr>
          </table>

          <table class="border-collapse border-table w-100 mt-2">
            <tr>
              <td class="w-33">'.$arrayPersona["PER_usuario"].'</td>
              <td class="w-33">'.$arrayPersona["PER_sangre"].'</td>
              <td class="w-33">'.$arrayPersona["PER_celular"].'</td>
            </tr>
            <tr>
              <td class="text-center w-25 bg-orange">DNI</td>
              <td class="text-center w-25 bg-orange">GRUPO SANGUINEO</td>
              <td class="text-center w-25 bg-orange">TELÉFONO CELULAR</td>
            </tr>
          </table>

        </td>
        <td class="w-15" style="border: solid 1px black">

        </td>
      </tr>
    </table>

    <table class="border-collapse border-table w-100 mt-2">
      <tr>
        <td class="w-40">'.$arrayPersona["PER_correo"].'</td>
        <td class="w-35">'.$arrayPersona["PER_telefono"].'</td>
        <td class="w-35">'.$arrayPersona["PER_id"].'</td>
      </tr>
      <tr>
        <td class="w-40 text-center bg-orange">CORREO ELECTRONICO</td>
        <td class="w-35 text-center bg-orange">TELÉFONO DE LA CASA</td>
        <td class="w-35 text-center bg-orange">CÓDIGO DEL TRABAJADOR</td>
      </tr>
    </table>

    <table class="border-collapse border-table w-100 mt-2">
      <tr>
        <td class="w-40">'.json_decode($arrayPersona["PER_contacto"], true)["telefonos"].'</td>
        <td class="w-35">'.json_decode($arrayPersona["PER_contacto"], true)["persona"].'</td>
        <td class="w-35">'.json_decode($arrayPersona["PER_contacto"], true)["parentesco"].'</td>
      </tr>
      <tr>
        <td class="w-40 text-center bg-orange">TELÉFONOS DE EMERGENCIA</td>
        <td class="w-35 text-center bg-orange">PERSONA DE CONTACTO</td>
        <td class="w-35 text-center bg-orange">PARENTESCO</td>
      </tr>
    </table>

    <table class="border-collapse border-table w-100 mt-2">
      <tr>
        <td class="text-center bg-orange" colspan="4">IMPLEMENTOS DE SEGURIDAD - EPPS</td>
      </tr>
      <tr>
        <td class="w-25">'.json_decode($arrayPersona["PER_implementos"], true)["chaqueta"].'</td>
        <td class="w-25">'.json_decode($arrayPersona["PER_implementos"], true)["camisa"].'</td>
        <td class="w-25">'.json_decode($arrayPersona["PER_implementos"], true)["pantalon"].'</td>
        <td class="w-25">'.json_decode($arrayPersona["PER_implementos"], true)["zapatos"].'</td>
      </tr>
      <tr>
        <td class="text-center bg-orange">TALLA DE CHAQUETA</td>
        <td class="text-center bg-orange">TALLA DE CAMISA/POLO</td>
        <td class="text-center bg-orange">TALLA DE PANTALON</td>
        <td class="text-center bg-orange">TALLA DE ZAPATOS</td>
      </tr>
    </table>

    <div class="subtitle-box">
      2. DOMICILIO ACTUAL
    </div>

    <table class="border-collapse border-table w-100 mt-2">
      <tr>
        <td class="">'.$arrayPersona["PER_direccion"].'</td>
      </tr>
    </table>

    <table class="border-collapse border-table w-100 mt-2">
      <tr>
        <td class="w-33">'.$arrayPersona["distrito"].'</td>
        <td class="w-33">'.$arrayPersona["provincia"].'</td>
        <td class="w-33">'.$arrayPersona["departamento"].'</td>
      </tr>
      <tr>
        <td class="text-center bg-orange">DISTRITO</td>
        <td class="text-center bg-orange">PROVINCIA</td>
        <td class="text-center bg-orange">DEPARTAMENTO</td>
      </tr>
    </table>

    <table class="border-collapse border-table w-100 mt-2">
      <tr>
        <td class="">'.$arrayPersona["PER_referencia"].'</td>
      </tr>
      <tr>
        <td class="text-center bg-orange">REFERENCIA</td>
      </tr>
    </table>

    <div class="subtitle-box">
      3. EDUCACIÓN
    </div>

    <table class="border-collapse border-table w-100 mt-2">
      <tr>
        <td class="w-20 bg-orange">ESTUDIOS</td>
        <td class="w-20 bg-orange">INSTITUCIÓN</td>
        <td class="w-20 bg-orange">ESPECIALIDAD</td>
        <td class="w-20 bg-orange">GRADO OB.</td>
        <td class="w-10 bg-orange">DESDE</td>
        <td class="w-10 bg-orange">HASTA</td>
      </tr>';
      foreach ($arrayEstudios as $x) {
          
        $plantilla .= '<tr>
          <td class="">'.$x[0].'</td>
          <td class="">'.$x[1].'</td>
          <td class="">'.$x[2].'</td>
          <td class="">'.$x[3].'</td>
          <td class="">'.$x[4].'</td>
          <td class="">'.$x[5].'</td>
        </tr>';
      }

    $plantilla .= '</table>

    <div class="subtitle-box">
      4. OTROS ESTUDIOS
    </div>

    <table class="border-collapse border-table w-100 mt-2">
      <tr>
        <td class="w-40 bg-orange">NOMBRE DEL CURSO</td>
        <td class="w-40 bg-orange">INSTITUCIÓN</td>
        <td class="w-10 bg-orange">DESDE</td>
        <td class="w-10 bg-orange">HASTA</td>
      </tr>';
      foreach ($arrayOtrosEstudios as $x) {
      $plantilla .= '<tr>
        <td class="">'.$x[0].'</td>
        <td class="">'.$x[1].'</td>
        <td class="">'.$x[2].'</td>
        <td class="">'.$x[3].'</td>
      </tr>';
      }
    $plantilla .= '</table>

    <div class="subtitle-box">
      5. ELECCIÓN DE PAGOS
    </div>

    <table class="border-collapse border-table w-100 mt-2">
      <tr>
        <td class="w-20 fw-bold bg-orange">SUELDO</td>
        <td class="w-20 fw-bold">NRO. DE CUENTA</td>
        <td class="w-20" colspan="3"></td>
      </tr>
      <tr>
        <td class="w-20 p-0">
          <table class="border-table-none w-100">
            <tr>
              <td class="w-90 border-right">INTERBANK</td>
              <td class="w-10">';
              if($arrayPersona["PER_banco_sueldo"] == "INTERBANK") $plantilla .= 'X';
              $plantilla .= '</td>
            </tr>
          </table>
        </td>
        <td class="w-20 p-0">
          <table class="border-table-none w-100">
            <tr>
              <td class="w-90">BANCO FALABELLA</td>
              <td class="w-10">';
              if($arrayPersona["PER_banco_sueldo"] == "BANCO FALABELLA") $plantilla .= 'X';
              $plantilla .= '</td>
            </tr>
          </table>
        </td>
        <td class="w-20 p-0">
          <table class="border-table-none w-100">
            <tr>
              <td class="w-90">CONTINENTAL</td>
              <td class="w-10">';
              if($arrayPersona["PER_banco_sueldo"] == "CONTINENTAL") $plantilla .= 'X';
              $plantilla .= '</td>
            </tr>
          </table>
        </td>
        <td class="w-20 p-0">
          <table class="border-table-none w-100">
            <tr>
              <td class="w-90">SCOTIABANK</td>
              <td class="w-10">';
              if($arrayPersona["PER_banco_sueldo"] == "SCOTIABANK") $plantilla .= 'X';
              $plantilla .= '</td>
            </tr>
          </table>
        </td>
        <td class="w-20 p-0">
          <table class="border-table-none w-100">
            <tr>
              <td class="w-90">BANCO DE CRÉDITO DEL PERÚ</td>
              <td class="w-10">';
              if($arrayPersona["PER_banco_sueldo"] == "BANCO DE CRÉDITO DEL PERÚ") $plantilla .= 'X';
              $plantilla .= '</td>
            </tr>
          </table>
        </td>
      </tr>
    </table>

    <table class="border-collapse border-table w-100 mt-2">
      <tr>
        <td class="w-20 fw-bold bg-orange">CTS</td>
        <td class="w-20 fw-bold">NRO. DE CUENTA</td>
        <td class="w-20" colspan="2"></td>
      </tr>
      <tr>
        <td class="w-25 p-0">
          <table class="border-table-none w-100">
            <tr>
              <td class="w-90 border-right">INTERBANK</td>
              <td class="w-10">';
              if($arrayPersona["PER_banco_cts"] == "INTERBANK") $plantilla .= 'X';
              $plantilla .= '</td>
            </tr>
          </table>
        </td>
        <td class="w-25 p-0">
          <table class="border-table-none w-100">
            <tr>
              <td class="w-90">BANCO FALABELLA</td>
              <td class="w-10">';
              if($arrayPersona["PER_banco_cts"] == "BANCO FALABELLA") $plantilla .= 'X';
              $plantilla .= '</td>
            </tr>
          </table>
        </td>
        <td class="w-25 p-0">
          <table class="border-table-none w-100">
            <tr>
              <td class="w-90">CONTINENTAL</td>
              <td class="w-10">';
              if($arrayPersona["PER_banco_cts"] == "CONTINENTAL") $plantilla .= 'X';
              $plantilla .= '</td>
            </tr>
          </table>
        </td>
        <td class="w-25 p-0">
          <table class="border-table-none w-100">
            <tr>
              <td class="w-90">BANCO DE CRÉDITO DEL PERÚ</td>
              <td class="w-10">';
              if($arrayPersona["PER_banco_cts"] == "BANCO DE CRÉDITO DEL PERÚ") $plantilla .= 'X';
              $plantilla .= '</td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td class="w-25 p-0">
          <table class="border-table-none w-100">
            <tr>
              <td class="w-90">BANCO FINANCIERO</td>
              <td class="w-10">';
              if($arrayPersona["PER_banco_cts"] == "BANCO FINANCIERO") $plantilla .= 'X';
              $plantilla .= '</td>
            </tr>
          </table>
        </td>
        <td class="w-25 p-0">
          <table class="border-table-none w-100">
            <tr>
              <td class="w-90">BANBIF</td>
              <td class="w-10">';
              if($arrayPersona["PER_banco_cts"] == "BANBIF") $plantilla .= 'X';
              $plantilla .= '</td>
            </tr>
          </table>
        </td>
        <td class="w-25 p-0">
          <table class="border-table-none w-100">
            <tr>
              <td class="w-90">SCOTIABANK</td>
              <td class="w-10">';
              if($arrayPersona["PER_banco_cts"] == "SCOTIABANK") $plantilla .= 'X';
              $plantilla .= '</td>
            </tr>
          </table>
        </td>
        <td class="w-25 p-0">
          <table class="border-table-none w-100">
            <tr>
              <td class="w-90">CAJA AREQUIPA</td>
              <td class="w-10">';
              if($arrayPersona["PER_banco_cts"] == "CAJA AREQUIPA") $plantilla .= 'X';
              $plantilla .= '</td>
            </tr>
          </table>
        </td>
      </tr>
    </table>

    <div class="subtitle-box">
      6. REGIMEN PENSIONARIO
    </div>
    
    <table class="border-collapse border-table w-100 mt-2">
      <tr>
        <td class="w-25 fw-bold" colspan="4">
          <p>SISTEMA DE PENSIONES</p>
          Declaro haber recibido el Boletín Informativo y por lo tanto:
        </td>
      </tr>
      <tr>
        <td class=" p-0" colspan="2">
          <table class="border-table-none w-100">
            <tr>
              <td class="w-90 border-right p-0 fw-bold">A) Deseo permanecer:</td>
              <td class="w-10 p-0"></td>
            </tr>
            <tr>
              <td class="w-90 border-right p-0">Sistema Nacional de Pensiones (ONP)</td>
              <td class="w-10 p-0">';
              $plantilla .= ($arrayPersona["PER_sis_pension"] == "ONP") ? '( SI )' : '( )';
              $plantilla .= '</td>
              </tr>
              <tr>
              <td class="w-90 border-right p-0 fw-bold">B) Realicen mi afiliación al:</td>
              <td class="w-10 p-0"></td>
              </tr>
              <tr>
              <td class="w-90 border-right p-0">Sistema Privado de Pensiones (AFP)</td>
              <td class="w-10 p-0">';
              $plantilla .= ($arrayPersona["PER_sis_pension"] == "AFP") ? '( SI )' : '( )';
              $plantilla .= '</td>
            </tr>
          </table>
        </td>
        <td class="" colspan="2">
        En tu primera afiliación al SPP, la AFP es elegida por el estado en un periodo que dura 2 años, ya que ofrece un menor costo para el afiliado. 
        Actualmente la AFP que te correspondería sería Integra. Si deseas cambiar de AFP puedes hacerlo después de los 2 primeros años de tu afiliación.
        </td>
      </tr>
    </table>

    <table class="border-collapse border-table w-100 mt-2">
      <tr>
        <td class="fw-bold">
          De estar afiliado a alguna AFP, declaro estar afiliado a:
        </td>
        <td class="fw-bold">
        Código Único C.U.S.P.P.
      </td>
      </tr>
      <tr>
      <td class="w-80 p-0">
        <table class="border-table-none w-100">
            <tr>
              <td class="">Integra</td>
              <td class="text-center" style="width: 20px; border-right: solid 1px black;">';
              if($arrayPersona["PER_afp"] == "Integra") $plantilla .= 'X';
              $plantilla .= '</td>
              <td class="">Prima</td>
              <td class="text-center" style="width: 20px; border-right: solid 1px black;">';
              if($arrayPersona["PER_afp"] == "Prima") $plantilla .= 'X';
              $plantilla .= '</td>
              <td class="">Profuturo</td>s
              <td class="text-center" style="width: 20px; border-right: solid 1px black;">';
              if($arrayPersona["PER_afp"] == "Profuturo") $plantilla .= 'X';
              $plantilla .= '</td>
              <td class="">Habitad</td>
              <td class="text-center" style="width: 20px;">';
              if($arrayPersona["PER_afp"] == "Habitad") $plantilla .= 'X';
              $plantilla .= '</td>
            </tr>
        </table>
      </td>
      <td class="w-20">
      fdsfsdf
      </td>
      </tr>
    </table>

    <div class="subtitle-box">
      7. SITUACIÓN ECONÓMICA
    </div>

    <table class="border-collapse border-table w-100 mt-2">
      <tr>
        <td class="w-20 fw-bold" colspan="2">
          La casa que habita actualmente es: 
        </td>
        <td class="w-20 p-0" colspan="3">
          <table class="border-table-none w-100">
            <tr>
              <td class="">Propia</td>
              <td class="text-center" style="width: 20px; border-right: solid 1px black;">';
              if($arrayPersona["PER_vivienda"] == "Propia") $plantilla .= 'X';
              $plantilla .= '</td>
              <td class="">Alquilada</td>
              <td class="text-center" style="width: 20px; border-right: solid 1px black;">';
              if($arrayPersona["PER_vivienda"] == "Alquilada") $plantilla .= 'X';
              $plantilla .= '</td>
              <td class="">Familiar</td>s
              <td class="text-center" style="width: 20px;">';
              if($arrayPersona["PER_vivienda"] == "Familiar") $plantilla .= 'X';
              $plantilla .= '</td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td class="20 p-0">
          <table class="border-table-none w-100 p-0">
            <tr>
              <td class="fw-bold">¿Posee vehículo propio?</td>
              <td class="text-center" style="width: 20px; border-left: solid 1px black;">'.$arrayPersona["PER_vehiculo"].'</td>
            </tr>
          </table>
        </td>
        <td class="20 p-0">
          <table class="border-table-none w-100 p-0">
          <tr>
            <td class="fw-bold">¿Posee vehículo propio?</td>
            <td class="text-center" style="width: 20px; border-left: solid 1px black;">'.$arrayPersona["PER_vehiculo_pagado"].'</td>
          </tr>
          </table>
        </td>
      </tr>
      <tr>
    </table>

    <div class="subtitle-box">
      8. DERECHOHABIENTES
    </div>

    <table class="border-collapse border-table w-100 mt-2">
      <tr>
        <td class="w-40 bg-orange">NOMBRES Y APELLIDOS</td>
        <td class="w-15 bg-orange">VINCULO</td>
        <td class="w-15 bg-orange">F. NACIMIENTO </td>
        <td class="w-15 bg-orange">SEXO</td>
        <td class="w-15 bg-orange">DNI</td>
      </tr>';

        foreach ($arrayDerechoHabientes as $x) {
        $plantilla .= '<tr>
        <td class="">'.$x[0].'</td>
        <td class="">'.$x[1].'</td>
        <td class="">'.$x[2].'</td>
        <td class="">'.$x[3].'</td>
        <td class="">'.$x[4].'</td>
      </tr>';
      }

    $plantilla .= '</table>

    <div class="subtitle-box">
      9. EXPERIENCIA LABORAL
    </div>

    <table class="border-collapse border-table w-100 mt-2">
      <tr>
        <td class="w-30 bg-orange">EMPRESA</td>
        <td class="w-10 bg-orange">F. INICIO</td>
        <td class="w-10 bg-orange">F. FIN  </td>
        <td class="w-30 bg-orange">CARGO</td>
        <td class="w-20 bg-orange">REMUNERACIÓN</td>
      </tr>';
      foreach ($arrayExperiencia as $x) {
      $plantilla .= '<tr>
        <td class="">'.$x[0].'</td>
        <td class="">'.$x[1].'</td>
        <td class="">'.$x[2].'</td>
        <td class="">'.$x[3].'</td>
        <td class="">'.$x[4].'</td>
      </tr>';
      }

    $plantilla .= '</table>

    <div class="subtitle-box">
      10. RENTA DE 5TA CATEGORIA
    </div>

    <table class="border-collapse border-table w-100 mt-2">
      <tr>
        <td class="w-40 text-center fw-bold">Durante el 2019 ¿Ha percibido ingresos por concepto de renta de quinta en algún trabajo anterior?</td>
        <td class="w-10 text-center">'.$arrayPersona["PER_5ta_ingresos"].'</td>
        </tr>
        <tr>
        <td class="fw-bold">¿Percibe ingresos adicionales de renta de quinta?</td>
        <td class="w-10 text-center">'.$arrayPersona["PER_5ta_adicional"].'</td>
        <td class="w-10 text-center fw-bold">Empresa</td>
        <td class="w-40 text-center">'.$arrayPersona["PER_5ta_empresa"].'</td>
      </tr>
    </table>

    <div class="subtitle-box">
      11. CROQUIS DOMICILIARIO
    </div>
    <div class="crockis">
    </div>

    <div class="subtitle-box">
      12. DECLARACIONES
    </div>
    
    <div class="mt-3">
      <ol>
        <li>Los datos anotados en esta solicitud son fidedignos y no hay omisión alguna de mi parte. De  acuerdo a lo regulado por la Ley N° 27444, Ley del Procedimiento Administrativo General, en caso de comprobarse falsedad alguna me someteré a las sanciones previstas por ley.</li>
        <li>Autorizo a SERVICIO GENERALES THIAGO & ARIS E.I.R.L. para verificar los datos declarados y validar la información que desee.</li>
        <li>Me comprometo a considerar como estrictamente confidencial y guardar en absoluta reserva toda clase de información que llegue a  adquirir y no hacer uso de ella en beneficio de personas o empresas ajenas a THIAGO & ARIS E.I.R.L. ya sea cuando esté a  su servicio o fuera de él.</li>
        <li>Notificar oportunamente mis cambios de domicilio.	</li>
      </ol>
      <div class="ms-5 mb-0">
        <p>declaro bajo juramento que estoy de acuerdo con las declaraciones expuestas anteriormente.</p>
        <p class="ms-5">Arequipa, ……… de …………………………… del </p>
      </div>
      <div class="text-end mt-0 p-0">
      <div class="huella"  style="margin-left: 600px"></div>
      <div style="margin-right: 250px; color:black" >___________________________________________</div>
      
      </div>
    </div>
  </body>';
  $footer = '';

  return [$plantilla, $header, $footer];
}
