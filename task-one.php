<?php  
include("config/app.php");
include_once('controllers/TaskOneController.php');
$data = new TaskOneController;
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

<h1>TASK 1</h1>

<table>

    <tr>
        <th>Category Name</th>
        <th>Total Items</th>
    </tr>


    <?php 

    if($categories = $data->getCategories()):

        foreach($categories as $key => $val): ?>
            <tr>
                <td><?= $key ?></td>
                <td><?= $val ?></td>
            </tr>

    <?php endforeach; endif;?>


</table>






