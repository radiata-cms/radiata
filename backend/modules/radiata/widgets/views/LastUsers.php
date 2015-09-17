<?php
/* @var $this yii\web\View */
/* @var $users common\models\user\User[] */

use yii\helpers\Html;
use common\modules\radiata\helpers\DateHelper;

?>
<div class="col-md-4">
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Yii::t('b/radiata/user', 'Latest Members') ?></h3>

            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
            <ul class="users-list clearfix">
                <?
                foreach ($users as $user) {
                    ?>
                    <li>
                        <?= Html::a(Html::img($user->getThumbFileUrl('image', 'avatar')), ['user/view', 'id' => $user->id]) ?>
                        <?= Html::a($user->getFullName(), ['user/view', 'id' => $user->id], ['class' => 'users-list-name']) ?>
                        <span class="users-list-date"><?= DateHelper::getDate($user->created_at, 'php:d M') ?></span>
                    </li>
                <?
                }
                ?>
            </ul>
            <!-- /.users-list -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer text-center">
            <?= Html::a(Yii::t('b/radiata/user', 'View All Users'), ['user/index'], ['class' => 'uppercase']) ?>
        </div>
        <!-- /.box-footer -->
    </div>
    <!--/.box -->
</div>