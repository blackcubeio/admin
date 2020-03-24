<?php

use blackcube\admin\helpers\Html;
use blackcube\core\models\BlocType;

$blocType = BlocType::findOne(['id' => 1]);

?>

<?php echo Html::tag('div', '', [
    'data-app' => '',
    'class' => 'wrapper',
]); ?>

<h1>Enhanced components</h1>
<?php
    if (Yii::$app->request->isPost) {
        print_r(Yii::$app->request->bodyParams);
    }
?>

<h2>Template Editor</h2>
<?php echo Html::beginForm(); ?>
    <?php echo Html::activeSchema($blocType, 'template', ['language' => 'fr']); ?>
    <?php echo Html::button('Save', ['type' => 'submit']); ?>
<?php echo Html::endForm(); ?>
