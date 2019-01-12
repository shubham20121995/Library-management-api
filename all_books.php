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

   public function all_books()
    {
        $query = "Select * from all_books";
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
if(isset($_POST['verify'])){
    
    $reg_no=$_POST['verify'];

    if(!empty($reg_no) ){
 
        
        $user->all_books();

    }else{
        echo json_encode("you must type both inputs");
    }

}
?>
