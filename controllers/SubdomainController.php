<?php

namespace app\controllers;

use app\models\Member;
use myPHPnotes\cPanel;
use Yii;
use app\components\Mode;
use app\models\Subdomain;
use app\models\SubdomainSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/* custom controller, theme uplon integrated */
/**
 * SubdomainController implements the CRUD actions for Subdomain model.
 */
class SubdomainController extends Controller
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
            ]
        );
    }

    /**
     * Lists all Subdomain models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SubdomainSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Subdomain model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $referrer = $this->request->referrer;
        return $this->render('view', [
            'model' => $this->findModel($id),
            'referrer' => $referrer,
            'mode' => Mode::READ
        ]);
    }

    /**
     * Creates a new Subdomain model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Subdomain();

        $referrer = Yii::$app->request->referrer;

        if ($model->load(Yii::$app->request->post())) {
            $referrer = $_POST['referrer'];

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Create success.');
                return $this->redirect($referrer);
            }

            Yii::$app->session->setFlash('error', 'An error occured when create.');
        }

        return $this->render('view', [
            'model' => $model,
            'referrer' => $referrer,
            'mode' => Mode::CREATE
        ]);
    }

    /**
     * Updates an existing Subdomain model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $referrer = Yii::$app->request->referrer;

        if ($model->load(Yii::$app->request->post())) {
            $referrer = $_POST['referrer'];

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Update success.');
                return $this->redirect($referrer);
            }

            Yii::$app->session->setFlash('error', 'An error occured when update.');
        }

        return $this->render('view', [
            'model' => $model,
            'referrer' => $referrer,
            'mode' => Mode::UPDATE
        ]);
    }

    /**
     * Deletes an existing Subdomain model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Delete success');
        } else {
            Yii::$app->session->setFlash('error', 'An error occured when delete.');
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the Subdomain model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Subdomain the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Subdomain::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGenerate($id_member)
    {
        $member = Member::findOne([
            'id' => $id_member
        ]);

        $secret = require_once '../config/secret.php';

        $cpanel = $secret['secret']['cpanel'];

        $cPanel = new cPanel($cpanel['username'], $cpanel['password'], $cpanel['host']);

        // Create Sub-Domain
        $parameters = [
            'domain'                => "$member->nama",
            'rootdomain'            => $cpanel['host'],
            'dir'                   => "/home/{$cpanel['username']}/{$cpanel['host']}", //same directory as root host
            'disallowdot'           => '1',
        ];

        $result = $cPanel->execute('api2', 'SubDomain', 'addsubdomain', $parameters);
        $resultObject = $result->cpanelresult->data[0];
        if ($resultObject->result == 1) {
            $model = new Subdomain([
                'id_member' => $id_member,
                'name' => $member->nama,
                'url' => "{$member->nama}.{$cpanel['host']}" ,
            ]);
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Subdomain created successfully');
                return $this->redirect(['/member/index-admin-distributor']);
            }
        }

        Yii::$app->session->setFlash('error', $resultObject->reason);
        return $this->redirect(['/member/index-admin-distributor']);
    }

}
