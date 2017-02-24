<?php
$this->pageTitle = Yii::t('chat','Chat');//anytime this view gets called

$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/chat.css');
?>

<div class="main-wrapper" >
<main class="focus-mobile main-content container js-app-layout-main" role="main"><div><div class="row">
  <!--<div class="col-md-3">
    <?php /*$this->widget('application.modules.user.components.MailWidget', array('archive'=>$archive)); */?>
  </div>-->
  <div class="col-md-12 chat-main">
    <div class="js-chat-content"><div class="chat-list">

    <a href="/discover/" class="visible-xs chat-nav-link"><i class="fa fa-angle-left btn-icon"></i>Back to Browsing</a>
    <div class="chat-list-check-all hidden-xs">
      <span class="chat-list-checkbox">
        <input type="checkbox" id="check-all" class="js-check-all">
        <label for="check-all"></label>
      </span>

      <!--<button class="btn btn-default btn-sm chat-archive-all-btn
      js-<?php /*if (!$archive) echo 'archive'; else  echo 'unarchive'; */?>-all">
       <?php /*if (!$archive) echo Yii::t('chat','Archive'); else  echo Yii::t('chat','Move to inbox'); */?>
      </button>-->
      <button class="btn btn-default btn-sm chat-delete-all-btn js-delete-all">
        <?php echo Yii::t('chat','Delete'); ?>
      </button>
    </div>
    <ul role="navigation" class="nav chat-list-filter js-filter" style="margin-bottom: 1.625em;" >
      <li role="presentation" class="<?php if ($type==Chat::ALL_TYPE) echo 'active'; ?>" style="display: inline-block;"><a href="<?php if (!$archive) echo Yii::app()->createUrl('user/chat/inbox'); else echo Yii::app()->createUrl('user/chat/archive'); ?> "><?php echo Yii::t('chat','All'); ?> <span class="hidden-xs"><?php echo Yii::t('chat','Messages'); ?></span></a></li>
      <li role="presentation" class="<?php if ($type==Chat::BUYING_TYPE) echo 'active'; ?>" style="display: inline-block;"><a data-filter="buying" href="<?php if (!$archive) echo Yii::app()->createUrl('user/chat/inbox',array('type'=>Chat::BUYING_TYPE)); else echo Yii::app()->createUrl('user/chat/archive',array('type'=>Chat::BUYING_TYPE));  ?>"><?php echo Yii::t('chat','Buying'); ?></a></li>
      <li role="presentation" class="<?php if ($type==Chat::SELLING_TYPE) echo 'active'; ?>" style="display: inline-block;"><a data-filter="selling" href="<?php if (!$archive) echo Yii::app()->createUrl('user/chat/inbox',array('type'=>Chat::SELLING_TYPE)); else echo Yii::app()->createUrl('user/chat/archive',array('type'=>Chat::SELLING_TYPE));?>"><?php echo Yii::t('chat','Selling'); ?></a></li>
    </ul>  

  <div class="chat-list-container">
<?php $this->renderPartial('_chat_loop', array('chats'=>$chats,'archive'=>$archive)); ?>
  </div>  


<?php if ($chats->totalItemCount > $chats->pagination->pageSize): ?>
 <p style="margin-left: auto;
    margin-right: auto;
    text-align: center;
    width: 100%;display:none" id="loading"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/static/loading.gif" alt="" /></p>
    <p id="showMore" style="margin-left: auto;
    margin-right: auto;
    text-align: center;
    width: 100%;"><a href="#" style="text-align:center; font-weight: bold; font-size:17px;">Показать ещё</a></p>


    <script type="text/javascript">
    /*<![CDATA[*/
        (function($)
        {
            // скрываем стандартный навигатор
            $('.pager').hide();

            // запоминаем текущую страницу и их максимальное количество
            var page = parseInt('<?php echo (int)Yii::app()->request->getParam('page', 1); ?>');
            var pageCount = parseInt('<?php echo (int)$chats->pagination->pageCount; ?>');

            var loadingFlag = false;

            $('#showMore').click(function()
            {
                // защита от повторных нажатий
                if (!loadingFlag)
                {
                    // выставляем блокировку
                    loadingFlag = true;

                    // отображаем анимацию загрузки
                    $('#loading').show();

                    $.ajax({
                        type: 'post',
                        url: window.location.href,
                        data: {
                            // передаём номер нужной страницы методом POST
                            'page': page + 1,
                            '<?php echo Yii::app()->request->csrfTokenName; ?>': '<?php echo Yii::app()->request->csrfToken; ?>'
                        },
                        success: function(data)
                        {
                            // увеличиваем номер текущей страницы и снимаем блокировку
                            page++;
                            loadingFlag = false;

                            // прячем анимацию загрузки
                            $('#loading').hide();

                            // вставляем полученные записи после имеющихся в наш блок
                            $('.chat-list-container').append(data);

                            // если достигли максимальной страницы, то прячем кнопку
                            if (page >= pageCount)
                                $('#showMore').hide();
                        }
                    });
                }
                return false;
            })
        })(jQuery);
    /*]]>*/
    </script>

<?php endif; ?>


  <a href="/archive/" class="visible-xs chat-nav-link">Archived Chats <i class="fa fa-angle-right"></i></a>
</div></div>
  </div>
</div></div></main>
</div>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'popupDialog',
    'options' => array(
        'title' => Yii::t('chat', 'Chat'),
        'autoOpen' => false,
        'modal' => true,
        'resizable'=> false
    ),
)); ?>
<div id="msgModal" style="padding-bottom: 20px; padding-top: 20px; text-align: center;"></div>
<button type="button" class="btn btn-success center-block" id="closePopup" style="width: 50%;">Ok</button>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');

$inputsUrl = Yii::app()->createUrl('user/chat/manage');
Yii::app()->clientScript->registerScript('inboxscript',"

var redirectAfterDelete = false;


$('.js-delete-all').on('click', function() {
    createJSON('delete');
    return false;
});

$('.js-archive-all').on('click', function() {
    createJSON('archive');   
    return false;
});  

$('.js-unarchive-all').on('click', function() {
    createJSON('unarchive');
    return false;
});


function createJSON(type) {
items = [];
    $('input.checking_item:checked').each(function() {
        var v = $(this).attr('id');  
      items.push(v);
    });
var obj = {
  type: type, 
  ids: items,
};
var jsonString = '';
jsonString = JSON.stringify(obj);
$.ajax({
                url: '".$inputsUrl."',
                type: 'POST',
                dataType: 'json',
                data: jsonString,     
                success: function(msg)
                { 
                      $('#msgModal').text(msg.popupMessage);
                      $('#popupDialog').dialog('open');
                      redirectAfterDelete = true;  
                }
        });
}

$('.chat-list-check-all > span').on('click', function() {
   if ( $('#check-all').is(':checked') == false )
        {
        $('input').prop('checked', true);
          }
   else
      { 
       $('input').prop('checked', false);
       }
    return false;  
});


$('#closePopup').click(function() {
       $('#popupDialog').dialog('close');
       if (redirectAfterDelete)
           document.location.href='".Yii::app()->createUrl('user/chat/inbox')."';
       return false;
});   

",CClientScript::POS_READY);                                                                                                                     