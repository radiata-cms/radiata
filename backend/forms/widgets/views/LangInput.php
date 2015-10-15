<?
use yii\bootstrap\Tabs;
use yii\helpers\Html;

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
    $tabs[] = [
        'label'       => '<i class="iconflags iconflags-' . $language->code . '"></i> ' . $language->code,
        'encode'      => false,
        'content' => Html::$options['type']($model->translate($language->locale), "[$language->locale]" . $attribute, ['class' => 'form-control' . $options['additionalCssClasses']]),
        'active'      => $language->locale == Yii::$app->language,
        'linkOptions' => ['lang' => $language->locale, 'class' => 'lang-tab-a', 'title' => $language->locale],
    ];

}

echo Tabs::widget(['items' => $tabs, 'id' => $options['id']]);
?>



<?
$jsCode = <<< JS

JS;
$this->registerJs($jsCode);
?>