<div id="regContainer">
    <div id="box_registrazione">
        <div id="myads">
            <div style="" class="view_header">
                <div class="title">
                    <h1><?php echo $ad->name; ?> </h1>

                </div>
                <p><?php echo Yii::t('messages', 'Category'); ?>: <?php echo Categories::model()->find('orderID=:orderID',array(':orderID'=>$ad->categoryID))->name; ?></p>
                <span style="display: none;" id="adId"><?php echo $ad->urlID; ?></span>
            </div>


            <?php

            $now = strtotime("now");
            $finishDate = Top::model()->find('adID=:adID',array(':adID'=>$ad->id))->finishDate;
              if (strtotime($finishDate)>$now) {
            ?>
                  <div class="row" style="padding-top:30px;padding-bottom:20px;text-align: center;">
                      <div class="top_msg_after_scs_act">
                          <p class="lead" style="" ><?php echo Yii::t('messages', 'Your ad now in top.'); ?><br>
                      </div>
                  </div>
            <?php }
            else { ?>
            <div >
                <ul class="operationBtnList" style="margin-left:0px;">
                    <li>
                        <div id="3" class="btnGreen operationBtn"><?php echo Yii::t('messages', 'Add your ad in top for'); ?> 3 <?php echo Yii::t('messages', 'dnya'); ?></div>
                    </li>
                    <li>
                        <div id="7" class="btnGreen operationBtn"><?php echo Yii::t('messages', 'Add your ad in top for'); ?> 7 <?php echo Yii::t('messages', 'dnei'); ?></div>
                    </li>
                    <li>
                        <div id="14" class="btnGreen operationBtn"><?php echo Yii::t('messages', 'Add your ad in top for'); ?> 14 <?php echo Yii::t('messages', 'dnei'); ?></div>
                    </li>
                </ul>
            </div>
            <?php } ?>

        </div>
    </div>
</div>
<?php
Yii::app()->clientScript->registerScript('showcasescript',"
    $('.operationBtn').click(function() {
        var id= this.id;
        addToTopRequest(id);
        return false;
    });

    function addToTopRequest(id){
        var addToTopUrl = '".Yii::app()->createurl('top/create')."';
        var adId = $('#adId').text();
        $.ajax({
                url: addToTopUrl,
                method: 'GET',
                data: 'days='+id+'&adId='+adId,
                success: function(response)
                {
                      if (response=='saved')
                          window.location.href = '".Yii::app()->createUrl("top/success")."';
                }
        });
    }

",CClientScript::POS_READY);
