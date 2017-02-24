 <div class="form">
                    <?php $form=$this->beginWidget('CActiveForm',
    array(
        'id' => 'upload-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    )); ?>



                            <div class="form-group">
                                <?php echo $form->label($model,'name'); ?>
                                <?php echo $form->textField($model,'name',array('class'=>"form-control")) ?>
                                <?php echo $form->error($model,'name',array('class'=>'has-error','style'=>'color: red; font-weight: bold')); ?>
                            </div>


                            <div class="form-group">
                                <?php echo $form->label($model,'description'); ?>
                                <?php echo $form->textArea($model, 'description', array('class'=>"form-control",'maxlength' => 300, 'rows' => 6, 'cols' => 50)); ?>
                                <?php echo $form->error($model,'description',array('class'=>'has-error','style'=>'color: red; font-weight: bold')); ?>
                            </div>

                            <div class="form-group">
                                <?php echo $form->label($model,'publicity'); ?>
                                <?php echo $form->dropDownList($model, 'publicity', array(Group::PUBLIC_TYPE=>'открытая',Group::PUBLIC_TYPE=>'закрытая')); ?>
                                <?php echo $form->error($model,'publicity',array('class'=>'has-error','style'=>'color: red; font-weight: bold')); ?>
                            </div>

                            <div class="form-group">
                                 <?php echo $form->labelEx($model, 'photo');  ?>
                                 <?php echo $form->fileField($model, 'photo');  ?>
                                 <?php echo $form->error($model, 'photo',array('class'=>'has-error','style'=>'color: red; font-weight: bold')); ?>
                            </div>

                            <button  type="submit" class="btn btn-lg btn-primary"><?php echo Yii::t('messages','Save'); ?></button>


                    <?php $this->endWidget(); ?>
                    </div><!-- form -->  
