<?
namespace console\controllers;

class InstallController extends \yii\console\Controller
{
    public function actionIndex()
    {
        $migrator = new \common\modules\radiata\components\Migrator();
        $migrator->migrate();
        if($migrator->error) {
            print_r($migrator->error->getMessage());
        }
    }
}

?>