<?php
require_once '../lib/Database.php';
require_once '../helpers/Format.php';

/**
 * Created by PhpStorm.
 * User: Przemo
 * Date: 2017-07-11
 * Time: 19:47
 */
class Category {

    private $db;
    private $fm;

    /**
     * Category constructor.
     */
    public function __construct() {

        $this->db = new Database();
        $this->fm = new Format();
    }

    public function catInsert($catName) {

        $catName = $this->fm->validation($catName);
        $catName = mysqli_real_escape_string($this->db->link, $catName);

        if (empty($catName)) {

            $msg = "<span class='error'>Wpisz nazwę KATEGORII produktu, którą chcesz dodać!</span>";
            return $msg;
        } else {

            $query = "INSERT INTO `tbl_category` (`catName`) VALUES ('$catName')";
            $catInsert = $this->db->insert($query);

            if ($catInsert) {

                $msg = "<span class='success'>Kategoria produktu zostala dodana!</span>";
                return $msg;
            } else {

                $msg = "<span class='error'>Kategoria produktu nie zostala dodana!</span>";
                return $msg;
            }
        }
    }

    public function getAllCat() {

        $query = "SELECT * FROM tbl_category ORDER BY catId DESC";
        $result = $this->db->select($query);
        return $result;
    }
}