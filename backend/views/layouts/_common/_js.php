<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AdminLteAsset;
use backend\modules\radiata\widgets\I18nSettingsWidget;
use yii\web\View;

?>

<script type="application/javascript">
    var ADMIN_LTE_SKIN = '<?=AdminLteAsset::ADMIN_LTE_SKIN?>';

    <?= I18nSettingsWidget::widget() ?>
</script>

<? $this->registerJs('radiata.initLangTabs();', View::POS_READY); ?>
<? $this->registerJs('radiata.makeSortable(".file-preview-thumbnails");', View::POS_READY); ?>