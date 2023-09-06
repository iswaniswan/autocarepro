<?php


/* @var $this yii\web\View */
/* @var $model app\models\Subdomain */
/* @var $referrer string */

$this->title = 'Tambah Subdomain';
$this->params['breadcrumbs'][] = ['label' => 'Subdomains', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subdomain-create">

    <?= $this->render('_form', [
        'model' => $model,
        'referrer'=> $referrer
    ]) ?>

</div>