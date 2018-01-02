<?php



class ApiController extends BaseController {

    protected $clientSideCallInformation;
    protected $clientDiagnostics;
    protected $receivedTime;
    protected $finishedTime;
    protected $response;
    protected $clientSideErrors;
    protected $input;
    protected $data;
    protected $route;
    protected $logId;
    protected $roleId;
    protected $schoolId;
    protected $class;
    protected $method;
    protected $logging = 'off';

    // shortClass and shortMethod are short names.  The mapping to a class and method is done using the configs
    //  in the setRoute method.
    public function __construct($shortClass,$shortMethod,$input) {
        $this->setClientDiagnostics($input['diagnostics']);
        $this->setReceivedTime();
        $this->setRoute($shortClass,$shortMethod);
        $this->setInput($input);

        $PAGE = (new SessionManager())->reviveSessionFromCache();
        $this->setRoleId($PAGE->getCurrentRoleId());
        $this->setSchoolId($PAGE->getCurrentSchoolId());
        $this->setLogging(
            \Edu3Sixty\SettingsController::getStatus(
                'api-logging',
                Auth::user()->id,
                $PAGE->getCurrentSchoolId(),
                $PAGE->getCurrentRoleId()

            )
        );
    }



    public function getRoleId() {
        return $this->roleId;
    }
    public function setRoleId($roleId) {
        $this->roleId = $roleId;
    }
    public function getSchoolId() {
        return $this->schoolId;
    }
    public function setSchoolId($schoolId) {
        $this->schoolId = $schoolId;
    }
    public function getLogging() {
        return $this->logging;
    }
    public function setLogging($onOrOff) {
        $this->logging = $onOrOff;
    }

    public function call() {
        $this->setReceivedTime();
        $this->setResponse($this->callRoute());
        if($this->getLogging() === 'on') {
            $this->logApiCall();
        }
        $this->setFinishedTime();
        return $this->toJson();
    }
    private function callRoute() {
        $callClass = $this->getClass();
        $class = new $callClass();
        $method = $this->getMethod();
        $input = $this->getInput();
        $this->setClientSideCallInformation($input['call']);
        return $class->$method($this->getData());
    }
    private function logApiCall() {
        $route = $this->getRoute();
        $callRecord = new ApiCalls();
        $callRecord->userId = Auth::user()->id;
        $callRecord->information = base64_encode($this->toJson());
        $callRecord->routeClass = $this->getClass();
        $callRecord->routeMethod = $this->getMethod();
        $callRecord->roleId = $this->getRoleId();
        $callRecord->schoolId = $this->getSchoolId();
        $callRecord->save();
        $logId = $callRecord->id;
        $this->setLogId($logId);
    }
    public function give() {

        return $this->toJson();
    }

    public function toJson() {
        return json_encode($this->asArray());
    }
    public function asArray() {
        return array(
            'diagnostics'=>array(
                'logId'=>$this->getLogId(),
                'client'=>$this->getClientDiagnostics(),
            ),
            'callId'=>$this->getClientSideCallInformation(),
            'input'=>$this->getInput(),
            'route'=>$this->getRoute(),
            'output'=>array(
                'data'=>$this->getResponse('passback'),
                'hasErrors'=>$this->getResponse('error'),
                'messages'=>$this->getResponse('messages')
            )
        );
    }
    public function setClientSideCallInformation($info) {
        $this->clientSideCallInformation = $info;
    }
    public function getClientSideCallInformation() {
        return $this->clientSideCallInformation;
    }

    public function setClientDiagnostics($diag) {
        $this->clientDiagnostics = $diag;
    }
    public function getClientDiagnostics() {
        return $this->clientDiagnostics;
    }

    private function setLogId($logId) {
        $this->logId = $logId;
    }
    public function getLogId() {
        return $this->logId;
    }
    public function getRoute($asString = false) {
        return $this->route;
    }
    public function setRoute($shortClass,$shortMethod) {
        $this->route = $shortClass . '@' . $shortMethod; //$this->parseRouteFromString($route);
        $callTo = RouteMapper::getAjaxRouteClassAndMethodFromShortName($shortClass,$shortMethod);

        $this->setClass($callTo['class']);
        $this->setMethod($callTo['method']);
    }
    public function setClass($class) {
        $this->class = $class;
    }
    public function setMethod($method) {
        $this->method = $method;
    }
    public function getClass() {
        return $this->class;
    }
    public function getMethod() {
        return $this->method;
    }
    public function getInput() {
        return $this->input;
    }

    public function setInput($input) {
        $this->input = $input;
        if(array_key_exists('data',$input)) {
            $this->setData($input['data']);
        }
        else {
            $this->setData(array());
        }
    }
    public function setData($data) {
        $this->data = $data;
    }

    public function getData() {
        return $this->data;
    }
    private function setResponse($response) {
        $this->response = json_decode($response->toJson(),true);
    }
    public function getResponse($key = false) {
        if($key === false) {
            return $this->response;
        }
        if(!array_key_exists($key,$this->response)) {
            throw new Exception('Response key requested does not exist in response array');
        }
        return $this->response[$key];

    }
    private function setReceivedTime($time = false) {
        if($time === false) {
            $time = \Carbon\Carbon::now();
        }

        $this->receivedTime = $time;
        $this->clientDiagnostics['time']['server']['received'] = $time;

    }
    public function getReceivedTime() {
        return $this->receivedTime;
    }
    private function setFinishedTime($time = false) {
        if($time === false) {
            $time = \Carbon\Carbon::now();
        }
        $this->finishedTime = $time;
        $this->clientDiagnostics['time']['server']['sent'] = $time;
    }
    public function getFinishedTime() {
        return $this->finishedTime;
    }


}
