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
    protected $logging = 'off';

    public function __construct($route,$input) {
        $this->setClientDiagnostics($input['diagnostics']);
        $this->setReceivedTime();
        $this->setRoute($route);
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
        $route = $this->getRoute();
        $class = new $route['class']();
        $method = $route['method'];
        $input = $this->getInput();
        $this->setClientSideCallInformation($input['call']);
        return $class->$method($this->getData());
    }
    private function logApiCall() {
        $route = $this->getRoute();
        $callRecord = new ApiCalls();
        $callRecord->userId = Auth::user()->id;
        $callRecord->information = base64_encode($this->toJson());
        $callRecord->routeClass = $route['class'];
        $callRecord->routeMethod = $route['method'];
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
            'route'=>$this->getRoute(true),
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
    private function parseRouteFromString($route) {
        $rt = explode('@',$route);
        return array(
            'class'=>$rt[0],
            'method'=>$rt[1]
        );
    }
    private function setLogId($logId) {
        $this->logId = $logId;
    }
    public function getLogId() {
        return $this->logId;
    }
    public function getRoute($asString = false) {
        if($asString) {
            $route = $this->route;
            return $route['class'] . "@" . $route['method'];
        }
        return $this->route;
    }
    public function setRoute($route) {
        $this->route = $this->parseRouteFromString($route);
    }
    public function getInput() {
        return $this->input;
    }

    public function setInput($input) {
        $this->input = $input;
        $this->setData($input['data']);
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
