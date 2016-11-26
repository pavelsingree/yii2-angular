<?php

namespace modules\site;

/**
 * site module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'modules\site\controllers\frontend';

    /**
     * @var boolean Если модуль используется для админ-панели.
     */
    public $isBackend;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // Это здесь для того, чтобы переключаться между frontend и backend
        if ($this->isBackend === true) {
            $this->controllerNamespace = 'modules\site\controllers\backend';
            $this->setViewPath('@modules/site/views/backend');
        } else {
            $this->setViewPath('@modules/site/views/frontend');
        }
    }
}
