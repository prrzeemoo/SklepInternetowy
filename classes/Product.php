<?php
/**
 * Created by PhpStorm.
 * User: Przemo
 * Date: 2017-07-18
 * Time: 17:20
 */

require_once '../lib/Database.php';
require_once '../helpers/Format.php';

class Product {

    private $db;
    private $fm;

    /**
     * Product constructor.
     */
    public function __construct() {

        $this->db = new Database();
        $this->fm = new Format();
    }

    /**
     * @param $data
     * @param $file
     * @return string
     */
    public function productInsert($data, $file) {

        $productName = mysqli_real_escape_string($this->db->link, $data['productName']);
        $catId       = mysqli_real_escape_string($this->db->link, $data['catId']);
        $brandId     = mysqli_real_escape_string($this->db->link, $data['brandId']);
        $body        = mysqli_real_escape_string($this->db->link, $data['body']);
        $price       = mysqli_real_escape_string($this->db->link, $data['price']);
        $type        = mysqli_real_escape_string($this->db->link, $data['type']);

        $dozwolone_rozszerzenia_plikow_graficznych = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $file['image']['name'];
        $file_size = $file['image']['size'];
        $file_temp = $file['image']['tmp_name'];

        $div          = explode('.', $file_name);
        $file_ext     = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $upload_image = "upload/" . $unique_image;

        if ($productName == "" or $catId == "" or $brandId == "" or $body == "" or $price == "" or $file_name == "" or $type == "") {

            $msg = "<span class='error'>Wszystkie Pola Muszą Zostać Uzupełnione!</span>";
            return $msg;

        } elseif ($file_size > 1048567) {

            echo "<span class='error'>Rozmiar pliku nie może być większy niż 1MB!</span>";

        } elseif (in_array($file_ext, $dozwolone_rozszerzenia_plikow_graficznych) === false) {

            echo "<span class='error'>Możesz zamieścić tylko pliki z rozszerzeniem: " . implode(', ', $dozwolone_rozszerzenia_plikow_graficznych) . " </span>";

        } else {

            move_uploaded_file($file_temp, $upload_image);
            $query = "INSERT INTO tbl_product(productName, catId, brandId, body, price, image, type) 
                      VALUES ('$productName', '$catId', '$brandId', '$body', '$price', '$upload_image', '$type')";
            $productInsert = $this->db->insert($query);

            if ($productInsert) {

                $msg = "<span class='success'>Produkt Został Dodany!</span>";
                return $msg;

            } else {

                $msg = "<span class='error'>Produkt Nie Został Dodany!</span>";
                return $msg;
            }
        }
    }

    /**
     * @return bool
     */
    public function getAllProduct() {

        $query = "SELECT p.*, c.catName, b.brandName
                  FROM tbl_product AS p, tbl_category AS c, tbl_brand AS b
                  WHERE p.catId = c.catId AND p.brandId = b.brandId
                  ORDER BY p.productId DESC";
        /*
        $query = "SELECT tbl_product.*, tbl_category.catName, tbl_brand.brandName
                                FROM tbl_product
                                INNER JOIN tbl_category
                                ON tbl_product.catId = tbl_category.catId
                                INNER JOIN tbl_brand
                                ON tbl_product.brandId = tbl_brand.brandId
                                ORDER BY tbl_product.productId DESC";
        */
        $result = $this->db->select($query);
        return $result;
    }

}