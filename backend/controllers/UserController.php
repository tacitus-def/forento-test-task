<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use common\models\Group;
use common\models\Person;
use common\models\Client;
use backend\models\GroupForm;
use backend\models\PersonForm;
use backend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\base\DynamicModel;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
                    ],
                ],
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['admin'],
                        ],
                    ],
                ],
            ],
        );
    }

public function actionAddClient($id)
    {
        $model = $this->findUser($id);
        $name = Yii::$app->request->post('name');
        $validation = DynamicModel::validateData(['name' => $name], [
            ['name', 'required'],
        ]);

        if ($validation->hasErrors()) {

        }
        else {
            $client = Client::find()->where(['name' => $name])->one();
            if ($client) {
                $model->link('clients', $client);
            }
        }

        return $this->redirect(['user/view', 'id' => $id]);
    }

    public function actionDeleteClient($id)
    {
        $model = $this->findUser($id);
        $client_id = Yii::$app->request->get('client');
        $validation = DynamicModel::validateData(['client' => $client_id], [
            ['client', 'required'],
            ['client', 'integer'],
        ]);

        if ($validation->hasErrors()) {

        }
        else {
            $client = Client::findOne($client_id);
            if ($client) {
                $model->unlink('clients', $client, true);
            }
        }

        return $this->redirect(['user/view', 'id' => $id]);
    }


public function actionAddMember($id)
    {
        $model = $this->findGroup($id);
        $email = Yii::$app->request->post('email');
        $validation = DynamicModel::validateData(['email' => $email], [
            ['email', 'required'],
            ['email', 'email'],
        ]);

        if ($validation->hasErrors()) {

        }
        else {
            $member = Person::find()->where(['email' => $email])->one();
            if ($member) {
                $model->link('persons', $member);
            }
        }

        return $this->redirect(['user/view', 'id' => $id]);
    }

    public function actionDeleteMember($id)
    {
        $model = $this->findGroup($id);
        $member_id = Yii::$app->request->get('member');
        $validation = DynamicModel::validateData(['member' => $member_id], [
            ['member', 'required'],
            ['member', 'integer'],
        ]);

        if ($validation->hasErrors()) {

        }
        else {
            $member = Person::findOne($member_id);
            if ($member) {
                $model->unlink('persons', $member, true);
            }
        }

        return $this->redirect(['user/view', 'id' => $id]);
    }

    /**
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param int $id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findUser($id);
        $clientProvider = new ActiveDataProvider([
            'query' => $model->getClients(),
            'pagination' => [
                'pageSize' => 20,
            ]
        ]);

        switch ($model->type_is) {
            case User::TYPE_GROUP:
                $group = new Group();
                Group::populateRecord($group, $model->getAttributes());
                $memberProvider = new ActiveDataProvider([
                    'query' => $group->getPersons(),
                    'pagination' => [
                        'pageSize' => 20,
                    ]
                ]);
                return $this->render("view-group", [
                    'model' => $group,
                    'memberProvider' => $memberProvider,
                    'clientProvider' => $clientProvider
                ]);
                break;
            case User::TYPE_PERSON:
                $user = new Person();
                Person::populateRecord($user, $model->getAttributes());
                $groupProvider = new ActiveDataProvider([
                    'query' => $user->getGroups(),
                    'pagination' => [
                        'pageSize' => 20,
                    ]
                ]);
                return $this->render("view-user", [
                    'model' => $user,
                    'groupProvider' => $groupProvider,
                    'clientProvider' => $clientProvider
                ]);
                break;
        }
        throw new \yii\web\HttpException(500);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreateUser()
    {
        $model = new Person();
        $form = new PersonForm(['model' => $model]);

        if ($this->request->isPost) {
            if ($form->load($this->request->post()) && $form->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create-user', [
            'form' => $form,
        ]);
    }

    public function actionCreateGroup()
    {
        $model = new Group();
        $form = new GroupForm(['model' => $model]);

        if ($this->request->isPost) {
            if ($form->load($this->request->post()) && $form->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create-group', [
            'form' => $form,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateUser($id)
    {
        $model = $this->findPerson($id);
        $form = new PersonForm(['model' => $model]);

        if ($this->request->isPost && $form->load($this->request->post()) && $form->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update-user', [
            'form' => $form,
        ]);
    }

    public function actionUpdateGroup($id)
    {
        $model = $this->findGroup($id);
        $form = new GroupForm(['model' => $model]);

        if ($this->request->isPost && $form->load($this->request->post()) && $form->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update-group', [
            'form' => $form,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findUser($id);
        $model->setAttribute('deleted', User::DELETED);
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Person the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findUser($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findPerson($id)
    {
        if (($model = Person::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findGroup($id)
    {
        if (($model = Group::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
