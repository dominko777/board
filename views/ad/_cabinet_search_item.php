<li class="ad container" style="width: 100%">
  


    <div class="adImage">
        <a  href="<?php echo Yii::app()->createUrl('ad/view',array('name'=>$data->transName)); ?>">

            <img alt="" src="<?php echo Ad::getAdCoverImage($data->images); ?>" class="lazythumb">

            <div class="adExtraImg">

                <img src="<?php echo Yii::app()->request->baseUrl.'/images/static/ico_photo.png'; ?>" class="n_photo">
                <div class="bgphotoNumb">
                </div>
                <div class="photoNumb">
                    <?php echo count($data->images); ?>
                </div>
            </div>
            <!--
            <div class="adExtraHit">

                <img src="<?php echo Yii::app()->request->baseUrl.'/images/static/ico_eye.png'; ?>" class="n_photo">
                <div class="bgphotoNumb">
                </div>
                <div class="photoNumb">
                    <?php // if ($data->tracks->sum>0) echo $data->tracks->sum; else echo '0'; ?>
                </div>
            </div>-->


        </a>
    </div>
    <div class="adDesc">
        <div class="adWhat">
            <a href="<?php echo Yii::app()->createUrl('ad/view',array('name'=>$data->transName)); ?>">
                <?php echo $data->name; ?>
            </a>
            <br>
            <div style="">
                <?php
                if ($data->published==1)
                   {
                      echo Yii::t('messages', 'Published').' ';
                      $d = strtotime($data->date_time);
                      echo date('H:i', $d).' '.date('m-d-Y', $d);
                   }
                else  echo Yii::t('messages', 'Not published');   ?>
            </div>




        </div>
<?php if ($data->userID == Yii::app()->user->id): ?>
        <div class="controls">
            <a href="#"  id="<?php echo $data->transName; ?>" class="remove_ad"></a>
            <a href="#" onclick="location.href='<?php echo Yii::app()->createurl('ad/edit',array('id'=>$data->transName)); ?>'" class="edit_ad"></a>
        </div>
<?php endif; ?>

        <!--<div style="margin-top: 20px" class="controlsPaid">
            <a  href="<?php echo Yii::app()->createUrl('showcase/index',array('id'=>$data->transName)); ?>" class="paidAdBtn"><?php echo Yii::t('messages', 'Push to showcase'); ?></a>
        </div>
        <div style="margin-top: 1px" class="controlsPaid">
            <a href="<?php echo Yii::app()->createUrl('top/index',array('id'=>$data->transName)); ?>" class="paidAdBtn"><?php echo Yii::t('messages', 'Push to top'); ?></a>
        </div>-->

    </div>
</li>