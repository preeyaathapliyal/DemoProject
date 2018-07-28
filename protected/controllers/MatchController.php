<?php

class MatchController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','admin','create','update','delete','teamList','teamListForWinner'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Match;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		//print_r($_POST);exit;
		if(isset($_POST['Match']))
		{
			$model->attributes=$_POST['Match'];
			if($model->save()) {
				Yii::app()->user->setFlash('success', "Match saved successfully!");
				$this->redirect(array('admin'));
			} else {
				$model->addError('common_error','Error in saving Match!');
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'team2'=>'',
			'winner'=>'',
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		$parser = new CHtmlPurifier(); //create instance of CHtmlPurifier
        $id = $parser->purify($id); //we purify the $id

		$team2 = isset($model->team2)?$model->team2:"";
		$winner = isset($model->winner)?$model->winner:"";
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Match'])) {
			$model->attributes=$_POST['Match'];
			if($model->save()) {
				Yii::app()->user->setFlash('success', "Match updated successfully!");
				$this->redirect(array('admin'));
			} else {
				$model->addError('common_error','Error in saving Match!');
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'team2'=>$team2,
			'winner'=>$winner,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		try {
			$parser = new CHtmlPurifier(); //create instance of CHtmlPurifier
	        $id = $parser->purify($id); //we purify the $id
    
            $model = $this->loadModel($id);
			$model = $model->delete();
            if(!isset($_GET['ajax']))
                Yii::app()->user->setFlash('success','Match Deleted Successfully');
            else
                echo "<div class='flash-success' style='color:green'>Match Deleted Successfully</div>";
        } catch(CDbException $e) {
            if(!isset($_GET['ajax']))
                Yii::app()->user->setFlash('error','Error in deleting Match');
            else
                echo "<div class='flash-error'>Error in deleting Match"; //for ajax
        }
                                
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin')); 
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Match');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Match('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Match']))
			$model->attributes=$_GET['Match'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Match::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='match-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionTeamList() 
	{

		$team_id = isset($_POST['Match_team1'])?$_POST['Match_team1']:"";
		if(!empty($team_id)) {
			$parser = new CHtmlPurifier(); //create instance of CHtmlPurifier
        	$id = $parser->purify($team_id); //we purify the $id

			$teamList = Team::model()->findAll(array('condition'=>'team_id != :team_id','params'=>array(':team_id'=>$team_id),'order'=>'Name ASC'));
			$teamList=CHtml::listData($teamList,'team_id','name');
			
		   $team2 = "<option value=''>Select Team2</option>";
		   foreach($teamList as $key=>$val)
		   $team2 .= CHtml::tag('option', array('value'=>$key),CHtml::encode($val),true);

			$winner = "<option value=''>Select Winner</option>";
			echo CJSON::encode(array(
			  'team2'=>$team2,
			  'winner'=>$winner
			));
		}
	}

	public function actionTeamListForWinner() 
	{
		$parser = new CHtmlPurifier(); //create instance of CHtmlPurifier
       	$_POST = $parser->purify($_POST); //we purify the $id
		
		$teamArray[] = isset($_POST['Match_team1'])?$_POST['Match_team1']:"";
		$teamArray[] = isset($_POST['Match_team2'])?$_POST['Match_team2']:"";

		if(!empty($teamArray)) {
			$teamList = implode(',',$teamArray);
			$teamList = rtrim($teamList,',');
			$teamWinnerList = Team::model()->findAll(array('condition'=>"team_id in ($teamList)",'order'=>'Name ASC'));
			$teamWinnerList=CHtml::listData($teamWinnerList,'team_id','name');
			
		   echo "<option value=''>Select Winner</option>";
		   foreach($teamWinnerList as $key=>$val)
		   echo CHtml::tag('option', array('value'=>$key),CHtml::encode($val),true);
		}
	}
}
