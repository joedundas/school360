<?php

class CoursesController extends BaseController {

    public function __construct()
    {

    }

    public function add($packet) {
        $info = $packet->getInputData();
        $course = new Courses();
        $course->courseName = $info['courseName'];
        $course->save();

        $packet->setResults(
            array(
                'id'=>$course->id
            )
        );

        return $packet->toJson();
    }

    public function get($packet) {
        $courses = Courses::get();
        $packet->setResults($courses);
        return $packet->toJson();
//        $courses = Courses::
//        $vw = ModalViews::where('key','=',$view);
//        if($vw->count() == 0) {
//            throw new \Exception('Modal View not found');
//        }
//        $vw = $vw->first();
//
//        $html = View::make($vw->view);
//
//        $packet = DependencyInjection::DataTransferPacket();
//        $packet->setResults(
//            array(
//                'html'=> $html->render(),
//                'width'=>$vw->width,
//                'title'=>$vw->title
//            )
//        );
//
//
//        return $packet->toJson();
    }



}
