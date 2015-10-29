<?php

namespace frontend\modules\vote\assets;

use yii\web\AssetBundle;

class VoteAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@frontend/modules/vote/assets';

    /**
     * @inheritdoc
     */
    public $css = [
        'css/vote.css'
    ];

    /**
     * @inheritdoc
     */
    public $js = [
        'js/vote.js'
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'frontend\assets\AppAsset',
    ];
}
