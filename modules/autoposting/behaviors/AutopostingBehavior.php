<?php

namespace modules\autoposting\behaviors;

use Yii;
use yii\base\Behavior;
use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * Class AutopostingBehavior
 * @package modules\autoposting\behaviors
 */
class AutopostingBehavior extends Behavior {

    /**
     * @return array
     */
    public function events() {

        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'postToWall',
        ];
    }

    /**
     * @param \yii\base\Event $event
     *
     * @throws Exception
     */
    public function postToWall( $event ) {

        $model    = $event->sender;

        if ($model) {
            $link = Url::to(['/lease/lease/view', 'state'=>$model->state, 'node'=>$model->url ], true);
            $message = "New listing available on our site - $model->make $model->model $model->year in $model->location. \n" . $link;
            $this->facebookPost([
                'message'     => $message,
                'link'        => $link,
                // 'picture'     => 'http://thepicturetoinclude.jpg', // link to vehicle picture
                // 'name'        => 'Name of the picture, shown just above it',
                // 'description' => 'Full description explaining whether the header or the picture'
            ]);
            $this->twitterPost($message);
        }

    }

    private function facebookPost ($data)
    {
        // need token
        $data['access_token'] = Yii::$app->params['autoposting']['facebook']['page_access_token'];

        $page_id = Yii::$app->params['autoposting']['facebook']['page_id'];;
        $post_url = 'https://graph.facebook.com/'.$page_id.'/feed';

        // init
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $post_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // execute and close
        $return = curl_exec($ch);
        curl_close($ch);
        // end
        return $return;
    }

    private function twitterPost ($message)
    {

        $CONSUMER_KEY = Yii::$app->params['autoposting']['twitter']['consumer_key'];
        $CONSUMER_SECRET = Yii::$app->params['autoposting']['twitter']['consumer_secret'];
        $OAUTH_TOKEN = Yii::$app->params['autoposting']['twitter']['oauth_token'];
        $OAUTH_SECRET = Yii::$app->params['autoposting']['twitter']['oauth_secret'];


        $connection = new \Abraham\TwitterOAuth\TwitterOAuth($CONSUMER_KEY, $CONSUMER_SECRET, $OAUTH_TOKEN, $OAUTH_SECRET);

        $statues = $connection->post("statuses/update", array("status" => $message));

        return $connection->getLastHttpCode() == 200;

    }

}