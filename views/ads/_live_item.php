<div class="ads_views_item">
    


    <div class="adImage">
        <a  href="<?php echo Yii::app()->createUrl('ad/view',array('name'=>$data->adTransName)); ?>">
            <?php
            
            if (!empty($data->adPhoto))
                    $src = AdImage::getDirPathThumbs($data->adPhoto);
            else
                $src = Yii::app()->request->baseUrl.'/images/static/nothumb.png';
            ?>
            <img alt="" src="<?php echo $src; ?>" class="lazythumb">
            <?php if ($data->adPhotoNumber!=0): ?>
            <div class="adExtraImg">

                <img src="<?php echo Yii::app()->request->baseUrl.'/images/static/ico_photo.png'; ?>" class="n_photo">
                <div class="bgphotoNumb">
                </div>

                <div class="photoNumb">
                    <?php echo $data->adPhotoNumber; ?>
                </div>

            </div>
            <?php endif;  ?>

        </a>
    </div>
    <div class="adDesc">
        <div class="adWhat">
            <a href="<?php echo Yii::app()->createUrl('ad/view',array('name'=>$data->adTransName)); ?>">
                <?php echo $data->adName; ?>
            </a>
            <br>
            <span style="font-size: 11px;" class="item_user_view" style="color: black">
            <?php 
				echo 'Пользователь '.Yii::t('messages', 'Name of site').' '.Yii::t('messages','watched');
              
	     ?>

</span>
&nbsp;
<span style="font-size: 11px;" class="item_user_view_time"><?php  $nd = date('H:i d-m-Y', strtotime($data->date)); ?>

    
<?php  echo $nd; ?>
</span>




        </div>
    </div>
