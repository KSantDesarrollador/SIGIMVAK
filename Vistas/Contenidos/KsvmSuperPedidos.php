<?php
    require_once "./Controladores/KsvmRequisicionControlador.php";
    $KsvmIniReq = new KsvmRequisicionControlador();
    $KsvmListarRequisicion = $KsvmIniReq->__KsvmListarSuperRequisiciones();
    ?>

<section class="full-width pageContent">
    <section class="full-width header-well">
        <div class="full-width header-well-icon">
            <i class="zmdi zmdi-upload"></i>
        </div>
        <div class="full-width header-well-text">
            <p class="text-condensedLight">
                PEDIDOS
            </p>
        </div>
    </section>
    <br>
    <div class="mdl-tabs" id="KsvmListaRequisicions">
        <div class="mdl-grid">
            <div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
                <table class="mdl-data-table mdl-js-data-table mdl-shadow--6dp full-width table-responsive">
                    <thead>
                        <tr>
                            <th class="mdl-data-table__cell--non-numeric"># Pedido</th>
                            <th class="mdl-data-table__cell--non-numeric">Fecha</th>
                            <th class="mdl-data-table__cell--non-numeric">Bodega</th>
                            <th class="mdl-data-table__cell--non-numeric">Responsable</th>
                            <th style="text-align:center; witdh:30px;">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($KsvmListarRequisicion->rowCount() >= 1) {
                            $KsvmQuery = $KsvmListarRequisicion->fetchAll();

                        foreach ($KsvmQuery as $rows) {
                        $KsvmCodBod = $rows['RqcOrigenReq'];
                        $KsvmBodega = $KsvmIniReq->__KsvmSeleccionBodega($KsvmCodBod);

                        ?>
                        <tr>
                            <td class="mdl-data-table__cell--non-numeric"><?php echo $rows['RqcNumReq']?></td>
                            <td class="mdl-data-table__cell--non-numeric"><?php echo $rows['RqcFchElabReq']?></td>
                            <td class="mdl-data-table__cell--non-numeric"><?php echo $KsvmBodega['BdgDescBod']?></td>
                            <td class="mdl-data-table__cell--non-numeric"><?php echo $rows['RqcPerElabReq']?></td>
                            <td style="text-align:right; witdh:30px; display:inline-flex;">

                                <a id="btn-detail" class="btn btn-sm btn-info"
                                    href="<?php echo KsvmServUrl;?>KsvmSuperPedidos/Detail/<?php echo KsvmEstMaestra::__KsvmEncriptacion($rows['RqcId']);?>"><i
                                        class="zmdi zmdi-card"></i></a>
                                <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                &nbsp;
                                <form action="<?php echo KsvmServUrl;?>Ajax/KsvmRequisicionAjax.php" method="POST"
                                    class="FormularioAjax" data-form="modificar" enctype="multipart/form-data">
                                    <input type="hidden" name="KsvmCodRevision"
                                        value="<?php echo KsvmEstMaestra::__KsvmEncriptacion($rows['RqcId']);?>">
                                    <input type="hidden" name="KsvmTokken"
                                        value="<?php echo KsvmEstMaestra::__KsvmEncriptacion('APB');?>">
                                    <button id="btn-Aprobado" type="submit" class="btn btn-sm btn-success"><i
                                            class="zmdi zmdi-check"></i></button>
                                    <div class="mdl-tooltip" for="btn-Aprobado">Aprobar</div>
                                    <div class="RespuestaAjax"></div>
                                </form>
                                &nbsp;
                                <form action="<?php echo KsvmServUrl;?>Ajax/KsvmRequisicionAjax.php" method="POST"
                                    class="FormularioAjax" data-form="modificar" enctype="multipart/form-data">
                                    <input type="hidden" name="KsvmCodRevision"
                                        value="<?php echo KsvmEstMaestra::__KsvmEncriptacion($rows['RqcId']);?>">
                                    <input type="hidden" name="KsvmTokken"
                                        value="<?php echo KsvmEstMaestra::__KsvmEncriptacion('NEG');?>">
                                    <button id="btn-Negado" type="submit" class="btn btn-sm btn-danger"><i
                                            class="zmdi zmdi-close"></i></button>
                                    <div class="mdl-tooltip" for="btn-Negado">Negar</div>
                                    <div class="RespuestaAjax"></div>
                                </form>
                            </td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php } else {?>
        <tr>
            <td class="mdl-data-table__cell--non-numeric" colspan="7"><strong>No se encontraron registros...</strong>
            </td>
        </tr>
        </tbody>
        </table>

        <?php }?>

        <!-- Método para cargar datos en el formulario -->
        <?php 
			  
              $KsvmPagina = explode("/", $_GET['Vistas']);
              if ($KsvmPagina[2] != "") {
              $KsvmDataEdit = $KsvmIniReq->__KsvmEditarDetalleRequisicionControlador($KsvmPagina[2]);
    
                  $KsvmQuery = $KsvmDataEdit->fetchAll();
                
                  
            ?>
        <script>
            window.onload = function () {

                $("#KsvmFormOcp").trigger("reset");
                $(".modal-title").text("Detalles Pedido");
                $("#KsvmDetallesRequisicion").modal({
                    show: true
                });
            }
        </script>

        <!-- Formulario de Detalles del Requisicion -->

        <div class="modal fade" id="KsvmDetallesRequisicion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content ">
                    <div class="modal-header">
                        <button class="close close-edit" type="button" id="btnExitSped" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                        <h5 class="modal-title text-center"></h5>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST" id="KsvmFormOcp">
                            <input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[2]; ?>">
                            <div class="mdl-grid">
                                <div
                                    class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
                                    <div class="mdl-textfield"><strong>Num.Pedido :</strong></div>
                                </div>
                                <div
                                    class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
                                    <div class="mdl-textfield"><strong>Medicamento:</strong></div>
                                </div>
                                <div
                                    class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
                                    <div class="mdl-textfield"><strong>Cantidad :</strong></div>
                                </div>
                                <div
                                    class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
                                    <div class="mdl-textfield"><strong>Stock :</strong></div>
                                </div>
                                <div
                                    class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--3-col-desktop">
                                    <div class="mdl-textfield"><strong>Observación :</strong></div>
                                </div>
                                <div
                                    class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--1-col-desktop">
                                    <div class="mdl-textfield"><strong>Acción :</strong></div>
                                </div>
                                <?php foreach ($KsvmQuery as $KsvmLlenarForm) {?>
                                <div
                                    class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
                                    <div class="mdl-data-table__cell--non-numeric">
                                        <div class="mdl-textfield__input">
                                            <?php echo $KsvmLlenarForm['RqcNumReq'];?></div>
                                    </div>
                                </div>
                                <div
                                    class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
                                    <div class="mdl-data-table__cell--non-numeric">
                                        <div class="mdl-textfield__input">
                                            <?php echo $KsvmLlenarForm['MdcDescMed'].' '.$KsvmLlenarForm['MdcConcenMed'];?>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
                                    <div class="mdl-data-table__cell--non-numeric mdl-textfield--floating-label">
                                        <div class="mdl-textfield__input">
                                            <?php echo $KsvmLlenarForm['DrqCantReq'];?></div>
                                    </div>
                                </div>
                                <div
                                    class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
                                    <div class="mdl-data-table__cell--non-numeric mdl-textfield--floating-label">
                                        <div class="mdl-textfield__input">
                                            <?php echo $KsvmLlenarForm['DrqStockReq'];?></div>
                                    </div>
                                </div>
                                <div
                                    class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--3-col-desktop">
                                    <div class="mdl-data-table__cell--non-numeric mdl-textfield--floating-label">
                                        <div class="mdl-textfield__input">
                                            <?php echo $KsvmLlenarForm['DrqObservReq'];?></div>
                                    </div>
                                </div>
                                <div
                                    class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--1-col-desktop">
                                    <a class="btn btn-sm btn-primary"
                                        href="<?php echo KsvmServUrl;?>KsvmDetallesRequisicionEditar/<?php echo KsvmEstMaestra::__KsvmEncriptacion($KsvmLlenarForm['DrqId']);?>/2/"><i
                                            class="zmdi zmdi-edit"></i></a>
                                </div>
                                <?php }?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php }?>
    </div>
</section>