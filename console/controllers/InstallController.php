<?
namespace console\controllers;

class InstallController extends \yii\console\Controller
{
    public function actionIndex()
    {
        $migrator = new \common\modules\radiata\components\Migrator();
        $migrator->migrate();
        if($migrator->error) {
            print_r('Error: ' . $migrator->error);
        } else {
            echo 'Done!';
            \Yii::$app->cache->flush();
        }
    }

    public function actionUninstall()
    {
        $migrator = new \common\modules\radiata\components\Migrator();
        $migrator->direction = "down";
        $migrator->migrate();
        if($migrator->error) {
            print_r('Error: ' . $migrator->error);
        } else {
            echo 'Done!';
            \Yii::$app->cache->flush();
        }
    }
}

?>