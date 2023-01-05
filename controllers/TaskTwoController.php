<?php

class TaskTwoController{

    public function __construct(){
        $db = new DatabaseClass;
        $this->connection = $db->connection;
    }

    public function getCategories(){
        $parentQuery =  $this->connection->query("SELECT category.Id, category.Name FROM `category` WHERE category.id NOT IN (SELECT categoryId FROM catetory_relations)");
        $parentCategoryId = [];
        if($parentQuery && $parentQuery->num_rows > 0){
            foreach($parentQuery as $parent){
                $parentCategoryId[] = $parent['Id'];
            }
        }

       return $parentCategoryId;

    }


    public function categoryTree( $parent_id = 0, $sub_mark = '--'){

            $totalItems = 0;
            $query = $this->connection->query("SELECT * FROM catetory_relations WHERE ParentcategoryId = $parent_id");
            
            if($query->num_rows > 0){
                while($row = $query->fetch_assoc()){
                    $totalItems += $this->_getItemNumberByCategory($row['categoryId']);
                    $treeCount = $this->_getItemNumberByCategory($row['categoryId']);
                    echo $sub_mark.$this->getCategoryTitle($row['categoryId']).'('.( $this->categoryTreeCount($row['categoryId']) +$treeCount ).')'.'<br>';
                    self::categoryTree($row['categoryId'], $sub_mark.'----');

                }
            }

    }


    public function categoryTreeCount( $parent_id = 0 ){
      
            $totalItems = 0;
            $query = $this->connection->query("SELECT * FROM catetory_relations WHERE ParentcategoryId = $parent_id");
            
            if($query->num_rows > 0){
                while($row = $query->fetch_assoc()){
                    $totalItems += $this->_getItemNumberByCategory($row['categoryId']);
                    self::categoryTreeCount($row['categoryId']);
                }
            }
        return $totalItems;

    }


    private function _getItemNumberByCategory($categoryId){
        $query = $this->connection->query("SELECT * FROM item JOIN item_category_relations ON item.Number=item_category_relations.ItemNumber WHERE item_category_relations.categoryId = $categoryId");
        return $query->num_rows;
    }

    public function getCategoryTitle($categoryId){
            $query = "SELECT Name FROM `category` WHERE Id = $categoryId LIMIT 1";
            $categoriesQuery =  $this->connection->query($query);
            if($categoriesQuery && $categoriesQuery->num_rows > 0){
                foreach($categoriesQuery as $parent){
                    return $parent['Name'];
                }
            }
    }




    private function _getChildCategories($categoryId){

        $query = "SELECT categoryId FROM `catetory_relations` WHERE ParentcategoryId = $categoryId";
        $categoriesQuery =  $this->connection->query($query);
        $results = [];
        if($categoriesQuery && $categoriesQuery->num_rows > 0){
            foreach($categoriesQuery as $parent){
                $results[] = $parent['categoryId'];
            }
        }

        return $results;

    }








}