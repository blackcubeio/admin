<?php
/**
 * ElementListPagination.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\widgets;

use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\data\Pagination;

/**
 * Widget ElementListPagination
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class ElementListPagination extends Widget
{
    /**
     * @var Pagination the pagination object that this pager is associated with.
     * You must set this property in order to make LinkPager work.
     */
    public $pagination;
    /**
     * @var int maximum number of page buttons that can be displayed. Defaults to 10.
     */
    public $maxButtonCount = 10;

    /**
     * @var array additional options
     */
    public $additionalLinkOptions = [];

    /**
     * Initializes the pager.
     */
    public function init()
    {
        parent::init();

        if ($this->pagination === null) {
            throw new InvalidConfigException('The "pagination" property must be set.');
        }
    }

    /**
     * {@inheritDoc}
     */
    public function run()
    {
        $currentPage = $this->pagination->getPage();
        list($beginPage, $endPage) = $this->getPageRange();
        $previousPage = max($currentPage - 1, 0);
        $nextPage = min($currentPage + 1, $this->pagination->getPageCount() - 1);

        return $this->render('element-list-pagination', [
            'beginPage' => $beginPage,
            'endPage' => $endPage,
            'previousPage' => $previousPage,
            'nextPage' => $nextPage,
            'currentPage' => $currentPage,
            'pagination' => $this->pagination,
            'additionalLinkOptions' => $this->additionalLinkOptions
        ]);
    }

    /**
     * @return array the begin and end pages that need to be displayed.
     */
    protected function getPageRange()
    {
        $currentPage = $this->pagination->getPage();
        $pageCount = $this->pagination->getPageCount();

        $beginPage = max(0, $currentPage - (int) ($this->maxButtonCount / 2));
        if (($endPage = $beginPage + $this->maxButtonCount - 1) >= $pageCount) {
            $endPage = $pageCount - 1;
            $beginPage = max(0, $endPage - $this->maxButtonCount + 1);
        }

        return [$beginPage, $endPage];
    }
}
