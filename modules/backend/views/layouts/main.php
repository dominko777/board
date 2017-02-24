<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo isset($this->pageTitle) ? $this->pageTitle : Yii::app()->name; ?></title>
<?php
Yii::app()->clientScript->registerMetaTag(Yii::t('messages', 'Seo keywords'), 'keywords');
Yii::app()->clientScript->registerCoreScript('jquery'); ?>

    <script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/css/bootstrap.min.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main1.css" media="screen" />
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/js/bootstrap.min.js"></script>
</head>

<body>
<?php
Yii::app()->clientScript->registerScriptFile("/js/clike.js");
?>


<nav class="navbar navbar-default navbar-static-top" style="background-color: #ffffff;">
      <div class="container">
        <div class="navbar-header">

            <a href="#" class="navbar-brand" style="padding-right: 5px; "><img alt="logo" src="<?php echo Yii::app()->request->baseUrl; ?>/images/static/logo6.png"/>
            <img style="display: none;" alt="big_logo" src="<?php echo Yii::app()->request->baseUrl; ?>/images/static/logo_150_150.jpg"/>
            </a>
            <a style="color:#d2232a; font-weight: bold; font-size: 20px" href="<?php echo Yii::app()->homeUrl; ?>" class="navbar-brand">Админка</a>  
            <p  class="visible-xs  visible-sm navbar-btn" style="margin-right:20px;">
                       <a rel="nofollow" class="btn  btn-danger" href="<?php  echo Yii::app()->request->baseUrl; echo "/Prodalike.apk" ?>" ><?php echo Yii::t('messages', 'Android Apk'); ?></a>
            </p>  
            <!--<p class="visible-xs  visible-sm navbar-btn">
                <a  class="btn btn-primary btn-sm"
                    href="<?php /*if(Yii::app()->user->isGuest) echo Yii::app()->createurl('account/login');  else echo Yii::app()->createurl('ad/new'); */?>" ><?php /*echo Yii::t('messages', 'Place my ad'); */?></a>
            </p>-->
        </div>

       
        <div class="navbar-collapse collapse" id="navbar">
          <ul class="nav navbar-nav">
        <li>
            <p  class="navbar-btn" style="margin-right:20px;">  
                       <a rel="nofollow" class="btn  btn-danger" href="<?php  echo Yii::app()->request->baseUrl; echo "/Prodalike.apk" ?>" ><?php echo Yii::t('messages', 'Android Apk'); ?></a>
            </p>
              </li>
            <li><a href="<?php echo Yii::app()->createurl('ads/viewAds'); ?>"><?php echo Yii::t('messages', 'Search ads'); ?></a></li>

          </ul>
        <?php
            if (Yii::app()->urlManager->parseUrl(Yii::app()->request)!='ads/viewAds'): ?>
        <div class="col-sm-3 col-md-3">   
        <form id="nav-search-form" class="navbar-form" role="search" action="<?php echo Yii::app()->createUrl('ads/view'); ?>">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="<?php echo Yii::t('messages','Search'); ?>" name="q" id="srch-term">
            <div class="input-group-btn">
                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
            </div>
        </div>
        </form>
        </div>
        <?php endif; ?>



          <ul class="nav navbar-nav navbar-right">

            <?php if(Yii::app()->user->isGuest){ ?>
             <li>
                <p class="navbar-btn">
                       <a rel="nofollow" class="btn btn-primary" href="<?php echo Yii::app()->createurl('account/login'); ?>" ><?php echo Yii::t('messages', 'Place my ad'); ?></a>
                 </p>
            </li>
             <li>
                <a href="<?php echo Yii::app()->createurl('account/login'); ?>"><?php echo Yii::t('messages', 'Login link'); ?></a>
            </li>
            <li>
                <a href="<?php echo Yii::app()->createurl('account/form'); ?>"><?php echo Yii::t('messages', 'Registration'); ?></a>
            </li>
           <?php } else { ?>
            <li>
                <p class="navbar-btn">
                       <a rel="nofollow" class="btn btn-primary" href="<?php echo Yii::app()->createurl('ad/new'); ?>" ><?php echo Yii::t('messages', 'Place my ad'); ?></a>
                 </p>
            </li>
            <?php
                  $criteria = new CDbCriteria;
                  $criteria->select = 't.id';
                  $criteria->join = 'LEFT JOIN 534q_chat c ON c.id = t.chatID ';
                  $criteria->join .= 'LEFT JOIN 534q_chat_delete cd ON c.id = cd.chatID AND cd.userID=:deleteUserID';
                  $criteria->condition = ' (c.buyerID =:buyerID XOR c.sellerID =:sellerID) AND t.userID <> :userID AND t.read =:read AND cd.id IS NULL';
                  $criteria->params = array(':buyerID'=>Yii::app()->user->id, ':sellerID'=>Yii::app()->user->id, ':userID'=>Yii::app()->user->id, ':deleteUserID'=>Yii::app()->user->id, ':read'=>0);
                  $countUnreadUserMessages = ChatReply::model()->count($criteria);
                ?>
              <li id="mychat">
                <a style="position:relative;" href="<?php echo Yii::app()->createurl('user/chat/inbox'); ?>" >
                    
                    <?php if ($countUnreadUserMessages!=0): ?>
                        <span style="border-radius: 25%; padding: 4px; color:white; background-color: #d2232a; ?> class="notifications-dot"><?php echo $countUnreadUserMessages; ?></span>
                    <?php endif; ?>
                    <span aria-hidden="true" class="glyphicon glyphicon-envelope"></span>
                </a>
            </li>



           <li>  
                <a href="<?php echo Yii::app()->createurl('backend/stat/index'); ?>">Статистика</a>
            </li>

           <li>
                <a href="<?php echo Yii::app()->createurl('activity/index'); ?>"><?php echo Yii::t('messages', 'News'); ?></a>
            </li>
           <?php } ?>
          </ul> 
        </div><!--/.nav-collapse -->
      </div>
    </nav>

   




<div class="container">
    <?php echo $content; ?>
</div>

<div class="hidden-xs footer" style="display: block">
<div class="container" >
  <div class="row" style="margin-left: -10px; margin-right: -10px;">
    <div class="footer-side col-lg-2 col-md-3">
      <h4 class="footer-label"><?php echo Yii::t('messages','Name of site'); ?></h4>
      <ul class="footer-list">
        <li>
          <a target="_blank" href="<?php echo Yii::app()->createUrl('site/contact'); ?>"><?php echo Yii::t('messages','Contacts'); ?></a>
        </li>
      </ul>


      <ul class="footer-list footer-social">
        <li class="footer-trademark hidden-xs hidden-sm">
          &copy; 2015 <?php echo Yii::t('messages','Name of site'); ?>
        </li>
      </ul>
    </div>
    <div class="footer-main col-lg-10 col-md-9">
      <div class="footer-categories hidden-xs hidden-sm">
          <?php
          $mainCategories = Main_categories::model()->with('categories')->findAll();
          foreach ($mainCategories as $mainCategory): ?>
          <ul class="footer-category">
            <li class="footer-label is-category">
                <?php echo $mainCategory->name; ?>
            </li>
              <?php foreach ($mainCategory->categories as $category): ?>
                <li class="footer-category-item">
                  <a href="<?php echo $this->createUrl('ads/view',array('mc'=>$mainCategory->transName,'ca'=>$category->transName)); ?>" >
                      <?php echo $category->name; ?>

                  </a>
                </li>
              <?php endforeach; ?>
          </ul>

        <?php endforeach; ?>

        </div><!-- end footer-categories -->
 
        <div class="footer-trademark hidden-md hidden-lg">
          &copy; 2015 Mysite
        </div>

    </div>
  </div>

</div>
</div>


<div id="loginModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo Yii::t('messages', 'Authorization'); ?></h4>
      </div>
      <div class="modal-body">

        <button onclick=" window.location='<?php echo Yii::app()->createurl('account/login'); ?>'" type="button" class="btn  btn-lg  btn-primary center-block" style="margin-top:10px;margin-bottom: 10px" data-dismiss="modal"><?php echo Yii::t('messages', 'Login link'); ?></button>


        <button onclick=" window.location='<?php echo Yii::app()->createurl('account/form'); ?>'" type="button" class="btn btn-lg btn-info center-block" style="margin-top:20px;margin-bottom: 10px" data-dismiss="modal"><?php echo Yii::t('messages', 'Registration'); ?></button>

</div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<body>





