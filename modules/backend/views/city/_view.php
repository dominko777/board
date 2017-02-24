<?php
/* @var $this CityController */
/* @var $data City */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name_en')); ?>:</b>
	<?php echo CHtml::encode($data->name_en); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('orderID')); ?>:</b>
	<?php echo CHtml::encode($data->orderID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />


</div>
