<?php

namespace modules\lease;

/**
 * site module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'modules\lease\controllers\frontend';

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
            $this->controllerNamespace = 'modules\lease\controllers\backend';
            $this->setViewPath('@modules/lease/views/backend');
        } else {
            $this->setViewPath('@modules/lease/views/frontend');
        }
    }
}
