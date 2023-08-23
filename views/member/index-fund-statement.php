<?php

use app\assets\DataTableAsset;
use app\components\Mode;
use app\models\FundRef;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Member */
/* @var $referrer string */

$this->title = 'Fund Statement';
$this->params['breadcrumbs'][] = ['label' => 'Members', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Sunting';

DataTableAsset::register($this);

?>

<?= \app\widgets\Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    'options' => [
        'title' => $this->title
    ],
]) ?>

<div class="member-update row">    
    <div class="col-sm-12">            
        <div class="card-box">
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
                        <?php foreach($result as $row) { ?>
                            <?php 
                            $row = (object)$row; 
                            $value = $row->credit + $row->debet;

                            $transaksi = 'Credit';
                            if ($row->debet > $row->credit) {
                                $transaksi = 'Debet';
                            }

                            if ($row->id_fund_ref == FundRef::DEPOSIT) {
                                $transaksi = 'Deposit';
                            }
                            ?>
                            <tr>
                                <td><?= $index +1 ?></td>
                                <td><?= $row->date_created ?></td>
                                <td><?= $transaksi ?></td>
                                <td><?= $row->id_trx ?></td>
                                <td>IDR. <?= number_format($value, 0, ",", ".") ?></td>
                                <td>
                                    <?php $fundRef = FundRef::findOne(['id' => $row->id_fund_ref]); ?>
                                    <?= @$fundRef->keterangan ?>
                                </td>
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

    $(document).ready(function() {
        $('table').dataTable();
    })                         

JS;

$this->registerJs($script, \yii\web\View::POS_END);

?>