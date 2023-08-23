<?php

use app\assets\DataTableAsset;
use app\assets\Select2Asset;
use app\models\FundRef;
use app\models\FundTicket;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FundTicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Admin Tickets';
$this->params['breadcrumbs'][] = $this->title;

echo \app\widgets\Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    'options' => [
        'title' => 'Tickets'
    ],
]) ?>

<?php 
$balance = FundTicket::getBalance($member->id);

?>

<div class="row mb-4">
    <div class="container-fluid">
        <div class="dt-button-wrapper">
            <?= Html::a('<i class="ti-location-arrow mr-2"></i> Send Ticket', ['send-admin'], ['class' => 'btn btn-primary mb-1']) ?>
            <?= Html::a('<i class="ti-printer mr-2"></i> Print', ['#'], ['class' => 'btn btn-info mb-1', 'onclick' => 'dtPrint()' ]) ?>
            <div class="btn-group mr-1">
                <?= Html::a('<i class="ti-download mr-2"></i> Export', ['#'], [
                    'class' => 'btn btn-success mb-1 dropdown-toggle',
                    'data-toggle' => 'dropdown'
                ]) ?>
                <div class="dropdown-menu" x-placement="bottom-start">
                    <?= Html::a('Excel', ['#'], ['class' => 'dropdown-item', 'onclick' => 'dtExportExcel()']) ?>
                    <?= Html::a('Pdf', ['#'], ['class' => 'dropdown-item', 'onclick' => 'dtExportPdf()']) ?>
                </div>
            </div>
        </div>

        <div class="member-index card-box shadow mb-4">
            <div class="mb-4">
                <h4 class="header-title" style="">
                    Riwayat Ticket
                </h4>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Transaksi</th>
                        <th>Referensi</th>
                        <th>Total</th>
                        <th>Keterangan</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php $index = 0; ?>
                        <?php foreach ($dataProvider->models as $model) { ?>
                            <tr>
                                <td><?= $index +1 ?></td>
                                <td><?= date('d M Y', strtotime($model->date_created)) ?></td>
                                <?php 
                                $transaksi = 'Receive';
                                if ($model->debet > 0) {
                                    $transaksi = 'Deliver';
                                }
                                ?>
                                <td><?= $model->getBadgeTransaction() ?></td>
                                <td><?= @$model->memberRef->nama ?></td>
                                <td><?= $model->credit + $model->debet ?></td>
                                <td></td>
                            </tr>
                        <?php $index++; } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?php
$script = <<<JS
    const dtPrint = () => {
        const dtBtn = $('.btn.buttons-print');
        dtBtn.trigger('click');
    }
    const dtExportPdf = () => {
        const dtBtn = $('.btn.buttons-pdf.buttons-html5');
        dtBtn.trigger('click');
    }
    const dtExportExcel = (e) => {
        const dtBtn = $('.btn.buttons-excel.buttons-html5');
        dtBtn.trigger('click');
    }
JS;

$this->registerJs($script, \yii\web\View::POS_END);

?>
