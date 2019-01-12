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

    public function return_book($registration_no,$book_id)
    {
        $query1 = "Select * from books_issued where registration_no ='$registration_no' and book_id='$book_id'";
		$result1 = mysqli_query($this->connection,$query1);
		$row1 =mysqli_fetch_assoc($result1);
		if(mysqli_num_rows($result1)>0)
		{
		$query = "Select * from all_books where book_id ='$book_id'";
        $result = mysqli_query($this->connection,$query);
		$row =mysqli_fetch_assoc($result);
        if(mysqli_num_rows($result)>0)
		{
			$no_of_copies=$row['no_of_copies']+1;
			$query2 = "update all_books set no_of_copies ='$no_of_copies' where book_id ='$book_id'";
			$query3 = "delete from books_issued where registration_no ='$registration_no' and book_id='$book_id'";
			$result2 = mysqli_query($this->connection,$query2);
			$result3 = mysqli_query($this->connection,$query3);
			if($result2 && $result3)
			{
			$json['success'] = '1'; // book returned
			}
			else if(!($result2) && $result3){
				$book_name=row1['book_name'];
				$date_of_issue=row1['date_of_issue'];
				$return_date=row1['return_date'];
				$query4 = "insert into books_issued values('$registration_no','$book_id','$book_name','$date_of_issue','$return_date','','')";
			    $result4 = mysqli_query($this->connection,$query4);
				$json['success'] = '4'; //book not returned
			}
			else if ($result2 && !($result3)){
				$no_of_copies2=$row['no_of_copies'];
				$query5 = "update all_books set no_of_copies ='$no_of_copies2' where book_id ='$book_id'";
			    $result5 = mysqli_query($this->connection,$query5);
				$json['success'] = '6'; //book not returned
			}
		}
					
		else{
			$json['success'] = '0'; // Wrong book id
		}
		}else{
			$json['success'] = '5'; // Wrong details
		}
		
            echo json_encode($json);
            mysqli_close($this -> connection);
        

    }

}


$user = new User();
if(isset($_POST['registration_no'],$_POST['book_id'])){
    $registration_no = $_POST['registration_no'];
	$book_id = $_POST['book_id'];
   
	     
    if(!empty($registration_no) && !empty($book_id)){
 
        $user->return_book($registration_no,$book_id);

    }else{
        $json['success'] = '3'; // empty parameter
		echo json_encode($json);
    }

}
?>
