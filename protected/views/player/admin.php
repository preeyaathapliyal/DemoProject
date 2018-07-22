<?php
/* @var $this PlayerController */
/* @var $model Player */

$this->breadcrumbs=array(
	'Players'=>array('index'),
	'Manage',
);

?>

<h1>Manage Players</h1>
<?php echo CHtml::button('Add Player', array('submit' => array('create'), 'class' => 'btn btn-primary')); ?>
&nbsp;&nbsp;&nbsp;

<?php if(Yii::app()->user->hasFlash('success')) {?>
</br>
    <div class="info" style="color:green">
        <label><?php echo Yii::app()->user->getFlash('success'); ?></label>
    </div>
<?php } ?>
<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'player-grid',
        'type' => 'striped bordered condensed hover',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
                    'name' => 'image',
                    'type' => 'image',
                    'value' => 'Yii::app()->request->baseUrl."/themes/images/player_images/".$data->image', 'htmlOptions' => array('width' => '80px', 'height' => '80px'),
                ),
		array(
                    'header' => 'Player Name',
                    'value' => '$data->playerNameImage()',
                    'headerHtmlOptions' => array('class' => 'custom_header'),
                ),
                array(
                        'header' => 'Team',
                        'value' => 'Player::getTeamName($data->team_id)',
                        'headerHtmlOptions' => array('class' => 'custom_header'),
                    ),
		'jersey_number',
		'country',
		array(
			'class' => 'bootstrap.widgets.TbButtonColumn',
                        'template' => '{update},{delete}',
		),
	),
)); ?>
