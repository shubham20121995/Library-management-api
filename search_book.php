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

   public function search_book($book_id)
    {
        $query = "Select * from all_books where book_id ='$book_id'";
        $result = mysqli_query($this->connection,$query);
        $row =mysqli_fetch_assoc($result);
		if(mysqli_num_rows($result)>0){
		
		$query1 = "Select registration_no,return_date from books_issued where book_id='$book_id'";
		 $result1 = mysqli_query($this->connection,$query1);
		 if(mysqli_num_rows($result1)>0)
		 {
            $json = array();
		    $json['success'] = '1';
		    $json['book_id'] =  $row['book_id'];
		    $json['book_name'] =  $row['book_name'];
		    $json['author'] =  $row['author'];
		    $json['publication'] =  $row['publication'];
		    $json['edition'] =  $row['edition'];
		    $json['no_of_copies'] =  $row['no_of_copies'];
		    $json['date_pur'] =  $row['date_pur'];
		    $json['price'] =  $row['price'];
           
		   while($row1 =mysqli_fetch_assoc($result1))
            {
                $json['reg_no'][] = $row1;
             }			
					
		 }else{
		$json['success'] = '1';
		$json['book_id'] =  $row['book_id'];
		$json['book_name'] =  $row['book_name'];
		$json['author'] =  $row['author'];
		$json['publication'] =  $row['publication'];
		$json['edition'] =  $row['edition'];
		$json['no_of_copies'] =  $row['no_of_copies'];
		$json['date_pur'] =  $row['date_pur'];
		$json['price'] =  $row['price'];
		 }
	   
	}
	
	else{
		$json['success'] = '0';
	}
		
		
		
           echo json_encode( $json);
            mysqli_close($this -> connection);
        

    }

}  

    




$user = new User();
if(isset($_POST['book_id'])){
    
    $book_id=$_POST['book_id'];

    if(!empty($book_id) ){
 
        
        $user->search_book($book_id);

    }else{
		$json['success'] = '3';
        echo json_encode($json);
    }

}
?>
