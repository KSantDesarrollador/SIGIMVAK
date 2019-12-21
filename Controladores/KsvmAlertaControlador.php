<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Modelos/KsvmAlertaModelo.php";
   } else {
       require_once "./Modelos/KsvmAlertaModelo.php";
   }

   class KsvmAlertaControlador extends KsvmAlertaModelo
   {
     /**
      *Función que permite ingresar una alerta
      */
     public function __KsvmAgregarAlertaControlador()
     {
         $KsvmNomAle = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmNomAle']);
         $KsvmColorAle = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmColorAle']);
         $KsvmDescAle = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmDescAle']);


         $KsvmNombre = "SELECT AltNomAle FROM ksvmalerta15 WHERE AltNomAle ='$KsvmNomAle'";
         $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmNombre);
         if ($KsvmQuery->rowCount() == 1) {
            $KsvmAlerta = [
              "Alerta" => "simple",
              "Titulo" => "Error inesperado",
              "Cuerpo" => "El nombre de la alerta ingresada ya se encuentra registrado, Por favor ingrese un nombre válido",
              "Tipo" => "info"
             ];
         }else{
              $KsvmNuevaAlerta = [
                "KsvmNomAle" => $KsvmNomAle,
                "KsvmColorAle" => $KsvmColorAle,
                "KsvmDescAle" => $KsvmDescAle
                ];

                $KsvmGuardarAle = KsvmAlertaModelo :: __KsvmAgregarAlertaModelo($KsvmNuevaAlerta);
                if ($KsvmGuardarAle->rowCount() >= 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Limpia",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "La alerta se registró satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido registrar la alerta",
                    "Tipo" => "info"
                    ];
                }
                
            }
            return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
        }
            
    /**
     * Función que permite paginar 
     */
      public function __KsvmPaginador($KsvmPagina, $KsvmNRegistros, $KsvmRol, $KsvmCodigo, $KsvmBuscar)
      {
        $KsvmPagina = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmPagina);
        $KsvmNRegistros = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmNRegistros);
        $KsvmRol = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmRol);
        $KsvmCodigo = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmCodigo);
        $KsvmBuscar = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmBuscar);
        $KsvmTabla = "";
        
        $KsvmPagina = (isset($KsvmPagina) && $KsvmPagina > 0 ) ? (int)$KsvmPagina : 1;
        $KsvmDesde = ($KsvmPagina > 0) ? (($KsvmPagina*$KsvmNRegistros) - $KsvmNRegistros) : 0;

        if (isset($KsvmBuscar) && $KsvmBuscar != "") {
            $KsvmDataAle = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmalerta15 WHERE (AltNomAle LIKE '%$KsvmBuscar%' 
                          OR AltDescAle LIKE '%$KsvmBuscar%') ORDER BY AltNomAle LIMIT $KsvmDesde, $KsvmNRegistros";
        } else {
            $KsvmDataAle = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmalerta15 ORDER BY AltNomAle LIMIT $KsvmDesde, $KsvmNRegistros" ;
        }
        

        $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
    
        $KsvmQuery = $KsvmConsulta->query($KsvmDataAle);
        $KsvmQuery = $KsvmQuery->fetchAll();
        
        $KsvmDataTot = "SELECT FOUND_ROWS()";
        $KsvmTotalReg = $KsvmConsulta->query($KsvmDataTot);
        $KsvmTotalReg = (int) $KsvmTotalReg->fetchColumn();
        $KsvmNPaginas = ceil($KsvmTotalReg/$KsvmNRegistros);

        $KsvmTabla .= '<table class="mdl-data-table mdl-js-data-table mdl-shadow--6dp full-width table-responsive">
                        <thead>
                            <tr>
                                <th class="mdl-data-table__cell--non-numeric">#</th>
                                <th class="mdl-data-table__cell--non-numeric">Nombre</th>
                                <th class="mdl-data-table__cell--non-numeric">Color</th>
                                <th class="mdl-data-table__cell--non-numeric">Descripción</th>
                                <th style="text-align:center; witdh:30px;">Acción</th>
                            </tr>
                        </thead>
                        <tbody>';

        if ($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas) {
            $KsvmContReg = $KsvmDesde +1;
            foreach ($KsvmQuery as $rows) {
                $KsvmTabla .= '<tr>
                                <td class="mdl-data-table__cell--non-numeric">'.$KsvmContReg.'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['AltNomAle'].'</td>
                                <td class="mdl-data-table__cell--non-numeric"><button class="btn btn-md" style="border-color:#000; background-color:'.$rows['AltColorAle'].';"></button></td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['AltDescAle'].'</td>
                                <td style="text-align:right; witdh:30px;">';
                                if ($KsvmRol == 1) {
                                    if ($KsvmCodigo == 0) {

                                    $KsvmTabla .=  '<form action="'.KsvmServUrl.'Ajax/KsvmRequisicionAjax.php" method="POST" class="FormularioAjax" data-form="eliminar" enctype="multipart/form-data"> 
                                                    <a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmAlertasCrud/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['AltId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmAlertasEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['AltId']).'/0/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>
                                                    <input type="hidden" name="KsvmCodDelete" value="'.KsvmEstMaestra::__KsvmEncriptacion($rows['AltId']).'">              
                                                    <button id="btn-delete" type="submit" class="btn btn-sm btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                                    <div class="RespuestaAjax"></div>
                                                    </form>';
                                    } else {
                                    $KsvmTabla .= '<form action="'.KsvmServUrl.'Ajax/KsvmRequisicionAjax.php" method="POST" class="FormularioAjax" data-form="eliminar" enctype="multipart/form-data"> 
                                                    <a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmAlertas/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['AltId']).'"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmAlertasEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['AltId']).'/1/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>
                                                    <input type="hidden" name="KsvmCodDelete" value="'.KsvmEstMaestra::__KsvmEncriptacion($rows['AltId']).'">              
                                                    <button id="btn-delete" type="submit" class="btn btn-sm btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                                    <div class="mdl-tooltip" for="btn-delete">Inhabilitar</div>
                                                    <div class="RespuestaAjax"></div>
                                                    </form>'; 
                                    }
                                }elseif ($KsvmRol == 2 || $KsvmRol == 3){
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmAlertas/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['AltId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmAlertasEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['AltId']).'/1/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>';
                                }else{
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmAlertas/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['AltId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>';
                                }

                                    

                $KsvmTabla .= '</td>
                               </tr>
                             </tbody>';
                             $KsvmContReg ++;
                             }

                            
                $KsvmTabla .= '</table>

                           <br>
				           <div class=" mdl-shadow--8dp full-width">
                            <nav class="navbar-form navbar-left form-group">
				            <span class="">
				             <strong>Total de '.$KsvmTotalReg.' </strong> registros encontrados
				            </span>
				            <span>&nbsp;|&nbsp;</span>
				            <span>
							 Página<strong>'.$KsvmPagina.'</strong> de <strong>'.$KsvmNPaginas.'</strong>
				            </span>
                            <span>&nbsp;|&nbsp;</span>
                            </nav>';
                            
        } else {
            if ($KsvmTotalReg >= 1) {
                echo '<script> window.location.href=" '.KsvmServUrl.'KsvmAlertasCrud"</script>';
            } else {
                $KsvmTabla .= '<tr> 
                            <td class="mdl-data-table__cell--non-numeric" colspan="7"><strong>No se encontraron registros...</strong></td>
                           </tr>
                          </tbody>
                          </table>';

            }
        }
            if ($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas && $KsvmCodigo == 0) {

                $KsvmTabla .= '<nav class="navbar-form navbar-right form-group">';
                
                if ($KsvmPagina == 1) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Primero</button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-rewind"></i></button>';
                } else {
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmAlertasCrud/1/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmAlertasCrud/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmAlertasCrud/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmAlertasCrud/'.($KsvmNPaginas).'/">Último</a>';
                                               
                }
                
             
                $KsvmTabla .= '</nav></div>';   

            } else {
                $KsvmTabla .= '<nav class="navbar-form navbar-right form-group">';
                
                if ($KsvmPagina == 1) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Primero</button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-rewind"></i></button>';
                } else {
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmAlertas/1/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmAlertas/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmAlertas/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmAlertas/'.($KsvmNPaginas).'/">Último</a>';
                                   
                                   
                }
                
                $KsvmTabla .= '</nav></div>'; 
            }
            
        
                                   
        return $KsvmTabla;
      }
     
      /**
       * Función que permite inhabilitar una alerta
       */
      public function __KsvmEliminarAlertaControlador()
      {
         $KsvmCode = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodDelete']);
         $KsvmCodeAle = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmCode);

         $KsvmDelAle = KsvmAlertaModelo :: __KsvmEliminarAlertaModelo($KsvmCodeAle);
         if ($KsvmDelAle->rowCount() == 1) {
            $KsvmAlerta = [
                "Alerta" => "Actualiza",
                "Titulo" => "Alerta Inhabilitada",
                "Cuerpo" => "La alerta seleccionada ha sido inhabilitada con éxito",
                "Tipo" => "success"
                ];
         } else {
            $KsvmAlerta = [
                "Alerta" => "simple",
                "Titulo" => "Error inesperado",
                "Cuerpo" => "No es posible eliminar la alerta seleccionada",
                "Tipo" => "info"
                ];
         }

         return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
      }
    
      /**
       * Función que permite editar una alerta 
       */
      public function __KsvmEditarAlertaControlador($KsvmCodEditar)
      {
          $KsvmCodAle = KsvmEstMaestra :: __KsvmDesencriptacion($KsvmCodEditar);

          return KsvmAlertaModelo :: __KsvmEditarAlertaModelo($KsvmCodAle);
      }
      
      /**
       * Función que permite contar una alerta 
       */
      public function __KsvmContarAlertaControlador()
      {
          return KsvmAlertaModelo :: __KsvmContarAlertaModelo(0);
      }

      /**
       * Función que permite imprimir una alerta 
       */
      public function __KsvmImprimirAlertaControlador()
      {
        return KsvmAlertaModelo :: __KsvmImprimirAlertaModelo();
      }

      /**
       * Función que permite actualizar una alerta 
       */
      public function __KsvmActualizarAlertaControlador()
      {
        $KsvmCodAle = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodEdit']);
        $KsvmNomAle = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmNomAle']);
        $KsvmColorAle = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmColorAle']);
        $KsvmDescAle = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmDescAle']);

        $KsvmConsulta = "SELECT * FROM ksvmalerta15 WHERE AltId = '$KsvmCodAle'";
        $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmConsulta);
        $KsvmDataAlerta = $KsvmQuery->fetch();

        if ($KsvmNomAle != $KsvmDataAlerta['AltNomAle']) {
            $KsvmConsulta = "SELECT AltNomAle FROM ksvmalerta15 WHERE AltNomAle = '$KsvmNomAle'";
            $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmConsulta);
            if ($KsvmQuery->rowCount() >= 1) {
                $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Error Inesperado",
                    "Cuerpo" => "El Nombre de la alerta ingresada ya se encuentra registrado, Por favor ingrese un nombre válido",
                    "Tipo" => "info"
                    ];
                    return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
                    exit();
            }
        }

        $KsvmActualAle = [
            "KsvmNomAle" => $KsvmNomAle,
            "KsvmColorAle" => $KsvmColorAle,
            "KsvmDescAle" => $KsvmDescAle,
            "KsvmCodAlerta" => $KsvmCodAle
            ];

            $KsvmGuardarAle = KsvmAlertaModelo :: __KsvmActualizarAlertaModelo($KsvmActualAle);
                if ($KsvmGuardarAle->rowCount() >= 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "La alerta se actualizó satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido actualizar la información de la alerta",
                    "Tipo" => "info"
                    ];
                }
                return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
         
        }

      /**
       * Función que permite seleccionar una Alerta 
       */
      public function __KsvmSeleccionarAlerta(){

        $KsvmSelectExt = "SELECT * FROM ksvmalerta15";

        $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
        $KsvmQuery = $KsvmConsulta->query($KsvmSelectExt);
        $KsvmQuery = $KsvmQuery->fetchAll();
        $KsvmListar = '<option value="" selected="" disabled>Seleccione Alerta</option>';

        foreach ($KsvmQuery as $row) {
            $KsvmListar .= '<option value="'.$row['AltId'].'">'.$row['AltNomAle'].'</option>';
        }
        return $KsvmListar;
    }
    
}
   
 