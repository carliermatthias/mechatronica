<?php

require_once  "database.php";
$db = Database::getInstance();

class cmdlist{
    private static $cmdlistInstance = null;
    private $cmdlist=[]; // Lege Array aanmaken en overschrijven bij opvragen van een route


    public static function getInstance() {
        if (is_null(self::$cmdlistInstance)) {
            self::$cmdlistInstance = new cmdlist();
        }
        return self::$cmdlistInstance;
    }


    public function newCommandlist(){
        $cmdlist=[];
        return $cmdlist;
    }
    
    public function addCommand($command, $time){
        $newcmd=[$command,$time];
        $cmdlist=array_push($newcmd);
        return $cmdlist;
    }



    // DIT MOET NIET HIER! MOET IN DE FRONTEND GEPLAATST WORDEN
    //BEGIN
    public function getCommands($cmdlist){ //alle commands gaan overlopen
        for ($i=0;$i<count($cmdlist);$i++){
            ?> <li> <?php $cmdlist[$i][0] + ": " + $cmdlist[$i][1] ?> </li> <?php
       
        }
    }
    //END
    
    public function getCommandlist($routeid){ // Lege array gaan overschrijven met bestaande command array
        $route=$db->getRouteById($routeid);
        $cmdlist=$route->commands;
        return $cmdlist; // array met commands returnen
    }

    public function updateCommandlist($id,$cmdlist){
        $db->updateRoute($id,$cmdlist);
    }

}
?>