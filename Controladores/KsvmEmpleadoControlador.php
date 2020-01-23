<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Modelos/KsvmEmpleadoModelo.php";
   } else {
       require_once "./Modelos/KsvmEmpleadoModelo.php";
   }

   class KsvmEmpleadoControlador extends KsvmEmpleadoModelo
   {
     /**
      *Función que permite ingresar un empleado
      */
     public function __KsvmAgregarEmpleadoControlador()
     {
        if ($_POST['KsvmIdParroquia'] == "") {
            $KsvmCodProc = $_POST['KsvmIdPais'];
         } else {
            $KsvmCodProc = $_POST['KsvmIdParroquia'];
         }
         
         
         $KsvmProcedencia = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmCodProc);
         $KsvmCargo = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmCargo']);
         $KsvmRol = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmRol']);
         $KsvmTipoIdent = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmTipoIdent']);
         $KsvmIdent = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmIdent']);
         $KsvmPrimApel = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmPrimApel']);
         $KsvmSegApel = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmSegApel']);
         $KsvmPrimNom = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmPrimNom']);
         $KsvmSegNom = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmSegNom']);
         $KsvmFchNac = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmFchNac']);
         $KsvmDirc = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmDirc']);
         $KsvmTelf = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmTelf']);
         $KsvmEmail = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmEmail']);
         $KsvmEstCiv = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmEstCiv']);
         $KsvmSexo = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmSexo']);
         $KsvmGenero = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmGenero']);
         if ($_FILES['KsvmFotoEmp']['error'] > 0) {
            $KsvmFotoEmp = "";
        } else {
            $KsvmFotoEmp = file_get_contents($_FILES['KsvmFotoEmp']['tmp_name']);
        }
        
         $KsvmCalulaEdad = self :: __KsvmCalculaEdad($KsvmFchNac);
         if ($KsvmCalulaEdad >= 18 && $KsvmCalulaEdad <= 50) {
             $KsvmFchNacEmp = $KsvmFchNac;
         } else {
            $KsvmAlerta = [
                "Alerta" => "simple",
                "Titulo" => "Error inesperado",
                "Cuerpo" => "La fecha de nacimiento no es correcta, El rango aceptado está entre 18 y 50 años",
                "Tipo" => "info"
               ];
               return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
         }
         
         $KsvmEmaEm = "";

         $KsvmIdentificacion = "SELECT EpoIdentEmp FROM ksvmempleado03 WHERE EpoIdentEmp ='$KsvmIdent'";
         $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmIdentificacion);
         if ($KsvmQuery->rowCount() == 1) {
            $KsvmAlerta = [
              "Alerta" => "simple",
              "Titulo" => "Error inesperado",
              "Cuerpo" => "El número de identificación ingresado ya se encuentra registrado, Por favor ingrese un número válido",
              "Tipo" => "info"
             ];
             return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
         } elseif ($KsvmEmail != "") {
              $KsvmEmailQ = "SELECT EpoEmailEmp FROM ksvmempleado03 WHERE EpoEmailEmp ='$KsvmEmail'";
              $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmEmailQ);
              $KsvmEmaEm = $KsvmQuery->rowCount();
           }else{
               $KsvmEmaEm = 0;
           }
         
             if ($KsvmEmaEm == 1) {
               $KsvmAlerta = [
               "Alerta" => "simple",
               "Titulo" => "Error inesperado",
               "Cuerpo" => "El Email ingresado ya se encuentra registrado, Por favor ingrese un Email válido",
               "Tipo" => "info"
              ];
             }else{
              $KsvmNuevoEmp = [
                "KsvmCrgId" => $KsvmCargo,
                "KsvmPrcId" => $KsvmProcedencia,
                "KsvmRrlId" => $KsvmRol,
                "KsvmEpoTipIdentEmp" => $KsvmTipoIdent,
                "KsvmEpoIdentEmp" => $KsvmIdent,
                "KsvmEpoPriApeEmp" => $KsvmPrimApel,
                "KsvmEpoSegApeEmp" => $KsvmSegApel,
                "KsvmEpoPriNomEmp" => $KsvmPrimNom,
                "KsvmEpoSegNomEmp" => $KsvmSegNom,
                "KsvmEpoTelfEmp" => $KsvmTelf,
                "KsvmEpoDirEmp" => $KsvmDirc,
                "KsvmEpoFchNacEmp" => $KsvmFchNacEmp,
                "KsvmEpoEmailEmp" => $KsvmEmail,
                "KsvmEpoSexoEmp" => $KsvmSexo,
                "KsvmEpoGeneroEmp" => $KsvmGenero,
                "KsvmEpoEstCivEmp" => $KsvmEstCiv,
                "KsvmFotoEmp" => $KsvmFotoEmp
                ];

                $KsvmGuardarEmp = KsvmEmpleadoModelo :: __KsvmAgregarEmpleadoModelo($KsvmNuevoEmp);
                if ($KsvmGuardarEmp->rowCount() >= 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "El empleado se registró satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido registrar el empleado",
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
            $KsvmDataEmp = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistaempleado WHERE ((RrlId != '$KsvmRol') AND (EpoPriApeEmp LIKE '%$KsvmBuscar%' 
                          OR EpoPriNomEmp LIKE '%$KsvmBuscar%' OR EpoIdentEmp LIKE '%$KsvmBuscar%'OR CrgNomCar LIKE '%$KsvmBuscar%')) AND RrlNomRol != 'Administrador'
                          LIMIT $KsvmDesde, $KsvmNRegistros";
        } else {
            $KsvmDataEmp = "SELECT SQL_CALC_FOUND_ROWS * FROM ksvmvistaempleado WHERE RrlId != '$KsvmRol' AND RrlNomRol != 'Administrador' LIMIT $KsvmDesde, $KsvmNRegistros" ;
        }
        

        $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
    
        $KsvmQuery = $KsvmConsulta->query($KsvmDataEmp);
        $KsvmQuery = $KsvmQuery->fetchAll();
        
        $KsvmDataTot = "SELECT FOUND_ROWS()";
        $KsvmTotalReg = $KsvmConsulta->query($KsvmDataTot);
        $KsvmTotalReg = (int) $KsvmTotalReg->fetchColumn();
        $KsvmNPaginas = ceil($KsvmTotalReg/$KsvmNRegistros);

        $KsvmTabla .= '<table class="mdl-data-table mdl-js-data-table mdl-shadow--6dp full-width table-responsive">
                        <thead>
                            <tr>
                                <th class="mdl-data-table__cell--non-numeric">#</th>
                                <th class="mdl-data-table__cell--non-numeric">Foto</th>
                                <th class="mdl-data-table__cell--non-numeric">Dni</th>
                                <th class="mdl-data-table__cell--non-numeric">Nombres</th>
                                <th class="mdl-data-table__cell--non-numeric">Telf</th>
                                <th class="mdl-data-table__cell--non-numeric">Edad</th>
                                <th class="mdl-data-table__cell--non-numeric">Sexo</th>
                                <th style="text-align:center; witdh:30px;">Acción</th>
                            </tr>
                        </thead>
                        <tbody>';

        if ($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas) {
            $KsvmContReg = $KsvmDesde +1;
            foreach ($KsvmQuery as $rows) {
                if ($rows['EpoSexoEmp'] == 'M') {
                    $KsvmSexo = 'Mujer';
                }else{
                    $KsvmSexo = 'Hombre';
                }
                $KsvmTabla .= '<tr>
                                <td class="mdl-data-table__cell--non-numeric">'.$KsvmContReg.'</td>
                                <td class="mdl-data-table__cell--non-numeric"><img style="border-radius:30px;" height="35px" width="35px" src="data:image/jpg;base64,'. base64_encode($rows['EpoFotoEmp']).'"/></td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['EpoIdentEmp'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['EpoPriApeEmp']." ".$rows['EpoSegApeEmp']." ".$rows['EpoPriNomEmp']." ".$rows['EpoSegNomEmp'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$rows['EpoTelfEmp'].'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$KSvmEdad = self :: __KsvmCalculaEdad($rows['EpoFchNacEmp']).'</td>
                                <td class="mdl-data-table__cell--non-numeric">'.$KsvmSexo.'</td>
                                <td style="text-align:right; witdh:30px;">';
                                if ($KsvmRol == 1) {
                                    if ($KsvmCodigo == 0) {

                                    $KsvmTabla .=  '<form action="'.KsvmServUrl.'Ajax/KsvmEmpleadoAjax.php" method="POST" class="FormularioAjax" data-form="eliminar" enctype="multipart/form-data"> 
                                                    <a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmEmpleadosCrud/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['EpoId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmEmpleadosEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['EpoId']).'/0/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>
                                                    <input type="hidden" name="KsvmCodDelete" value="'.KsvmEstMaestra::__KsvmEncriptacion($rows['EpoId']).'">              
                                                    <button id="btn-delete" type="submit" class="btn btn-sm btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                                    <div class="RespuestaAjax"></div>
                                                    </form>';
                                    } else {
                                    $KsvmTabla .= '<form action="'.KsvmServUrl.'Ajax/KsvmEmpleadoAjax.php" method="POST" class="FormularioAjax" data-form="eliminar" enctype="multipart/form-data"> 
                                                    <a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmEmpleados/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['EpoId']).'"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmEmpleadosEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['EpoId']).'/1/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>
                                                    <input type="hidden" name="KsvmCodDelete" value="'.KsvmEstMaestra::__KsvmEncriptacion($rows['EpoId']).'">              
                                                    <button id="btn-delete" type="submit" class="btn btn-sm btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                                    <div class="mdl-tooltip" for="btn-delete">Inhabilitar</div>
                                                   <div class="RespuestaAjax"></div>
                                                    </form>'; 
                                    }
                                }elseif ($KsvmRol == 2 || $KsvmRol == 3){
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmEmpleados/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['EpoId']).'/"><i class="zmdi zmdi-card"></i></a>
                                                    <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                                    <a id="btn-edit" class="btn btn-sm btn-primary" href="'.KsvmServUrl.'KsvmEmpleadosEditar/'.KsvmEstMaestra::__KsvmEncriptacion($rows['EpoId']).'/1/"><i class="zmdi zmdi-edit"></i></a>
                                                    <div class="mdl-tooltip" for="btn-edit">Editar</div>';
                                }else{
                                    $KsvmTabla .= '<a id="btn-detail" class="btn btn-sm btn-info" href="'.KsvmServUrl.'KsvmEmpleados/Detail/'.KsvmEstMaestra::__KsvmEncriptacion($rows['EpoId']).'/"><i class="zmdi zmdi-card"></i></a>
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
                echo '<script> window.location.href=" '.KsvmServUrl.'KsvmEmpleadosCrud"</script>';
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
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmEmpleadosCrud/1/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmEmpleadosCrud/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmEmpleadosCrud/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmEmpleadosCrud/'.($KsvmNPaginas).'/">Último</a>';
                                   
                                   
                }
                
             
                $KsvmTabla .= '</nav></div>';     

            } elseif ($KsvmTotalReg >= 1 && $KsvmPagina <= $KsvmNPaginas && $KsvmCodigo == 1) {
                $KsvmTabla .= '<nav class="navbar-form navbar-right form-group">';
                
                if ($KsvmPagina == 1) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Primero</button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-rewind"></i></button>';
                } else {
                    $KsvmTabla .= '<a class = "btn btn-xs btn-success mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmEmpleados/1/">Primero</a>
                                   <span></span>
                                   <a class = "btn btn-xs btn-default mdl-shadow--8dp " href="'.KsvmServUrl.'KsvmEmpleados/'.($KsvmPagina-1).'/"><i class="zmdi zmdi-fast-rewind"></i></a>';
                }

                if ($KsvmPagina == $KsvmNPaginas) {
                    $KsvmTabla .= '<button class = "btn btn-xs btn-default mdl-shadow--8dp disabled"><i class="zmdi zmdi-fast-forward"></i></button>
                                   <span></span>
                                   <button class = "btn btn-xs btn-success mdl-shadow--8dp disabled">Último</button>';
                } else {
                    $KsvmTabla .= '<a class="btn btn-xs btn-default mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmEmpleados/'.($KsvmPagina+1).'/"><i class="zmdi zmdi-fast-forward"></i></a>
                                   <span></span>
                                   <a class="btn btn-xs btn-success mdl-shadow--8dp" href="'.KsvmServUrl.'KsvmEmpleados/'.($KsvmNPaginas).'/">Último</a>';
                                   
                                   
                }
                
                $KsvmTabla .= '</nav></div>'; 
            }
            
        
                                   
        return $KsvmTabla;
      }

      /**
       * Función que permite calcular la edad
       */
      public function __KsvmCalculaEdad($fechaNacimiento){
        $KsvmDia=date("d");
        $KsvmMes=date("m");
        $KsvmAnio=date("Y");
        
        
        $KsvmDiaNac=date("d",strtotime($fechaNacimiento));
        $KsvmMesNac=date("m",strtotime($fechaNacimiento));
        $KsvmAnioNac=date("Y",strtotime($fechaNacimiento));
        
        //si el mes es el mismo pero el día inferior aun no ha cumplido años, le quitaremos un año al actual
        
        if (($KsvmMesNac == $KsvmMes) && ($KsvmDiaNac > $KsvmDia)) {
        $KsvmAnio=($KsvmAnio-1); }
        
        //si el mes es superior al actual tampoco habrá cumplido años, por eso le quitamos un año al actual
        
        if ($KsvmMesNac > $KsvmMes) {
        $KsvmAnio=($KsvmAnio-1);}
        
         //ya no habría mas condiciones, ahora simplemente restamos los años y mostramos el resultado como su edad
        
        $KsvmEdad=($KsvmAnio-$KsvmAnioNac);
        
        
        return $KsvmEdad;
        
        
        }
     
      /**
       * Función que permite inhabilitar un empleado 
       */
      public function __KsvmEliminarEmpleadoControlador()
      {
         $KsvmCode = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodDelete']);
         $KsvmCode = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmCode);

         $KsvmConsulta = "SELECT EpoId FROM ksvmvistaempleado WHERE EpoId = '$KsvmCode'";
         $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmConsulta);
         $KsvmDataEmpleado = $KsvmQuery->fetch();
         if ($KsvmDataEmpleado['EpoId'] != 1) {
             $KsvmDelEmp = KsvmEmpleadoModelo :: __KsvmEliminarEmpleadoModelo($KsvmCode);
             if ($KsvmDelEmp->rowCount() == 1) {
                $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Empleado Inhabilitado",
                    "Cuerpo" => "El empleado seleccionado ha sido inhabilitado con éxito",
                    "Tipo" => "success"
                    ];
             }
         } else {
            $KsvmAlerta = [
                "Alerta" => "simple",
                "Titulo" => "Error inesperado",
                "Cuerpo" => "No es posible eliminar el Administrador del sistema",
                "Tipo" => "info"
                ];
         }

         return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
      }
    
      /**
       * Función que permite editar un empleado 
       */
      public function __KsvmEditarEmpleadoControlador($KsvmCodEmpleado)
      {
          $KsvmCodigo = KsvmEstMaestra :: __KsvmDesencriptacion($KsvmCodEmpleado);

          return KsvmEmpleadoModelo :: __KsvmEditarEmpleadoModelo($KsvmCodigo);
      }
      
      /**
       * Función que permite contar un empleado 
       */
      public function __KsvmContarEmpleadoControlador()
      {
          return KsvmEmpleadoModelo :: __KsvmContarEmpleadoModelo(0);
      }

      /**
       * Función que permite imprimir un Empleado 
       */
      public function __KsvmImprimirEmpleadoControlador()
      {
        return KsvmEmpleadoModelo :: __KsvmImprimirEmpleadoModelo();
      }

      /**
       * Función que permite actualizar un empleado 
       */
      public function __KsvmActualizarEmpleadoControlador()
      {
        $KsvmCode = KsvmEstMaestra :: __KsvmDesencriptacion($_POST['KsvmCodEdit']);

        if ($_POST['KsvmIdParroquia'] == "") {
            $KsvmCodProc = $_POST['KsvmIdPais'];
         } else {
            $KsvmCodProc = $_POST['KsvmIdParroquia'];
         }
         
         
        $KsvmProcedencia = KsvmEstMaestra :: __KsvmFiltrarCadena($KsvmCodProc);
        $KsvmCargo = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmCargo']);
        $KsvmRol = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmRol']);
        $KsvmTipoIdent = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmTipoIdent']);
        $KsvmIdent = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmIdent']);
        $KsvmPrimApel = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmPrimApel']);
        $KsvmSegApel = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmSegApel']);
        $KsvmPrimNom = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmPrimNom']);
        $KsvmSegNom = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmSegNom']);
        $KsvmFchNac = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmFchNac']);
        $KsvmDirc = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmDirc']);
        $KsvmTelf = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmTelf']);
        $KsvmEmail = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmEmail']);
        $KsvmEstCiv = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmEstCiv']);
        $KsvmSexo = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmSexo']);
        $KsvmGenero = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmGenero']);
        if ($_FILES['KsvmFotoEmp']['error'] > 0) {
            $KsvmFotoEmp = "";
        } else {
            $KsvmFotoEmp = file_get_contents($_FILES['KsvmFotoEmp']['tmp_name']);
        }
        
        $KsvmConsulta = "SELECT * FROM ksvmvistaempleado WHERE EpoId = '$KsvmCode'";
        $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmConsulta);
        $KsvmDataEmpleado = $KsvmQuery->fetch();

        if ($KsvmIdent != $KsvmDataEmpleado['EpoIdentEmp']) {
            $KsvmConsulta = "SELECT EpoIdentEmp FROM ksvmvistaempleado WHERE EpoIdentEmp = '$KsvmIdent'";
            $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmConsulta);
            if ($KsvmQuery->rowCount() >= 1) {
                $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Error Inesperado",
                    "Cuerpo" => "El número de identificación ingresado ya se encuentra registrado, Por favor ingrese un número válido",
                    "Tipo" => "info"
                    ];
                    return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
                    exit();
            }
        }

        $KsvmActualEmp = [
            "KsvmCrgId" => $KsvmCargo,
            "KsvmPrcId" => $KsvmProcedencia,
            "KsvmRrlId" => $KsvmRol,
            "KsvmEpoTipIdentEmp" => $KsvmTipoIdent,
            "KsvmEpoIdentEmp" => $KsvmIdent,
            "KsvmEpoPriApeEmp" => $KsvmPrimApel,
            "KsvmEpoSegApeEmp" => $KsvmSegApel,
            "KsvmEpoPriNomEmp" => $KsvmPrimNom,
            "KsvmEpoSegNomEmp" => $KsvmSegNom,
            "KsvmEpoTelfEmp" => $KsvmTelf,
            "KsvmEpoDirEmp" => $KsvmDirc,
            "KsvmEpoFchNacEmp" => $KsvmFchNac,
            "KsvmEpoEmailEmp" => $KsvmEmail,
            "KsvmEpoSexoEmp" => $KsvmSexo,
            "KsvmEpoGeneroEmp" => $KsvmGenero,
            "KsvmEpoEstCivEmp" => $KsvmEstCiv,
            "KsvmFotoEmp" => $KsvmFotoEmp,
            "KsvmCodEmpleado" => $KsvmCode
            ];

            $KsvmGuardarEmp = KsvmEmpleadoModelo :: __KsvmActualizarEmpleadoModelo($KsvmActualEmp);
                if ($KsvmGuardarEmp->rowCount() >= 1) {
                    $KsvmAlerta = [
                    "Alerta" => "Actualiza",
                    "Titulo" => "Grandioso",
                    "Cuerpo" => "El empleado se actualizó satisfactoriamente",
                    "Tipo" => "success"
                    ];
                } else {
                    $KsvmAlerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error inesperado",
                    "Cuerpo" => "No se a podido actualizar la información del empleado",
                    "Tipo" => "info"
                    ];
                }
                return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
         
        }

        public function __KsvmSeleccionarEmpleado(){
            $KsvmSelectEmp = "SELECT * FROM ksvmseleccionaempleado";

            $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
            $KsvmQuery = $KsvmConsulta->query($KsvmSelectEmp);
            $KsvmQuery = $KsvmQuery->fetchAll();
            
            foreach ($KsvmQuery as $row) {
                $KsvmListar .= '<option value="'.$row['EpoId'].'">'.$row['EpoPriApeEmp'].' '.$row['EpoSegApeEmp'].' '.
                $row['EpoPriNomEmp'].' '.$row['EpoSegNomEmp'].'</option>';
            }
            return $KsvmListar;
        }
    
}
   
 