<?
/* @var $this \yii\web\View */
/* @var array $metaTags */

foreach ($metaTags as $metaTag) {
    $this->registerMetaTag([
        'name'    => $metaTag['name'],
        'content' => $metaTag['content']
    ]);
}