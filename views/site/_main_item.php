<div class="searchCard">
    <div class="pdt-card-img"> 
        <a class="pdt-card-thumbnail" href="<?php echo Yii::app()->createUrl('ad/view',array('name'=>$data->transName)); ?>">
            <?php
            $countIm = count($data->images);
            if ($countIm>0)
                    $src = AdImage::getDirPathFullsize($data->images[$countIm-1]->image);
            else
                $src = Yii::app()->request->baseUrl.'/images/static/nothumb.png'; 
            ?>
            <img alt="" src="<?php echo $src; ?>" class="lazythumb">
        </a>
    </div>
    <div class="adDesc">
        <div class="pdt-card-title">

                <?php echo $data->name; ?>
        </div>
        <p class="pdt-card-attr">
            <span class="item_price"><?php echo $data->price.' '; echo Yii::t('messages', 'Currency_sign small'); ?></span>
        </p>
    </div>
    <div>
 
    </div>
</div> 