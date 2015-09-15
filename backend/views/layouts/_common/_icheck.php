<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AdminLteAsset;

?>

<script type="application/javascript">
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-<?=AdminLteAsset::ADMIN_LTE_SKIN?>',
            radioClass: 'iradio_square-<?=AdminLteAsset::ADMIN_LTE_SKIN?>',
            increaseArea: '20%' // optional
        });
    });
</script>