<?php
/**
 * DashboardCard.php
 *
 * PHP version 7.4+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\widgets
 */

namespace blackcube\admin\widgets;

use yii\base\Widget;
use Yii;

/**
 * Widget DashboardCard
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\widgets
 */
class DashboardCard extends Widget
{
    public $title;
    public $icon;
    public $listTitle;
    public $viewPermission;
    public $updatePermission;
    public $updateRoute;
    public $elementsQuery;
    public $counts = [];
    /**
     * {@inheritDoc}
     */
    public function run()
    {
        if (Yii::$app->user->can($this->viewPermission) === true) {
            return $this->render('dashboard-card', [
                'title' => $this->title,
                'icon' => $this->icon,
                'listTitle' => $this->listTitle,
                'viewPermission' => $this->viewPermission,
                'updatePermission' => $this->updatePermission,
                'updateRoute' => $this->updateRoute,
                'elementsQuery' => $this->elementsQuery,
                'counts' => $this->counts,
            ]);
        }
        return '';

    }
}
