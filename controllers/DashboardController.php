<?php

namespace app\controllers;

use app\components\Session;
use app\models\Member;
use app\models\Paket;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class DashboardController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'index-member'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    [
                        'actions' => ['index-distributor'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return Session::isDistributor();
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        if (!Session::isAdmin()) {
            return $this->actionIndexMember();
        }

        $this->layout = 'main';
        return $this->render('index');
    }

    public function actionIndexDistributor()
    {
        if (!Session::isDistributor()) {
            return $this->actionIndexMember();
        }

        $this->layout = 'main';
        return $this->render('index-distributor');
    }

    public function actionIndexMember()
    {
        if (Session::isDistributor()) {
            return $this->actionIndexDistributor();
        }

        if (Session::isAdmin()) {
            return $this->actionIndex();
        }

        $this->layout = 'main';

        if (Session::getIdMember() == null or Session::isMemberActive() == false) {
            return $this->render('index-member');
        }

        $member = Member::findOne(Session::getIdMember());
        $paket = Paket::findOne(['id' => $member->id_paket]);
        
        return $this->render('index-member-summary', [
            'member' => $member,
            'paket' => $paket
        ]);    
    }

}
