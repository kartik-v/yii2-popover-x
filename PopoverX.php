<?php
/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2016
 * @package yii2-popover-x
 * @version 1.3.3
 */

namespace kartik\popover;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\base\Widget;

/**
 * An extended popover widget for Yii Framework 2 based on the bootstrap-popover-x plugin by Krajee. This widget
 * combines both the popover and bootstrap modal features and includes various new styling enhancements.
 *
 * The following example will show the content enclosed between the [[begin()]] and [[end()]] calls within the popover
 * dialog:
 *
 * ~~~php
 * PopoverX::begin([
 *     'header' => 'Hello world',
 *     'footer' => Html::button('View', ['class'=>'btn btn-primary']),
 *     'toggleButton' => ['label' => 'Open Popover'],
 * ]);
 *
 * echo 'Say hello...';
 *
 * PopoverX::end();
 * ~~~
 *
 * @see http://plugins.krajee.com/popover-x
 * @see http://github.com/kartik-v/bootstrap-popover-x
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class PopoverX extends Widget
{
    const TYPE_DEFAULT = 'default';
    const TYPE_PRIMARY = 'primary';
    const TYPE_INFO = 'info';
    const TYPE_SUCCESS = 'success';
    const TYPE_DANGER = 'danger';
    const TYPE_WARNING = 'warning';

    const ALIGN_RIGHT = 'right';
    const ALIGN_LEFT = 'left';
    const ALIGN_TOP = 'top';
    const ALIGN_BOTTOM = 'bottom';
    const ALIGN_TOP_LEFT = 'top top-left';
    const ALIGN_BOTTOM_LEFT = 'bottom bottom-left';
    const ALIGN_TOP_RIGHT = 'top top-right';
    const ALIGN_BOTTOM_RIGHT = 'bottom bottom-right';
    const ALIGN_LEFT_TOP = 'left left-top';
    const ALIGN_RIGHT_TOP = 'right right-top';
    const ALIGN_LEFT_BOTTOM = 'left left-bottom';
    const ALIGN_RIGHT_BOTTOM = 'right right-bottom';

    const SIZE_LARGE = 'lg';
    const SIZE_MEDIUM = 'md';

    /**
     * @inheritdoc
     */
    public $pluginName = 'popoverX';

    /**
     * @var string the popover contextual type. Must be one of the [[TYPE]] constants Defaults to
     *     `PopoverX::TYPE_DEFAULT` or `default`.
     */
    public $type = self::TYPE_DEFAULT;

    /**
     * @var string the popover placement. Must be one of the [[ALIGN]] constants Defaults to `PopoverX::ALIGN_RIGHT` or
     *     `right`.
     */
    public $placement = self::ALIGN_RIGHT;

    /**
     * @var string the size of the popover dialog. Must be [[PopoverX::SIZE_LARGE]] or [[PopoverX::SIZE_MEDIUM]]
     */
    public $size;

    /**
     * @var string the header content in the popover dialog.
     */
    public $header;

    /**
     * @var array the HTML attributes for the header. The following special options are supported:
     *
     * - tag: string, the HTML tag for rendering the header. Defaults to 'div'.
     *
     */
    public $headerOptions = [];

    /**
     * @var string the body content
     */
    public $content = '';

    /**
     * @var array the HTML attributes for the popover indicator arrow.
     */
    public $arrowOptions = [];

    /**
     * @var string the footer content in the popover dialog.
     */
    public $footer;

    /**
     * @var array the HTML attributes for the footer. The following special
     * options are supported:
     *
     * - tag: string, the HTML tag for rendering the footer. Defaults to 'div'.
     *
     */
    public $footerOptions = [];

    /**
     * @var array the options for rendering the close button tag. The close button is displayed in the header of the
     *     popover dialog. Clicking on the button will hide the popover dialog. If this is null, no close button will
     *     be rendered. The following special options are supported:
     *
     * - tag: string, the HTML tag for rendering the button. Defaults to 'button'.
     * - label: string, the label of the button. Defaults to '&times;'.
     *
     * The rest of the options will be rendered as the HTML attributes of the button tag. Please refer to the [PopoverX
     *     plugin documentation](http://plugins.krajee.com/popover-x) and the [Modal plugin
     *     help](http://getbootstrap.com/javascript/#modals) for the supported HTML attributes.
     */
    public $closeButton = [];

    /**
     * @var array the options for rendering the toggle button tag. The toggle button is used to toggle the visibility
     *     of the popover dialog. If this property is null, no toggle button will be rendered. The following special
     *     options are supported:
     *
     * - tag: string, the tag name of the button. Defaults to 'button'.
     * - label: string, the label of the button. Defaults to 'Show'.
     *
     * The rest of the options will be rendered as the HTML attributes of the button tag. Please refer to the [PopoverX
     *     plugin documentation](http://plugins.krajee.com/popover-x) and the [Modal plugin
     *     help](http://getbootstrap.com/javascript/#modals) for the supported HTML attributes.
     *
     */
    public $toggleButton;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->initWidget();
    }
    
    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->runWidget();
    }
    
    /**
     * Initializes the widget
     */
    public function initWidget()
    { 
        $this->initOptions();
        echo $this->renderToggleButton() . "\n";
        echo Html::beginTag('div', $this->options) . "\n";
        echo Html::tag('div', '', $this->arrowOptions);
        echo $this->renderHeader() . "\n";
        echo $this->renderBodyBegin() . "\n";
    }
    
    /**
     * Runs the widget
     */
    public function runWidget()
    {
        echo "\n" . $this->renderBodyEnd();
        echo "\n" . $this->renderFooter();
        echo "\n" . Html::endTag('div');
        $this->registerAssets();
    }

    /**
     * Renders the header HTML markup of the popover dialog.
     *
     * @return string the rendering result
     */
    protected function renderHeader()
    {
        $button = $this->renderCloseButton();
        if ($button !== null) {
            $this->header = $button . "\n" . $this->header;
        }
        if (!empty($this->header)) {
            $tag = ArrayHelper::remove($this->headerOptions, 'tag', 'div');
            Html::addCssClass($this->headerOptions, 'popover-title');
            return Html::tag($tag, "\n" . $this->header . "\n", $this->headerOptions);
        } else {
            return null;
        }
    }

    /**
     * Renders the opening tag of the popover dialog body.
     *
     * @return string the rendering result
     */
    protected function renderBodyBegin()
    {
        return Html::beginTag('div', ['class' => 'popover-content']);
    }

    /**
     * Renders the closing tag of the popover dialog body.
     *
     * @return string the rendering result
     */
    protected function renderBodyEnd()
    {
        return $this->content . "\n" . Html::endTag('div');
    }

    /**
     * Renders the HTML markup for the footer of the popover dialog.
     *
     * @return string the rendering result
     */
    protected function renderFooter()
    {
        if (!empty($this->footer)) {
            $tag = ArrayHelper::remove($this->footerOptions, 'tag', 'div');
            Html::addCssClass($this->footerOptions, 'popover-footer');
            return Html::tag($tag, "\n" . $this->footer . "\n", $this->footerOptions);
        } else {
            return null;
        }
    }

    /**
     * Renders the toggle button.
     *
     * @return string the rendering result
     */
    protected function renderToggleButton()
    {
        if ($this->toggleButton !== null) {
            $tag = ArrayHelper::remove($this->toggleButton, 'tag', 'button');
            $label = ArrayHelper::remove($this->toggleButton, 'label', 'Show');
            if ($tag === 'button' && !isset($this->toggleButton['type'])) {
                $this->toggleButton['type'] = 'button';
            }
            return Html::tag($tag, $label, $this->toggleButton);
        } else {
            return null;
        }
    }

    /**
     * Renders the close button.
     *
     * @return string the rendering result
     */
    protected function renderCloseButton()
    {
        if ($this->closeButton !== null) {
            $tag = ArrayHelper::remove($this->closeButton, 'tag', 'button');
            $label = ArrayHelper::remove($this->closeButton, 'label', '&times;');
            if ($tag === 'button' && !isset($this->closeButton['type'])) {
                $this->closeButton['type'] = 'button';
            }

            return Html::tag($tag, $label, $this->closeButton);
        } else {
            return null;
        }
    }

    /**
     * Initializes the widget options.
     * This method sets the default values for various options.
     */
    protected function initOptions()
    {
        $this->options = array_merge([
            'role' => 'dialog'
        ], $this->options);
        $size = !empty($this->size) ? ' popover-' . $this->size : '';
        Html::addCssClass($this->options, 'popover popover-' . $this->type . $size);
        Html::addCssClass($this->arrowOptions, 'arrow');

        if ($this->pluginOptions !== false) {
            $this->pluginOptions = ArrayHelper::merge($this->pluginOptions, ['show' => false]);
        }

        if ($this->closeButton !== null) {
            $this->closeButton = ArrayHelper::merge($this->closeButton, [
                'data-dismiss' => 'popover-x',
                'aria-hidden' => 'true',
                'class' => 'close',
            ]);
        }

        if ($this->toggleButton !== null) {
            $this->toggleButton = ArrayHelper::merge($this->toggleButton, [
                'data-toggle' => 'popover-x',
                'data-placement' => $this->placement
            ]);
            if (!isset($this->toggleButton['data-target']) && !isset($this->toggleButton['href'])) {
                $this->toggleButton['data-target'] = '#' . $this->options['id'];
            }
        }
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        PopoverXAsset::register($view);
        if ($this->toggleButton === null) {
            $this->registerPlugin($this->pluginName);
        }
    }
}
