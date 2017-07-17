<?php

require_once '../lib/Database.php';
require_once '../helpers/Format.php';

/**
 * Created by PhpStorm.
 * User: Przemo
 * Date: 2017-07-17
 * Time: 17:26
 */
class Brand {

    private $db;
    private $fm;

    /**
     * Brand constructor.
     */
    public function __construct() {

        $this->db = new Database();
        $this->fm = new Format();
    }

    public function brandInsert($brandName)
    {

        $brandName = $this->fm->validation($brandName);
        $brandName = mysqli_real_escape_string($this->db->link, $brandName);

        if (empty($brandName)) {

            $msg = "<span class='error'>Wpisz nazwę MARKI produktu, którą chcesz dodać!</span>";
            return $msg;

        } else {

            $query = "INSERT INTO `tbl_brand` (`brandName`) VALUES ('$brandName')";
            $brandInsert = $this->db->insert($query);

            if ($brandInsert) {

                $msg = "<span class='success'>Marka produktu została dodana!</span>";
                return $msg;

            } else {

                $msg = "<span class='error'>Marka produktu nie została dodana!</span>";
                return $msg;
            }
        }
    }
}