<?php
/**
 * Default configuration for Xhgui
 */

return array(
    'debug' => false,
    'mode' => 'development',

    // Can be either mongodb or file.
    /*
    'save.handler' => 'file',
    'save.handler.filename' => dirname(__DIR__) . '/cache/' . 'xhgui.data.' . microtime(true) . '_' . substr(md5($url), 0, 6),
    */
    'save.handler' => 'mongodb',

    // Needed for file save handler. Beware of file locking. You can adujst this file path
    // to reduce locking problems (eg uniqid, time ...)
    //'save.handler.filename' => __DIR__.'/../data/xhgui_'.date('Ymd').'.dat',
    'db.host' => 'mongodb://mongo:27017',
    'db.db' => 'xhprof',

    // Allows you to pass additional options like replicaSet to MongoClient.
    // 'username', 'password' and 'db' (where the user is added)
    'db.options' => array(),
    'templates.path' => dirname(__DIR__) . '/src/templates',
    'date.format' => 'M jS H:i:s',
    'detail.count' => 6,
    'page.limit' => 25,

    // Profile 1 in 100 requests.
    // You can return true to profile every request.
    'profiler.enable' => function() {
        if (isset($_GET['profile'])) {
            if ($_GET['profile'] != 0) {
                $lifetime = time() + 512640;
                setcookie('profile', 1, $lifetime, "/", $_SERVER['HTTP_HOST'], false, false);
                $_COOKIE['profile'] = 1;
            } else {
                setcookie('profile', 0, time() + 1, "/", $_SERVER['HTTP_HOST'], false, false);
                unset($_COOKIE['profile']);
            }
        }

        if (
            (isset($_COOKIE['profile']) && $_COOKIE['profile'] === '1')
            || (
                $_SERVER['argc'] > 1
                && in_array('profile', $_SERVER['argv'])
                && in_array('profile=1', $_SERVER['argv'])
            )
        ) {
            return true;
        }
        return false;
    },

    'profiler.simple_url' => function($url) {
        return preg_replace('/\=\d+/', '', $url);
    }
);
