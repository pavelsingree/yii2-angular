<?php

namespace modules\cars\backend;

use yii\web\Controller;

/**
 * Default controller for the `cars` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
