</br>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'match-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('class'=>'well','enctype' => 'multipart/form-data'),
)); ?>
    

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->error($model,'common_error'); ?>
	<?php 
    echo $form->dropDownListRow($model, 'team1', CHtml::listData(Team::model()->findAll(array('order'=>'Name ASC')), 'team_id', 'name'),array('empty'=>'Select Team1','class'=>'span5','ajax' => array(
        'type'=>'POST', 
        'url'=>CController::createUrl('match/teamList'), //url to call.
        'data' => array('Match_team1'=>'js:this.value'),
       // 'update'=>'#Match_team2', //selector to update
        'success'=>'function(data) { 
                            data = JSON.parse(data);
                            $("#Match_team2").html(data.team2); 
                            $("#Match_winner").html(data.winner); 
                           
                        }'
        )));
    ?>

    <?php  echo $form->dropDownListRow($model,'team2', ($model->isNewRecord) ?  array() : CHtml::listData(Team::model()->findAll(array('order'=>'Name ASC')), 'team_id', 'name'), array('empty'=>'Select Team2','class'=>'span5','ajax' => array(
        'type'=>'POST', 
        'url'=>CController::createUrl('match/teamListForWinner'), //url to call.
        'data' => array('Match_team2'=>'js:this.value','Match_team1'=>'js:Match_team1.value'),
        'update'=>'#Match_winner', //selector to update
        ),'options' => array($team2=>array('selected'=>true)))); ?>

    <?php echo $form->labelEx($model,'match_date'); ?>
    <?php echo $form->dateField($model,'match_date',array('size'=>32,'class'=>'span5')); ?>
    <?php echo $form->error($model,'match_date'); ?>

	<?php echo $form->textFieldRow($model,'match_status',array('class'=>'span5','maxlength'=>1)); ?>

	<?php  echo $form->dropDownListRow($model, 'winner', ($model->isNewRecord) ?  array() : CHtml::listData(Team::model()->findAll(array('order'=>'Name ASC')), 'team_id', 'name'), array('empty'=>'Select Winner','class'=>'span5','options' => array($winner=>array('selected'=>true)))); ?>

	<?php echo $form->textFieldRow($model,'score',array('class'=>'span5')); ?>

	<div>
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
