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
        'enableClientValidation'=>false,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'htmlOptions'=>array(
            'class'=>'form-signin form-center',
            'style'=>'margin-bottom: 40px;',
        ),
    )); ?>
        <h2 class="form-signin-heading"><?php echo Yii::t('messages','Login title'); ?></h2>
        <?php
            if(Yii::app()->user->hasFlash('notice')) {
            echo '<div id="scsMsg" style="display:block;" class="alert alert-warning" role="alert">'.Yii::app()->user->getFlash('notice', '', true).'</div>';
            }
        ?>
        <?php echo $form->label($model,'email', array('class'=>'sr-only')); ?>
        <?php  echo $form->emailField($model,'email', array('autofocus'=>'true','required'=>'true','class'=>"form-control mar-form",'placeholder'=>Yii::t('messages','Email'))); ?>
        <?php echo $form->label($model,'password', array('class'=>'sr-only')); ?>
        <?php  echo $form->passwordField($model,'password', array('required'=>'true','class'=>"form-control mar-form",'placeholder'=>Yii::t('messages','Password'))); ?>
        <?php echo $form->errorSummary($model, '<strong><?php echo Yii::t("messages","Please fix the errors on the form:"); ?></strong><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>', '', array('class' => 'alert alert-danger')); ?>
        <button onclick="$('.form-signin').submit()" href="#" type="submit" class="btn btn-lg btn-primary btn-block"><?php echo Yii::t('messages','Login link'); ?></button>
        <p style="margin-top: 10px;"><?php echo CHtml::link(Yii::t('messages','Forgot password?'),array('account/reset-password'),array('style'=>'padding-top:10px;')); ?></p>
        <p><?php echo Yii::t('messages','New user?'); ?>&nbsp;<a href="<?php echo Yii::app()->createurl('account/form'); ?>"><b><?php echo Yii::t('messages','Registration'); ?></b></a></p>
        <p><h2 class="text_in_line"><span><?php echo Yii::t('messages','or'); ?></span></h2></p>
        <p>      
        <?php 
            $this->widget('ext.eauth.EAuthWidget', array('action' => 'site/login'));
        ?></p>   
    <?php $this->endWidget(); ?>


