<?php
namespace modules\seo;
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
                    'class' => 'modules\seo\components\UrlRule',
                ],
            ]
        );
    }
}