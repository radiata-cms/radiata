<?
use vova07\imperavi\Widget;
use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

/**
 * @var yii\web\View $this
 * @var string $attribute
 * @var array $options
 * @var array $languages
 */
?>

<?
$tabs = [];
foreach ($languages as $language) {
    if($options['redactor']) {
        $content = Widget::widget([
            'model'     => $model->translate($language->locale),
            'attribute' => "[$language->locale]" . $attribute,
            'name'      => $model->translate($language->locale)->formName() . "[$language->locale][" . $attribute . "]",
            'options'   => [
                'class' => 'wysiwygTextArea',
            ],
            'settings'  => [
                'lang'             => $language->code,
                'minHeight'        => 300,
                'pastePlainText'   => true,
                'buttonSource'     => true,
                'plugins'          => [
                    //'clips',
                    'fullscreen',
                    'imagemanager',
                    'filemanager',
                ],
                'imageUpload'      => Url::to([$options['urlPreffix'] . 'image-upload']),
                'imageManagerJson' => Url::to([$options['urlPreffix'] . 'images-get']),
                'fileManagerJson'  => Url::to([$options['urlPreffix'] . 'files-get']),
                'fileUpload'       => Url::to([$options['urlPreffix'] . 'file-upload']),
                'callbacks'        => [
                    'change' => new JsExpression('function() {
                        alert(3);
                    }'),
                ],
            ]
        ]);
    } else {
        $content = Html::$options['type']($model->translate($language->locale), "[$language->locale]" . $attribute, ['class' => 'form-control' . $options['additionalCssClasses']]);
    }

    $tabs[] = [
        'label'       => '<i class="iconflags iconflags-' . $language->code . '"></i> ' . $language->code,
        'encode'      => false,
        'content' => $content,
        'active'      => $language->locale == Yii::$app->language,
        'linkOptions' => ['lang' => $language->locale, 'class' => 'lang-tab-a', 'title' => $language->locale],
    ];

}

echo Tabs::widget(['items' => $tabs, 'id' => $options['id']]);
?>