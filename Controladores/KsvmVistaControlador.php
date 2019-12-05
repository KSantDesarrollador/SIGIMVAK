<!--
* Copyright 2019 Klever Santiago Vaca Muela
-->

<?php

     require_once "./Modelos/KsvmVistaModelo.php";
     class KsvmVistaControlador extends KsvmVistaModelo
     {
       /**
        *Funcion que permite cargar la plantilla
        */
      public  function __KsvmCargarPlantillaControlador()
       {
           return require_once "./Vistas/KsvmPaginaMaestra.php";
       }

       /**
        *Funcion que permite cargar las diferentes vistas
        */
       public function __KsvmCargarContenidoControlador()
       {
          if (isset($_GET['Vistas'])) {
             $KsvmRuta = explode("/", $_GET['Vistas']);
             
             $KsvmRespuesta = KsvmVistaModelo :: __KsvmCargarContenidoModelo($KsvmRuta[0]);
   
            }else{
             $KsvmRespuesta = "Login";
          }
          return $KsvmRespuesta;
       }

     }
