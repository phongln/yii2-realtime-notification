<?php

namespace app\controllers;

use Yii;
use app\models\Notification;
use app\models\NotificationSearch;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * NotificationController implements the CRUD actions for Notification model.
 */
class NotificationController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'delete', 'view', 'refresh'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Get default notifications for extension
     * @author PhongLN <phong.ln@vinixcorp.com.vn>
     * @return mixed
     */
    public function actionGetDefaultNotifications()
    {
        $req = Yii::$app->request;
        Yii::$app->response->format = Response::FORMAT_JSON;
        if($req->isGet && $req->get('secret') == Yii::$app->params['secretForInitialNotification']) {
            return ['defaultData' => json_encode(Notification::getDefaultNotification())];
        }

        return [];
    }

    /**
     * Re-push notification with specific id
     * @author PhongLN <phong.ln@vinixcorp.com.vn>
     * @return mixed
     */
    public function actionRefresh()
    {
        $req = Yii::$app->request;
        $model = $this->findModel($req->post('id'));

        if($req->isAjax && $req->isPost && !empty($model)) {
            $tab = $model->status == 1 ? 'default' : 'pushed';
            Yii::$app->response->format = Response::FORMAT_JSON;
            Yii::$app->session->setFlash('success-message', ucfirst($tab) . ' notification was refresh successfully.');

            if($tab == 'pushed') {
                return [
                    'type' => $tab, 'time' => $model->time, 'title' => $model->title, 'message' => $model->message,
                    'url' => $model->url, 'reloadLink' => Url::to(['index', 'tab' => $tab])
                ];
            }
        }
    }

    /**
     * Lists all Notification models.
     * @author PhongLN <phong.ln@vinixcorp.com.vn>
     * @return mixed
     */
    public function actionIndex($tab = 'pushed')
    {
        $searchModel = new NotificationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $defaultDataProvider = $searchModel->search(Yii::$app->request->queryParams, 1);

        $model = new Notification();
        $req = Yii::$app->request;
        $tab = !empty($req->post('tab')) ? $req->post('tab') : $tab;

        if($req->isAjax && $req->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if (!empty($req->post()) && $model->load($req->post()) && $model->save()) {
                Yii::$app->session->setFlash('success-message', ucfirst($tab) . ' notification was created successfully.');
            } else {
                Yii::$app->session->setFlash('error-message', d1($model->errors));
            }

            if($tab == 'pushed') {
                return [
                    'type' => $tab, 'time' => $model->time, 'title' => $model->title, 'message' => $model->message,
                    'url' => $model->url, 'reloadLink' => Url::to(['index', 'tab' => $tab])
                ];
            } else {
                return [
                    'type' => $tab, 'reloadLink' => Url::to(['index', 'tab' => $tab])
                ];
            }
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'defaultDataProvider' => $defaultDataProvider,
            'model' => $model,
            'tab' => $tab
        ]);
    }

    /**
     * Displays a single Notification model.
     * @author PhongLN <phong.ln@vinixcorp.com.vn>
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Notification model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @author PhongLN <phong.ln@vinixcorp.com.vn>
     */
    public function actionCreate()
    {
        $model = new Notification();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Notification model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @author PhongLN <phong.ln@vinixcorp.com.vn>
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $req = Yii::$app->request;
        $tab = $model->status == 1 ? 'default' : 'pushed';

        if($req->isAjax && $req->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if (!empty($req->post()) && $model->load($req->post()) && $model->save()) {
                Yii::$app->session->setFlash('success-message', ucfirst($tab) . ' notification was updated successfully.');
            } else {
                Yii::$app->session->setFlash('error-message', implode(', ', $model->errors));
            }

            if($tab == 'pushed') {
                return [
                    'type' => $tab, 'time' => $model->time, 'title' => $model->title, 'message' => $model->message,
                    'url' => $model->url, 'reloadLink' => Url::to(['index', 'tab' => $tab])
                ];
            } else {
                return [
                    'type' => $tab, 'defaultData' => json_encode(Notification::getDefaultNotification()), 'reloadLink' => Url::to(['index', 'tab' => $tab])
                ];
            }
        } else {
            return $this->render('update', [
                'model' => $model
            ]);
        }
    }

    /**
     * Deletes an existing Notification model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @author PhongLN <phong.ln@vinixcorp.com.vn>
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Notification model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Notification the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     * @author PhongLN <phong.ln@vinixcorp.com.vn>
     */
    protected function findModel($id)
    {
        if (($model = Notification::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
