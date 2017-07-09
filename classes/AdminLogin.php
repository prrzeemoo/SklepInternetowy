<?php

//require_once '../lib/Session.php';
//Session::checkSession();
require_once '../lib/Database.php';
require_once '../helpers/Format.php';


/**
 * Created by PhpStorm.
 * User: Przemo
 * Date: 2017-07-09
 * Time: 19:45
 */
class AdminLogin {
    private $db;
    private $fm;

    public function __construct() {

        $this->db = new Database();
        $this->fm = new Format();
    }

    public function adminLogin($adminUser, $adminPass) {

        $adminUser = $this->fm->validation($adminUser);
        $adminPass = $this->fm->validation($adminPass);

        $adminUser = mysqli_real_escape_string($this->db->link, $adminUser);
        $adminPass = mysqli_real_escape_string($this->db->link, $adminPass);

        if (empty($adminUser) || empty($adminPass)) {

            $loginmsg = "Użytkownik lub Hasło nie może pozostać nieuzupełnione!";
            return $loginmsg;
        } else {

            $query = "SELECT * FROM tbl_admin WHERE adminUser = '$adminUser' AND adminPass = '$adminPass'";

            $result = $this->db->select($query);

            if ($result != false) {

                $value = $result->fetch_assoc();
            }
        }
    }

}