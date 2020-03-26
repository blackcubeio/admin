<?php
/**
 * @var $tagsQuery \blackcube\core\models\FilterActiveQuery
 */
use blackcube\admin\helpers\Html;

$formatter = Yii::$app->formatter;
?>
<div class="flex flex-1" loader-done="">
    <?php echo \blackcube\admin\widgets\Sidebar::widget(); ?>
    <main class="bg-white flex-1 p-3 overflow-hidden">
        <div class="inline-block min-w-full overflow-hidden px-6 py-6">
            <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <?php echo Yii::t('blackcube.admin', 'Name'); ?>
                        <!-- input type="text" class="appearance-none bg-gray-200 text-gray-700 border border-gray-300 rounded py-1 px-4 mb-1 leading-tight"
                        placeholder="<?php echo Yii::t('blackcube.admin', 'Name'); ?>" -->
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <?php echo Yii::t('blackcube.admin', 'Status'); ?>
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <?php echo Yii::t('blackcube.admin', 'Action'); ?>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tagsQuery->each() as $tag): ?>
                <?php /* @var \blackcube\core\models\Tag $tag */ ?>
                <tr>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <div class="flex items-start">
                            <p class="text-gray-900 whitespace-no-wrap">
                                <?php echo Html::a($tag->name, ['tag/edit', 'id' => $tag->id], ['class' => 'hover:text-blue-600 py-1']); ?>
                                <span class="text-xs text-gray-600 italic">(<?php echo Html::a($tag->category->name, ['category/index', 'id' => $tag->categoryId], ['class' => 'hover:text-blue-600 py-1']); ?>)</span>
                            </p>
                        </div>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <span class="inline-flex mx-0">
                            <?php echo Html::tag('span',
                                'T' . Html::tag('span', 'Status du Tag', ['class' => 'tooltip-text text-sm text-white p-3 bg-blue-800 p-3 -mt-6 -ml-6 rounded']), [
                                'class' => 'tooltip cursor-pointer font-hairline text-white rounded-l-full text-xs px-2 mr-0 '.($tag->active ? 'bg-green-700':'bg-red-700'),
                            ]); ?>
                            <?php echo Html::tag('span', 'U' . Html::tag('span', 'Status de l\'URL', ['class' => 'tooltip-text text-sm text-white p-3 bg-blue-800 p-3 -mt-6 -ml-6 rounded']), [
                                'class' => 'tooltip cursor-pointer font-hairline text-white text-xs px-2 mx-0 '.(($tag->slug && $tag->slug->active) ? 'bg-green-700':'bg-red-700'),
                            ]); ?>
                            <?php echo Html::tag('span', 'S' . Html::tag('span', 'Intégration Sitemap', ['class' => 'tooltip-text text-sm text-white p-3 bg-blue-800 p-3 -mt-6 -ml-6 rounded']), [
                                'class' => 'tooltip cursor-pointer font-hairline text-white text-xs px-2 mx-0 '.(($tag->slug && $tag->slug->sitemap && $tag->slug->sitemap->active) ? 'bg-green-700':'bg-red-700'),
                            ]); ?>
                            <?php echo Html::tag('span', 'G' . Html::tag('span', 'Mise en place SEO', ['class' => 'tooltip-text text-sm text-white p-3 bg-blue-800 p-3 -mt-6 -ml-6 rounded']), [
                                'class' => 'tooltip cursor-pointer font-hairline text-white rounded-r-full text-xs px-2 mx-0 '.(($tag->slug && $tag->slug->seo && $tag->slug->seo->active) ? 'bg-green-700':'bg-red-700'),
                            ]); ?>
                        </span>
                        <!-- p class="text-gray-900 whitespace-no-wrap">
                            <?php // echo $formatter->asDate($tag->dateCreate); ?>
                        </p -->
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <?php echo Html::beginForm(['tag/delete', 'id' => $tag->id]); ?>
                            <button class="bg-gray-300 hover:bg-red-600 hover:text-white text-gray-800 font-bold py-2 px-2 rounded inline-flex items-center">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                            <?php echo Html::endForm(); ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
            <div class="px-6 py-6 flex flex-col xs:flex-row items-center justify-end xs:justify-between">
                <?php echo Html::a(Yii::t('blackcube.admin', 'Create'), ['tag/create'], ['class' => 'text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded']); ?>
            </div>
        <?php /*
        <div
                class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between          ">
                            <span class="text-xs xs:text-sm text-gray-900">
                                Showing 1 to 4 of 50 Entries
                            </span>
            <div class="inline-flex mt-2 xs:mt-0">
                <button
                        class="text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-l">
                    Prev
                </button>
                <button
                        class="text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-r">
                    Next
                </button>
            </div>
        </div>
        <?php */ ?>
        </div>
    </main>
</div>
