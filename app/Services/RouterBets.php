<?php


class RouterBets
{
    private static $list  = [];

    public static function get($uri,$exact,$class,$method,$params = [])
    {
        self::$list[] = [
            'exact' => $exact,
            'get' => true,
            'uri' => $uri,
            'class' => $class,
            'methodClass' => $method,
            'params' => $params
        ];
    }
    public static function post($uri,$exact,$class,$method,$data = true)
    {
        self::$list[] = [
            'exact' => $exact,
            'post' => true,
            'uri' => $uri,
            'class' => $class,
            'methodClass' => $method,
            'data' => $data,
        ];
    }
    public static function delete($uri,$exact,$class,$method,$data = true)
    {
        self::$list[] = [
            'exact' => $exact,
            'delete' => true,
            'uri' => $uri,
            'class' => $class,
            'methodClass' => $method,
            'data' => $data
        ];
    }

    public static function enable()
    {
        $q = $_GET['q'];

        foreach (self::$list as $route) {
            $operand = $route['exact'] == true ? $route['uri'] == '/' . $q : str_starts_with('/' . $q, $route['uri']) == true;

            if($operand) {
                    if ($route['post'] == true or $_SERVER['REQUEST_METHOD'] == 'POST') {
                        $className = new $route['class'];
                        $method = $route['methodClass'];

                        $url_params = mb_substr($q,strlen($route['uri']),strlen('/'.$q));
                        if ($route['data'] == true) {
                            $className->$method($_POST,$url_params);
                        }
                    }
                    if ($route['get'] == true AND $_SERVER['REQUEST_METHOD'] == 'GET') {
                        $className = new $route['class'];
                        $method = $route['methodClass'];
                        $url_params = mb_substr($q,strlen($route['uri']),strlen('/'.$q));

                        $className->$method($route['params'],$url_params);
                    }
                    if ($route['delete'] == true OR $_SERVER['REQUEST_METHOD'] == 'DELETE') {
                        $className = new $route['class'];
                        $method = $route['methodClass'];
                        if ($route['data'] == true) {
                            $className->$method($_POST);
                        }
                    }
                }
            }

    }

    private static function not_found_page()
    {
        exit(responseOut(array('error' => 'not-found 404')));
    }
}