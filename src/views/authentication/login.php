<?php
/**
 * @var \blackcube\admin\models\Administrator $administrator
 */
use yii\helpers\Html;
?>
<div class="form container">
    <div class="w-full max-w-lg">
        <div class="leading-loose">
            <?php echo Html::beginForm('', 'post', ['class' => 'max-w-xl m-4 p-10 bg-white rounded shadow-xl', 'novalidate' => 'novalidate']); ?>
                <p class="title">Blackcube</p>
                <div class="">
                    <?php echo Html::activeLabel($administrator, 'email', ['class' => 'label']); ?>
                    <?php echo Html::activeTextInput($administrator, 'email', ['class' => 'field'.($administrator->hasErrors('email') ? ' error':''), 'required' => 'required', 'placeholder' => 'Email', 'aria-label' => 'E-mail' ]); ?>
                </div>
                <div class="mt-2">
                    <?php echo Html::activeLabel($administrator, 'password', ['class' => 'label']); ?>
                    <?php echo Html::activeTextInput($administrator, 'password', ['class' => 'field'.($administrator->hasErrors('password') ? ' error':''), 'required' => 'required', 'placeholder' => 'Password', 'aria-label' => 'Password']); // $administrator->hasErrors('password') ? 'invalid':'']); ?>
                </div>
                <div class="buttons">
                    <a class="link" href="#">
                        Forgot Password?
                    </a>
                    <button class="submit-btn" type="submit">Login</button>
                </div>
                <!-- a class="inline-block right-0 align-baseline font-bold text-sm text-500 hover:text-blue-800" href="#">
                    Not registered ?
                </a -->
            <?php echo Html::endForm(); ?>
        </div>
    </div>
</div>