<?php
require_once('db_config.php');
/*
 * Page: Application library
 * */
class Library {

    /*
    * Register New User
    *
    * @param $firstName, $lastName, $email, $password
    * @return ID
    * 
    */    
    public function register($firstName, $lastName, $email, $password) {
        try {
            $db = connectDB();
            $query = $db->prepare("INSERT INTO users(id, firstName, lastName, email, password, registerDate) VALUES (NULL, :firstName,:lastName,:email,:password, CURRENT_TIMESTAMP)");
            $query->bindParam("firstName", $firstName, PDO::PARAM_STR);
            $query->bindParam("lastName", $lastName, PDO::PARAM_STR);
            $query->bindParam("email", $email, PDO::PARAM_STR);
            $enc_password = hash('sha256', $password);
            $query->bindParam("password", $enc_password, PDO::PARAM_STR);
            $query->execute();
            return $db->lastInsertId();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
    * Login
    *
    * @param $username, $password
    * @return $mixed
    *
    */    
    public function login($email, $password) {
        try {
            $db = connectDB();
            $query = $db->prepare("SELECT id FROM users WHERE email=:email AND password=:password");
            $query->bindParam("email", $email, PDO::PARAM_STR);
            $enc_password = hash('sha256', $password);
            $query->bindParam("password", $enc_password, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                $result = $query->fetch(PDO::FETCH_OBJ);
                return $result->id;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
    * get User Details
    *
    * @param $user_id
    * @return $mixed
    *
    */    
    public function userDetails($user_id) {
        try {
            $db = connectDB();
            $query = $db->prepare("SELECT firstName, lastName, email, registerDate FROM users WHERE id=:user_id");
            $query->bindParam("user_id", $user_id, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                return $query->fetch(PDO::FETCH_OBJ);
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
    * Check Email
    *
    * @param $email
    * @return boolean
    * 
    */    
    public function isEmail($email) {

        try {
            $db = connectDB();
            $query = $db->prepare("SELECT id FROM users WHERE email=:email");
            $query->bindParam("email", $email, PDO::PARAM_STR);
            $query->execute();
            $query->rowCount() > 0 ? true : false;
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
    * Get Users skills&grades
    *
    * @param $user_id
    * @return array
    * 
    */    
    public function getGrades($user_id) {
        $tmp = array();
        try {
            $db = connectDB();
            $query = $db->prepare("SELECT * FROM grades WHERE user_id=:user_id", array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $query->bindParam("user_id", $user_id, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                while ($row = $query->fetch(PDO::FETCH_OBJ, PDO::FETCH_ORI_NEXT)) {
                // e nevoie de PDO::FETCH_ORI_NEXT pentru a face FETCH la fiecare row
                // fara PDO::FETCH_ORI_NEXT imi returneaza doar ultimul row din tabela cu rezultatul
                // salvez fiecare row din tabel intr un temporary array ($tmp)
                  array_push($tmp, $row);
                }
                return $tmp;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
    * Get skills list
    *
    * @return array
    * 
    */    
    public function getSkills() {
        $tmp = array();
        try {
            $db = connectDB();
            $query = $db->prepare("SELECT * FROM skills", array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $query->execute();
            if ($query->rowCount() > 0) {
                while ($row = $query->fetch(PDO::FETCH_OBJ, PDO::FETCH_ORI_NEXT)) {
                // e nevoie de PDO::FETCH_ORI_NEXT pentru a face FETCH la fiecare row
                // fara PDO::FETCH_ORI_NEXT imi returneaza doar ultimul row din tabela cu rezultatul
                // salvez fiecare row din tabel intr un temporary array ($tmp)
                  array_push($tmp, $row);
                }
                return $tmp;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
    * Get skills list by week
    *
    * @return array
    * 
    */    
    public function getSkillsByWeek($userID, $week) {
        $tmp = array();
        try {
            $db = connectDB();
            $query = $db->prepare("SELECT * FROM skills WHERE user_id=:UID AND week=:week", array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $query->bindParam("UID", $userID, PDO::PARAM_INT);
            $query->bindParam("week", $week, PDO::PARAM_INT);
            $query->execute();
            if ($query->rowCount() > 0) {
                while ($row = $query->fetch(PDO::FETCH_OBJ, PDO::FETCH_ORI_NEXT)) {
                // e nevoie de PDO::FETCH_ORI_NEXT pentru a face FETCH la fiecare row
                // fara PDO::FETCH_ORI_NEXT imi returneaza doar ultimul row din tabela cu rezultatul
                // salvez fiecare row din tabel intr un temporary array ($tmp)
                  array_push($tmp, $row);
                }
                return $tmp;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
    * Save skill grade
    *
    * @param $user_id
    * @return bool
    * 
    */    
    public function saveGrade($userID, $skillName, $grade, $week) {
        try {
            $db = connectDB();
            $query = $db->prepare("INSERT INTO grades(user_id, skill_name, grade, week) VALUES (:userID, :skillName, :grade, :week)");
            $query->bindParam("userID", $userID, PDO::PARAM_INT);
            $query->bindParam("skillName", $skillName, PDO::PARAM_STR);
            $query->bindParam("grade", $grade, PDO::PARAM_INT);
            $query->bindParam("week", $week, PDO::PARAM_INT);
            $query->execute();
            $query->rowCount() === 1 ? true : false;
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
    * Delete skill
    *
    * @param $user_id, $skill_name, $skill_week
    * @return
    * 
    */    
    public function deleteGrade($user_id, $skill_name, $skill_week) {
        try {
            $db = connectDB();
            $query = $db->prepare("DELETE FROM grades WHERE user_id=:uID AND skill_name=:skillName AND week=:skillWeek");
            $query->bindParam("uID", $user_id, PDO::PARAM_INT);
            $query->bindParam("skillName", $skill_name, PDO::PARAM_STR);
            $query->bindParam("skillWeek", $skill_week, PDO::PARAM_INT);
            $query->execute();
            //$query->rowCount() === 1 ? true : false;
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }    
}