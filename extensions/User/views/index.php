<div class="panel seller-namecard">
      <div class="media">

          <span class="pull-left">

          <img class="img-circle media-object pretty-border" src="<?php echo User::getAvatarImgSrc($user->avatar); ?>">


          </span>

        <div class="media-body">
          <h1 class="media-heading">
            <?php echo $user->fio; ?>
          </h1>
          <div class="text-muted"><?php echo Yii::t('messages','On site with').'&nbsp;'.date('Y',strtotime($user->register_date)).'&nbsp;'.Yii::t('messages','(On site with) year'); ?></div>
        </div>
      </div>

     <?php if (Yii::app()->user->id!=$user->id): ?>
     <div class="seller-namecard-bottom">
      <button id="<?php echo $user->urlID; ?>" class="follow-button btn
      <?php if (empty($ifImFollowing))
            echo 'btn-info';
          else
              echo 'btn-success';
      ?>
      js-profile-follow"><?php
            if (empty($ifImFollowing))
                echo Yii::t('messages','Follow');
            else
                echo Yii::t('messages','Followed');
          ?></button>
    </div>
    <?php endif; ?>

    </div>
    <!--<div class="panel">
        <div class="panel-body">
            <div id="feedback_ratings" style="padding-left: 4px;">
               <a  onclick = " return false;" href="<?php /*echo Yii::app()->createUrl('sellerrating/create',array('type'=>SellerRating::POSITIVE,'sellerId'=>$user->urlID)); */?>">
                <div class="score">
                    <span class="spr pos"></span>
                    <span class="num pos_r"><?php /*echo SellerRating::model()->count('type=:type AND sellerID=:sellerID',array(':type'=>SellerRating::POSITIVE,':sellerID'=>$user->id)); */?></span>
                    <div class="cf"></div><span class="txt"><?php /*echo Yii::t('messages','Positive rating'); */?></span>
                    </div>
               </a>
            <a  onclick = " return false;" href="<?php /*echo Yii::app()->createUrl('sellerrating/create',array('type'=>SellerRating::NEUTRAL,'sellerId'=>$user->urlID)); */?>">
                <div class="score">
                      <span class="spr nei"></span>
                      <span class="num neu_r"><?php /*echo SellerRating::model()->count('type=:type AND sellerID=:sellerID',array(':type'=>SellerRating::NEUTRAL,':sellerID'=>$user->id)); */?></span>
                      <span class="txt"><?php /*echo Yii::t('messages','Neitral rating'); */?></span>
                </div>
            </a>

            <a  onclick = " return false;" href="<?php /*echo Yii::app()->createUrl('sellerrating/create',array('type'=>SellerRating::NEGATIVE,'sellerId'=>$user->urlID)); */?>">
                <div class="score">
                    <span class="spr neg"></span>
                    <span class="num neg_r"><?php /*echo SellerRating::model()->count('type=:type AND sellerID=:sellerID',array(':type'=>SellerRating::NEGATIVE,':sellerID'=>$user->id)); */?></span>
                    <span class="txt"><?php /*echo Yii::t('messages','Negative rating'); */?></span>
                </div>
               </a>
            </div>
        </div>
    </div>-->
<?php if ((count($user->groups)>0) || Yii::app()->user->id==$user->id): ?>
        <div class="panel">
            <div class="panel-body">
                <?php if (Yii::app()->user->id==$user->id): ?> 
                <a style="width: 100%; margin-bottom:15px;" href="<?php echo Yii::app()->createUrl('ad/new'); ?>"  class="btn btn-primary
                  ">Дать обьявление</a>
                <!--<br>
                <a href="<?php /*echo Yii::app()->createUrl('group/new'); */?>" style="width: 100%"  class="btn btn-default
                  ">Создать группу</a>-->
                <?php endif; ?>
            </div>
        </div>
<?php endif; ?>
</div>




<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'infodialog',
    'options' => array(
        'title' => Yii::t('messages', 'Info'),
        'autoOpen' => false,
        'modal' => true,
        'resizable'=> false
    ),
)); ?>
<div id="msgModal" style="padding: 20px"></div>
<button type="button" class="btn btn-success center-block" id="closePopup" style="width: 50%;">Ok</button>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');


$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'ratingDialog',
    'options' => array(
        'title' => Yii::t('messages', 'Rating'),
        'autoOpen' => false,
        'modal' => true,
        'resizable'=> false
    ),
)); ?>
<div id="msgModal" style="padding: 20px"><?php echo Yii::t('messages', 'You must be logged in to create rating');
echo ' <a style="text-decoration: underline; color: blue;" href="'.Yii::app()->createUrl('account/login').'">'.Yii::t('messages','Login link').'</a>'; ?></div>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');




if(Yii::app()->user->isGuest){

}
else {
Yii::app()->clientScript->registerScript('followscript',"
$('.follow-button').click(function() {
       $.ajax({
                url: '".Yii::app()->createUrl('account/follow',array('id'=>$user->urlID))."',
                method: 'GET',
                success: function(msg)
                {
                      var result = $.parseJSON(msg);
                      if (result.follow == 'created')
                      {
                         var userLogin = $('.seller-namecard .media-body h1').text();
                         $('.follow-button').text('".Yii::t('messages','Followed')."').removeClass('btn-info').addClass('btn-success');
                         $('#infodialog > #msgModal').empty().text('".Yii::t('messages','You have followed user')."'+' '+userLogin)
                         $('#infodialog').dialog('open');
                      }
                      else
                      if (result.follow == 'deleted')
                      {
                         var userLogin = $('.seller-namecard .media-body h1').text();
                         $('.follow-button').text('".Yii::t('messages','Follow')."').removeClass('btn-success').addClass('btn-info');
                         $('#infodialog > #msgModal').empty().text('".Yii::t('messages','You have not followed user')."'+' '+userLogin)
                         $('#infodialog').dialog('open');
                      }

                }
        });
       return false;
});    

$('#closePopup').click(function() {
       $('#infodialog').dialog('close');
       return false;
});
",CClientScript::POS_READY);
}