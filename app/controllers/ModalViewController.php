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

        $html = View::make($vw->view);

        $packet = DependencyInjection::DataTransferPacket();
        $packet->setResults(
            array(
                'html'=> $html->render(),
                'width'=>$vw->width,
                'title'=>$vw->title
            )
        );
//        $response->addPassback(
//            array(
//                'html'=> $html->render(),
//                'width'=>$vw->width,
//                'title'=>$vw->title
//            )
//        );
//        $sendBack = array(
//            'output'=>array(
//                'html'=> $html->render(),
//                'width'=>$vw->width,
//                'title'=>$vw->title
//            )
//        );

        return $packet->toJson();
    }



}
