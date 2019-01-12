<?php
include_once 'connection.php';
header('Content-Type: application/json');
$_POST = json_decode(file_get_contents('php://input'), true);
class User {

    private $db;
    private $connection;

    function __construct() {
        $this -> db = new DB_Connection();
        $this -> connection = $this->db->getConnection();
    }

    public function update_book($book_id,$author,$book_name,$publication,$edition,$no_of_copies,$date_pur,$price)
    {
        $query = "update all_books set author ='$author',book_name ='$book_name'
		          ,publication ='$publication' ,edition='$edition'
				  ,no_of_copies ='$no_of_copies',date_pur='$date_pur'
				  ,price ='$price' where book_id ='$book_id'";
        $result = mysqli_query($this->connection,$query);
		
        if($result){
		$json['success'] = '1';
		}	
		else{
			$json['success'] = '0';
		}
		
            echo json_encode($json);
            mysqli_close($this -> connection);
        

    }

}


$user = new User();
if(isset($_POST['book_id'],$_POST['author'],$_POST['book_name'],$_POST['publication']
          ,$_POST['edition'],$_POST['no_of_copies'],$_POST['date_pur'],$_POST['price'])){
    $book_id = $_POST['book_id'];
    $book_name = $_POST['book_name'];
	$author = $_POST['author'];
	$publication = $_POST['publication'];
	$edition = $_POST['edition'];
	$no_of_copies = $_POST['no_of_copies'];
	$date_pur = $_POST['date_pur'];
	$price = $_POST['price'];
     
    if(!empty($book_id) && !empty($book_name) && !empty($author) && !empty($publication)
		 && !empty($edition) && !empty($no_of_copies) && !empty($date_pur) && !empty($price)){
 
        $user->update_book($book_id,$author,$book_name,$publication,$edition,$no_of_copies,$date_pur,$price);

    }else{
        $json['success'] = '3';
		echo json_encode($json);
    }

}
?>
