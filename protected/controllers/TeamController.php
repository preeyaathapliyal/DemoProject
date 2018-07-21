<?php

class TeamController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'players', 'fixtures', 'create','update','delete','error'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Action to render the error
     * todo: design proper error page
     */
    public function actionError() {
        $error = Yii::app()->errorHandler->error;
        if ($error)
            $this->render('error', array('error' => $error));
        else
            throw new CHttpException(404, 'Page not found.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new Team('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Team']))
            $model->attributes = $_GET['Team'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Team the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Team::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Team $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'team-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Fetches the list of players.
     * @param integer $id
     * @return View
     */
    public function actionPlayers($id) {
        try {
            if (Yii::app()->request->isAjaxRequest) {
                //get Team Name
                $teamModel = Team::model()->findByPk($id);
                $name = (($teamModel->name) ? $teamModel->name : 'No Records available');

                $model = new player('search');
                $model->unsetAttributes();  // clear any default values

                $parser = new CHtmlPurifier(); //create instance of CHtmlPurifier
                $id = $parser->purify($id); //we purify the $id
                $name = $parser->purify($name); //we purify the $name

                $this->renderPartial('players', array(
                    'model' => $model, 'id' => $id, 'teamName' => $name
                        ), false, true);
            }
        } catch (Exception $ex) {
            return 'No Data Found';
        }
    }

    /**
     * Fetches the list of players.
     * @param integer $id
     * @return View
     */
    public function actionFixtures() {

        $model = new Match('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Match']))
            $model->attributes = $_GET['Match'];

        $this->render('fixtures', array(
            'model' => $model,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Team;
        
        if (isset($_POST['Team'])) {
            echo CActiveForm::validate($model);
            $checkTeam = Team::checkTeamExist($_POST['Team']['name']);
            if($checkTeam){
                $uploadedFile=CUploadedFile::getInstance($model,'logo');
                if(!empty($uploadedFile)){
                    $fileName = "{$_POST['Team']['name']}-{$uploadedFile->name}"; 
                    $uploadedFile->saveAs(Yii::app()->basePath.'/../themes/images/'.$fileName); 
                    $model->attributes = $_POST['Team'];
                    $model->created_at = date('Y:m:d H:i:s');
                    $model->logo = $fileName;
                    if ($model->validate() && $model->save()) {
                        Yii::app()->user->setFlash('success', "Team saved successfully!");
                        $this->redirect(array('index'));
                    } else {
                        Yii::app()->user->setFlash('error', "Team not saved!");
                    }
                } else {
                    Yii::app()->user->setFlash('uploadError', "Error in uploading logo!");
                }
            } else {
                Yii::app()->user->setFlash('exist', "Team already exist!");
            }
        }
        
        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        //echo "<pre>";print_r($_FILES);exit;
        if (isset($_POST['Team'])) {
            $this->performAjaxValidation($model);
            
            $uploadedFile=CUploadedFile::getInstance($model,'logo');
            if(!empty($uploadedFile)){
                $fileName = "{$_POST['Team']['name']}-{$uploadedFile->name}"; 
                $uploadedFile->saveAs(Yii::app()->basePath.'/../themes/images/'.$fileName); 
                $model->attributes = $_POST['Team'];
                $model->updated_at = date('Y:m:d H:i:s');
                $model->logo = $fileName;
                if ($model->validate() && $model->save()) {
                    Yii::app()->user->setFlash('success', "Team updated successfully!");
                    $this->redirect(array('index'));
                } else {
                    Yii::app()->user->setFlash('error', "Team not updated!");
                }
            } else {
                Yii::app()->user->setFlash('uploadError', "Error in uploading logo!");
            }
            
        }
        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {//echo "sdfdg"; exit;
        $model = $this->loadModel($id)->delete();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }
    
}
