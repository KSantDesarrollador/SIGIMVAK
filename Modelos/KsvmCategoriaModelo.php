<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Raiz/KsvmEstMaestra.php";
   } else {
       require_once "./Raiz/KsvmEstMaestra.php";
   }

   class KsvmCategoriaModelo extends KsvmEstMaestra
   {
     /**
      *Función que permite ingresar una categoria
      */
     protected function __KsvmAgregarCategoriaModelo($KsvmDataCategoria)
     {
         $KsvmIngCategoria = "INSERT INTO ksvmcategoria10(CtgNomCat, CtgColorCat)
                                    VALUES(:KsvmNomCat, :KsvmColorCat)";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmIngCategoria);
         $KsvmQuery->bindParam(":KsvmNomCat", $KsvmDataCategoria['KsvmNomCat']);
         $KsvmQuery->bindParam(":KsvmColorCat", $KsvmDataCategoria['KsvmColorCat']);

         $KsvmQuery->execute();
         return $KsvmQuery;
     }
     /**
      *Función que permite inhabilitar una categoria
      */
      protected function __KsvmEliminarCategoriaModelo($KsvmCodCategoria)
      {
         $KsvmDelCategoria = "UPDATE ksvmcategoria10 SET CtgEstCat = 'X' WHERE CtgId = :KsvmCodCategoria";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmDelCategoria);
         $KsvmQuery->bindParam(":KsvmCodCategoria", $KsvmCodCategoria);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }
      /**
      *Función que permite editar una categoria
      */
      protected function __KsvmEditarCategoriaModelo($KsvmCodCategoria)
      {
          $KsvmEditCategoria = "SELECT * FROM ksvmcategoria10 WHERE CtgId = :KsvmCodCategoria";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmEditCategoria);
          $KsvmQuery->bindParam(":KsvmCodCategoria", $KsvmCodCategoria);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
       /**
      *Función que permite contar una categoria
      */
      protected function __KsvmContarCategoriaModelo($KsvmCodCategoria)
      {
          $KsvmContarCategoria = "SELECT CtgId FROM ksvmcategoria10 WHERE CtgEstCat = 'A'";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmContarCategoria);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
       /**
      *Función que permite actualizar una categoria
      */
      protected function __KsvmActualizarCategoriaModelo($KsvmDataCategoria)
      {
        $KsvmActCategoria = "UPDATE ksvmcategoria10 SET CtgNomCat = :KsvmNomCat, CtgColorCAt = :KsvmColorCat
                            WHERE CtgId = :KsvmCodCategoria";
        $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmActCategoria);
        $KsvmQuery->bindParam(":KsvmNomCat", $KsvmDataCategoria['KsvmNomCat']);
         $KsvmQuery->bindParam(":KsvmColorCat", $KsvmDataCategoria['KsvmColorCat']);
         $KsvmQuery->bindParam(":KsvmCodCategoria", $KsvmDataCategoria['KsvmCodCategoria']);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }

   }
