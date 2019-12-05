<!--
* Copyright 2019 Klever Santiago Vaca Muela
-->

<?php

  /**
   *Condicion para peticion Ajax
   */
  if ($KsvmPeticionAjax) {
    require_once "../Raiz/KsvmEstMaestra.php";
  } else {
      require_once "./Raiz/KsvmEstMaestra.php";
  }

  class KsvmMenuModelo extends KsvmEstMaestra
  {
    /**
     *Funcion que permite mostrar el menu
     */
    public function __KsvmMostrarMenuModelo($Rol)
    {
      $KsvmMenu = "SELECT * FROM ksvmmenu17 m JOIN ksvmmenuxrol18 r ON m.MnuId = r.MnuId WHERE m.MnuEstMen = 'A'  AND r.RrlId ='$Rol' ORDER BY m.MnuNomMen";
      $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->query($KsvmMenu);

      return $KsvmQuery;
    }
    /**
     *Funcion que permite mostrar el submenu
     */
    public function __KsvmMostrarSubmenuModelo($Id)
    {
      $KsvmSubmenu = "SELECT * FROM ksvmmenu17 WHERE MnuEstMen = 'A' AND MnuJerqMen = '$Id' ORDER BY MnuNomMen";
      $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->query($KsvmSubmenu);

      return $KsvmQuery;
    }
     /**
     *Funcion que permite mostrar la Jerarquía
     */
    public function __KsvmMostrarJerarquiaModelo($KsvmJerq)
    {
      $KsvmJerarquia = "SELECT * FROM ksvmmenu17 WHERE MnuEstMen = 'A' AND MnuId = '$KsvmJerq' ";
      $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->query($KsvmJerarquia);

      return $KsvmQuery;
    }

    /**
      *Función que permite ingresar un menu
      */
      protected function __KsvmAgregarMenuModelo($KsvmDataMenu)
      {
          $KsvmIngMenu = "INSERT INTO ksvmmenu17(MnuJerqMen, MnuNomMen, MnuNivelMen, MnuIconMen, MnuUrlMen, MnuLeyendMen)
                                     VALUES(:KsvmJerqMen, :KsvmNomMen, :KsvmNivelMen, :KsvmIconMen, :KsvmUrlMen, :KsvmLeyendMen)";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmIngMenu);
          $KsvmQuery->bindParam(":KsvmJerqMen", $KsvmDataMenu['KsvmJerqMen']);
          $KsvmQuery->bindParam(":KsvmNomMen", $KsvmDataMenu['KsvmNomMen']);
          $KsvmQuery->bindParam(":KsvmNivelMen", $KsvmDataMenu['KsvmNivelMen']);
          $KsvmQuery->bindParam(":KsvmIconMen", $KsvmDataMenu['KsvmIconMen']);
          $KsvmQuery->bindParam(":KsvmUrlMen", $KsvmDataMenu['KsvmUrlMen']);
          $KsvmQuery->bindParam(":KsvmLeyendMen", $KsvmDataMenu['KsvmLeyendMen']);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
      /**
       *Función que permite eliminar un menu
       */
       protected function __KsvmEliminarMenuModelo($KsvmCodMenu)
       {
          $KsvmDelMenu = "DELETE FROM ksvmmenu17 WHERE MnuId = :KsvmCodMenu";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmDelMenu);
          $KsvmQuery->bindParam(":KsvmCodMenu", $KsvmCodMenu);
          $KsvmQuery->execute();
          return $KsvmQuery;
       }
       /**
       *Función que permite editar un menu
       */
       protected function __KsvmEditarMenuModelo($KsvmCodMenu)
       {
           $KsvmEditMenu = "SELECT * FROM ksvmmenu17 WHERE MnuId = :KsvmCodMenu";
           $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmEditMenu);
           $KsvmQuery->bindParam(":KsvmCodMenu", $KsvmCodMenu);
           $KsvmQuery->execute();
           return $KsvmQuery;
       }
        /**
       *Función que permite contar un menu
       */
       protected function __KsvmContarMenuModelo($KsvmCodMenu)
       {
           $KsvmContarMenu = "SELECT MnuId FROM ksvmmenu17 WHERE MnuEstMen = 'A'";
           $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmContarMenu);
           $KsvmQuery->execute();
           return $KsvmQuery;
       }
        /**
       *Función que permite actualizar un menu
       */
       protected function __KsvmActualizarMenuModelo($KsvmDataMenu)
       {
         $KsvmActMenu = "UPDATE ksvmmenu17 SET MnuJerqMen = :KsvmJerqMen, MnuNomMen = :KsvmNomMen, MnuNivelMen = :KsvmNivelMen,
                             MnuIconMen = :KsvmIconMen, MnuUrlMen = :KsvmUrlMen, MnuLeyendMen = :KsvmLeyendMen
                             WHERE MnuId = :KsvmCodMenu";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmActMenu);
         $KsvmQuery->bindParam(":KsvmJerqMen", $KsvmDataMenu['KsvmJerqMen']);
          $KsvmQuery->bindParam(":KsvmNomMen", $KsvmDataMenu['KsvmNomMen']);
          $KsvmQuery->bindParam(":KsvmNivelMen", $KsvmDataMenu['KsvmNivelMen']);
          $KsvmQuery->bindParam(":KsvmIconMen", $KsvmDataMenu['KsvmIconMen']);
          $KsvmQuery->bindParam(":KsvmUrlMen", $KsvmDataMenu['KsvmUrlMen']);
          $KsvmQuery->bindParam(":KsvmLeyendMen", $KsvmDataMenu['KsvmLeyendMen']);
          $KsvmQuery->bindParam(":KsvmCodMenu", $KsvmDataMenu['KsvmCodMenu']);
          $KsvmQuery->execute();
          return $KsvmQuery;
       }

  }
