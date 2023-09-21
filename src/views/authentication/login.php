<?php
/**
 * login.php
 *
 * PHP version 8.0+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\views\authentication
 *
 * @var \blackcube\admin\models\Administrator $administrator
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\helpers\Heroicons;
use blackcube\admin\helpers\Html;
use blackcube\admin\helpers\Tailwind;
use blackcube\admin\helpers\BlackcubeHtml;

?>
<div class="login-wrapper">
    <div class="login-container">
        <div class="login-panel">
            <h2 class="login-title">
                Blackcube
            </h2>
            <?php echo Html::beginForm('', 'post', ['class' => 'space-y-6', 'novalidate' => 'novalidate']); ?>
                <div>
                    <?php echo Html::activeLabel($administrator, 'email', [
                        'class' => 'login-label',
                    ]); ?>
                    <?php echo Tailwind::activeTextInput($administrator, 'email', [
                        'errorClass' => 'error',
                        'accessory' => [
                            'options' => ['class' => 'login-input-text-accessory'],
                            'icon' => ['icon' => 'solid/exclamation-circle', 'options' => ['class' => 'h-5 w-5 text-red-500']],
                            'wrapperOptions' => ['class' => 'login-input'],
                        ],
                        'class' => 'login-input-text',
                        'required' => 'required',
                        'placeholder' => Module::t('views', 'username@website.com'),
                        'aria-label' => Module::t('views', 'E-mail'),
                        'autocomplete' => 'username',
                    ]); ?>
                </div>

                <div>
                    <?php echo Html::activeLabel($administrator, 'password', [
                        'class' => 'login-label',
                    ]); ?>
                    <?php echo Tailwind::activePasswordInput($administrator, 'password', [
                        'accessory' => [
                            'wrapperOptions' => ['class' => 'login-input'],
                        ],
                        'class' => 'login-input-text',
                        'required' => 'required',
                        'placeholder' => Module::t('views', 'Password'),
                        'aria-label' => Module::t('views', 'Password'),
                        'autocomplete' => 'current-password',
                    ]); ?>
                </div>

                <div class="login-checkboxes-panel">
                    <div class="login-checkboxes-item">
                        <?php echo Html::activeCheckbox($administrator, 'rememberMe', [
                            'class' => 'login-input-checkbox',
                            'aria-label' => 'Remember me',
                            'label' => null,
                            'uncheck' => null,
                            'value' => '1',
                        ]); ?>
                        <?php echo Html::activeLabel($administrator, 'rememberMe', [
                            'class' => 'ml-2 login-label',
                        ]); ?>
                    </div>

                    <!-- div class="text-sm">
                        <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Forgot your password?
                        </a>
                    </div -->
                </div>

                <div>
                    <button type="submit" class="login-button">
                        Sign in
                    </button>
                </div>
            <?php echo Html::endForm(); ?>

        </div>
    </div>
    <!-- Alert box -->
    <blackcube-alert>

    </blackcube-alert>

    <!-- Slide panel overlay -->
    <blackcube-overlay class="overlay" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">

    </blackcube-overlay>

    <blackcube-notification-center>

    </blackcube-notification-center>
</div>
