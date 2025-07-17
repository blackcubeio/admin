<?php
/**
 * DashboardCard.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\widgets;

use yii\base\Widget;
use Yii;

/**
 * Widget DashboardCard
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
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
