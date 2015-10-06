<?
/**
 * @var yii\web\View $this
 * @var string JSTreeDivId
 * @var string dataUrl
 * @var string moveUrl
 * @var string createUrl
 * @var string editUrl
 * @var string deleteUrl
 */
use yii\web\View;

?>

    <div id="<?= $JSTreeDivId ?>"></div>
<?
$jsCode = <<< JS
    var JS_TREE_DATA_URL = '$dataUrl';
    var JS_TREE_MOVE_URL = '$moveUrl';
    var JS_TREE_CREATE_URL = '$createUrl';
    var JS_TREE_EDIT_URL = '$editUrl';
    var JS_TREE_DELETE_URL = '$deleteUrl';
    var JS_TREE_PARENT_ID_FIELD = '$parentIdField';
    var JST_PREFIX = '$jstPrefix';

    if(typeof(jstreeContainers) == 'undefined') {
        var jstreeContainers = new Array();
    }
    jstreeContainers.push('$JSTreeDivId');
JS;
$this->registerJs($jsCode, View::POS_BEGIN);
?>