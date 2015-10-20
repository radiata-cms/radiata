<?php

use backend\forms\helpers\FieldHelper;
use backend\forms\RadiataField;
use backend\forms\widgets\FileInputWidget;
use backend\forms\widgets\GalleryInputWidget;
use backend\forms\widgets\LangInputWidget;
use common\modules\news\models\NewsCategory;
use common\modules\news\models\NewsGallery;
use dosamigos\selectize\SelectizeTextInput;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;


/* @var $this yii\web\View */
/* @var $model common\modules\news\models\News */
/* @var $modelCategory common\modules\news\models\NewsCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin([
        'id' => 'news-form',
        'layout'     => 'horizontal',
        'fieldClass' => RadiataField::className(),
        'options'    => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= FieldHelper::showErrors($model); ?>

    <div class="nav-tabs-custom">
        <!-- Tabs within a box -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#main-tab" data-toggle="tab"><?= Yii::t('b/news', 'Main tab') ?></a></li>
            <li><a href="#tags-tab" data-toggle="tab"><?= Yii::t('b/news', 'Tags tab') ?></a></li>
            <li><a href="#image-tab" data-toggle="tab"><?= Yii::t('b/news', 'Image tab') ?></a></li>
            <li><a href="#gallery-tab" data-toggle="tab"><?= Yii::t('b/news', 'Gallery tab') ?></a></li>
            <li><a href="#seo-tab" data-toggle="tab"><?= Yii::t('b/news', 'Seo tab') ?></a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="main-tab">
                <?= $form->field($model, 'title')->widget(LangInputWidget::classname(), [
                    'options' => [
                        'type' => 'activeTextInput',
                    ],
                ]) ?>

                <?= $form->field($model, 'slug')->widget(LangInputWidget::classname(), [
                    'options' => [
                        'type' => 'activeTextInput',
                    ],
                ]) ?>

                <?= $form->field($model, 'date')->dateTimeInput(['class' => 'pull-right']) ?>

                <?= $form->field($model, 'status')->dropDownList($model->getStatusesList()); ?>

                <?= $form->field($model, 'category_id')->dropDownList($modelCategory->getItemsForLinkedField(), ['encodeSpaces' => true]) ?>

                <?= $form->field($model, 'categories')->treeInput([
                    'class' => NewsCategory::className()
                ]) ?>

                <?= $form->field($model, 'description')->widget(LangInputWidget::classname(), [
                    'options' => [
                        'type' => 'activeTextarea',
                    ],
                ]) ?>

                <?= $form->field($model, 'content')->widget(LangInputWidget::classname(), [
                    'options' => [
                        'type' => 'activeTextarea',
                        'redactor'   => true,
                        'urlPreffix' => 'news/',
                        'form'       => $form,
                    ],
                ]) ?>
            </div>
            <div class="tab-pane" id="tags-tab">
                <?
                $modalNewTag = Modal::widget([
                    'id'            => 'new-tag-modal',
                    'toggleButton'  => [
                        'label'       => Yii::t('b/news/tags', 'Add new tag'),
                        'tag'         => 'a',
                        'data-target' => '#new-tag-modal',
                        'href'        => Url::toRoute(['tags/add-new-tag']),
                    ],
                    'closeButton'   => [
                        'tag'   => 'button',
                        'label' => '<span aria-hidden="true">×</span>'
                    ],
                    'clientOptions' => false,
                ]);
                ?>
                <?= $form->field($model, 'tagIds')->widget(SelectizeTextInput::className(), [
                    'loadUrl'       => ['tags/tags-list'],
                    'options'       => ['class' => 'form-control'],
                    'clientOptions' => [
                        'plugins'          => ['remove_button', 'restore_on_backspace', 'drag_drop'],
                        'valueField'       => 'id',
                        'labelField'       => 'name',
                        'searchField'      => ['name'],
                        'options'          => new JsExpression($model->getTagsItems()),
                        'items'            => $model->getTagIds(true),
                        'hideSelected'     => true,
                        'closeAfterSelect' => true,
                    ],
                ])->hint($modalNewTag); ?>
            </div>
            <div class="tab-pane" id="image-tab">
                <?= $form->field($model, 'image')->widget(FileInputWidget::classname(), [
                    'options'       => [
                        'accept' => 'image/*',
                    ],
                    'pluginOptions' => [
                        'initialPreview' => $model->getThumbFileUrl('image', 'small') ? [
                            Html::img($model->getThumbFileUrl('image', 'small'), ['class' => 'file-preview-image']),
                        ] : [],
                    ],
                ]) ?>

                <?= $form->field($model, 'image_description')->widget(LangInputWidget::classname(), [
                    'options' => [
                        'type' => 'activeTextInput',
                    ],
                ]) ?>
            </div>
            <div class="tab-pane" id="gallery-tab">
                <?= $form->field($model, 'gallery')->widget(GalleryInputWidget::classname(), ['form' => $form, 'className' => NewsGallery::className()]); ?>
            </div>
            <div class="tab-pane" id="seo-tab">
                <?= $form->field($model, 'redirect')->widget(LangInputWidget::classname(), [
                    'options' => [
                        'type' => 'activeTextInput',
                    ],
                ]) ?>

                <?= $form->field($model, 'meta_title')->widget(LangInputWidget::classname(), [
                    'options' => [
                        'type' => 'activeTextInput',
                    ],
                ]) ?>

                <?= $form->field($model, 'meta_keywords')->widget(LangInputWidget::classname(), [
                    'options' => [
                        'type' => 'activeTextInput',
                    ],
                ]) ?>

                <?= $form->field($model, 'meta_description')->widget(LangInputWidget::classname(), [
                    'options' => [
                        'type' => 'activeTextarea',
                    ],
                ]) ?>
            </div>

        </div>
    </div>
    <!-- /.nav-tabs-custom -->

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('b/news', 'Create') : Yii::t('b/news', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <? $this->registerJs('radiata.initErrorsInTabs("#news-form");', View::POS_READY); ?>
    <? $this->registerJs('radiata.updateWysiwygTextArea("#news-form");', View::POS_READY); ?>

</div>
