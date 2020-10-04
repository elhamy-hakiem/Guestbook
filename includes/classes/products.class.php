<?php
require ('dbconn.class.php');
class products extends dbconn
{

    // Add New Product 
    public function addProduct($title,$description,$image,$price,$available,$user_id)
    {
        $stmt = $this->connection()->prepare("INSERT INTO `products`(`title`, `description`, `image`, `price`, `available`, `user_id`) 
                                                             VALUES (:title, :description, :image, :price, :available, :user_id)");
        $result = $stmt->execute(array(
            'title'         => $title,
            'description'   => $description,
            'image'         => $image,
            'price'         => $price,
            'available'     => $available,
            'user_id'       => $user_id
        ));
        if($result)
        {
            return true;
        }
        return false;
    }

    // Update Product 
    public function updateProduct($id,$title,$description,$image,$price,$available)
    {
        $stmt = $this->connection()->prepare("UPDATE `products` 
                                                 SET 
                                                    `title` = :title,
                                                    `description` =:description,
                                                    `image` = :image,
                                                    `price`= :price,
                                                    `available`= :available
                                                WHERE
                                                    `id` = :id");
        $result = $stmt->execute(array(
            'title'         => $title,
            'description'   => $description,
            'image'         => $image,
            'price'         => $price,
            'available'     => $available,
            'id'            => $id
        ));
        if($result)
        {
            return true;
        }
        return false;
    }

    // Delete Product 
    public function deleteProduct($id)
    {
        $stmt = $this->connection()->prepare("DELETE FROM `products` WHERE `id` = :id");
        $stmt ->bindParam(":id",$id);
        $result = $stmt ->execute();
        if($result)
        {
            return true;
        }
        return false;
    }

    // Get All Products 
    public function getProducts($extra='')
    {
        $stmt = $this ->connection() ->prepare("SELECT * FROM `products` $extra ");
        $stmt ->execute();
        $result = $stmt ->fetchAll();
        if($result && count($result) > 0)
        {
            return $result;
        }
        return null;
    }

    // Get Peoduct 
    public function getProduct($id)
    {
        $id = intval($id);
        $products = $this ->getProducts("WHERE `id` = $id ");
        if($products && count($products) > 0 )
        {
            return $products[0];
        }
        return null;
    }

    // Search For Product 
    public function searchProduct($keyword)
    {
        return $this ->getProducts("WHERE `title` LIKE '%$keyword%'");
    }
}