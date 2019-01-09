<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/category.php';
 
// instantiate database and category object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$category = new Category($db);
// get keywords
$keywords=isset($_GET["s"]) ? $_GET["s"] : "";
 
// query categorys
$stmt = $category->search($keywords);
$num = $stmt->rowCount();
// check if more than 0 record found
try{
    if($num>0){
        // categorys array
        $categorys_arr=array();
        $categorys_arr["records"]=array();
        // retrieve our table contents
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            // extract row
            // this will make $row['name'] to
            // just $name only
            extract($row);
     
            $category_item=array(
                "id" => $id,
                "name" => $name,
                "description" => html_entity_decode($description),
            );
            array_push($categorys_arr["records"], $category_item);
        }
        // set response code - 200 OK
        http_response_code(200);
        // show categorys data
        echo json_encode($categorys_arr);
    }else{
        // set response code - 404 Not found
        http_response_code(404);
        echo json_encode(
            array("message" => "No categories Was found.")
        );
    }
}catch(PDOException $e){
    echo json_encode(
            array("message" => "$e->getMessage()")
        );
}
?>