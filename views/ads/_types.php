<div id="t_filter">
    <div class="typeslinks" id="typeLink">
        <div class="types">
            <?php foreach ($types as $type): ?>
                <ul>
                    <li>
                        <a data-id="<?php echo $type->transName;  ?>" href="#" class="tpLink">
                            <span class="link"><span><?php echo $type->name;  ?></span></span>
                        </a>
                    </li>
                </ul>
            <?php endforeach; ?>
        </div>
    </div>


    <div id="type_filter" class="sb_advfields" style="width: 100%; display: none;padding-bottom: 13px">
            <span style="padding-left: 4px; float:left; line-height: 23px;padding-right: 7px;font-size: 13px;">Шкафы / стенки</span>
            <a class="remove_type_filter" href="#"></a>
    </div>
</div>

<?php Yii::app()->clientScript->registerScript('typesscript',"
   $('a.tpLink').on('click',function(e) {
       var nameTpLink = $(this).text();
       var nameTpLinkId = $(this).data('id');

       $('#main_ads_list').fadeTo('fast', 0.2);
       var typeTransName = $(this).data('id');
       var typeLinkUrl = '".Yii::app()->createurl('ads/search')."'+'?'+$('#search-form').serialize()+'&type='+typeTransName+getActivePropertyUrl();
       $.ajax({
                url: typeLinkUrl,
                method: 'GET',
                success: function(response)
                {
                   $('#typeLink').hide();
                   $('#type_filter span').text(nameTpLink);
                   $('a.remove_type_filter').attr('id',nameTpLinkId);
                   $('#type_filter').show();
                   $('#main_ads_list').remove();
                   $('#content_m').append(response);


                }
            });
       return false;
   })

   $('a.remove_type_filter').on('click',function(e) {
       var typeLinkUrl = '".Yii::app()->createurl('ads/search')."'+'?'+$('#search-form').serialize()+getActivePropertyUrl();
       $.ajax({
                url: typeLinkUrl,
                method: 'GET',
                success: function(response)
                {
                   $('#type_filter').hide();
                   $('#typeLink').show();
                   $('#main_ads_list').remove();
                   $('#content_m').append(response);
                }
            });
       return false;
   })


",CClientScript::POS_READY);
?>