<li data-id="106441337" class="ad container">
    <div class="adWhen" style="font-size: 11px; text-align: center;">
        <?php
    //    echo $today_date.'<br>';
    //    echo $data->date_time;
        ?>

        <?php
        $d = strtotime($data->date_time);
        if ($d >= strtotime("today"))
            echo Yii::t('messages', 'Today');
        else if ($d >= strtotime("yesterday"))
           // echo "Yesterday";
        ?>
        <br>
        <?php
        echo date('m.d', $d).'<br>';   
        echo date('H-i', $d);
        ?>
    </div>


    <div class="adImage">
        <a  href="<?php echo Yii::app()->createUrl('ad/view',array('id'=>$data->urlID)); ?>">
            <?php
            $countIm = count($data->images);
            if ($countIm>0)
                    $src = AdImage::getDirPathThumbs($data->images[$countIm-1]->image);
            else
                    $src = "http://s.sbito.it/1201425894895/img2/nothumb.png";
            ?>
            <img alt="" src="<?php echo $src; ?>" class="lazythumb">

            <div class="adExtraImg">

                <img src="http://s.sbito.it/1201425894895/img2/ico_photo.png" class="n_photo">
                <div class="bgphotoNumb">
                </div>
                <div class="photoNumb">
                    <?php echo count($data->images); ?>
                </div>
            </div>


        </a>
    </div>
    <div class="adDesc">
        <div class="adWhat">
            <a href="<?php echo Yii::app()->createUrl('ad/view',array('id'=>$data->urlID)); ?>">
                <?php echo $data->name; ?>
            </a>
            <br>




        </div>
        <div class="adType">
            <?php
            switch ($data->subtypeID) {
                case Ad::SALE: echo Ad::SALE_VALUE; break;
                case Ad::RENT: echo Ad::RENT_VALUE; break;
                case Ad::WANTED: echo Ad::WANTED_VALUE; break;
            }
            ?>
            <br>

        </div>
        <div class="adCat">

            <?php echo $data->categoryName; ?>

        </div>
        <div class="adWhere">
            <?php echo $data->cityName; ?>
        </div>
    </div>
</li>