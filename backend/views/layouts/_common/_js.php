<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AdminLteAsset;
use backend\modules\radiata\widgets\I18nSettingsWidget;

?>

<script type="application/javascript">
    var ADMIN_LTE_SKIN = '<?=AdminLteAsset::ADMIN_LTE_SKIN?>';

    <?= I18nSettingsWidget::widget() ?>
</script>