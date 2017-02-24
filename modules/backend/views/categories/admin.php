<?php
/* @var $this CategoriesController */
/* @var $model Categories */

$this->breadcrumbs=array(
	'Categories'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Categories', 'url'=>array('index')),
	array('label'=>'Create Categories', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#categories-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Categories</h1>
<a style="margin-bottom: 15px;" class="btn btn-default btn-lg" href="<?php echo Yii::app()->createUrl('backend/categories/create'); ?>"><span aria-hidden="true" class="glyphicon glyphicon-plus"></span>&nbsp;<?php echo Yii::t('admin', 'Add category'); ?></a>
<a style="margin-left: 25px; margin-bottom: 15px;" class="btn btn-default btn-sm" href="<?php echo Yii::app()->createUrl('backend/main_categories/admin'); ?>"><span aria-hidden="true" class="glyphicon"></span>&nbsp;<?php echo Yii::t('admin', 'Main categories'); ?></a>
 </br>
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
	'id'=>'categories-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
        'orderID',
		array( 'name'=>'mainCategory', 'value'=>'$data->mainCategory->name' ),
		array(
			'class'=>'CButtonColumn',
            'template'=>'{update}{up}{down}{delete}',
            'buttons'=>array
            (
                'up' => array
                (
                    'url'=> 'Yii::app()->createUrl("backend/categories/up", array("id"=>$data->id))',
                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/static/up_icon.png',
                    'click' => 'function(){ return false; }',
                ),
                'down' => array
                (
                    'url'=> 'Yii::app()->createUrl("backend/categories/down", array("id"=>$data->id))',
                    'click' => 'function(){ return false; }',
                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/static/bottom_icon.png'

                ),
            ),
		),
	),
)); ?>

<?php
    Yii::app()->clientScript->registerScript('updownscript',"

       $('.container').on('click','#categories-grid a.up',function() {
         var qUrl = $(this).attr('href');
          $.ajax({
          url: qUrl,
          success: function(msg){
            $.fn.yiiGridView.update('categories-grid');
          }
          });
          return false;
        });

        $('.container').on('click','#categories-grid a.down',function() {
         var qUrl = $(this).attr('href');
          $.ajax({
          url: qUrl, 
          success: function(msg){
            $.fn.yiiGridView.update('categories-grid');
          }
          });
          return false;
        });

    ",CClientScript::POS_READY);
?>
