<?
use backend\forms\widgets\LangInputWidget;
use kartik\file\FileInput;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var string $attribute
 * @var array $options
 */

echo '<div id="gallery-deleted-items"></div>';

echo FileInput::widget([
    'name'          => $fieldName . '[][image]',
    'options'       => [
        'accept'   => 'image/*',
        'multiple' => true,
    ],
    'pluginOptions' => [
        'layoutTemplates'         => [
            'footer'       => '<div class="file-thumbnail-footer">
                            <div class="{TAG_CSS_NEW}">{CUSTOM_TAG_NEW}</div>
                            <div class="{TAG_CSS_INIT}">{CUSTOM_TAG_INIT}</div>
                            <div>{actions}</div>
                        </div>',
            'actionUpload' => '',
        ],
        'overwriteInitial'        => false,
        'showClose'               => false,
        'uploadUrl'               => true,
        'showUpload'              => false,
        'initialPreview'          => $initialPreview,
        'initialPreviewConfig'    => $initialPreviewConfig,
        'autoReplace'             => true,
        'maxFileCount'            => 100,
        'language'                => Yii::$app->language,
        'previewThumbTags'        => [
            '{CUSTOM_TAG_NEW}'  => Html::hiddenInput($fieldName . '[][gallery_id]', 'NEW_IND') . '' . $form->field($newsGallery, '[NEW_IND]image_text')->widget(LangInputWidget::classname(), [
                    'options' => [
                        'id'                   => 'galTabsNEW_IND',
                        'type'                 => 'activeTextInput',
                        'additionalCssClasses' => 'kv-input kv-new form-control input-sm',
                    ],
                ]),
            '{CUSTOM_TAG_INIT}' => '',
            '{TAG_CSS_NEW}'     => '',
            '{TAG_CSS_INIT}'    => 'hide',
        ],
        'initialPreviewThumbTags' => $initialPreviewThumbTags,
    ],
    'pluginEvents'  => [
        'fileloaded'    => "function(event, file, previewId, index, reader) {
            if(typeof(galInd) == 'undefined') {
                galInd = -1;
            } else {
                galInd--;
            }

            $('input').each(function(){
                var attrName = $(this).attr('name');
                if(typeof(attrName) != 'undefined' && attrName.indexOf('NEW_IND') > -1) {
                    attrName = attrName.replace('NEW_IND', galInd);
                    $(this).attr('name', attrName);
                }
            });

            $('ul,div').each(function(){
                var attrName = $(this).attr('id');
                if(typeof(attrName) != 'undefined' && attrName.indexOf('NEW_IND') > -1) {
                    attrName = attrName.replace('NEW_IND', galInd);
                    $(this).attr('id', attrName);
                }
            });

            $('a').each(function(){
                var attrName = $(this).attr('href');
                if(typeof(attrName) != 'undefined' && attrName.indexOf('NEW_IND') > -1) {
                    attrName = attrName.replace('NEW_IND', galInd);
                    $(this).attr('href', attrName);
                }
            });

            radiata.initLangTabs();
            radiata.makeSortable('.file-preview-thumbnails');
        }",
        'filepredelete' => 'function(event, key) {
            var AreYouSure = confirm(i18n.AreYouSure)
            if(AreYouSure) {
                var input = "<input type=\"hidden\" name=\"GalleryDeletedItems[]\" value=\""+key+"\">";
                $("#gallery-deleted-items").append(input);
            } else {
                throw "Cancel";
            }
        }',
    ],
]);
?>
