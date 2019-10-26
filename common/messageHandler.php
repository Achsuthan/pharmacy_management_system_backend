<?php
class messageHandler
{
    private $code;
    private $details;
    private $status;
    private $message;
    public function __construct($status, $code, $details, $message)
    {
        $this->code = $code;
        $this->details = $details;
        $this->status = $status;
        $this->message = $message;
    }

    function getResponse()
    {
        if ($this->status == "success") {
            $arr = array('code' => $this->code, 'message' => $this->message, 'details' => $this->details);
            return json_encode($arr);
        } else {
            $arr = array('code' => $this->code, 'message' => $this->message, 'details' => $this->details);
            return json_encode($arr);
        }
    }
}
