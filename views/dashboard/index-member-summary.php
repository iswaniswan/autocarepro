<?php
/** @var yii\web\View $this */

use app\components\Session;
use app\models\FundActive;
use app\models\FundPassive;
use app\models\FundTicket;
use yii\helpers\Url;

$this->title = 'Dashboard Member';
$this->params['breadcrumbs'][] = $this->title;

echo \app\widgets\Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    'options' => [
        'title' => $this->title
    ],
]) ?>


<div class="row mb-4">
    <div class="col-sm-6">
        <div class="card-box tilebox-one">
            <h6 class="text-muted text-uppercase mt-0">Member Area</h6>
            <div class="row mt-4 mb-2" style="margin-left: -24px;">
                <a href="<?= Url::to(['member/update-profile', 'id' => $member->id]) ?>" class="col text-center">
                    <i class="icon-user m-2 h2 text-success"></i>
                    <span class="text-muted" style="display: block;">Profil</span>
                </a>
                <a href="<?= Url::to(['member/update-paket', 'id' => $member->id]) ?>" class="col text-center">
                    <i class="icon-badge m-2 h2 text-purple"></i>
                    <span class="text-muted" style="display: block;">Paket</span>
                </a>
                <a href="<?= Url::to(['member/update-bank', 'id' => $member->id]) ?>" class="col text-center">
                    <i class="icon-wallet m-2 h2 text-primary"></i>
                    <span class="text-muted" style="display: block;">Bank</span>
                </a>
                <a href="<?= Url::to(['member/update-security', 'id' => $member->id]) ?>" class="col text-center">
                    <i class="icon-lock-open m-2 h2 text-danger"></i>
                    <span class="text-muted" style="display: block;">Security</span>
                </a>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card-box tilebox-one">
            <i class="icon-tag float-right m-0 h2 text-success"></i>
            <h6 class="text-muted text-uppercase mt-0"><?= $paket->name ?></h6>
            <h3 class="my-3 card-poin"><?= FundTicket::getBalance($member->id) ?></h3>
            <?php $lastCredit = FundTicket::lastCredit($member->id) ?>
            <span>Terakhir ditambahkan <?= date('d M Y', strtotime($lastCredit->date_created)) ?></span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-6">
        <div class="card-box tilebox-one">
            <i class="ti-money float-right m-0 h2 text-muted"></i>
            <h6 class="text-muted text-uppercase mt-0">Saldo Active</h6>
            <?php $balanceActive = FundActive::getBalance($member->id); ?>
            <h3 class="my-3 text-success"><?= "IDR. " . number_format($balanceActive, 0, ",", ".") ?></h3>
        </div>
    </div>
    <div class="col-6">
        <div class="card-box tilebox-one">
            <i class="ti-money float-right m-0 h2 text-muted"></i>
            <h6 class="text-muted text-uppercase mt-0">Saldo Passive</h6>
            <?php $totalWithdraw = FundPassive::getBalance($member->id); ?>
            <h3 class="my-3 text-danger"><?= "IDR. " . number_format($totalWithdraw, 0, ",", ".") ?></h3>
        </div>
    </div>
</div>