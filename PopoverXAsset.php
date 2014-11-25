<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014
 * @package yii2-popover-x
 * @version 1.3.0
 */

namespace kartik\popover;

use Yii;

/**
 * Asset bundle for PopoverX widget. Includes assets from
 * bootstrap-popover-x plugin by Krajee.
 *
 * @see http://plugins.krajee.com/popover-x
 * @see http://github.com/kartik-v/bootstrap-popover-x
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class PopoverXAsset extends \kartik\base\AssetBundle
{
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
    
    public function init()
    {
        $this->setSourcePath('@vendor/kartik-v/bootstrap-popover-x');
        $this->setupAssets('css', ['css/bootstrap-popover-x']);
        $this->setupAssets('js', ['js/bootstrap-popover-x']);
        parent::init();
    }
}
