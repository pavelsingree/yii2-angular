<?php
namespace modules\seo\components;
use modules\seo\models\Route;
use modules\zipdata\models\Zip;
use yii\helpers\Json;
use Yii;
use yii\web\UrlRuleInterface;

class UrlRule implements UrlRuleInterface
{
    public function createUrl($manager, $route, $params)
    {
        /**
         * Lease module create urls
         */
        if ($route === 'lease/lease/view') {
            if (isset($params['state'], $params['node'], $params['role'])) {
                $role = ($params['role'] == 'dealer') ? 'new-lease' : 'lease-transfer';
                return $role . '/' . $params['state'] . '/' . $params['node'];
            }
        }
        if ($route === 'lease/lease/update') {
            if (isset($params['state'], $params['node'], $params['role'])) {
                $role = ($params['role'] == 'dealer') ? 'new-lease' : 'lease-transfer';
                return $role . '/' . $params['state'] . '/' . $params['node'] . '/edit/update';
            }
        }

        /**
         *  Information Pages create urls
         */
        if ($route === 'cars/info/view') {
            if (isset($params['node'])) {
                return 'i/' . $params['node'];
            }
        }

        /**
         *  Search Pages create urls
         */
        if ($route === 'lease/search/view') {
            if (!empty($params['url'])) {
                $params['url'] = str_replace(' ', '_', $params['url']);
                if($search_url = Route::findRouteByUrl($params['url'])) {
                    return '/'.$params['url'];
                } else {
                    $route = new Route();
                    $route->url = str_replace(' ', '_', substr($params['url'],1) );
                    $route->route = 'lease/search/index';
                    $route->params = json_encode(['make'=>$params['make'], 'model'=>$params['model'], 'location'=>$params['location']  ]);
                    $route->save();
                    return '/'.$params['url'];
                }
            }
            if (isset($params['type']) && in_array($params['type'], ['user','dealer'])) {
                $type = ($params['type'] == 'dealer')? 'new-lease' : 'lease-transfer';
            } else {
                return false;
            }
            if ((isset($params['zip']) && !empty($params['zip'])) || (isset($params['location']) && isset($params['state']))) {
                // make model price zip type
                if (isset($params['zip']) && !empty($params['zip'])) {
                    $zipdata = Zip::findOneByZip($params['zip']);
                } else {
                    $zipdata = Zip::findOneByLocation($params['location'], $params['state']);
                }
                // city state_code
                if (!empty($zipdata)) {
                    $url = $type . '/' . $zipdata['state_code'] . '/' . $params['make'] . '-' . $params['model'] . '-' . $zipdata['city'];
                    if (!empty($params['year'])) {
                        $url.='/'.$params['year'];
                    }
                    $url = str_replace(' ', '_', $url);
                    if($search_url = Route::findRouteByUrl($url)) {
                        return '/'.$url;
                    } else {
                        $route = new Route();
                        $route->url = str_replace(' ','_',$url);
                        $route->route = 'lease/search/index';
                        $pars = ['make'=>$params['make'], 'model'=>$params['model'], 'location'=>$zipdata['city'], 'state'=>$zipdata['state_code'] ]; //, 'zip'=>$params['zip'] ];
                        if (!empty($params['year'])) {
                            $pars['year']=$params['year'];
                        }
                        $route->params = json_encode($pars);
                        $route->save();
                        return $route->url;
                    }
                }
            }
            if (isset($params['make'], $params['model'] )) {
                $url = $type . '/' . $params['make'] . '-' . $params['model'] ;
                if (!empty($params['year'])) {
                    $url.='/'.$params['year'];
                }
                $url = str_replace(' ', '_', $url);
                if($search_url = Route::findRouteByUrl($url)) {
                    return '/'.$url;
                } else {
                    $route = new Route();
                    $route->url = str_replace(' ','_',$url);
                    $route->route = 'lease/search/index';
                    $pars = ['make'=>$params['make'], 'model'=>$params['model']  ];
                    if (!empty($params['year'])) {
                        $pars['year']=$params['year'];
                    }
                    $route->params = json_encode($pars);
                    $route->save();
                    return $route->url;
                }
            }
        }

        return false;
    }

    /**
     * Parse request
     * @param \yii\web\Request|UrlManager $manager
     * @param \yii\web\Request $request
     * @return array|boolean
     */
    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();

        /**
         * Parse request for search URLs with location and year
         */
        if (preg_match('%^(?P<role>lease-transfer|new-lease)\/(?P<state>[A-Za-z]{2})\/(?P<url>[._\sA-Za-z-0-9-]+)\/(?P<year>\d{4})?%', $pathInfo, $matches)) {
            $route = Route::findRouteByUrl($pathInfo);
            if (!$route) {
                return false;
            }
            $params = [
                'node' => $matches['url'] . '/' . $matches['year'],
                'role' => $matches['role'],
                'state' => $matches['state'],
                'year' => $matches['year']
            ];
            if (!empty($route['params'])) {
                $params = array_merge($params, json_decode($route['params'], true));
            }
            return [$route['route'], $params];
        }

        /**
         * Parse request for search URLs with location and with year
         */
        if (preg_match('%^(?P<role>lease-transfer|new-lease)\/(?P<url>[._\sA-Za-z-0-9-]+)\/(?P<year>\d{4})%', $pathInfo, $matches)) {
            $route = Route::findRouteByUrl($pathInfo);
            if (!$route) {
                return false;
            }
            $params = [
                'node' => $matches['url'] . '/' . $matches['year'],
                'role' => $matches['role'],
                'year' => $matches['year']
            ];
            if (!empty($route['params'])) {
                $params = array_merge($params, json_decode($route['params'], true));
            }
            return [$route['route'], $params];
        }

        /**
         * Parse request for leases URLs and search URLs with location
         */
        if (preg_match('%^(?P<role>lease-transfer|new-lease)\/(?P<state>[A-Za-z]{2})\/(?P<url>[_A-Za-z-0-9-]+)?%', $pathInfo, $matches)) {
            $route = Route::findRouteByUrl([$matches['url'], $pathInfo]);
            if (!$route) {
                return false;
            }
            $params = [
                'role' => $matches['role'],
                'node' => $matches['url'],
                'state' => $matches['state']
            ];
            if (!empty($route['params'])) {
                $params = array_merge($params, json_decode($route['params'], true));
            }
            return [$route['route'], $params];
        }

        /**
         * Parse request for search URLs without location and year
         */
        if (preg_match('%^(?P<role>lease-transfer|new-lease)\/(?P<url>[._\sA-Za-z-0-9-]+)?%', $pathInfo, $matches)) {
            $route = Route::findRouteByUrl($pathInfo);
            if (!$route) {
                return false;
            }
            $params = [
                'node' => $matches['url'],
                'role' => $matches['role'],
            ];
            if (!empty($route['params'])) {
                $params = array_merge($params, json_decode($route['params'], true));
            }
            return [$route['route'], $params];
        }

        /**
         * Parse request for Information pages URLs
         */
        if (preg_match('%^i\/(?P<url>[_A-Za-z-0-9-]+)?%', $pathInfo, $matches)) {
            $route = Route::findRouteByUrl($matches['url']);
            if (!$route) {
                return false;
            }
            $params = Json::decode($route['params']);
            $params['node'] = $route['url'];
            return [$route['route'], $params];
        }

        return false;
    }
}