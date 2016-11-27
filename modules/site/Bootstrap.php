<?php
namespace modules\site;
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
                // rules definition
                '/' => 'site/site/index',
                '<_a:(about|contact)>' => 'site/site/<_a>'
            ]
        );
    }
}