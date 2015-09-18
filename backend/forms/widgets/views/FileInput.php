<?
use kartik\file\FileInput;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var $imageDeletedInputId
 * @var $imageInputId
 * @var string $attribute
 * @var array $options
 * @var array $pluginOptions
 */
?>

<?= Html::hiddenInput($imageDeletedInputId, '', ['id' => $imageDeletedInputId]); ?>

<?= FileInput::widget([
    'model'     => $model,
    'attribute' => $attribute,
    'options'   => $options,
    'pluginOptions' => $pluginOptions,
]); ?>

<?
$jsCode = <<< JS
        $(function () {
            $('#{$imageInputId}').on('filecleared', function(event, key) {
                $('#{$imageDeletedInputId}').val('true');
            });
        });
JS;
$this->registerJs($jsCode);
?>