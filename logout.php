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

    public function logout($reg_no)
    {
        $query = "update books_issued set notification ='0' where registration_no='$reg_no'";
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
if(isset($_POST['registration_no'])){
    $reg_no = $_POST['registration_no'];
    
     
    if(!empty($reg_no)){
 
        
        $user->logout($reg_no);

    }else{
        echo json_encode("you must type both inputs");
    }

}
?>
