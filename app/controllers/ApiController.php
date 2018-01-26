<?php



class ApiController extends BaseController {


    protected $logging = 'off';
    protected $packet;


    // shortClass and shortMethod are short names.  The mapping to a class and method is done using the configs
    //  in the setRoute method.
    public function __construct(DataTransferPacketInterface $packet) {
        $this->packet = $packet;
        $this->setLogging(
            \Edu3Sixty\SettingsController::getStatus(
                'api-logging',
                $this->packet->getUserId(),
                $this->packet->getSchoolId(),
                $this->packet->getRoleId()

            )
        );
    }
    public function getLogging() {
        return $this->logging;
    }
    public function setLogging($onOrOff) {
        $this->logging = $onOrOff;
    }
    public function call() {
        $this->packet->setResults($this->callRoute());
        if($this->getLogging() === 'on') {
            $this->packet->log();
        }
        $this->packet->setServerSentTime();
        return $this->packet->toJson();
    }
    private function callRoute() {
        $callClass = $this->packet->getClass();
        $class = new $callClass();
        $method = $this->packet->getMethod();
        return $class->$method($this->packet);
    }
}
