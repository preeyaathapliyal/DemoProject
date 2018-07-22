<?php
/* @var $this TeamController */
/* @var $model Team */
/* @var $form CActiveForm */
?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id' => 'team-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
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
