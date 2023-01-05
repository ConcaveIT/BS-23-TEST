<?php  
include("config/app.php");
include_once('controllers/TaskTwoController.php');
include_once('controllers/TaskOneController.php');
$data = new TaskTwoController;
$data1 = new TaskOneController;
?> 

<style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 50%;
    }

    td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }
</style>

<h1>TASK 2</h1>

<?php 


    if($data->getCategories()){
        foreach($data->getCategories() as $parent){
            echo '<b>'.$data->getCategoryTitle($parent).'</b>('.$data1->getCategories()[$data->getCategoryTitle($parent)].')<br>';
            $data->categoryTree($parent);
        }
    }


 ?>






