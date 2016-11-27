<?php
namespace modules\seo\helpers;
use Yii;
use yii\helpers\Html;

/**
 * @package modules\seo\helpers
 */
class Meta
{
    /**
     * Генерирует meta теги title, keywords, description и возвращает строку Заголовка страницы.
     *
     * @param string $type Тип страницы, для которой генерируются meta теги
     * @param object $model
     * @return string $title Заголовок страницы
     */
    public static function all($type, $model = null)
    {
        $title = 'Carvoy | A new generation of leasing a car!'; // Заголовок страницы по-умолчанию.

        switch ($type) {
            case 'home':
                $title = 'Carvoy | A new generation of leasing a car!';
                Yii::$app->view->registerMetaTag(['name' => 'keywords','content' => 'lease, car, transfer']);
                Yii::$app->view->registerMetaTag(['name' => 'description','content' => 'Carvoy - Change the way you lease! Lease your next new car online and we\'ll deliver it to your doorstep.']);
                break;
            case 'lease':
                $title = $model->make . ' - ' . $model->model . ' - ' . $model->year . ' - ' . $model->exterior_color . ' - ' . $model->engineFuelType . ' for lease in ' . $model->location;
                Yii::$app->view->registerMetaTag(['name' => 'keywords','content' => Html::encode($model->year . ', ' . $model->make . ', ' . $model->model . ', ' . $model->exterior_color . ', ' . $model->engineFuelType . ', ' . $model->location . ', for, lease')]);
                Yii::$app->view->registerMetaTag(['name' => 'description','content' => Html::encode($model->year . ' ' . $model->make . ' ' . $model->model . ' ' . $model->exterior_color . ' ' . $model->engineFuelType . ' for lease in ' . $model->location)]);
                break;
            case 'info_page':
                $title = $model->make . ' - ' . $model->model . ' - ' . $model->year;
                Yii::$app->view->registerMetaTag(['name' => 'keywords','content' => Html::encode($model->year . ', ' . $model->make . ', ' . $model->model)]);
                Yii::$app->view->registerMetaTag(['name' => 'description','content' => Html::encode($model->year . ' ' . $model->make . ' ' . $model->model)]);
                break;
            case 'search':
                if ($model['role'] == 'd') $role = 'Dealer Lease';
                elseif ($model['role'] == 'u') $role = 'Lease Transfers';
                else $role = 'All Leases';
                if (isset($model['make']) && isset($model['model'])) {
                    $_make = (is_array($model['make']))? (( isset($model['make']) && ( count($model['make']) == 1) )? $model['make'][0] : false ) : $model['make'];
                    $_model = (is_array($model['model']))? (( isset($model['model']) && ( count($model['model']) == 1) )? $model['model'][0] : false ) : $model['model'];
                    $_year = false;
                    $_location = false;
                    if (isset($model['year'])) {
                        $_year = (is_array($model['year']))? (( isset($model['year']) && ( count($model['year']) == 1) )? $model['year'][0] : false ) : $model['year'];
                    }
                    if (isset($model['location'])) {
                        $_location = (is_array($model['location']))? (( isset($model['location']) && ( count($model['location']) == 1) )? $model['location'][0] : false ) : $model['location'];
                    }
                    if ( ($_make || $_model) && !(isset($model['make']) && ( count($model['make']) > 1)) ) {
                        $title = $_make . (($_model)? ' ' . $_model : '') . (($_year)? ' ' . $_year : '') . ' for Lease' . (($_location)? ' in ' . $_location . '. ' : '. ') . $role . '.';
                    } else {
                        $title = 'Vehicle for Lease' . (($_location)? ' in ' . $_location . '. ' : '. ') . $role . '.';
                    }
                    Yii::$app->view->registerMetaTag(['name' => 'keywords','content' => Html::encode( ltrim($_make . (($_model)? ', ' . $_model : '') . (($_year)? ', ' . $_year : '') . ', for, Lease' . (($_location)? ', in, ' . $_location : '') . ', ' . implode(', ', (explode(' ', $role))), ', ') ) ]);
                    Yii::$app->view->registerMetaTag(['name' => 'description','content' => Html::encode( 'List of '. ((!$_model && !$_make)? 'Vehicles' : '') . $_make . (($_model)? ' ' . $_model : '') . (($_year)? ' ' . $_year : '') . (($_location)? ' in ' . $_location : '') . ' available for lease. ' . $role . '.' )]);
                } else {
                    $title = 'Search results';
                }
                break;
        }
        return $title;
    }
}