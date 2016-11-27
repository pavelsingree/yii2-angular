<?php
namespace modules\lease;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $app->getUrlManager()->addRules(
            [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['leases' => 'lease/api'],
                    'prefix' => 'api'
                ]
            ]
        );
    }
}