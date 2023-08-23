<?php
/** @var yii\web\View $this */
use app\components\Session;
use app\models\Deposit;
use app\models\Member;
use app\models\Paket;
use app\models\Roi;
use app\models\User;
use app\models\Withdraw;
use yii\helpers\Url;

$username = Session::getUsername();


$this->title = 'Dashboard Admin';
$this->params['breadcrumbs'][] = $this->title;

echo \app\widgets\Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    'options' => [
        'title' => $this->title
    ],
]) ?>

<?php 
$member = Member::findOne(['id' => Session::getIdMember()]);
$group = $member->getGroupAsAdmin();

/** roi */
$currentRoi = Roi::getCurrentRoi();
?>


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
    <div class="col-sm-3">
        <div class="card-box tilebox-one">
            <i class="ti-ticket float-right m-0 h2 text-success"></i>
            <h6 class="text-muted text-uppercase mt-0">ADMIN</h6>
            <h3 class="my-3 card-poin"><i class="ti-infinite"></i></h3>
            <span>Ticket</span>
            <div class="text-right" style="margin-top: -24px;">
                <a href="<?= Url::to(['/fund-ticket/index-admin']) ?>" class="btn btn-primary">Detail</a>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card-box tilebox-one">
            <i class="ti-reload float-right m-0 h2 text-success"></i>
            <h6 class="text-muted text-uppercase mt-0">RoI</h6>
            <h3 class="my-3 card-poin"><?= $currentRoi->roi ?> %</h3>
            <span>Rate sekarang</span>
            <div class="text-right" style="margin-top: -24px;">
                <a href="<?= Url::to(['/roi/index-admin']) ?>" class="btn btn-primary">Detail</a>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-6">
        <div class="card-box tilebox-one">
            <i class="ti-money float-right m-0 h2 text-muted"></i>
            <h6 class="text-muted text-uppercase mt-0">Total Deposit Member</h6>
            <?php $totalDeposit = Deposit::getBalanceDistributor($member); ?>
            <h3 class="my-3 text-success"><?= "IDR. " . number_format($totalDeposit, 0, ",", ".") ?></h3>
        </div>
    </div>
    <div class="col-6">
        <div class="card-box tilebox-one">
            <i class="ti-money float-right m-0 h2 text-muted"></i>
            <h6 class="text-muted text-uppercase mt-0">Total Withdraw Member</h6>
            <?php $totalWithdraw = Withdraw::getBalanceDistributor($member); ?>
            <h3 class="my-3 text-danger"><?= "IDR. " . number_format($totalWithdraw, 0, ",", ".") ?></h3>
        </div>
    </div>
</div>

<div class="row">

    <?php foreach (Paket::find()->all() as $paket) { ?>
        <div class="col-md-6 col-xl-3">
            <div class="card-box tilebox-one">
                <i class="icon-people float-right m-0 h2 text-muted"></i>
                <h6 class="text-muted text-uppercase mt-0"><?= $paket->name ?></h6>
                <h3 class="my-3" data-plugin="counterup">
                    <?= Member::getAllMemberCount([
                        'id_paket' => $paket->id,
                        'id_member_sponsor' => Session::getIdMember()
                    ]) ?>
                </h3>
                <div class="text-right" style="margin-top: -24px;">
                    <?php if ($paket->id == Paket::DISTRIBUTOR) { ?>
                        <a href="<?= Url::to(['/member/index-admin-distributor', 'id_paket' => $paket->id]) ?>" class="btn btn-primary">Detail</a>
                    <?php } else { ?>
                        <a href="<?= Url::to(['/member/index-admin-downline', 'id_paket' => $paket->id]) ?>" class="btn btn-primary">Detail</a>
                    <?php }?>
                </div>
            </div>
        </div>
    <?php } ?>

</div>