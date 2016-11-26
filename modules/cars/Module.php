<?php

namespace modules\cars;

/**
 * site module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'modules\cars\controllers\frontend';

    /**
     * @var boolean.
     */
    public $isBackend;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->isBackend === true) {
            $this->controllerNamespace = 'modules\cars\controllers\backend';
            $this->setViewPath('@modules/cars/views/backend');
        } else {
            $this->setViewPath('@modules/cars/views/frontend');
        }
    }
}
