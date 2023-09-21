<?php
/**
 * error.php
 *
 * PHP version 8.0+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package webapp\views\layouts
 *
 * @var $message string
 * @var $exception Exception
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use yii\web\HttpException;

?>
<div class="error-wrapper">
    <div class="error-container">
        <div class="error-container-panel">
            <main class="sm:flex">
                <p class="error-code">
                    <?php echo ($exception instanceof HttpException) ? $exception->statusCode : '500'; ?>
                </p>
                <div class="error-message-panel">
                    <div class="error-message">
                        <h1 class="error-message-title">
                            <?php echo $message; ?>
                        </h1>
                        <p class="error-message-info">
                            <?php
                                if ($exception instanceof HttpException) :
                                switch ($exception->statusCode):
                                    case 404:
                                        echo Module::t('views', 'Please check the URL in the address bar and try again.');
                                        break;
                                endswitch;
                                else:
                                    echo Module::t('views', 'Unhandled error.');
                                endif;
                            ?>

                        </p>
                    </div>
                    <div class="error-message-buttons">
                        <a href="#" class="error-message-button"> Go back home </a>
                        <!-- a href="#" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-800 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"> Contact support </a -->
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>