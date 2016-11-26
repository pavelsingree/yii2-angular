<?php

namespace modules\users;

/**
 * site module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'modules\users\controllers\frontend';

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
            $this->controllerNamespace = 'modules\users\controllers\backend';
            $this->setViewPath('@modules/users/views/backend');
        } else {
            $this->setViewPath('@modules/users/views/frontend');
        }
    }
}
