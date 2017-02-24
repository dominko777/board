<?php
$this->pageTitle = Yii::t('messages', 'Name of site').' - '.Yii::t('messages', 'Site description for page title'); //anytime this view gets called
?>
<?php  $model->password='';
       $model->password_repeat='';

?>


    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'changepassword-form',
        'enableClientValidation'=>false,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'htmlOptions'=>array(
            'class'=>'form-center form-new-password',
        ),
    )); ?>
        <h2><?php echo Yii::t('messages','Resetting password');  ?></h2>
        <?php echo $form->label($model,'password', array('class'=>'sr-only')); ?>
        <?php  echo $form->passwordField($model,'password', array('required'=>'true','class'=>"form-control mar-form",'placeholder'=>Yii::t('messages','Password'))); ?>
        <?php echo $form->label($model,'repeat_password', array('class'=>'sr-only')); ?>
        <?php  echo $form->passwordField($model,'password_repeat', array('required'=>'true','class'=>"form-control mar-form",'placeholder'=>Yii::t('messages','Password repeat'))); ?>

        <?php echo $form->errorSummary($model, '<strong><?php echo Yii::t("messages","Please fix the errors on the form:"); ?></strong><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>', '', array('class' => 'alert alert-danger')); ?>

        <button onclick="$('.form-new-password').submit()" href="#" type="submit" class="btn btn-lg btn-primary btn-block"><?php echo Yii::t('messages','Reset password'); ?></button>
        <p style="margin-top: 10px;"><?php echo CHtml::link(Yii::t('messages','Login link'),array('account/login'),array('class'=>'btn btn-main')); ?></p>
   <?php $this->endWidget(); ?>


