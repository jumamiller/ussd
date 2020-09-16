<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class onlineUssdController extends Controller
{

    /**
     * @var mixed|null
     */
    private $phoneNumber;
    private $sessionId;
    private $serviceCode;
    private $text;

    public int $level = 0;
    public string $response = "";
    public $ussd_string_exploded;

    public function __construct(Request $request) {
        $this->serviceCode      =$request->get('serviceCode');
        $this->sessionId        =$request->get('sessionId');
        $this->phoneNumber      =$request->get('phoneNumber');
        $this->text             =$request->get('text');

        $this->ussd_string_exploded=explode('*',$this->text);
        $this->level=count($this->ussd_string_exploded);
    }
    public function onlineUssdMenu() {
        /**
         * show the main menu when the user
         * first dials the ussd code
         */

        if($this->text==""){
            $this->displayMainMenu();
        }
        elseif ($this->text=="1"){
            /**
             * display courses offered when the
             * user responds with register option(1)
             */
            $this->displayCourseMenu();
        }
        elseif ($this->text=="1*1"){
            /**
             * course option 1 is Laravel Framework
             * if the user selects $this,prompt user
             * to enter details
             */
            $this->user_first_name();
        }
        elseif (
            $this->ussd_string_exploded[0]==1   &&
            $this->ussd_string_exploded[1]==1   &&
            $this->level                  ==3
        ){
            $this->user_last_name();
        }
        elseif (
            $this->ussd_string_exploded[0]==1   &&
            $this->ussd_string_exploded[1]==1   &&
            $this->level                  ==4
        ){
            $this->user_email_address();
        }
        elseif (
            $this->ussd_string_exploded[0]==1   &&
            $this->ussd_string_exploded[1]==1   &&
            $this->level                  ==5
        ){
            $this->success_registration();
        }

        /**
         * user goes for option 2,sysmphony
         */
        elseif($this->text=="1*2"){
            $this->user_first_name();
        }
        elseif (
            $this->ussd_string_exploded[0]  ==1 &&
            $this->ussd_string_exploded[1]  ==2 &&
            $this->level                    ==3
        ){
            $this->user_last_name();
        }
        elseif (
            $this->ussd_string_exploded[0]  ==1 &&
            $this->ussd_string_exploded[1]  ==2 &&
            $this->level                    ==4
        ){
            $this->user_email_address();
        }
        elseif(
            $this->ussd_string_exploded[0]  ==1 &&
            $this->ussd_string_exploded[1]  ==2 &&
            $this->level                    ==5
        ){
            $this->success_registration();
        }
        elseif ($this->text=="2"){
            $this->about_us();
        }

    }
    public function ussd_proceed($continue){
        echo "CON $continue";
    }
    public function ussd_stop($end){
        echo "END $end";
    }
    public function displayMainMenu(){
        $this->response="Welcome to JKUAT online classes\n";
        $this->response.="1.Register\n";
        $this->response.="2.About JKUAT";

        $this->ussd_proceed($this->response);
    }
    public function displayCourseMenu(){
        $this->response="Choose which framework to learn \n";
        $this->response.="1.Laravel\n";
        $this->response.="2.Symphony";

        $this->ussd_proceed($this->response);
    }

    public function user_first_name(){
        $this->response="Please enter your first name";
        $this->ussd_proceed($this->response);
    }
    public function user_last_name(){
        $this->response="Please enter your last name";
        $this->ussd_proceed($this->response);
    }

    public function user_email_address(){
        $this->response="Please enter your school email";
        $this->ussd_proceed($this->response);
    }
    public function success_registration(){
        $this->response="Congratulations,you have successfully registered for online sessions";
        $this->ussd_stop($this->response);
    }
    public function about_us() {
        $this->response="Jomo Kenyatta University is a leading institution in Africa.visit www.jkuat.ac.ke for more.";
        $this->ussd_stop($this->response);
    }
}
