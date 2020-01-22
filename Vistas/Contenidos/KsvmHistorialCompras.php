<!--
* Copyright 2019 Klever Santiago Vaca Muela
-->

<!-- pageContent -->

<section class="full-width pageContent">
    <section class="full-width header-well">
        <div class="full-width header-well-icon">
            <i class="zmdi zmdi-shopping-basket"></i>
        </div>
        <div class="full-width header-well-text">
            <p class="text-condensedLight">
                HISTORIAL DE COMPRAS
            </p>
        </div>
    </section>
    <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
        <div class="mdl-tabs__panel is-active" id="KsvmReporteCompras">
            <div class="mdl-grid">
                <div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
                    <div class="" style="float:left;">
                        <!-- Formulario de busqueda -->
                        <form data-form="" action="" method="POST" autocomplete="off" enctype="multipart/form-data">
                            <div class="mdl-textfield mdl-js-textfield">
                                <article class="full-width tile-buscar-est" style="height:235px;">
                                    <div class="mdl-textfield--expandable">
                                        <strong class="hide-on-tablet">Busqueda:</strong>
                                        <hr>
                                        <div class="mdl-textfield mdl-js-textfield">
                                            <select class="ksvmSelectDin" name="KsvmCtgId" id="KsvmDato1"
                                                style="width:100%;">
                                                <option value="" selected="">Seleccione Categoría</option>
                                                <?php require_once "./Controladores/KsvmCategoriaControlador.php";
													$KsvmSelCat = new KsvmCategoriaControlador();
													echo $KsvmSelCat->__KsvmSeleccionarCategoria();
													?>
                                            </select>
                                        </div>
                                        <div class="mdl-textfield mdl-js-textfield">
                                            <select class="ksvmSelectDin" name="KsvmMdcId" id="KsvmExtId"
                                                style="width:100%;">
                                                <option value="" selected="">Seleccione Medicamento</option>
                                                <?php require_once "./Controladores/KsvmMedicamentoControlador.php";
													$KsvmSelMed = new KsvmMedicamentoControlador();
													echo $KsvmSelMed->__KsvmSeleccionarMedicamento();
													?>
                                            </select>
                                            <span id="KsvmError1" class="ValForm"><i
                                                    class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
                                                    campo</i></span>&nbsp;
                                        </div>
                                    </div>

                                    <a href="<?php echo KsvmServUrl;?>KsvmCompras/1/" id="btn-input"
                                        class="btn btn-md btn-secondary mdl-shadow--8dp hide-on-tablet">COMPRAS
                                        &nbsp;<i class="zmdi zmdi-arrow-left"></i></a>
                                    <button type="submit" style="float:right;" class="btn btn-info"
                                        for="KsvmBuscarCompra">
                                        <i class="zmdi zmdi-search">&nbsp;<strong
                                                class="hide-on-tablet">BUSCAR</strong></i>
                                    </button>
                                    <div>
                                        <img src="" alt="">
                                    </div>
                                </article>
                                <div class="RespuestaAjax"></div>
                        </form>
                    </div>
                    </div>

                    <?php
                        require_once "./Controladores/KsvmCompraControlador.php";
                        $KsvmIniComp = new KsvmCompraControlador();
    
                        if (isset($_POST['KsvmCtgId']) || isset($_POST['KsvmMdcId'])) {
    
                            $_SESSION['KsvmCtgId'] = $_POST['KsvmCtgId'];
                            $_SESSION['KsvmMdcId'] = $_POST['KsvmMdcId'];

                            echo $KsvmIniComp -> __KsvmBuscaHistorial($_SESSION['KsvmCtgId'], $_SESSION['KsvmMdcId']);
                        }else{
    

                            echo $KsvmIniComp -> __KsvmBuscaHistorial("", "");
                           }
                    ?>
                <div class="mdl-textfield--expandable " style="margin-top:270px; right:20px;">

                </div>
        </div>

    </div>

    </div>

</section>