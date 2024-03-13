<?php

namespace backend\controllers;

use Yii;
use common\models\Person;
use common\models\Client;
use backend\models\ClientForm;
use backend\models\ClientSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\base\DynamicModel;

/**
 * ClientController implements the CRUD actions for Client model.
 */
class ClientController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                        'add-user' => ['POST'],
                        'delete-user' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Client models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ClientSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Client model.
     * @param int $id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $userProvider = new ActiveDataProvider([
            'query' => $model->getUsers(),
            'pagination' => [
                'pageSize' => 20,
            ]
        ]);
        return $this->render('view', [
            'model' => $model,
            'userProvider' => $userProvider,
        ]);
    }

    /**
     * Creates a new Client model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Client();
        $form = new ClientForm(['model' => $model]);

        if ($this->request->isPost) {
            if ($form->load($this->request->post()) && $form->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'form' => $form,
        ]);
    }

    public function actionAddUser($id)
    {
        $model = $this->findModel($id);
        $email = Yii::$app->request->post('email');
        $validation = DynamicModel::validateData(['email' => $email], [
            ['email', 'required'],
            ['email', 'email'],
        ]);

        if ($validation->hasErrors()) {

        }
        else {
            $user = Person::find()->where(['email' => $email])->one();
            if ($user) {
                $model->link('users', $user);
            }
        }

        return $this->redirect(['client/view', 'id' => $id]);
    }

    public function actionDeleteUser($id)
    {
        $model = $this->findModel($id);
        $user_id = Yii::$app->request->get('user');
        $validation = DynamicModel::validateData(['user' => $user_id], [
            ['user', 'required'],
            ['user', 'integer'],
        ]);

        if ($validation->hasErrors()) {

        }
        else {
            $user = Person::findOne($user_id);
            if ($user) {
                $model->unlink('users', $user, true);
            }
        }

        return $this->redirect(['client/view', 'id' => $id]);
    }

    /**
     * Updates an existing Client model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $form = new ClientForm(['model' => $model]);

        if ($this->request->isPost && $form->load($this->request->post()) && $form->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'form' => $form,
        ]);
    }

    /**
     * Deletes an existing Client model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->setAttribute('deleted', Client::DELETED);
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Client model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Client the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Client::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
