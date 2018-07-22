<?php
/* @var $this PlayerController */
/* @var $model Player */
/* @var $form CActiveForm */
?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'player-form',
	'enableAjaxValidation'=>false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>
<?php if (Yii::app()->user->hasFlash('error')) { ?>
        <div style="color: red">
            <?php echo Yii::app()->user->getFlash('error'); ?>
        </div>
    <?php } ?>
    <?php if (Yii::app()->user->hasFlash('uploadError')) { ?>
        <div style="color: red">
            <?php echo Yii::app()->user->getFlash('uploadError'); ?>
        </div>
    <?php } ?>
    <?php if (Yii::app()->user->hasFlash('exist')) { ?>
        <div style="color: red">
            <?php echo Yii::app()->user->getFlash('exist'); ?>
        </div>
    <?php } ?>
	
        <?php 
        echo $form->dropDownListRow($model, 'team_id', CHtml::listData(Team::model()->findAll(array('order'=>'Name ASC')), 'team_id', 'name'),array('empty'=>'Select Team','class'=>'span5'));
        ?>
        <?php echo $form->textFieldRow($model,'first_name',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'last_name',array('class'=>'span5','maxlength'=>1)); ?>

	<?php echo $form->fileFieldRow($model,'image',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'jersey_number',array('class'=>'span5')); ?>
        <?php echo $form->textFieldRow($model,'country',array('class'=>'span5')); ?>

	<div>
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
