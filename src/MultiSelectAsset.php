<?php

namespace flywi\select;

use yii\web\AssetBundle;

class MultiSelectAsset extends AssetBundle
{
    public $sourcePath = '@bower/multiselect-two-sides/dist';

    public $js = [
        'js/multiselect.min.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
