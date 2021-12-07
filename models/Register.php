<?php
/**
 * Class: Register
 *
 * This class processes a user registration form 
 * 
 * 
 * @author gerry.guinane
 * 
 */

class Register extends Model{
    
//CLASS properties
    protected $db;                //MySQLi object: the database connection ( 
    protected $user;              //object of User class
    protected $pageTitle;         //String: containing page title
    protected $pageHeading;       //String: Containing Page Heading
    protected $postArray;         //Array: Containing copy of $_POST array
    protected $panelHead_1;       //String: Panel 1 Heading
    protected $panelHead_2;       //String: Panel 2 Heading
    protected $panelHead_3;       //String: Panel 3 Heading
    protected $panelContent_1;    //String: Panel 1 Content
    protected $panelContent_2;    //String: Panel 2 Content     
    protected $panelContent_3;    //String: Panel 3 Content        
        
//CLASS methods	

//
	//METHOD: constructor 
	function __construct($postArray,$pageTitle,$pageHead,$database, $user)
	{   
            parent::__construct('Register',$user->getLoggedinState());
            
            $this->db=$database;

            $this->user=$user;
            
            //set the PAGE title
            $this->setPageTitle($pageTitle);
            
            //set the PAGE heading
            $this->setPageHeading($pageHead);

            //get the postArray
            $this->postArray=$postArray;
            
            //set the FIRST panel content
            $this->setPanelHead_1();
            $this->setPanelContent_1();


            //set the DECOND panel content
            $this->setPanelHead_2();
            $this->setPanelContent_2();
        
            //set the THIRD panel content
            $this->setPanelHead_3();
            $this->setPanelContent_3();
	}
        //END METHOD: constructor 
        
        //setter methods
        
        //headings
        public function setPageTitle($pageTitle){ //set the page title    
                $this->pageTitle=$pageTitle;
        }  //end METHOD -   set the page title       
        public function setPageHeading($pageHead){ //set the page heading  
                $this->pageHeading=$pageHead;
        }  //end METHOD -   set the page heading
        
        //Panel 1
        public function setPanelHead_1(){//set the panel 1 heading
                $this->panelHead_1='<h3 class="text-center">Account Registration</h3>'; 
        }//end METHOD - //set the panel 1 heading
        public function setPanelContent_1(){//set the panel 1 content 
             $this->panelContent_1 = file_get_contents('forms/form_accountRegistration.html');  //this reads an external form file into the string          
        }//end METHOD - //set the panel 1 content        

        //Panel 2
        public function setPanelHead_2(){ //set the panel 2 heading  
        }//end METHOD - //set the panel 2 heading     
        public function setPanelContent_2(){//set the panel 2 content
            //process the registration button
            if (isset($this->postArray['btnRegUser'])){  //check the user reg button is pressed
                if(isset($_POST['g-recaptcha-response'])){
                    $captcha=$_POST['g-recaptcha-response'];//check if captcha verified
                  }
                  if(!$captcha){
                    $this->panelContent_2 .= '<p><i>Please check the the captcha form.</i></p>';
                  }
                else if ($this->postArray['password']===$this->postArray['password-repeat']){  //verify passwords match
                    //process the registration data
                    $userTable=new UserTable($this->db);
                    if ($userTable->addRecord($this->postArray,true)){  //call the user::registration() method.                    
                        $userTable->sendRegistrationEmail($this->postArray['email']);//send email confirmation to entered address
                        $this->panelContent_2.='<h3 class="text-success">REGISTRATION SUCCESSFUL</h3>';
                        }
                    else{
                        $this->panelContent_2.='<h3 class="text-danger">REGISTRATION NOT SUCCESSFUL</h3>';
                        }                     
                }
                else{//passwords don't match
                    $this->panelContent_2='<h3 class="text-danger">Passwords do not Match</h3>';
                }
            }
            else if (isset($this->postArray['btnRegEventAdmin'])){  //check the event admin reg button is pressed
                if(isset($_POST['g-recaptcha-response'])){
                    $captcha=$_POST['g-recaptcha-response'];//check if captcha verified
                  }
                  if(!$captcha){
                    $this->panelContent_2 .= '<p><i>Please check the the captcha form.</i></p>';
                  }
                else if ($this->postArray['password']===$this->postArray['password-repeat']){  //verify passwords match
                    //process the registration data
                    $eventAdminTable=new EventAdminTable($this->db);
                    if ($eventAdminTable->addRecord($this->postArray,true)){  //call the user::registration() method.                    
                        $eventAdminTable->sendRegistrationEmail($this->postArray['email']);//send email confirmation to entered address
                        $this->panelContent_2.='<h3 class="text-success">REGISTRATION SUCCESSFUL</h3>';
                        }
                    else{
                        $this->panelContent_2.='<h3 class="text-danger">REGISTRATION NOT SUCCESSFUL</h3>';
                        }                     
                }
                else{//passwords don't match
                    $this->panelContent_2='<h3 class="text-danger">Passwords do not Match</h3>';
                }
            }
            else{
                $this->panelContent_2='Please enter details in the form';
            }           
        }//end METHOD - //set the panel 2 content  
        
        //Panel 3
        public function setPanelHead_3(){ //set the panel 3 heading       
                $this->panelHead_3='<h3>Panel 3</h3>';             
        } //end METHOD - //set the panel 3 heading
        public function setPanelContent_3(){ //set the panel 2 content      
                $this->panelContent_3='Panel 3 content - under construction';
        }  //end METHOD - //set the panel 2 content        
       

        //getter methods
        public function getPageTitle(){return $this->pageTitle;}
        public function getPageHeading(){return $this->pageHeading;}
        public function getMenuNav(){return $this->menuNav;}
        public function getPanelHead_1(){return $this->panelHead_1;}
        public function getPanelContent_1(){return $this->panelContent_1;}
        public function getPanelHead_2(){return $this->panelHead_2;}
        public function getPanelContent_2(){return $this->panelContent_2;}
        public function getPanelHead_3(){return $this->panelHead_3;}
        public function getPanelContent_3(){return $this->panelContent_3;}
        public function getUser(){return $this->user;}

        
}//end class
        