<?php
$this->breadcrumbs=array(
	'Tbl Match Models'=>array('index'),
	'Manage',
);


?>

<h1>Manage Match</h1>
<?php echo CHtml::button('Add Match', array('submit' => array('create'), 'class' => 'btn btn-primary')); ?>


<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'match-grid',
        'type' => 'striped bordered condensed hover',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'match_id',
		'team1',
		'team2',
		'match_status',
		/*
		'winner',
		'score',
		'created_at',
		'updated_at',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
