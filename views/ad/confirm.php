<?php
$this->pageTitle = Yii::t('messages', 'Name of site').' - '.Yii::t('messages', 'Site description for page title'); //anytime this view gets called
?>

<?php
$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerCssFile($baseUrl.'/css/new_form.css');
?>
<div id="no_drop_area">
    <div id="template_content">
        <div id="main">

            <section class="lfloat">
                <nav>
                    <ul>
                        <li class="active">
                            <div>
                                <div class="circle lfloat">
                                    <span>1</span>
                                </div>
                                <div class="stepTitle lfloat">
                                    Inserimento
                                </div>
                            </div>
                        </li>
                        <li>
                            <div>
                                <div>
                                    <div class="circle lfloat">
                                        <span>2</span>
                                    </div>
                                    <div class="stepTitle lfloat">
                                        Verifica
                                    </div>
                                </div>
                            </div>
                        </li>


                    </ul>
                </nav>
<article id="aiPreview" style="display: none;">
    <div class="container">
        <div class="backgroundWhite">
            <div class="lfloat" id="breadcrumb">
                Category &gt; <strong id="prev_category"></strong>
            </div>
            <div class="rfloat" id="edit">
                <a onclick="javascript:window.history.back(-1);">Modifica</a>
            </div>
            <div id="photo">
                <script type="text/javascript">base_url = "https://s.sbito.it/1201425394663";</script>
                <img src="https://s.sbito.it/1201425394663/img2/no_photo.png" id="prev_photo">
            </div>
            <div class="subContainer lfloat">
                <div id="prev_subject"></div>
                <div id="prev_body"></div>
                <div class="collapsed" id="others"></div>
            </div>
            <div id="showAll">Vedi tutto l'annuncio</div>
        </div>
        <div id="listphotos" class="lfloat">
            <div id="prevFoto"></div>
            <div id="slideGallery"></div>
            <div id="nextFoto"></div>
        </div>

        <div class="info">
            <div class="row">
                <label>Nome</label><span id="prev_name"></span>
            </div>
            <div style="display:none" id="row_vat" class="row">
                <label>Partita IVA</label><span id="prev_vat"></span>
            </div>
            <div class="row">
                <label>Email</label><span id="prev_email"></span>
            </div>
            <div class="row">
                <label>Telefono</label><span id="prev_phone"> </span> <span id="prev_phone_hidden"> </span>
            </div>
        </div>
    </div>
    <div class="section_footer" style="display: none;">
        <div id="btnConfirm" class="btnGreen">Conferma</div>
    </div>
        </div>
    </div>
    </article>
    </section>
</div>
