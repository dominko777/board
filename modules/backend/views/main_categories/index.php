<?php
/* @var $this Main_categoriesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Main Categories',
);

$this->menu=array(
	array('label'=>'Create Main_categories', 'url'=>array('create')),
	array('label'=>'Manage Main_categories', 'url'=>array('admin')),
);
?>

<h1>Main Categories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
