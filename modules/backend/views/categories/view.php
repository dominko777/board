<?php
/* @var $this CategoriesController */
/* @var $model Categories */

$this->breadcrumbs=array(
	'Categories'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Categories', 'url'=>array('index')),
	array('label'=>'Create Categories', 'url'=>array('create')),
	array('label'=>'Update Categories', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Categories', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Categories', 'url'=>array('admin')),
);
?>

<h1>View Categories #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		array( 'name'=>'mainCategory', 'value'=>$model->mainCategory->name ),
	),
)); ?>
<a style="margin-top: 15px;" class="btn btn-success btn-lg" href="<?php echo Yii::app()->createUrl('backend/categories/admin'); ?>"><span aria-hidden="true" class="glyphicon glyphicon-ok"></span>&nbsp;<?php echo Yii::t('admin', 'Ok'); ?></a>
