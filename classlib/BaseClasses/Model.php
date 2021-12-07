<?php
/* 
 * Class - generic model parent class
 *
 * 
 */

class Model {
	//class properties
    protected $loggedin; //boolean - user logged in state
    protected $modelType; //String - identifues the type of model (eg USER, ADMINISTRATOR)
	
    //constructor method
    function __construct($modelType,$loggedinState) {  //constructor  
        //initialise the model
        $this->loggedin=$loggedinState;
        $this->modelType=$modelType;
    } //end METHOD - constructor
        
    public function getDiagnosticInfo(){
        echo '<div class="container-fluid"   style="background-color: #AAAAAA">'; //outer DIV
            echo '<h3>'.strtoupper($this->modelType).'  (MODEL CLASS) properties</h3>';
            echo '<table border=1 border-style: dashed; style="background-color: #EEEEEE" >';
            echo '<tr><th>PROPERTY</th><th>VALUE</th></tr>';
            echo "<tr><td>pageTitle</td>    <td>".$this->pageTitle."</td></tr>";
            echo "<tr><td>pageHeading</td>  <td>".$this->pageHeading."</td></tr>";
            echo "<tr><td>panelHead_1</td>  <td>$this->panelHead_1</td></tr>";
            echo "<tr><td>panelContent_1</td><td>$this->panelContent_1</td></tr>";
            echo "<tr><td>panelHead_2</td>  <td>$this->panelHead_2</td></tr>";
            echo "<tr><td>panelContent_2</td><td>$this->panelContent_2</td></tr>";
            echo "<tr><td>panelHead_3</td>  <td>$this->panelHead_3</td></tr>";
            echo "<tr><td>panelContent_3</td><td>$this->panelContent_3</td></tr>";
            echo "<tr><td></td><td>         </td></tr>";
            echo "<tr><td></td><td>         </td></tr>";
            echo '</table>';
            echo '<p><hr>';
        echo '</div>';
    }//END METHOD:  getDiagnosticInfo()
} //end CLASS

//        public function getPageTitle(){return $this->pageTitle;}
//        public function getPageHeading(){return $this->pageHeading;}
//        public function getPanelHead_1(){return $this->panelHead_1;}
//        public function getPanelContent_1(){return $this->panelContent_1;}
//        public function getPanelHead_2(){return $this->panelHead_2;}
//        public function getPanelContent_2(){return $this->panelContent_2;}
//        public function getPanelHead_3(){return $this->panelHead_3;}
//        public function getPanelContent_3(){return $this->panelContent_3;}