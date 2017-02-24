<?php
$this->pageTitle = Yii::t('messages', 'Name of site').' - '.Yii::t('messages', 'Site description for page title'); //anytime this view gets called
?>

<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'resetpassword-form',
        'enableClientValidation'=>false,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'htmlOptions'=>array(
            'class'=>'form-center form-reset-password',
        ),
    )); ?>
    <h2><?php echo Yii::t('messages', 'Resetting password'); ?></h2>
    <?php echo $form->label($model,'email', array('class'=>'sr-only')); ?>
    <?php  echo $form->emailField($model,'email', array('autofocus'=>'true','required'=>'true','class'=>"form-control mar-form",'placeholder'=>Yii::t('messages','Email'))); ?>
    <?php echo $form->errorSummary($model, '<strong><?php echo Yii::t("messages","Please fix the errors on the form:"); ?></strong><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>', '', array('class' => 'alert alert-danger')); ?>
    <button onclick="$('.form-reset-password').submit()" href="#" type="submit" class="btn btn-lg btn-primary btn-block"><?php echo Yii::t('messages','Change password'); ?></button>
    <p style="margin-top: 10px;"><?php echo CHtml::link(Yii::t('messages','Login link'),array('account/login'),array('style'=>'padding-top:10px;')); ?></p>
<?php $this->endWidget(); ?>

