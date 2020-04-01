<?php

$uploadModel = new \blackcube\admin\models\UploadModel();


?>
<?php echo \yii\helpers\Html::beginForm(); ?>
    <input type="text" name="file:plop">
    <input type="submit">
    <?php var_dump($_POST); ?>
    <?php echo \blackcube\admin\helpers\Html::activeUpload($uploadModel, 'files', ['multiple' => true, 'upload-url' => \yii\helpers\Url::to(['tag/upload'])]); ?>
    <?php // echo \blackcube\admin\helpers\Html::tag('resumable-file', '', ['upload-url' => \yii\helpers\Url::to(['tag/upload'])]); ?>
<?php echo \yii\helpers\Html::endForm(); ?>
