<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'match-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php if (Yii::app()->user->hasFlash('error')) { ?>
        <div class="row">
            <?php echo Yii::app()->user->getFlash('error'); ?>
        </div>
    <?php } ?>
    <?php if (Yii::app()->user->hasFlash('uploadError')) { ?>
        <div class="row">
            <?php echo Yii::app()->user->getFlash('uploadError'); ?>
        </div>
    <?php } ?>
    <?php if (Yii::app()->user->hasFlash('exist')) { ?>
        <div class="row">
            <?php echo Yii::app()->user->getFlash('exist'); ?>
        </div>
    <?php } ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	
        <?php 
        echo $form->dropDownListRow($model, 'team1', CHtml::listData(Team::model()->findAll(array('order'=>'Name ASC')), 'team_id', 'name'),array('empty'=>'Select Team1','class'=>'span5'));
        ?>
        <?php  echo $form->dropDownListRow($model, 'team2', CHtml::listData(Team::model()->findAll(array('order'=>'Name ASC')), 'team_id', 'name'),array('empty'=>'Select Team2','class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'match_status',array('class'=>'span5','maxlength'=>1)); ?>

	<?php  echo $form->dropDownListRow($model, 'winner', CHtml::listData(Team::model()->findAll(array('order'=>'Name ASC')), 'team_id', 'name'),array('empty'=>'Select Winner','class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'score',array('class'=>'span5')); ?>

	<div>
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
