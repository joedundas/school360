<?php

class ModalViewController extends BaseController {

    public function __construct()
    {

    }

    public function getModalView($view) {

        $vw = ModalViews::where('key','=',$view);
        if($vw->count() == 0) {
            throw new \Exception('Modal View not found');
        }
        $vw = $vw->first();

        $response = DependencyInjection::ApiResponse();
        $html = View::make($vw->view);

        $response->addPassback(
            array(
                'html'=> $html->render(),
                'width'=>$vw->width,
                'title'=>$vw->title
            )
        );
        return Response::make($response->toJson());

    }



}
