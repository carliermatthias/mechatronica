<?php

/**
 * User: Matthias
 * Date: 29/10/2019
 * Time: 09:35
 */
require_once  "config.php";

class Database {

    private static $DatabaseInstance = null;
    private $db;

    private function __construct() {
        try {
            $server = config::getInstance()->getServer();
            $db = config::getInstance()->getDatabase();
            $user = config::getInstance()->getUsername();
            $pass = config::getInstance()->getPassword();

            $this->db = new PDO("mysql:host=$server; dbname=$db", $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getInstance() {
        if (is_null(self::$DatabaseInstance)) {
            self::$DatabaseInstance = new Database();
        }
        return self::$DatabaseInstance;
    }

    public function close() {
        $this->db = null;
    }

    public function sanitize($value){
        $value = trim($value);
        $value = stripslashes($value);
        $value = htmlentities($value, ENT_QUOTES);
        //if is_string($value) {$value = filter_var($value, FILTER_SANITIZE_STRING);};
        //if is_integer($value){$value = filter_var($value, FILTER_SANITIZE_NUMBER_INT);};
        return $value;

    }


    // START USERS

    public function getId($email){
        $email = $this->sanitize($email);
        try {
            $sql = "SELECT id FROM users WHERE email =:email";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            $id = $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $e){
            die();
        }

            
            return $id[0]->id;
        
    
    }

    public function addStandardUser($naam, $wachtwoord,$email) {
        $naam = $this->sanitize($naam);
        $email = $this->sanitize($email);
        $result=false;
        try {
            $sql = "INSERT INTO users(name, ww, role, email)
                    VALUES(:name,:ww,:role,:email)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":name", $naam);
            $role=0;
            
            $wachtwoord = password_hash(hash('sha512', $wachtwoord, true), PASSWORD_BCRYPT);
            $stmt->bindParam(":ww", $wachtwoord);
            $stmt->bindParam(":role", $role);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            $result=true;
        } catch (PDOException $e) {
            $result=false;
            die();
        }
        return $result;
    }


    public function addUser($naam, $wachtwoord, $role, $email) {
        $role = $this->sanitize($role);
        $naam = $this->sanitize($naam);
        $email = $this->sanitize($email);
        $result=false;
        try {
            $sql = "INSERT INTO users(name, ww, role, email)
                    VALUES(:name,:ww,:role, :email)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":name", $naam);
            
            $wachtwoord = password_hash(hash('sha512', $wachtwoord, true), PASSWORD_BCRYPT);
            $stmt->bindParam(":ww", $wachtwoord);
            $stmt->bindParam(":role", $role);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            $result=true;
            return true;
        } catch (PDOException $e) {
            $result=false;
            die();
        }
    }

    private function checkCredentials($email) {
        $email = $this->sanitize($email);
        try {
            $sql = "SELECT * from users WHERE email = :email";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $e) {
            die();
        }
        return $results;
    }

    public function checkLogin($email, $ww) {
        $user = $this->checkCredentials($email);
        return(!empty($user) && password_verify(hash('sha512', $ww, true), $user[0]->ww) ? true : false);
    }

    public function checkEmail($email){
        $email = $this->sanitize($email);
        try {
            $sql = "SELECT * from users WHERE email = :email";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $e) {
            die();
        }
        return (empty($results));
    }

    public function getName($email){
        $email = $this->sanitize($email);
        try {
            $sql = "SELECT * FROM users WHERE email =:email";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            $name = $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $e){
            die();
        }

       
            return $name[0]->name;
        
    
}

    public function getRole($name){
        $name = $this->sanitize($name);
        try {
            $sql = "SELECT role FROM users WHERE name =:name";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":name", $name);
            $stmt->execute();
            $role = $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $e){
            die();
        }
        return $role[0]->role; // 0 = user | 1 = admin
    }

    public function deleteUser($id, $name){
        $idcheck = $this->getId($name); // check if name isn't modified for malicious actions
        $id = $this->sanitize($id);
        $name = $this->sanitize($name);
        if ($idcheck == $id){
            try {
                $sql = "DELETE FROM users WHERE id = :id AND name = :name";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":id", $id);
                $stmt->bindParam(":name", $name);
                $stmt->execute();
                
            } catch (PDOException $e){
                die();
            }
        }
       
        
    }
    public function editUsername($id, $name){
        $id = $this->sanitize($id);
        $name = $this->sanitize($name);
        
            try {
                $sql = "UPDATE users SET name=:name WHERE id = :id";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":id", $id);
                $stmt->bindParam(":name", $name);
                $stmt->execute();
                
            } catch (PDOException $e){
                die();
            }
        
    }

    public function editEmail($id, $email){
        $id = $this->sanitize($id);
        $email = $this->sanitize($email);
        
            try {
                $sql = "UPDATE users SET email=:email WHERE id = :id";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":id", $id);
                $stmt->bindParam(":email", $email);
                $stmt->execute();
                
            } catch (PDOException $e){
                die();
            }
        
    }
    public function editPassword($id, $passwd){
        $id = $this->sanitize($id);
        $passwd = $this->sanitize($passwd);
        $wachtwoord = password_hash(hash('sha512', $passwd, true), PASSWORD_BCRYPT);
        
            try {
                $sql = "UPDATE users SET ww=:ww WHERE id = :id";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":id", $id);
                $stmt->bindParam(":ww", $wachtwoord);
                $stmt->execute();
                
            } catch (PDOException $e){
                die();
            }
        
    }

    // END USERS
    // START ROUTES

    public function addRoute($email, $trajectname){
        $userid = $this->getId($email);
        $userid = $this->sanitize($userid);
        $name = $this->sanitize($trajectname);
        try {
            $sql = "INSERT INTO routes (userid, name, commands) VALUES (:userid, :name, '')";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":userid", $userid);
            $stmt->bindParam(":name", $name);
            $stmt->execute();
        } catch (PDOException $e){
            die();
        }
        
    }

    public function getRoutes($email){
        $userid = $this->getId($email);
        $uid = $this->sanitize($userid);
        try {
            $sql = "SELECT * FROM routes WHERE userid = :userid";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":userid", $uid);
            $stmt->execute();
            $routes = $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $e){
            die();
        }
        return $routes;
    }

    public function getRouteById($id){
        $id = $this->sanitize($id);
        try {
            $sql = "SELECT * FROM routes WHERE id =:id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $route = $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $e){
            die();
        }
        return $route[0];
    }

    public function updateRoute($id, $commands){
        $id = $this->sanitize($id);
        $commands = $this->sanitize($commands);
        try {
            $sql = "UPDATE routes SET commands=:commands WHERE id=:id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":commands", $commands);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
        } catch (PDOException $e){
            die();
        }
       
    }

    public function deleteRoute($id){
        $id = $this->sanitize($id);
        try {
            $sql = "DELETE FROM routes WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            
        } catch (PDOException $e){
            die();
        }
        
    }

    // END ROUTES
    // START MEASUREMENTS

    public function addMeasurement($routeid, $data){
        $routeid = $this->sanitize($routeid);
        $data = $this->sanitize($data);
        
        try {
            $sql = "INSERT INTO measurements (routeid, data) VALUES (:routeid, :data)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":routeid", $routeid);
            $stmt->bindParam(":data", $data);
            $stmt->execute();
        } catch (PDOException $e){
            die();
        }
    }

    public function getMeasurementByRouteid($routeid){
        $routeid = $this->sanitize($routeid);
        try {
            $sql = "SELECT * FROM measurements WHERE routeid =:routeid";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":routeid", $routeid);
            $stmt->execute();
            $measurement = $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $e){
            die();
        }
        return $measurement[0];
    }

    public function deleteMeasurement($id){
        $id = $this->sanitize($id);
        try {
            $sql = "DELETE FROM measurements WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            
        } catch (PDOException $e){
            die();
        }
        
    }

    // STOP MEASUREMENTS
}