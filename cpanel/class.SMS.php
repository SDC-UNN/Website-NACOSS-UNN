<?php

require_once('class_lib.php');

class SMS {

    private $sender_id;
    private $message;
    private $recipients;
    private $gate_way_url;
    private $gate_way_username;
    private $gate_way_password;
    private $response = NULL;
    private $r_message;
    private $r_usedUnits = 0;
    private $r_unSent = NULL;

    public function __construct($gateway, $username, $password, $sender, $message, $recipients) {
        $this->set_gatewayData($gateway, $username, $password, $sender, $message, $recipients);
    }

    public function send() {
        $this->response = $this->make_request();
        if ($this->response != NULL) {
            $this->process_response();
            return true;
        } else {
            $this->r_message = 'noc';
            return false;
        }
    }

    private function make_request() {
        $ping = checkdnsrr('bulksmsnigeria.net', 'ANY');
        if ($ping) {
            $r = file_get_contents($this->get_url() . '?username=' . $this->get_username() . '&password=' . $this->get_password() . '&sender=' . $this->get_sender() . '&recipient=' . $this->get_recipients() . '&message=' . $this->get_message());
            return $r;
        } else {
            return NULL;
        }
    }

    private function process_response() {
        $r = explode(' ', $this->response);
        $this->r_message = $r[0];
        if ($this->r_message == 'OK') {
            $this->r_usedUnits = $r[1];
            isset($r[2]) ? $this->r_unSent = $r[2] : $this->r_unSent = 'non';
        }
    }

    public function get_responseText() {
        $array = array(
            'OK' => 'Successful',
            '2904' => 'SMS Sending Failed',
            '2905' => 'Invalid username/password combination',
            '2906' => 'Credit exhausted',
            '2907' => 'Gateway unavailable',
            '2908' => 'Invalid schedule date format',
            '2909' => 'Unable to schedule',
            '2910' => 'Username is empty',
            '2911' => 'Password is empty',
            '2912' => 'Recipient is empty',
            '2913' => 'Message is empty',
            '2914' => 'Sender is empty',
            '2915' => 'One or more required fields are empty',
            'noc' => 'Could not connect to SMS gateway');
        return $array[$this->r_message];
    }

    public function get_unitsUsed() {
        return $this->r_usedUnits;
    }

    public function get_unsentNumbers() {
        return $this->r_unSent;
    }

    private function set_url($str) {
        if (strlen($str)) {
            $this->gate_way_url = $str;
        } else {
            die('invalid gateway');
        }
    }

    private function set_username($str) {
        if (strlen($str)) {
            $this->gate_way_username = $str;
        } else {
            die('invalid username');
        }
    }

    private function set_password($str) {
        if (strlen($str)) {
            $this->gate_way_password = $str;
        } else {
            die('invalid password');
        }
    }

    private function set_sender($str) {
        if (strlen($str)) {
            $this->sender_id = $str;
        } else {
            die('invalid sender id');
        }
    }

    private function set_message($str) {
        if (strlen($str)) {
            $this->message = $str;
        } else {
            die('invalid message');
        }
    }

    private function set_recipients($url) {
        if (strlen($url)) {
            $this->recipients = $url;
        } else {
            die('invalid recipients list');
        }
    }

    private function get_url() {
        return $this->gate_way_url;
    }

    private function get_username() {
        return urlencode($this->gate_way_username);
    }

    private function get_password() {
        return urlencode($this->gate_way_password);
    }

    private function get_sender() {
        return urlencode($this->sender_id);
    }

    private function get_message() {
        return urlencode($this->message);
    }

    private function get_recipients() {
        $recipients = explode(',', $this->recipients);
        $array = array();
        foreach ($recipients as $r) {
            if (!in_array($r, $array)) {
                $array[] = $r;
            }
        }
        return implode(',', $array);
    }

    private function set_gatewayData($gateway, $username, $password, $sender, $message, $recipients) {
        $this->set_url($gateway);
        $this->set_username($username);
        $this->set_password($password);
        $this->set_sender($sender);
        $this->set_message($message);
        $this->set_recipients($recipients);
    }

}

?>