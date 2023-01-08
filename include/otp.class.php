<?php

class otp{

    private function send_otp($email,$subject,$body,$current_date_time){
        
    }
    function get_otp($email,$subject,$body,$current_date_time){
        $this->send_otp($email,$subject,$body,$current_date_time);
    }
}