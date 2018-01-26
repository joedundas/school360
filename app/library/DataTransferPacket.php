<?php

class DataTransferPacket implements DataTransferPacketInterface
{
    protected $userId;
    protected $schoolId;
    protected $roleId;
    protected $inputData;
    protected $error = false;
    protected $errors  = array(
        'form'=>array(),
        'server'=>array(),
    );
    protected $diagnostics = array(
        'time'=>array(
            'server'=>array(
                'received'=>'',
                'sent'=>''
            ),
            'client'=>array(
                'sent'=>'',
                'received'=>''
            )
        )
    );
    protected $passback;
    protected $results;
    protected $callInformation = array(
        'url'=>'',
        'route'=>array(
            'class'=>'',
            'method'=>''
        ),
        'clientSideId'=>''
    );
    protected $logId = null;
    protected $routeRequiresAuth = null;



    public function loadFromReceivedAjaxCall($input,$shortClass,$shortMethod) {
        $this->setInputData(array_key_exists('data',$input) ? $input['data'] : array());

        $this->setUrl($shortClass . '@' . $shortMethod); // = $shortClass . '@' . $shortMethod; //$this->parseRouteFromString($route);
        $callTo = RouteMapper::getAjaxRouteClassAndMethodFromShortName($shortClass,$shortMethod);
        $this->setRoute($callTo['class'],$callTo['method']);
        $this->setRouteRequiresAuth($callTo['requiresAuth']);

        if(!Auth::check()) { // user is not logged in
            if($this->doesRouteRequireAuth()) {
                throw new Exception('Route requires authentication');
            }
        }
        else {
            if($this->doesRouteRequireAuth()) {
                $this->loadUserInformationFromCache();
            }
        }

        $this->setClientSentTime($input['diagnostics']['time']['local']['sent']);
        $this->setServerReceivedTime();
        $this->setClientSideId($input['call']['id']);

        if(array_key_exists('passback',$input)) { $this->addPassback($input['passback']); }
    }
    public function setRouteRequiresAuth($value) {
        if(!is_bool($value)) {
            throw new Exception('setRouteRequiresAuth requires a boolean input value');
        }
        $this->routeRequiresAuth = $value;
    }
    public function doesRouteRequireAuth() {
        if(is_null($this->routeRequiresAuth)) {
            throw new Exception('Checked if route requires auth before it was set');
        }
        return $this->routeRequiresAuth;
    }
    public function getRoute() {
        return $this->callInformation['route'];
    }
    public function getClass() {
        return $this->callInformation['route']['class'];
    }
    public function getMethod() {
        return $this->callInformation['route']['method'];
    }
    public function setResults($results) {
        $this->results = $results;
    }
    public function setInputData($input) {
        $this->inputData = $input;
    }
    public function getInputData() {
        return $this->inputData;
    }
    public function getCallInformation() {
        return $this->callInformation;
    }
    public function getDiagnostics() {
        return $this->diagnostics;
    }


    public function loadUserInformationFromCache() {
        $this->setUserId(Auth::user()->id);
        $PAGE = (new SessionManager())->reviveSessionFromCache();
        $this->setRoleId($PAGE->getCurrentRoleId());
        $this->setSchoolId($PAGE->getCurrentSchoolId());
    }

    public function getUserId()
    {
        return $this->userId;
    }
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }
    public function getSchoolId()
    {
        return $this->schoolId;
    }
    public function setSchoolId($schoolId)
    {
        $this->schoolId = $schoolId;
    }
    public function getRoleId()
    {
        return $this->roleId;
    }
    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;
    }
    public function getLogId()
    {
        return $this->logId;
    }
    public function setLogId($logId)
    {
        $this->logId = $logId;
    }





    public function __construct()
    {

    }
    public function __toString()
    {
       return $this->toJson();
    }







    public function addResults($results) {
        foreach($results as $key=>$value) {
            $this->results[$key] = $value;
        }
    }
    public function getResults() {
        return $this->results;
    }

    public function asArray() {
        return array(
            'user'=>array(
                'userId'=>$this->getUserId(),
                'roleId'=>$this->getRoleId(),
                'schoolId'=>$this->getSchoolId()
            ),
            'input'=>$this->getInputData(),
            'output'=>array(
                'hasErrors'=>$this->inError(),
                'errors'=>$this->getErrors(),
                'results'=>$this->getResults(),
            ),
            'diagnostics'=>$this->getDiagnostics(),
            'route'=>$this->getRoute(),
            'call'=>$this->getCallInformation(),
            'passback'=>$this->getPassbackAsArray()
        );
    }
    public function toJson() {
        return json_encode( $this->asArray() );
    }

    public function inError() {
        return $this->error;
    }
    public function getPassbackAsArray() {
        return $this->passback;
    }
    public function getPassbackValue($key) {
        if(isset($this->passback[$key])) {
            return $this->passback[$key];
        }
        return false;
    }


    public function addPassback(array $pb) {
        foreach($pb as $key=>$value) {
            $this->passback[$key] = $value;
        }
        return $this;
    }
    public function erasePassback(array $keys = array()) {
        if(count($keys) == 0) { $this->passback = array(); }
        else {
            foreach($keys as $idx=>$key) {
                unset($this->passback[$key]);
            }
        }
        return $this;
    }


    public function setUrl($url) {
        $this->callInformation['url'] = $url;
    }
    public function setRoute($routeClass,$routeMethod) {
        $this->callInformation['route']['class'] = $routeClass;
        $this->callInformation['route']['method'] = $routeMethod;
    }
    public function setClientSideId($id) {
        $this->callInformation['clientSideId'] = $id;
    }
    public function setServerReceivedTime($time = false) {
        $this->setDiagnosticTime('server','received',$time);
    }
    public function setServerSentTime($time = false) {
        $this->setDiagnosticTime('server','sent',$time);
    }
    public function setClientSentTime($time = false) {
        $this->setDiagnosticTime('client','sent',strtotime($time));
    }
    public function setClientReceivedTime($time = false) {
        $this->setDiagnosticTime('client','received',strtotime($time));
    }
    private function setDiagnosticTime($side,$end,$time = false) {
        if($time === false) {
            $time = \Carbon\Carbon::now();
        }
        $this->diagnostics['time'][$side][$end] = \Carbon\Carbon::parse($time);
    }
    public function addError($message, $type = 'server') {
        $this->errors[$type][] = $message;
        $this->error = true;
    }
    public function getErrors() {
        return $this->errors;
    }
    public function log() {
        $callRecord = new ApiCalls();
        $callRecord->userId = $this->getUserId();
        $callRecord->information = base64_encode($this->toJson());
        $callRecord->routeClass = $this->getClass();
        $callRecord->routeMethod = $this->getMethod();
        $callRecord->roleId = $this->getRoleId();
        $callRecord->schoolId = $this->getSchoolId();
        $callRecord->save();
        $logId = $callRecord->id;
        $this->setLogId($logId);
    }
    public function removeInputByKey($key) {
        unset($this->inputData[$key]);
    }
}