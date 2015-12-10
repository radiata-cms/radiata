<?
/* @var $this \yii\web\View */
/* @var array $metaTags */

foreach ($metaTags as $metaTag) {
    if($metaTag['name'] == 'meta_title') {
        $this->title = $metaTag['content'];
    } else {
        $this->registerMetaTag([
            'name'    => $metaTag['name'],
            'content' => $metaTag['content']
        ]);
    }
}