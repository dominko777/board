<?php
$this->pageTitle = Yii::t('messages', 'Name of site').' - '.Yii::t('messages', 'Site description for page title'); //anytime this view gets called
$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl."/js/ajaxvalidationmessages.js");
?>
  
<div class="card sell-form">
    <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'ad-form',
                    'enableAjaxValidation'=>true,

                    'errorMessageCssClass'=>'has_error',
                    'clientOptions'=>array(
                        'validateOnChange'=>false,
                        'validateOnSubmit'=>true,
                        'afterValidate' => "js: function(form, html, hasError) {
                                             var htmlToString = JSON.stringify(html);
                                             if (hasError)
                                             {
                                             if (htmlToString.indexOf('{')==0) {
                                                   $('#ad-form').ajaxvalidationmessages('show', html);
                                                }
                                                else {
                                                   $('#ad-form').ajaxvalidationmessages('hide');
                                                }
                                             }
                                             else
                                                {
                                                    $('#ad-form').ajaxvalidationmessages('hide');
                                                    if ( htmlToString.indexOf('message')!=0 )
                                                    {
                                                        var result = 'object'? html : jQuery.parseJSON(html);
                                                        if (result.message == true)
                                                        {
                                                            flagMessageSaved = true;
                                                            adId = result.id;
                                                            $('#Ad_id').val(result.id);
                                                            $('#transNameIndex').empty().val(result.transName);

                                                            if (numberAddedFiles!=0)
                                                                 {
                                                                    $('#submitAdButton').prop('disabled',true);
                                                                    drop.processQueue();
                                                                 }
                                                            else
                                                                 window.location.href = '".Yii::app()->createUrl("ad/view")."/'+result.transName;
                                                        }       
                                                    }
                                                }
                                             }


                                         
                    "),
                    'action'=>Yii::app()->createUrl("ad/adajaxvalidation"),
                    'htmlOptions'=>array(
                        'class'=>'clearfix dropzone',
                        'enctype'=>'multipart/form-data',
                    ),
                    )); ?>
    <h2  class="text-center letterpress-heading mod-dark heading-four">
        <span  class="letterpress-heading-text mod-bg-white">
            <span><?php
            if ($model->isNewRecord)
                                echo Yii::t('messages', 'Create ad');
                            else
                                echo Yii::t('messages', 'Edit ad');
                            ?>
 </span>
        </span>
    </h2>
    <?php  echo $form->textField($model,'id', array('value'=>(!empty($model->id))? $model->id : 0, 'style'=>'display: none; ')); ?>

    <div  class="form-group sell-field  <?php if ($model->getError('name')) echo ' has-error'; ?>">
        <?php echo $form->label($model,'name'); ?> 
        <?php  echo $form->textField($model,'name', array('autofocus'=>'true','required'=>'true','class'=>"form-control")); ?>
        <div  class="error">
            <?php echo $form->error($model,'name',array('class'=>'help-block')); ?>
        </div>
    </div>

    <div class="form-group sell-field">
        <?php echo $form->label($model,'mainCategoryID'); ?>
        <?php echo $form->dropDownList($model,'mainCategoryID',
                 CHtml::listData($main_categories, 'id', 'name'),
                 array('prompt'=>Yii::t('messages', 'All categories'),'class'=>'form-control','required'=>true, 'aria-required'=>true,
                 'ajax' => array(  
                    'type'=>'POST',
                    'url'=>CController::createUrl('ad/getCategories'),
                    'update'=>'#Ad_categoryID',
                )));
        ?>  
        <?php echo $form->error($model,'mainCategoryID',array('class'=>'help-block')); ?>
    </div>


    <div class="form-group sell-field">
        <?php echo $form->label($model,'categoryID'); ?>

        <?php 
              $categoriesForSelect = Categories::model()->findAll('mainCategoryID=:mainCategoryID',array('mainCategoryID'=>$model->mainCategoryID));

        echo $form->dropDownList($model,'categoryID',
                 CHtml::listData($categoriesForSelect, 'id', 'name'),
                 array('prompt'=>Yii::t('messages', 'Select subcategory'),'class'=>'form-control','required'=>true, 'aria-required'=>true));
        ?>
        <?php echo $form->error($model,'categoryID',array('class'=>'help-block')); ?>
    </div>


    <div class="form-group sell-field">
        <?php echo $form->label($model,'cityID'); ?>
        <?php
                            if (empty($model->cityID))
                                echo $form->dropDownList($model, 'cityID',  CHtml::listData(City::model()->findAll(), 'orderID', 'name'), array('class'=>'form-control','prompt'=>Yii::t('messages', 'All cities')));
                            else
                            {
                               echo '<select class="form-control" name="Ad[cityID]" id="Ad_cityID">';
                               echo '<option value="">'.Yii::t('messages', 'All cities').'</option>';
                                $cities = City::model()->findAll(array('order'=>'orderID ASC'));
                                foreach ($cities as $city):  ?>
                                    <option <?php  if ($city->id == $model->cityID) echo 'selected="selected"'; ?> value="<?php echo $city->orderID; ?>"><?php echo $city->name; ?></option>
                                <?php
                                endforeach;
                               echo '</select>';
                                }
                                ?>
        <?php echo $form->error($model,'cityID',array('class'=>'help-block')); ?>
    </div>

    <div class="form-group sell-field">
        <?php echo $form->label($model,'text'); ?>
        <?php echo $form->textArea($model,'text', array('maxlength'=>'2000', 'class'=>'form-control')); ?>
        <?php echo $form->error($model,'text',array('class'=>'help-block')); ?>
    </div>

    <div class="form-group sell-field">
        <?php echo $form->label($model,'price'); ?>
        <?php echo $form->textField($model,'price', array('maxlength'=>'10', 'class'=>'form-control')); ?>
        <?php echo $form->error($model,'price',array('class'=>'help-block')); ?>
    </div>

    <div class="form-group sell-field">
        <?php echo $form->label($model,'condition'); ?>
        <select class="form-control" aria-required="true" required="true" name="Ad[condition]" id="conditionSelect">
                                <option selected="selected" value="<?php echo Ad::ALL_CONDITION_VALUE; ?>"><?php echo Yii::t('messages', 'Choose condition');  ?></option>
                                <option value="<?php echo Ad::ALL_CONDITION_VALUE; ?>"><?php echo Yii::t('messages', 'All condition text');  ?></option>
                                <option value="<?php echo Ad::NEW_CONDITION_VALUE; ?>"><?php echo Yii::t('messages', 'New condition text');  ?></option>
                                <option value="<?php echo Ad::BU_CONDITION_VALUE; ?>"><?php echo Yii::t('messages', 'Bu condition text');  ?></option>
        </select>
    <?php echo $form->error($model,'condition',array('class'=>'help-block')); ?>
    </div>

   <div class="form-group sell-field">
        <?php echo $form->label($model,'phone'); ?>
       <?php
              $model->phone = ($model->phone!=0) ? $model->phone : User::model()->findByPk(Yii::app()->user->id)->phone; ;
              echo $form->textField($model,'phone', array('maxlength'=>'15', 'class'=>'form-control')); ?>
        <?php echo $form->error($model,'phone',array('class'=>'help-block')); ?> 
    </div>

   <div class="form-group sell-field">
        <?php echo $form->checkBox($model,'hidePhone', array()); ?>
        <span><?php echo Yii::t('messages', 'Show number'); ?></span>
        <?php echo $form->error($model,'hidePhone',array('class'=>'help-block')); ?>
    </div> 

    <?php  echo $form->textField($model,'transName', array('maxlength'=>'50','id'=>'transNameIndex','style'=>'display: none;')); ?>


    <?php $this->endWidget(); ?>
    <div class="row">
    <div class="sell-field " style="clear: both; width: 100%; ">
        <div class="col-md-6 col-xs-12  pull-left">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('messages','Create') : Yii::t('messages','Save') ,array('class'=>'btn btn-lg btn-primary  pull-left col-xs-12' ,'style'=>'cursor: pointer','id'=>'submitAdButton'));   ?>
        </div>
    <?php if (!$model->isNewRecord) { ?>
    <div  class="btn-horizontal-list">
        <?php if ($model->soldStatus != 1): ?>
        <div class="col-md-3  col-xs-12  pull-right">
            <button  id="soldAdBtn" type="button" class="btn btn-warning btn-lg  col-xs-12">
                <span><?php echo Yii::t('messages','Mark as sold');; ?></span>
            </button>
        </div>
        <?php endif; ?>
        <div class="col-md-3  col-xs-12 pull-right">
            <button  id="deleteAdBtn" type="button" class="btn btn-danger btn-lg  col-xs-12">
                <span><?php echo Yii::t('messages','Delete ad');; ?></span>
            </button>
        </div>
    </div>
    <?php } ?>
    </div>
    </div>

    
</div>

<?php

Yii::app()->clientScript->registerScript('newadscript',"

       var flagMessageSaved = false;
       var  isPhotosUploaded = false;
       var numberAddedFiles = 0;
       var adId = 0;

       $('#submitAdButton').on('click',function(){
          if (flagMessageSaved == false)
            $('#ad-form').submit();
          else
              if (numberAddedFiles!=0)
                {
                  $(this).prop('disabled', true);
                  drop.processQueue();
                }  
          return false;
       }) 
   ",CClientScript::POS_READY);  



$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'mydialog',
    'options' => array(
        'title' => Yii::t('messages', 'Upload file error'),
        'autoOpen' => false,
        'modal' => true,
        'resizable'=> false
    ),
)); ?>
<div id="msgModal" style="padding: 20px"></div>
<button type="button" class="btn btn-success center-block" id="closePopup" style="width: 50%;">Ok</button>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');




$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'/js/dropzone/js/dropzone.min.js');
$cs->registerCssFile($baseUrl.'/js/dropzone//css/dropzone.css');
Yii::app()->clientScript->registerScript('dropzonescript',"
  var drop = new Dropzone('#ad-form',{   
  url: '".Yii::app()->createUrl("ad/photoUpload")."',  
  autoProcessQueue: false,
  addRemoveLinks : true, 
  uploadMultiple: false,
  parallelUploads: 100,
  maxFiles: 100,
  autoDiscover: false,
  dictDefaultMessage: '".Yii::t('messages', 'Drop images here to upload')."',
  dictRemoveFile: '".Yii::t('messages', 'Remove image')."',
  dictCancelUpload: '".Yii::t('messages', 'Cancel upload')."',
  acceptedFiles: 'image/*', 
  init: function(){
       thisDropzone = this;
       thisDropzone.on('addedfile', function(file) { numberAddedFiles++; });
        $.ajax({
           type: 'GET',
           url: '".Yii::app()->createUrl("ad/showadimages")."'+'/id/".$model->id."',
           success: function(msg){
           console.log(msg);
                var jsonResponse = $.parseJSON(msg);
                var firstSequence, secondSequence, thirdSequence;
                $.each(jsonResponse[0].imgArray , function(key, value) {
                firstSequence=value.substr(0,3);
                secondSequence=value.substr(3,3);
                thirdSequence=value.substr(6,3);
                var mockFile = {};
                var sIUrl = '".Yii::app()->getBaseUrl(true)."/images/dzthumbs/'+firstSequence+'/'+secondSequence+'/'+thirdSequence+'/'+value;
                thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                thisDropzone.options.thumbnail.call(thisDropzone, mockFile, sIUrl);
                var imgPreviewTemplate = jQuery(mockFile.previewTemplate);
                $( '<div style=\'display: none\' class=\'photo_id\'>'+key+'</div>').appendTo(imgPreviewTemplate);
            });

           }
        });
      }
  });
 
  drop.on('success', function(file, response) {
       var jsonResponse = $.parseJSON(response);
       $.each(jsonResponse, function(key,value){
                if (key == 'erroris')
                    if (value == true)
                    {
                       $('#submitAdButton').prop('disabled',false);
                       file.previewElement.classList.add('dz-error');
                       $('#msgModal').empty().append(jsonResponse.etype);
                       $('#mydialog').dialog('open');
                    }
                    else
                        {
                            var valtransNameIndex = $('#transNameIndex').val();  
                            window.location.href = '".Yii::app()->createUrl("ad/view")."/'+valtransNameIndex;
                        } 

       });


      // window.location.href = '".Yii::app()->createUrl("ad/verify")."';
  });


",CClientScript::POS_READY);



if (!$model->isNewRecord) {
    Yii::app()->clientScript->registerScript('removephotoscript',"

    var redirectAfterDelete = false;
    
drop.on('removedfile', function(file) {
    var imgPreviewTemplate = jQuery(file.previewTemplate);
    var  id = imgPreviewTemplate.find('div.photo_id').html();
    $.ajax({
        type: 'GET',
        url: '".Yii::app()->createUrl("ad/photoremove")."'+'/id/".$model->id."', 
        data: 'id_img='+id,
        success: function(msg){
            $(this).prop('disabled', true);
        }
    });
});


$('#soldAdBtn').click(function() {
       $.ajax({
                url: '".Yii::app()->createUrl("ad/makesold",array('id'=>$model->id))."',
                method: 'GET',
                success: function(msg)
                {
                      var result = $.parseJSON(msg);
                      if(result.modelSaved == true)
                      {
                        var valtransNameIndex = $('#transNameIndex').val();
                        window.location.href = '".Yii::app()->createUrl("ad/view")."/'+valtransNameIndex;
                      }   
                        
                }
        });
       return false;
});


$('#deleteAdBtn').click(function() {
if(!confirm('Вы хотите удалить это обьявление')) return false;
    
    $.ajax({
                url: '".Yii::app()->createUrl("ad/delete")."',   
                method: 'POST',
                data: 'id=".$model->transName."',
                success: function(response)
                {

                        $('#msgModal').empty().append('".Yii::t('messages','Ad was successfuly deleted')."');
                        redirectAfterDelete = true;
                        $('#mydialog').dialog('open');
                      
                }
        });
        return false;
});

$('#closePopup').click(function() {
       $('#popupDialog').dialog('close');
       if (redirectAfterDelete)
           document.location.href='".Yii::app()->createUrl('ads/view')."';
       return false;
});

",CClientScript::POS_READY);
}