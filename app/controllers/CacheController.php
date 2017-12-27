<?php



class CacheController extends BaseController implements CacheControllerInterface  {





    public function __construct()
    {

    }


    public function save($items) {
        foreach($items as $key=>$item) {
            Session::put('cache.' . $key, $item);
        }
    }

    public function get($key) {
        return Session::get('cache.' . $key);
    }

    public function flush($flushAuth = false)
    {
        Session::forget('cache');
        if ($flushAuth) {
            Session::flush();
        }

    }

}
