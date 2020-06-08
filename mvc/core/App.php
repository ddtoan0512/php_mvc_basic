<?php 

class App {

    // http://localhost/live/Home/SayHi/1/2/3

    protected $controller = "Home";
    protected $action = "SayHi";
    protected $params=[];

    function __construct(){
        //Array ( [0] => Home [1] => SayHi [2] => 1 [3] => 2 [4] => 3 )
        $arr = $this->UrlProcess();

        //handle controller
        if( file_exists("./mvc/controllers/" . $arr[0] . ".php")){
            $this->controller = $arr[0];
            unset($arr[0]);
        }
        require_once "./mvc/controllers/". $this->controller .".php";

        // handle action
        if(isset($arr[1])){
            if(method_exists($this->controller, $arr[1])){
                $this->action = $arr[1];
            }
            unset($arr[1]);
        }

        // handle params
        $this->params = $arr ? array_values($arr): [];

        call_user_func_array([$this->controller, $this->action], $this->params);
    }
    
    function UrlProcess(){    
        // Home/SayHi/1/2/3
        // if(isset($_SERVER["REQUEST_URI"])){
        //     return explode("/", filter_var(trim($url = $_SERVER["REQUEST_URI"], "/")));
        // }
        if(isset($_GET['url'])){
            return explode("/", filter_var(trim($url = $_GET['url'], "/")));
        }
    }
}

?>