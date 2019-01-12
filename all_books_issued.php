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

   public function book_issued()
    {
        $query = "Select book_id,book_name,registration_no,date_of_issue,return_date from books_issued";
        $result = mysqli_query($this->connection,$query);
         
		if(mysqli_num_rows($result)>0){
		$emparray = array();
		$emparray['success'] = 'true';
		
         while($row =mysqli_fetch_assoc($result))
       {
          $emparray['books'][] = $row;
       }
	   
	}
	
	else{
		$emparray = array();
		$emparray['success'] = 'false';
	}
		
		
		
           echo json_encode( $emparray);
            mysqli_close($this -> connection);
        

    }

}  

    




$user = new User();
if(isset($_POST['registration_no'])){
    
    $reg_no=$_POST['registration_no'];

    if(!empty($reg_no) ){
 
        
        $user->book_issued();

    }else{
        $emparray = array();
		$emparray['success'] = '3';
		echo json_encode( $emparray);
    }

}
?>
