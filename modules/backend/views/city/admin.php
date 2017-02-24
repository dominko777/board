<?php
/* @var $this CityController */
/* @var $model City */

$this->breadcrumbs=array(
	'Cities'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List City', 'url'=>array('index')),
	array('label'=>'Create City', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#city-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Cities</h1>
<a style="margin-bottom: 15px;" class="btn btn-default btn-lg" href="<?php echo Yii::app()->createUrl('backend/city/create'); ?>"><span aria-hidden="true" class="glyphicon glyphicon-plus"></span>&nbsp;<?php echo Yii::t('admin', 'Add'); ?></a>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'city-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
        'name',
		'orderID',
		array(
			'class'=>'CButtonColumn',
            'template'=>'{update}{up}{down}{delete}',
            'buttons'=>array
            (
                'up' => array
                (
                    'url'=> 'Yii::app()->createUrl("backend/city/up", array("id"=>$data->id))',
                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/static/up_icon.png',
                    'click' => 'function(){ return false; }',
                ),
                'down' => array
                (
                    'url'=> 'Yii::app()->createUrl("backend/city/down", array("id"=>$data->id))',
                    'click' => 'function(){ return false; }',
                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/static/bottom_icon.png'

                ),
            ),
		),
	),
)); ?>

<?php
    Yii::app()->clientScript->registerScript('updownscript',"

       $('.container').on('click','#city-grid a.up',function() {
         var qUrl = $(this).attr('href');
          $.ajax({
          url: qUrl,
          success: function(msg){
            $.fn.yiiGridView.update('city-grid');
          }
          });
          return false;
        }); 

        $('.container').on('click','#city-grid a.down',function() {
         var qUrl = $(this).attr('href');
          $.ajax({
          url: qUrl,
          success: function(msg){
            $.fn.yiiGridView.update('city-grid');
          }
          });
          return false;
        });

    ",CClientScript::POS_READY);
?>
