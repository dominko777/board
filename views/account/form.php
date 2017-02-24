<?php
$this->pageTitle = Yii::t('messages', 'Name of site').' - '.Yii::t('messages', 'Site description for page title'); //anytime this view gets called
$cs = Yii::app()->getClientScript();
$cs->registerCssFile(Yii::app()->request->baseUrl."/css/bootstrap-social.css");
$cs->registerCssFile(Yii::app()->request->baseUrl."/css/font-awesome/css/font-awesome.css");
 
?>
<style>
    .auth-service {
    float: left;
    width: 100%;
}
    .auth-services .auth-service .auth-link {
    display: block;
    float: left;
    width: 100%;
}
    a.auth-link:hover, a.auth-link:focus {
    color: #ffffff; /* Цвет активной ссылки */
   }
</style> 

<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'aiform',
        'enableClientValidation'=>false,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'htmlOptions'=>array(
            'class'=>'form-register form-center',
            'style'=>'margin-bottom: 45px;',
        ),
    )); ?>
    <h2 class="form-signin-heading"><?php echo Yii::t('messages','Registration'); ?></h2>
        <?php
            if(Yii::app()->user->hasFlash('notice')) {
            echo '<div id="scsMsg" style="display:block;" class="alert alert-warning" role="alert">'.Yii::app()->user->getFlash('notice', '', true).'</div>';
            }
        ?>
        <?php echo $form->label($model,'email', array('class'=>'sr-only')); ?>
        <?php  echo $form->emailField($model,'email', array('autofocus'=>'true','required'=>'true','class'=>"form-control mar-form",'placeholder'=>Yii::t('messages','Email'))); ?>
        <?php echo $form->label($model,'fio', array('class'=>'sr-only')); ?>
        <?php  echo $form->textField($model,'fio', array('autofocus'=>'true','required'=>'true','class'=>"form-control mar-form",'placeholder'=>Yii::t('messages', 'Login'))); ?>
        <?php echo $form->label($model,'password', array('class'=>'sr-only')); ?>
        <?php  echo $form->passwordField($model,'password', array('required'=>'true','class'=>"form-control mar-form",'placeholder'=>Yii::t('messages','Password'))); ?>
        <?php echo $form->label($model,'repeat_password', array('class'=>'sr-only')); ?>
        <?php  echo $form->passwordField($model,'password_repeat', array('required'=>'true','class'=>"form-control mar-form",'placeholder'=>Yii::t('messages','Password repeat'))); ?>

        <?php echo $form->errorSummary($model, '<strong><?php echo Yii::t("messages","Please fix the errors on the form:"); ?></strong><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>', '', array('class' => 'alert alert-danger')); ?>

        <button onclick="$('.form-register').submit()" href="#" type="submit" class="btn btn-lg btn-primary btn-block"><?php echo Yii::t('messages','Register link'); ?></button>
        <p><h2 class="text_in_line"><span><?php echo Yii::t('messages','or'); ?></span></h2></p> 
       <p>
        <?php
            $this->widget('ext.eauth.EAuthWidget', array('action' => 'site/login'));
        ?></p>  
<?php $this->endWidget(); ?>


