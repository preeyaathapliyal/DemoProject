<?php
/* @var $this TeamController */
/* @var $model Team */
/* @var $form CActiveForm */
?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id' => 'team-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('class'=>'well','enctype' => 'multipart/form-data'),
)); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->error($model,'common_error'); ?>

    <?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>200)); ?>

    <?php echo $form->fileFieldRow($model,'logo',array('class'=>'span5')); ?>

    <?php echo $form->textFieldRow($model,'club_state',array('class'=>'span5','maxlength'=>200)); ?>

   <div>
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>$model->isNewRecord ? 'Create' : 'Save',
        )); ?>
    </div>

<?php $this->endWidget(); ?>

<?php
