<?php

namespace panix\mod\rbac;

use yii\web\AssetBundle;

/**
 * Class RbacAsset
 *
 * @package panix\mod\rbac
 */
class RbacAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@vendor/panix/mod-rbac/assets';

    /**
     * @var array
     */
    public $js = [
        'js/rbac.js',
    ];

    public $css = [
        'css/rbac.css',
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
