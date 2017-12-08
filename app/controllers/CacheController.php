<?php



class CacheController extends BaseController implements CacheControllerInterface  {

    public function __construct()
    {

    }

    public function save($items) {
        foreach($items as $key=>$item) {
            Session::put($key, $item);
        }
    }

    public function get($key) {
        return Session::get($key);
    }
}
