<?php



class SessionController extends BaseController {

    public function __construct()
    {

    }

    static public function saveToSession($items) {
        foreach($items as $key=>$item) {
            Session::put($key, $item);
        }
    }

    static public function getFromSession($key) {
        return Session::get($key);
    }
}
