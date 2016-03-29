<?php
class Product extends Model{

    public function getProduct(){
        $sql = "select * from product where 1";

        return $this->db->query($sql);
    }
    public function getByProductId($id){
        $id_p = $this->db->escape($id);
        $sql = "select * from product where id = '{$id}' limit 1";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }

    public function save($data, $id = null){
        if ( !isset($data['name']) || !isset($data['price']) || !isset($data['description'])){
            return false;
        }
        $id = (int)$id;
        $name = $this->db->escape($data['name']);
        $code = $this->db->escape($data['code']);
        $price = $this->db->escape($data['price']);
        $brand = $this->db->escape($data['brand']);
        $image = $this->db->escape($data['image']);
        $description = $this->db->escape($data['description']);
        $status = isset($data['status']) ? 1 : 0;
        $is_new = isset($data['is_new']) ? 1 : 0;
        $is_recommended = isset($data['is_recommended']) ? 1 : 0;
        if ( !$id ) {
            $sql = "
            insert into product
                set name = '{$name}',
                    code = '{$code}',
                    price = '{$price}',
                    brand = '{$brand}',
                    image = '{$image}',
                    description = '{$description}',
                    status = {$status},
                    is_new = {$is_new},
                    is_recommended = {$is_recommended}
            ";
        } else {
            $sql = "
              update product
                set name = '{$name}',
                    code = '{$code}',
                    price = '{$price}',
                    brand = '{$brand}',
                    image = '{$image}',
                    description = '{$description}',
                    status = {$status},
                    is_new = {$is_new},
                    is_recommended = {$is_recommended}
                    where id = {$id}
            ";
        }
        return $this->db->query($sql);
    }

    public function delete($id){
        $id = (int)$id;
        $sql = "delete from product where id = {$id}";
        return $this->db->query($sql);
    }

}

/*
/*
const SW_BY_DEFAULT = 10;
public function getLatestProducts($count = self::SHOW_BY_DEFAULT){
   $count = intval($count);
   $productList = array();
   $sql = 'SELECT id, name, price, image, is_new FROM product'
       . 'WHERE status = "1"'
       . 'ORDER BY id DESC'
       . 'LIMIT' . $count;
   $result = $this->db->query($sql);
   $i = 0;
   while ($row = $result->fetch()){
       $productList[$i]['id'] = $row['id'];
       $productList[$i]['name'] = $row['name'];
       $productList[$i]['image'] = $row['image'];
       $productList[$i]['price'] = $row['price'];
       $productList[$i]['is_new'] = $row['is_new'];
       $i++;    }
   return $productList;} */