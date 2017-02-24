<div class="col-md-2 col-sm-3 col-xs-6">
<figure class="card product-card">
  <div class="card-image">
    <a href="<?php echo Yii::app()->createUrl('ad/view',array('name'=>$data->transName)); ?>" class="js-view-product">
      <img src="<?php echo Ad::getAdCoverImage($data->images); ?>" alt="<?php echo $data->name; ?>">
    </a>
  <button  data-logged="<?php if(!Yii::app()->user->isGuest) echo 'true'; else echo 'false'; ?>" class="btn btn-default pdt-card-like
  <?php foreach ($data->likes as $like):
        if ($like->userID == Yii::app()->user->id) echo 'btn-success';
        endforeach; ?>"
  data-link="<?php echo Yii::app()->createUrl('ad/like',array('name'=>$data->transName)); ?>">
       <span class="glyphicon glyphicon-heart" aria-hidden="true"></span>
  </button> 

  </div>
  <figcaption class="caption">
    <h4 class="title"><?php echo $data->name; ?></h4>
    <p class="text-muted">
      <span class="price"><?php echo $data->price.'&nbsp;'.Yii::t('messages','Currency_sign small').'.'; ?></span>

      <span  class="pdt-card-likes">
          <span><?php echo $data->countlikes; ?></span>
          <span aria-hidden="true" class="glyphicon glyphicon-heart" style="color: #b3b3b3"></span>
      </span>
    </p>
    <div>
        <hr class="pdt-card-divider">
        <a class="btn btn-danger center-block" href="/user/chat/create?product=prodam-nikon-d3000-cifrovoy-fotoapparat-75688">
                        <span>Удалить</span>
                    </a>
        <a href="<?php echo Yii::app()->createUrl('account/user',array('id'=>$data->user->urlID)); ?>" class="pdt-card-seller media" style="text-decoration: none;">

            <div class="pull-left"><img  src="<?php echo User::getAvatarImgSrc($data->user->avatar); ?>" class="pdt-card-avatar media-object img-circle" style="height: 21px;  width: 21px;">

            </div>
            <div class="media-body">
                <h3 class="pdt-card-username media-heading"><?php echo $data->user->fio; ?></h3>
                <time class="pdt-card-timeago" style="max-width: 106px;">
                    <?php
                    echo CHtml::openTag('span',array('class'=>'timeago',
                                     'title'=>date(DATE_ISO8601,$data->time),         
                     ));  
                    echo date("d-m-Y",$data->time);
                    ?>  
                </time>
                
            </div>
        </a>

    </div>
  </figcaption>
</figure>
</div>

