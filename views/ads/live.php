<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/listing.min.css" media="screen" />
<?php $this->pageTitle= 'Просмотры обьявлений на Доминко'; ?>
<style>

.ads_views_item {
    margin: 10px 10px 20px 10px;
    float: left;
    background: #fff none repeat scroll 0 0;
    box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.26);
    display: inline-block;
    min-height: 188px;
    padding: 10px 0 0;
    position: relative;
    vertical-align: top;
    width: 300px;
}

.ads_views_item .adImage {
    background: #eee none repeat scroll 0 0;
    border: 1px solid #ccc;
    display: table;
    float: left;
    height: 96px;
    position: relative;
    text-align: center;
    width: 128px;
}

.ads_views_item .adImage > a {
    display: table-cell;
    vertical-align: middle;
}

.ads_views_item .adImage > a img {
    vertical-align: bottom;
}


.ads_views_item .adExtraImg {
    bottom: 0;
    color: #fff;
    height: 18px;
    left: 0;
    line-height: 18px;
    position: absolute;
    text-align: right;
    width: 40px;
}

.ads_views_item .adImage > a .n_photo {
    bottom: 5px;
    left: 4px;
    position: absolute;
    z-index: 10;
}


.ads_views_item .adExtraImg .bgphotoNumb {
    background: #000 none repeat scroll 0 0;
    height: 18px;
    opacity: 0.6;
    position: absolute;
    width: 100%;
}


.ads_views_item .adExtraImg .photoNumb {
    color: #fff;
    font-size: 12px;
    position: absolute;
    right: 0;
    text-align: center;
    width: 22px;
}

.ads_views_item .adWhat {
    width: 100%;
    float: left;
    padding-top: 20px;
    padding-left: 5px;
    padding-right: 5px;
}

.ads_views_item .adWhat > a{
    font-size: 14px;
    color: #5d8a21;
    font-weight: bold;
}

.ads_views_item .item_user_view {
    float:left;
    padding-top: 10px;
    
}

.ads_views_item .item_user_view_time {
    float:left;
    padding-top: 10px;
    padding-left: 5px;
    
}
</style>

<?php
 
$this->widget('ext.timeago.JTimeAgo', array(
    'selector' => ' .timeago',
    'settings'=>array(
                'allowFuture'=>true,
                )
 
));
 
?>

<div class="subcontent" id="main_ads_list">
    <div style="padding-left: 10px; font-size: 14px; color: black; " class="navigation" ><h2><strong><?php echo Yii::t('messages', 'Ads views'); ?></strong></h2></div>
    
        <div style="background: #fff none repeat scroll 0 0; border: 1px solid #cecece; border-radius: 5px;">
<style>
    .yiiPager .first, .yiiPager .last {
        display: none;
    }
</style>



           
           <div id="ads_views_list">     
                <?php
                $today = date('Y-m-d');
                $this->widget('ext.widgets.EColumnListView', array(
                    'dataProvider'=>$lives,
                    'summaryText'=>'',
                    'emptyText' => '',
                    'itemView'=>'_live_item',
                    'ajaxUpdate'=>false,
                    'template'=>"{items}\n{pager}",        
                     'pager'=>array(
                     'htmlOptions'=>array(
                    'class'=>'paginator'
                       )
                     ), 
                    'columns' => 3,
'enablePagination'=>true,
                ));
                ?>
          </div>
  

<?php if ($lives->totalItemCount > $lives->pagination->pageSize): ?>
 
    <p style="margin-left: auto;
    margin-right: auto;
    text-align: center;
    width: 100%;display:none" id="loading"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/static/loading.gif" alt="" /></p>
    <p style="margin-left: auto;
    margin-right: auto;
    text-align: center;
    width: 100%;" id="showMore"><a style="text-align:center; font-weight: bold; font-size:17px;" href="#">Показать ещё</a></p>
 
    <script type="text/javascript">
    /*<![CDATA[*/
        (function($)
        {
            // скрываем стандартный навигатор
            $('.pager').hide();
 
            // запоминаем текущую страницу и их максимальное количество
            var page = parseInt('<?php echo (int)Yii::app()->request->getParam('page', 1); ?>');
            var pageCount = parseInt('<?php echo (int)$lives->pagination->pageCount; ?>');
 
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
                            $('#ads_views_list').append(data);
 
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



            <div class="pagination" style="padding:15px 0;">
                <div>

                </div>
            </div>









        </div>

</div>