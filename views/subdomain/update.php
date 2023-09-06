<?php

/* @var $this yii\web\View */
/* @var $model app\models\Subdomain */
/* @var $referrer string */

$this->title = 'Edit Subdomain';
$this->params['breadcrumbs'][] = ['label' => 'Subdomains', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Sunting';
?>
<div class="subdomain-update">

    <?= $this->render('_form', [
        'model' => $model,
        'referrer'=> $referrer
    ]) ?>

</div>
