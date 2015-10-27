<?php
/* @var $this yii\web\View */

/* @var $model common\modules\news\models\NewsTag */
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="<?= Yii::t('b/news/tag', 'Close') ?>">
        <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"><?= Yii::t('b/news/tag', 'Add new tag') ?></h4>
</div>
<div class="modal-body" id="newTagFromContainer">
    <?= $this->render('_form', ['model' => $model,]) ?>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?= Yii::t('b/news/tag', 'Close') ?></button>
</div>

<?
$js = <<<JS
    jQuery('#new-tag-form').on('beforeSubmit', function(){
        var form = jQuery(this);
        jQuery.post(
            form.attr("action"),
            form.serialize()
        )
        .done(function(result) {
            if(typeof(result.newName) != 'undefined') {
                var selectize = jQuery('#news-tagids')[0].selectize;
                selectize.addOption({id:result.newId, name:result.newName});
                selectize.refreshOptions();
                selectize.addItem(result.newId);
                selectize.refreshItems();
                $('#new-tag-modal').modal('hide');
            } else {
                $('#new-tag-form').find('.callout-danger').remove();
                $('#new-tag-form').prepend(result.errors);
            }
        })
        .fail(function() {
            console.log("server error");
        });
        return false;
    });
JS;
$this->registerJs($js);
?>


