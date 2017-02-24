<div id="row">
    <div class="col-md-12 col-lg-12">
        <div id="main_ads_list" class="subcontent">
            <?php
            $this->widget('ext.Breadcrumbs.Breadcrumbs',array(
                'mainCategory'=>$activeMainCategory,
                'category'=>$activeCategory,
                'city'=>$activeCity,
                'itemCount'=>$ads->itemCount,
                'totalItemCount'=>$ads->totalItemCount
            ));   ?>

            <div class="main">
                <div class="listing">


        <style>
            .yiiPager .first, .yiiPager .last {
                display: none;
            }
        </style>






                        <?php
                        $today = date('Y-m-d');
                        $this->widget('zii.widgets.CListView', array(
                            'viewData' => array('today_date' => $today),
                            'dataProvider'=>$ads,
                            'summaryText'=>'',
                            'emptyText' => '',
                            'itemView'=>'_search_item',
                            'pager' =>'CPager',
                            'ajaxUpdate'=>true,
        'enablePagination'=>true,
                         //   'enableHistory' => true,
                         //   'ajaxUrl'=>Yii::app()->createurl('ads/search').'?Ad_page_2&mc=kukhnya',
                            'afterAjaxUpdate' => 'function(id, data){
                                $(".timeago").timeago();
                                $("html, body").animate({scrollTop: $("#content").position().top }, 100);}'
                        ));
                        ?>








                    <div style="padding:15px 0;" class="pagination">
                        <div>

                        </div>
                    </div>


                </div>
            </div>

        </div>
    </div>
</div>