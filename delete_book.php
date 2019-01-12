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

    public function delete_book($book_id)
    {
        $query1 = "select * from all_books where book_id ='$book_id'";
		$result1 = mysqli_query($this->connection,$query1);
		if(mysqli_num_rows($result1)>0)
		{
		$query = "delete from all_books where book_id ='$book_id'";
        $result = mysqli_query($this->connection,$query);
		
        if($result){
		$json['success'] = '1';// book deleted
		}	
		else{
			$json['success'] = '0';// book not deleted
		}
		
        }else{
			$json['success'] = '4';// book not found.
		}
		 echo json_encode($json);
            mysqli_close($this -> connection);		
    }

}


$user = new User();
if(isset($_POST['book_id'])){
    $book_id = $_POST['book_id'];
  
     
    if(!empty($book_id)){
 
        $user->delete_book($book_id);

    }else{
        $json['success'] = '3';//Enter all details
		echo json_encode($json);
    }

}
?>
