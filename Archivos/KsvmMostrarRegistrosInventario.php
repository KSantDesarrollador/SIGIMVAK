
<?php

/**
   *Condicion para peticion Ajax
   */
  if ($KsvmPeticionAjax) {
    require_once "../Raiz/KsvmEstMaestra.php";
} else {
    require_once "./Raiz/KsvmEstMaestra.php";
}

class KsvmMostrarRegistrosInventario extends KsvmEstMaestra
{

    public function __KsvmMostrarRegistros()
    {

    $KsvmMuestraRegistro = "SELECT * FROM ksvmvistaregistrosinventario WHERE DivEstInv = 'N'";

            $KsvmConsulta = KsvmEstMaestra :: __KsvmConexion();
            $KsvmTable = "";

            $KsvmTable .= '<table
                class="mdl-data-table-data mdl-js-data-table mdl-shadow--4dp full-width table-responsive TableInfo">
                <thead>
                    <tr>
                        <th class="mdl-data-table__cell--non-numeric">#
                        </th>
                        <th class="mdl-data-table__cell--non-numeric">Medicamento
                        </th>
                        <th class="mdl-data-table__cell--non-numeric">Lote
                        </th>
                        <th class="mdl-data-table__cell--non-numeric">Caducidad
                        </th>
                        <th class="mdl-data-table__cell--non-numeric">Stock Sistema
                        </th>
                        <th class="mdl-data-table__cell--non-numeric">Conteo Físico
                        </th>
                        <th style="text-align:center; witdh:30px;">Acción
                        </th>
                    </tr>
                </thead>
                <tbody>';

            $KsvmContReg = 0+1;
            $KsvmQuery = $KsvmConsulta->query($KsvmMuestraRegistro);
                $KsvmQuery = $KsvmQuery->fetchAll();
                if ($KsvmQuery != null) {
                    foreach ($KsvmQuery as $rows) {
                    $KsvmTable .= '
                        <tr>
                        <td class="mdl-data-table__cell--non-numeric">'.$KsvmContReg.'</td>
                        <td class="mdl-data-table__cell--non-numeric">'.$rows['MdcDescMed'].' '.$rows['MdcConcenMed'].'</td> 
                        <td class="mdl-data-table__cell--non-numeric">'.$rows['ExtLoteEx'].'</td>
                        <td class="mdl-data-table__cell--non-numeric">'.$rows['ExtFchCadEx'].'</td>
                        <td class="mdl-data-table__cell--non-numeric">'.$rows['DivStockInv'].'</td>
                        <td class="mdl-data-table__cell--non-numeric">'.$rows['DivContFisInv'].'</td>
                        <td style="text-align:center; witdh:30px;">
                        <input type="hidden" name="KsvmCodX" value="'.KsvmEstMaestra::__KsvmEncriptacion($rows['DivId']).'" id="KsvmCodX">  
                        <button class="btn btn-xs btn-danger" id="btnDel"><i class="zmdi zmdi-minus"></i></button></td>
                        </tr>'; 
                        $KsvmContReg ++;
                    }
        
                } 

                $KsvmTable .= '</tbody></table>';
                return $KsvmTable;
    }
}
?>
<script type="text/javascript">
   $(document).ready(function(){
               /**Método para elimnar registros*/
               $('#btnDel').click(function () {
        var KsvmId = $('#KsvmCodX').val()
        if (KsvmId != "") {
            swal({
				title: "¿Está seguro?",
				text: "Está Seguro de eliminar el registro",
				type: "info",
				showCancelButton: true,
				cancelButtonColor: "#F44336",
				confirmButtonText: "Aceptar",
                cancelButtonText: "Cancelar"
            }, function (isConfirm) {
			if (isConfirm) {
        $.ajax({
            type: 'POST',
            url: '<?php echo KsvmServUrl;?>Ajax/KsvmInventarioAjax.php',
            data: {'KsvmCodX': KsvmId},
            success:function (CargaLista) {
            if (CargaLista == "true") {
                KsvmCargarData();
            } else {
                $('.Resultado').html(CargaLista);
            }
            },
            error:function () {
                alert('Ocurrió un error al cargar la lista');
            }
        });

        }
    });
   }
 });

    function KsvmCargarData() {
        $.ajax({
		type: 'POST',
        url: '<?php echo KsvmServUrl;?>Ajax/KsvmMostrarRegistrosInventarioAjax.php'
        })
        .done(function (CargaLista) {
            $('#ListaData').html(CargaLista);
        })
        .fail(function () {

    });
    }
    KsvmCargarData();
    
});
</script>