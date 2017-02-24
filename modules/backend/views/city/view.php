<?php
/* @var $this CityController */
/* @var $model City */

$this->breadcrumbs=array(
	'Cities'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List City', 'url'=>array('index')),
	array('label'=>'Create City', 'url'=>array('create')),
	array('label'=>'Update City', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete City', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage City', 'url'=>array('admin')),
);
?>

<h1>View City #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
        'orderID',
	),
)); ?>
<a style="margin-top: 15px;" class="btn btn-success btn-lg" href="<?php echo Yii::app()->createUrl('backend/city/admin'); ?>"><span aria-hidden="true" class="glyphicon glyphicon-ok"></span>&nbsp;<?php echo Yii::t('admin', 'Ok'); ?></a>
