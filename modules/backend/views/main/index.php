 
<?php 
$this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$ads,
    'itemView'=>'_search_item',   
    'sortableAttributes'=>array(
    ),
));

$vUrl= "";

Yii::app()->clientScript->registerScript('adminremovescript',"

$('.del_button').on('click',function(){
var id;
id = $(this).attr('id');
alert(id);
return false;
        var url = '".$vUrl."';
            $.ajax({
                url: url,
                method: 'POST',
                data: $('#aiform').serialize(),
                success: function(response)
                {


     
                }
            });
        });
",CClientScript::POS_READY);