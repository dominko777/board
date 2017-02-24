<?php
$this->pageTitle = Yii::t('messages', 'Name of site').' - '.Yii::t('messages', 'Site description for page title'); //anytime this view gets called
?>



<div class="col-md-4 col-sm-5">
    <?php $this->widget('ext.User.UserWidget',array('user'=>$user,'ifImFollowing' => false)); ?> 
</div>     
<div class="col-md-8 col-sm-7">
     <div class="panel">
         <div class="panel-body">
             <?php if(Yii::app()->user->hasFlash('success')):?>
                    <p class="bg-success  main-site-messages">
                    <?php echo Yii::app()->user->getFlash('success'); ?>
                    </p>
                <?php endif; ?>
             <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'profile-form',
                        'htmlOptions'=>array('style'=>'margin-top: 10px; padding-top:0px'),
                        'enableAjaxValidation'=>false,
                        'htmlOptions'=>array(
                            'class'=>'form-center',
                        ),
                    )); ?>
              <?php echo $form->label($user,'fio', array('class'=>'sr-only')); ?>
        <?php  echo $form->textField($user,'fio', array('autofocus'=>'true','required'=>'true','class'=>"form-control mar-form",'placeholder'=>Yii::t('messages','Login'))); ?>
        <?php echo $form->label($user,'phone', array('class'=>'sr-only')); ?>
        <?php  echo $form->textField($user,'phone', array('class'=>"mar-form form-control ",'placeholder'=>Yii::t('messages','Phone'))); ?>
        <?php echo $form->errorSummary($user, '<strong><?php echo Yii::t("messages","Please fix the errors on the form:"); ?></strong><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>', '', array('class' => 'alert alert-danger')); ?>
        <button onclick="$('#profile-form').submit()" href="#" type="submit" class="btn btn-lg btn-primary btn-block"><?php echo Yii::t('messages','Save'); ?></button>
             <?php $this->endWidget(); ?>
        <p class="text-center" ><?php echo Yii::t('messages','or'); ?></p>
        <p class="text-center"><a  href="<?php echo Yii::app()->createUrl('account/avatar'); ?>" ><?php echo Yii::t('messages','Change avatar'); ?></a></p>

         </div>
     </div>
    
</div>



