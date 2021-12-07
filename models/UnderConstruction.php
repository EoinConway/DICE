<?php
/**
 * Class: UnderConstruction
 * 
 * This is a template/empty class that provides 'under construction' content.
 * 
 * It handles bot logged in and not logged in usee cases. 
 *
 * @author gerry.guinane
 * 
 */

class UnderConstruction extends Model{

//CLASS properties
    protected $pageTitle;         //String: containing page title
    protected $pageHeading;       //String: Containing Page Heading
    protected $panelHead_1;       //String: Panel 1 Heading
    protected $panelHead_2;       //String: Panel 2 Heading
    protected $panelHead_3;       //String: Panel 3 Heading
    protected $panelContent_1;    //String: Panel 1 Content
    protected $panelContent_2;    //String: Panel 2 Content     
    protected $panelContent_3;    //String: Panel 3 Content    

//CLASS methods	

    //METHOD: constructor 
    function __construct($loggedin,$pageTitle,$pageHead) {   
        parent::__construct('Under Construction',$loggedin);

        //set the PAGE title
        $this->setPageTitle($pageTitle);

        //set the PAGE heading
        $this->setPageHeading($pageHead);

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
        if($this->loggedin){
            $this->panelHead_1='<h3>Panel 1</h3>';   
        }
        else{        
            $this->panelHead_1='<h3>Panel 1</h3>'; 
        }       
    }//end METHOD - //set the panel 1 heading
    public function setPanelContent_1(){//set the panel 1 content
        if($this->loggedin){
            $this->panelContent_1="Panel 1 content for <b>$this->pageHeading</b> menu item is under construction.  This message appears if user is in logged ON state.";
        }
        else{        
            $this->panelContent_1="Panel 1 content for <b>$this->pageHeading</b> menu item is under construction.  This message appears if user is in logged OFF state.";;
        }
    }//end METHOD - //set the panel 1 content        

    //Panel 2
    public function setPanelHead_2(){ //set the panel 2 heading
        if($this->loggedin){
            $this->panelHead_2='<h3>Panel 2</h3>';   
        }
        else{        
            $this->panelHead_2='<h3>Panel 2</h3>'; 
        }
    }//end METHOD - //set the panel 2 heading        
    public function setPanelContent_2(){//set the panel 2 content
        if($this->loggedin){
            $this->panelContent_2="Panel 2 content for <b>$this->pageHeading</b> menu item is under construction.  This message appears if user is in logged ON state.";;
        }
        else{        
            $this->panelContent_2="Panel 2 content for <b>$this->pageHeading</b> menu item is under construction.  This message appears if user is in logged OFF state.";;
        }
    }//end METHOD - //set the panel 2 content  

    //Panel 3
    public function setPanelHead_3(){ //set the panel 3 heading
        if($this->loggedin){
            $this->panelHead_3='<h3>Panel 3</h3>';   
        }
        else{        
            $this->panelHead_3='<h3>Panel 3</h3>'; 
        }
    } //end METHOD - //set the panel 3 heading
    public function setPanelContent_3(){ //set the panel 2 content
        if($this->loggedin){
            $this->panelContent_3="Panel 3 content for <b>$this->pageHeading</b> menu item is under construction.  This message appears if user is in logged ON state.";;
        }
        else{        
            $this->panelContent_3="Panel 3 content for <b>$this->pageHeading</b> menu item is under construction.  This message appears if user is in logged OFF state.";;
        }
    }  //end METHOD - //set the panel 3 content        


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
        
        
}//end class
        