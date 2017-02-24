<?php $this->pageTitle = Yii::t('messages','Ads').'-'.Yii::t('messages','News').'&nbsp;'.Yii::t('messages','Seo keywords on Prodalike'); //anytime this view gets called


$this->widget('ext.timeago.JTimeAgo', array(
    'selector' => ' .timeago',

));
?> 

<div class="activity">
    <h2 class="text-center letterpress-heading activity-heading">
        <span  class="letterpress-heading-text">
        <span ><?php echo Yii::t('messages','News'); ?></span>
        </span>
    </h2>
    <div class="pagination-more">
        <?php $this->widget('ext.Activitytabs.ActivitytabsWidget',array()); ?>
        <ul class="activity-list">
            <?php
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider'=>$newAds,
                    'summaryText'=>'',
                    'emptyText' => '',
                    'itemView'=>'_index_item',
                    'ajaxUpdate'=>false,
                    'template'=>"{items}\n{pager}",
                     'pager'=>array(
                     'htmlOptions'=>array(
                    'class'=>'paginator'
                       )
                     ),
                    'enablePagination'=>true,
                ));
                ?>

        </ul>

        <?php if ($newAds->totalItemCount > $newAds->pagination->pageSize): ?>

    <div style="height: 5em; text-align: center; width: 100%; margin: auto; display:none;"  id="loading"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/static/loading.gif" alt="" /></div>
    <button class="btn btn-block btn-default pagination-more-btn activity-more"   id="showMore">Показать ещё</button>

    <script type="text/javascript">
    /*<![CDATA[*/
        (function($)
        {
            // скрываем стандартный навигатор
            $('.pager').hide();

            // запоминаем текущую страницу и их максимальное количество
            var page = parseInt('<?php echo (int)Yii::app()->request->getParam('page', 1); ?>');
            var pageCount = parseInt('<?php echo (int)$newAds->pagination->pageCount; ?>');

            var loadingFlag = false;

            $('#showMore').click(function()
            {
                // защита от повторных нажатий
                if (!loadingFlag)
                {
                    // выставляем блокировку
                    loadingFlag = true;
                    $('#showMore').hide();
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
                            $('#showMore').show(); 
                            // вставляем полученные записи после имеющихся в наш блок
                            $('.activity-list').append(data);
                            $(".timeago").timeago();

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
    </div>
</div>

