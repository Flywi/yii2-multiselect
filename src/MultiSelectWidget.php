<?php

namespace flywi\select;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

/**
 * Class MultiSelectWidget
 * @package flywi\select
 */
class MultiSelectWidget extends InputWidget
{
    public $data = [];

    public $selectID = '';

    public $leftSelectBoxOptions = [];

    public $rightSelectBoxOptions = [];

    public $rightAllButtonShow = true;
    public $rightAllButtonOptions = [];

    public $rightSelectedButtonShow = true;
    public $rightSelectedButtonOptions = [];

    public $leftSelectedButtonShow = true;
    public $leftSelectedButtonOptions = [];

    public $leftAllButtonShow = true;
    public $leftAllButtonOptions = [];

    public $clientOptions = [];

    public $template = '<div class="col-xs-5">{left}</div><div class="col-xs-2">{middle}</div><div class="col-xs-5">{right}</div>';

    private $defaultSelectBoxOptions = [
        'class' => 'form-control',
        'size' => 15,
        'multiple' => 'multiple',
    ];

    private $defaultButtonOptions = [
        'class' => 'btn btn-block'
    ];

    public function init()
    {
        $this->registerAsset();
    }

    public function run()
    {
        $left = $this->resolveLeft();
        $middle = $this->resolveMiddle();
        $right = $this->resolveRight();
        $html = strtr($this->template, [
            '{left}' => $left,
            '{middle}' => $middle,
            '{right}' => $right,
        ]);
        echo $html;
        $id = $this->getId();
        $view = $this->getView();
        $clientOptions = (!empty($this->clientOptions))
            ? Json::encode($this->clientOptions)
            : '';
        $js = "jQuery('#{$id}').multiselect({$clientOptions});";
        $view->registerJs($js);
    }

    protected function resolveLeft()
    {
        $id = $this->getId();
        $options = array_merge(['id' => $id], $this->defaultSelectBoxOptions, $this->leftSelectBoxOptions);
        $selectContent = Html::tag(
            'select',
            Html::renderSelectOptions(null, $this->data),
            $options
        );
        return $selectContent;
    }

    protected function resolveMiddle()
    {
        $id = $this->getId();
        $temp = [];
        if ($this->rightAllButtonShow) {
            $options = array_merge(['id' => "{$id}_rightAll"], $this->defaultButtonOptions, $this->rightAllButtonOptions);
            $temp[] = Html::button('<i class="glyphicon glyphicon-forward"></i>', $options);
        }
        if ($this->rightSelectedButtonShow) {
            $options = array_merge(['id' => "{$id}_rightSelected"], $this->defaultButtonOptions, $this->rightSelectedButtonOptions);
            $temp[] = Html::button('<i class="glyphicon glyphicon-chevron-right"></i>', $options);
        }
        if ($this->leftSelectedButtonShow) {
            $options = array_merge(['id' => "{$id}_leftSelected"], $this->defaultButtonOptions, $this->leftSelectedButtonOptions);
            $temp[] = Html::button('<i class="glyphicon glyphicon-chevron-left"></i>', $options);
        }
        if ($this->leftAllButtonShow) {
            $options = array_merge(['id' => "{$id}_leftAll"], $this->defaultButtonOptions, $this->leftAllButtonOptions);
            $temp[] = Html::button('<i class="glyphicon glyphicon-backward"></i>', $options);
        }

        return join('', $temp);
    }

    protected function resolveRight()
    {
        // right select box select id
        // not need specify right option in clientOptions
        $rightSelectID = $this->selectID ?: Html::getInputId($this->model, $this->attribute);
        $this->clientOptions = array_merge(
            $this->clientOptions ?: [],
            ['right' => '#'.$rightSelectID]
        );
        $name = Html::getInputName($this->model, $this->attribute);
        $options = array_merge(['id' => $rightSelectID, 'name' => "{$name}[]"], $this->defaultSelectBoxOptions, $this->rightSelectBoxOptions);
        $selectContent = Html::tag(
            'select',
            '',
            $options
        );
        return $selectContent;
    }

    protected function registerAsset()
    {
        $view = $this->getView();
        MultiSelectAsset::register($view);
    }
}
