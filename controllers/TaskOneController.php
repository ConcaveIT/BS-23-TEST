<?php

class TaskOneController{

    public function __construct(){
        $db = new DatabaseClass;
        $this->connection = $db->connection;
    }

    public function getCategories(){

        $parentCategory =  $this->connection->query("SELECT category.Id, category.Name FROM `category` WHERE category.id NOT IN (SELECT categoryId FROM catetory_relations)");
        $parentCategoryId = [];
        if($parentCategory && $parentCategory->num_rows > 0){
            foreach($parentCategory as $parent){
                $parentCategoryId[$parent['Name']] = $parent['Id'];
            }
        }
        $countNumber = [];

        if($parentCategoryId ){
            foreach($parentCategoryId  as $key => $parentId){
                $countNumber[$key] =  isset($countNumber[$key]) ? $countNumber[$key] + $this->_categoryTreeCount($parentId) : $this->_categoryTreeCount($parentId);
                if($subcats = $this->_getChildCategories($parentId)){
                    foreach($subcats as $subcId){
                        $countNumber[$key] += $this->_categoryTreeCount($subcId);
                    }
                }
            }
        }
        arsort($countNumber);
        return  $countNumber;
        
    }


    private function _categoryTreeCount( $parent_id = 0 ){
            $totalItems = 0;
            $query = $this->connection->query("SELECT * FROM catetory_relations WHERE ParentcategoryId = $parent_id");
            if($query->num_rows > 0){
                while($row = $query->fetch_assoc()){
                    $totalItems += $this->_getItemNumberByCategory($row['categoryId']);
                    self::_categoryTreeCount($row['categoryId']);
                }
            }
        return $totalItems;
    }


    private function _getItemNumberByCategory($categoryId){
        $query = $this->connection->query("SELECT * FROM item JOIN item_category_relations ON item.Number=item_category_relations.ItemNumber WHERE item_category_relations.categoryId = $categoryId");
        return $query->num_rows;
    }


    private function _getChildCategories($categoryId){

        $query =  $this->connection->query("SELECT categoryId FROM `catetory_relations` WHERE ParentcategoryId = $categoryId");
        $results = [];
        if($query->num_rows > 0){

            while($row = $query->fetch_assoc()){
                $results[] = $row['categoryId'];
                self::_getChildCategories($row['categoryId']);
            }
        }
        return $results;
    }

}