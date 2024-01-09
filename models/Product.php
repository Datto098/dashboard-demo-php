<?php
class Product extends Db
{
    //Viet phuong thuc lay ra tat ca san pham moi nhat
    function getAllProducts($page, $perPage)
    {
        $sql = self::$connection->prepare("SELECT * 
        FROM products,manufactures,protypes 
        WHERE products.manu_id = manufactures.manu_id
        AND products.type_id = protypes.type_id
        ORDER BY id DESC
        LIMIT ?, ?");
        $sql->bind_param("ii", $page, $perPage);
        $sql->execute(); //return an object
        $items = array();
        $items = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        return $items; //return an array
    }

    public function getTotalProduct()
    {
        $sql = parent::$connection->prepare("SELECT count(*) as 'total' FROM `products`");
        $sql->execute();
        return $sql->get_result()->fetch_all(MYSQLI_ASSOC)[0]['total'];
    }

    public function addProduct($name, $manuId, $typeId, $price, $image, $description, $feature)
    {
        $sql = parent::$connection->prepare("INSERT INTO `products`(name, manu_id, type_id, price, pro_image, description, feature) VALUES(?,?,?,?,?,?,?)");
        $sql->bind_param("siiissi", $name, $manuId, $typeId, $price, $image, $description, $feature);
        return $sql->execute();
    }

    public function deleteProduct($productId)
    {
        $sql = parent::$connection->prepare("DELETE FROM `products` WHERE id = ?");
        $sql->bind_param("i", $productId);
        return $sql->execute();
    }

    public function getProductById($productId)
    {
        $sql = parent::$connection->prepare("SELECT * 
        FROM products,manufactures,protypes 
        WHERE products.manu_id = manufactures.manu_id
        AND products.type_id = protypes.type_id AND products.id = ?");
        $sql->bind_param("i", $productId);
        $sql->execute();
        return $sql->get_result()->fetch_all(MYSQLI_ASSOC)[0];
    }

    public function editProduct($id, $name, $manuId, $typeId, $price, $image, $description, $feature)
    {
        $sql = parent::$connection->prepare("UPDATE `products` SET name = ?, manu_id = ?, type_id = ?, price = ? , pro_image = ?, description = ?, feature = ? WHERE id = ?");
        $sql->bind_param("siiissii", $name, $manuId, $typeId, $price, $image, $description, $feature, $id);
        return $sql->execute();
    }

    public function searchProduct($searchValue, $page, $perPage)
    {
        $sql = parent::$connection->prepare("SELECT *
        FROM (
            SELECT products.*, manufactures.manu_name, protypes.type_name
            FROM products
            INNER JOIN manufactures ON products.manu_id = manufactures.manu_id
            INNER JOIN protypes ON products.type_id = protypes.type_id
        ) AS combined_data
        WHERE id = ? OR name LIKE ? OR description LIKE ? OR type_name LIKE ? OR manu_name LIKE ? LIMIT ?, ?;
    ");
        $param = "%" . $searchValue . "%";
        $sql->bind_param("sssssii", $searchValue, $param, $param, $param, $param, $page, $perPage);
        $sql->execute();
        return $sql->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function amountResultSearch($searchValue)
    {
        $sql = parent::$connection->prepare("SELECT COUNT(*) as total
        FROM (
            SELECT products.*, manufactures.manu_name, protypes.type_name
            FROM products
            INNER JOIN manufactures ON products.manu_id = manufactures.manu_id
            INNER JOIN protypes ON products.type_id = protypes.type_id
        ) AS combined_data
        WHERE id = ? OR name LIKE ? OR description LIKE ? OR type_name LIKE ? OR manu_name LIKE ?;
    ");
        $param = "%" . $searchValue . "%";
        $sql->bind_param("sssss", $searchValue, $param, $param, $param, $param);
        $sql->execute();
        return $sql->get_result()->fetch_all(MYSQLI_ASSOC)[0]["total"];
    }
}
