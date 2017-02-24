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
<?php

if (Yii::app()->user->id!=$user->id):
Yii::app()->clientScript->registerScript('ratingscriptcabinet',"

$('#feedback_ratings > a').click(function() {
       $('#feedback_ratings').fadeTo(0, 0.5);
       var ratingUrl = $(this).attr('href');
       $.ajax({
                url: ratingUrl,
                method: 'GET',
                success: function(msg)
                {
                      var result = $.parseJSON(msg);
                      $('.pos_r').text(result.positive);
                      $('.neu_r').text(result.neutral);
                      $('.neg_r').text(result.negative);
                      $('#feedback_ratings').fadeTo(0, 1);
                }
        });
       return false;
});
",CClientScript::POS_READY);
endif;


if(Yii::app()->user->isGuest){
Yii::app()->clientScript->registerScript('notloggedratingscriptcabinet',"
$('#feedback_ratings > a').click(function() {
       $('#ratingDialog').dialog('open');
       return false;
});
",CClientScript::POS_READY);
}
 
