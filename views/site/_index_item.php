<div class="col-md-2 col-lg-2 col-xs-6">
      <figure class="card product-card">
  <div class="card-image">
    <a href="<?php echo Yii::app()->createUrl('ad/view',array('name'=>$data->transName)); ?>" class="js-view-product">

      <img src="<?php echo Ad::getAdCoverImage($data->images); ?>" alt="<?php echo $data->name; ?>">
    </a>
    <button  class="btn btn-default pdt-card-like  
      <?php foreach ($data->likes as $like):
            if ($like->userID == Yii::app()->user->id) echo 'btn-success';
            endforeach; ?>"
      data-link="<?php echo Yii::app()->createUrl('ad/like',array('name'=>$data->transName)); ?>"
      data-logged="<?php if(!Yii::app()->user->isGuest) echo 'true'; else echo 'false'; ?>">
           <span class="glyphicon glyphicon-heart" aria-hidden="true"></span>
      </button>

  </div>
  <figcaption class="caption">
    <h4 class="title" style="font-size: 0.8em"><?php echo $data->name; ?></h4>      
    <p class="text-muted">
      <span class="price"><?php echo $data->price.'&nbsp;'.Yii::t('messages','Currency_sign small').'.'; ?></span>
      <span  class="pdt-card-likes">
          <span><?php echo $data->countlikes; ?></span>
          <span aria-hidden="true" class="glyphicon glyphicon-heart" style="color: #00B230"></span>
      </span>
    </p>
  </figcaption>
</figure>
</div>

<!--<div class="searchCard">
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
        <hr class="searchCardDivider">

        <a href="<?php echo Yii::app()->createUrl('ad/user',array('id'=>$data->user->urlID)); ?>" class="pdt-card-seller media" style="text-decoration: none;">
            <?php
                if ($data->user->avatar =='nothumb.jpg') $avatarSrc =  Yii::app()->request->baseUrl.'/images/static/default.png';
                            else $avatarSrc = User::getAvatarFile($data->user->avatar);
            
            ?>
            <div class="pull-left"><img alt="nicangelb" src="<?php echo $avatarSrc; ?>" class="pdt-card-avatar media-object img-circle">

            </div>
            <div class="media-body">
                <h3 class="pdt-card-username media-heading"><?php echo $data->user->fio; ?></h3>
                <time class="pdt-card-timeago">
                    <span><?php echo date('H-i d-m-Y', strtotime($data->time)); ?>
      </span>
                </time>
            </div>
        </a>
    </div>
</div>
-->