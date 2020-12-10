<?php

require_once __DIR__ . "/classes/myclassautoloader.php";

class CategoryGrp{
    public $mysqli;
    public $pdoConnection;
    function __construct(){
        $this->mysqli = new mysqli("localhost","root","","ecommerce");
        $this->pdoConnection = new DbConn();
    }
    

    
    public function noofProduct($id, $totalProduct){
        $innersql = "SELECT cg.categoryId AS ID,c.Name from catetory_relations cg LEFT JOIN category c ON cg.categoryId = c.Id where cg.ParentcategoryId='".$id."'";

        $stmt = $this->pdoConnection->conn->prepare($innersql);
        $stmt->execute();
        $rowcount = $stmt->rowCount();

        if($rowcount != 0)
        {
            while($row = $stmt->fetch())
            {
                $cid = $row['ID'];
                $totalProduct = $this->noofProduct($cid,$totalProduct);
            }
            return $totalProduct;

        }else{
            $stmt = $this->pdoConnection->conn->prepare("SELECT Id from item where Number IN(SELECT ItemNumber from item_category_relations where categoryId='$id')");
            $stmt->execute();
            $countProduct = $stmt->rowCount();
            $countTotal = $totalProduct + $countProduct;

            return $countTotal;
        }

        
    }

    public function print_menu($id) 
    {
        $innersql = "SELECT cg.categoryId AS ID,c.Name from catetory_relations cg LEFT JOIN category c ON cg.categoryId = c.Id where cg.ParentcategoryId='".$id."'";

        $stmt = $this->pdoConnection->conn->prepare($innersql);
        $stmt->execute();
        $rowcount = $stmt->rowCount();

        if($rowcount != 0)
        {
            echo "<ul>";
            while($row = $stmt->fetch())
            {
                $cid = $row['ID'];

                $countProduct = $this->noofProduct($cid,0);
                echo "<li>".$row['Name']."(".$countProduct.")</li>";
                $this->print_menu($row['ID']);
            }
            echo "</ul>";
        }
    }


    public function category(){
        $sql = "SELECT cr.ParentcategoryId as id,c.Name  From catetory_relations cr LEFT JOIN category c ON cr.ParentcategoryId = c.Id group by cr.ParentcategoryId";
        $stmt = $this->pdoConnection->conn->prepare($sql);
        $stmt->execute();

        while($row = $stmt->fetch())
        {
            $countProduct = $this->noofProduct($row['id'],0);
            echo "<li>". $row['Name']. "(". $countProduct . ")";
            $this->print_menu($row['id']);
            echo "</li>";
        }
    }

}




$obj = new CategoryGrp();
$obj->category();

?>
