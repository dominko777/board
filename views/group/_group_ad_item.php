<div class="col-md-3" style="padding: 20px">
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
    <h4 class="title"><?php echo $data->name; ?></h4>
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
 
