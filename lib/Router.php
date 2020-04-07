<?php
namespace cmrweb;
class Router
{
    private static $url;
    function __construct()
    {
        if (isset($_GET['url'])) {
            self::$url = explode('/', $_GET['url']);
        }
    }
    public static function route($routes)
    {
        $useremail = isset($_SESSION['user']['email'])?$_SESSION['user']['email']:false;
        $userprenom = isset($_SESSION['user']['prenom'])?$_SESSION['user']['prenom']:false;
        $username = isset($_SESSION['user']['nom'])?$_SESSION['user']['nom']:false;
        $userid = isset($_SESSION['user']['id'])?$_SESSION['user']['id']:false;
        $admin = isset($_SESSION['user']['admin'])?$_SESSION['user']['admin']:false;

        $html = new Html();
        $dev = $_ENV['APP_ENV'] == "dev" ? true : false;
        if(!isset(self::$url[0])){
            self::$url[0] = 'home';    
        }
        if(!in_array(self::$url[0],array_keys($routes))){   
            require "web/pages/erreur.php";
        }elseif(in_array("init",$routes)&& empty(self::$url[1])){   
            require "web/module/init.php";
        }else
        foreach ($routes as $route => $file) {
                if (self::$url[0] == "{$route}" && empty(self::$url[1])) {
                    if(file_exists("web/pages/style/$file.css"))
                    echo "<link rel='stylesheet' href='web/pages/style/$file.css'>";
                    if(file_exists("web/pages/controller/c_$file.php"))
                    require "web/pages/controller/c_$file.php";
                    if(file_exists("web/pages/$file.php"))
                    require "web/pages/$file.php";
                } elseif (self::$url[0] == "{$route}" && !empty(self::$url[1])&& empty(self::$url[2])) {
                    $id = self::$url[1];
                    if(file_exists("web/pages/controller/c_$file.php"))
                    require "web/pages/controller/c_$file.php";
                    if(file_exists("web/pages/$file.php"))
                    require "web/pages/$file.php";
                } elseif (self::$url[0] == "{$route}" && !empty(self::$url[1])&& !empty(self::$url[2])) {
                    $id = self::$url[1];
                    $slug = self::$url[2];
                    if(file_exists("web/pages/controller/c_$file.php"))
                    require "web/pages/controller/c_$file.php";
                    if(file_exists("web/pages/$file.php"))
                    require "web/pages/$file.php";
                }

        }
    }
    
}
