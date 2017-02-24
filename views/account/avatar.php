<?php
$this->pageTitle = Yii::t('messages', 'Name of site').' - '.Yii::t('messages', 'Site description for page title'); //anytime this view gets called
?>



<div class="col-md-4 col-sm-5">
    <div class="panel seller-namecard">
      <div class="media">

          <span class="pull-left">

          <img class="img-circle media-object pretty-border" src="<?php
                                 echo User::getAvatarImgSrc($user->avatar); ?>" alt="<?php echo $user->fio; ?>">


          </span>

        <div class="media-body">
          <h1 class="media-heading">
            <?php echo $user->fio; ?>
          </h1>
          <div class="text-muted"><?php echo Yii::t('messages','On site with').'&nbsp;'.date('Y',strtotime($user->register_date)).'&nbsp;'.Yii::t('messages','(On site with) year'); ?></div>
        </div>
      </div>
    </div>
    <div class="panel">
        <div class="panel-body">
            <div id="feedback_ratings" style="padding-left: 4px;">
               <a  onclick = " return false;" href="<?php echo Yii::app()->createUrl('sellerrating/create',array('type'=>SellerRating::POSITIVE,'sellerId'=>$user->urlID)); ?>">
                <div class="score">
                    <span class="spr pos"></span>
                    <span class="num pos_r"><?php echo SellerRating::model()->count('type=:type AND sellerID=:sellerID',array(':type'=>SellerRating::POSITIVE,':sellerID'=>$user->id)); ?></span>
                    <div class="cf"></div><span class="txt"><?php echo Yii::t('messages','Positive rating'); ?></span>
                    </div>
               </a>
            <a  onclick = " return false;" href="<?php echo Yii::app()->createUrl('sellerrating/create',array('type'=>SellerRating::NEUTRAL,'sellerId'=>$user->urlID)); ?>">
                <div class="score">
                      <span class="spr nei"></span>
                      <span class="num neu_r"><?php echo SellerRating::model()->count('type=:type AND sellerID=:sellerID',array(':type'=>SellerRating::NEUTRAL,':sellerID'=>$user->id)); ?></span>
                      <span class="txt"><?php echo Yii::t('messages','Neitral rating'); ?></span>
                </div>
            </a>

            <a  onclick = " return false;" href="<?php echo Yii::app()->createUrl('sellerrating/create',array('type'=>SellerRating::NEGATIVE,'sellerId'=>$user->urlID)); ?>">
                <div class="score">
                    <span class="spr neg"></span>
                    <span class="num neg_r"><?php echo SellerRating::model()->count('type=:type AND sellerID=:sellerID',array(':type'=>SellerRating::NEGATIVE,':sellerID'=>$user->id)); ?></span>
                    <span class="txt"><?php echo Yii::t('messages','Negative rating'); ?></span>
                </div>
               </a>
            </div>
        </div>
    </div>
</div>
<div class="col-md-8 col-sm-7">
     <div class="panel">
         <div class="panel-body">
             <h2><?php echo Yii::t('messages','Changing avatar'); ?></h2>
             <?php if(Yii::app()->user->hasFlash('success')):?>
                    <p class="bg-success  main-site-messages">
                    <?php echo Yii::app()->user->getFlash('success'); ?>
                    </p>
                <?php endif; ?>
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'avatarform',
                'enableClientValidation'=>false,
                'method'=>'POST',
                'clientOptions'=>array(
                    'validateOnSubmit'=>false,
                    ),
                'htmlOptions'=>array(
                    'class'=>'clearfix dropzone',
                    'enctype'=>'multipart/form-data',
                ),
                )); ?>
             <button id="btnAvatarSubmit" href="#" type="submit" class="btn btn-lg btn-primary btn-block" style="width: 150px; cursor: pointer;"><?php echo Yii::t('messages','Save'); ?></button>
             <?php $this->endWidget(); ?>
         </div>
     </div>

</div>




<?php
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
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');


$dropZoneUrl = Yii::app()->createUrl("account/uploadavatar",array('urlID'=>$user->urlID));
 
$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->getClientScript();  
$cs->registerScriptFile($baseUrl.'/js/dropzone/js/dropzone.min.js');
$cs->registerCssFile($baseUrl.'/js/dropzone//css/dropzone.css');
Yii::app()->clientScript->registerScript('dropzonescript',"




  var drop = new Dropzone('#avatarform',{
  url: '".$dropZoneUrl."',
  autoProcessQueue: false,
  addRemoveLinks : true,
  uploadMultiple: false,
  parallelUploads: 1,
  maxFiles: 1,
  autoDiscover: false,
  dictDefaultMessage: '".Yii::t('messages', 'Drop images here to upload avatar')."',
  dictRemoveFile: '".Yii::t('messages', 'Remove image')."',
  dictCancelUpload: '".Yii::t('messages', 'Cancel upload')."',
  dictMaxFilesExceeded: '".Yii::t('messages', 'You can upload only one photo for avatar')."', 
  });

  drop.on('success', function(file, response) {
       var jsonResponse = $.parseJSON(response);
       $.each(jsonResponse, function(key,value){
                if (key == 'erroris')
                    if (value == true)
                    {
                       file.previewElement.classList.add('dz-error');
                       $('#msgModal').empty().append(jsonResponse.etype);
                       $('#mydialog').dialog('open');
                    }
                    else
                        {
                            window.location.href = '".Yii::app()->createUrl("account/profile")."';
                        }

       });
  });

$('#btnAvatarSubmit').on('click',function(){
            drop.processQueue();
            return false;
})
 
",CClientScript::POS_READY);
 