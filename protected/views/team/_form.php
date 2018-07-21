<?php
/* @var $this TeamController */
/* @var $model Team */
/* @var $form CActiveForm */
?>
<?php
$this->breadcrumbs = array(
    'Teams' => array('index'),
    'Manage',
);
?>
<div class="container">
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
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'team-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'class' => 'form-horizontal'),
    ));
    ?>
    <div class="row form-group">
        <p class="note">Fields with <span class="required">*</span> are required.</p>
    </div>

     <div class="form-group">
        <div class="row col-md-12">

            <div class="col-md-2">
                <?php echo $form->labelEx($model, 'name', array("class" => "custom-label")); ?>
            </div>
            <div class="col-md-10">
<?php echo $form->textField($model, 'name', array("class" => "form-control", 'size' => 60, 'maxlength' => 200, "style" => "width:50%")); ?>
<?php echo $form->error($model, 'name'); ?>
            </div>

        </div>
    </div>
    </br>
    <div class="form-group" style="margin-right: 10px">
        <div class="row col-md-12">
            <div class="col-md-2">
                <?php echo $form->labelEx($model, 'logo', array("class" => "custom-label")); ?>
            </div>
            <div class="col-md-10">
<?php echo $form->fileField($model, 'logo', array("class" => "form-control", 'size' => 60, "style" => "width:50%")); ?>
<?php echo $form->error($model, 'logo'); ?>
            </div>
        </div>
    </div>
    </br>
    <div class="form-group">
        <div class="row col-md-12">
            <div class="col-md-2" text-align="left">
                <?php echo $form->labelEx($model, 'club_state', array("class" => "custom-label")); ?>
            </div>
            <div class="col-md-10">
<?php echo $form->textField($model, 'club_state', array("class" => "form-control", 'size' => 60, 'maxlength' => 200, "style" => "width:50%")); ?>
<?php echo $form->error($model, 'club_state'); ?>
            </div>
        </div>
    </div>
    </br>

    <div class="form-group buttons">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>


</div><!-- form -->