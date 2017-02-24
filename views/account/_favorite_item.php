<li class="ad container" >
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


        </a>
    </div>
    <div class="adDesc">
        <div class="adWhat">
            <a href="<?php echo Yii::app()->createUrl('ad/view',array('name'=>$data->transName)); ?>">
                <?php echo $data->name; ?>
            </a>
            <br>




        </div>

        <div class="controls">
            <a href="#"  id="<?php echo $data->transName; ?>" class="remove_fav"></a>
        </div>


    </div>
</li>