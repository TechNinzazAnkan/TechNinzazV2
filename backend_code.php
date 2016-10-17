<?php
	header("Access-Control-Allow-Origin: *");

	// Sample Code to Connect with Local Database
	/*$servername = "localhost";
	$username = "root";
	$password = "password";
	$dbname = "ninzaz_db";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} */

	$db_username = 'techninz_root';
	$db_password = 'rootuser';
	$db_host = 'localhost';
	$db_database = 'techninz_website';

	$conn = new mysqli($db_host, $db_username, $db_password, $db_database);

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

	if(isset($_POST['func'])&& $_POST['func'] == 'registerV2') {
		$name = mysqli_real_escape_string($conn,$_POST["name"]);
		$email = mysqli_real_escape_string($conn,$_POST["email"]);
		$phonenumber = mysqli_real_escape_string($conn,$_POST["phonenumber"]);
		$yourSubject = mysqli_real_escape_string($conn,$_POST["subject"]);

		echo ("insert into registerV2(id,name,email,phonenumber,subject) values('','$name','$email','$phonenumber','$yourSubject')");
		$q1 = mysqli_query($conn, "INSERT INTO `registerV2`(`id`, `name`, `email`, `phonenumber`, `subject`) VALUES ('','$name','$email','$phonenumber','$yourSubject')");

		$mainResponse = array();

		$mainResponse['updateStatus'] = 'true';
	    $mainResponse['updateMessage'] = 'Inserted Successfully';
	
		$finalUpdateResponse = json_encode($mainResponse);
	    echo $finalUpdateResponse;

	    $to = "techninzazarifa@gmail.com";
		$subject = "New Registration of TechNinzaz Domain";
		$txt = "Checkout the New Registration happened in your TechNinzaz!!!!!!!!!                         \n Student Name: ".$name."\n"." Email: ".$email."\n"." Mobile Number: ".$phonenumber."\n"." Your Query: ".$yourSubject;
		$headers = "From: contact@techninzaz.com" . "\r\n" .
		"CC: techninzazankan@gmail.com";
		mail($to,$subject,$txt,$headers);

	} else if(isset($_POST['func'])&& $_POST['func'] == 'feedback') {
		//print_r($_POST);
		$name = mysqli_real_escape_string($conn, $_POST["name"]);
		$experiance = mysqli_real_escape_string($conn, $_POST["experiance"]);

		$q1 = mysqli_query($conn, "INSERT INTO `feedbackV2`(`id`, `name`, `experiance`) VALUES ('','$name','$experiance')");

		$feedbackResponse = array();

		$feedbackResponse['updateStatus'] = 'true';
	    $feedbackResponse['updateMessage'] = 'Feedback Inserted Successfully';
	
		$finalUpdateResponse = json_encode($feedbackResponse);
	    echo $finalUpdateResponse;

	    $to = "techninzazarifa@gmail.com";
		$subject = "New Feedback Submitted in TechNinzaz";
		$txt = "Checkout the New Feedback in TechNinzaz Website!!!!!!!!!                          \n Student Name: ".$name."\n"." Experiance: ".$experiance;
		$headers = "From: contact@techninzaz.com" . "\r\n" .
		"CC: techninzazankan@gmail.com";
		mail($to,$subject,$txt,$headers);

	} else if(isset($_POST['func'])&& $_POST['func'] == 'contactV2') {
		//print_r($_POST);
		$name = mysqli_real_escape_string($conn, $_POST["name"]);
		$email = mysqli_real_escape_string($conn, $_POST["email"]);
		$phone = mysqli_real_escape_string($conn, $_POST["phone"]);
		$course = mysqli_real_escape_string($conn, $_POST["course"]);
		$query = mysqli_real_escape_string($conn, $_POST["query"]);


		$q1 = mysqli_query($conn, "INSERT INTO `contactV2`(`id`, `name`, `email`, `phone`, `course`, `query`) VALUES ('','$name','$email','$phone','$course','$query')");

		$contactResponse = array();

		$contactResponse['updateStatus'] = 'true';
	    $contactResponse['updateMessage'] = 'Feedback Inserted Successfully';
	
		$finalUpdateResponse = json_encode($contactResponse);
	    echo $finalUpdateResponse;

	    $to = "techninzazarifa@gmail.com";
		$subject = "New Contact Submitted in TechNinzaz";
		$txt = "Checkout the New Contact in TechNinzaz!!!!!!!!!                           \n Student Name: ".$name."\n"." Email: ".$email."\n"." Mobile Number: ".$phone."\n"." Contact Query: ".$query;
		$headers = "From: contact@techninzaz.com" . "\r\n" .
		"CC: techninzazankan@gmail.com";
		mail($to,$subject,$txt,$headers);

		
	} else if(isset($_POST['func'])&& $_POST['func'] == 'corporateFeedBackForm') {
		//print_r($_POST);
		
		$name = mysqli_real_escape_string($conn, $_POST["name"]);
		$email = mysqli_real_escape_string($conn, $_POST["email"]);
		$phone = mysqli_real_escape_string($conn, $_POST["phone"]);

		$courseObtained = mysqli_real_escape_string($conn, $_POST["courseName"]);
		$facultyName = mysqli_real_escape_string($conn, $_POST["facultyName"]);

		/*	Course Ratings	*/
		$overallRating = mysqli_real_escape_string($conn, $_POST["courseRating"]["one"]);
		$topicSequence = mysqli_real_escape_string($conn, $_POST["courseRating"]["two"]);
		$courseMaterial = mysqli_real_escape_string($conn, $_POST["courseRating"]["three"]);
		$objectiveExpectation = mysqli_real_escape_string($conn, $_POST["courseRating"]["four"]);
		
		/*	Faculty Ratings	*/
		$facultyCommunication = mysqli_real_escape_string($conn, $_POST["facultyRating"]["one"]);
		$facultyPreperation = mysqli_real_escape_string($conn, $_POST["facultyRating"]["two"]);
		$queryResponse = mysqli_real_escape_string($conn, $_POST["facultyRating"]["three"]);
		$trainingMethod = mysqli_real_escape_string($conn, $_POST["facultyRating"]["four"]);
		
		$courseProblem = mysqli_real_escape_string($conn, $_POST["textareaOne"]);
		$futureSuggestion = mysqli_real_escape_string($conn, $_POST["textareaTwo"]);
		$otherComments = mysqli_real_escape_string($conn, $_POST["textareaThree"]);		
		
		echo ("INSERT INTO `corporateFeedback`(`id`, `name`, `email`, `phone`, `courseObtained`, `facultyName`, `overallRatingCourse`, `topicSequenceCourse`, `courseMaterial`, `courseObjectiveExpectation`, `facultyCommunication`, `facultyPreperation`, `facultyQueryResponse`, `facultyTrainingMethod`, `courseProblemFaced`, `futureSuggestion`, `otherComments`) VALUES ('','$name','$email','$phone','$courseObtained','$facultyName','$overallRating','$topicSequence','$courseMaterial','$objectiveExpectation','$facultyCommunication','$facultyPreperation','$queryResponse','$trainingMethod','$courseProblem','$futureSuggestion','$otherComments')");
		$q1 = mysqli_query($conn, "INSERT INTO `corporateFeedback`(`id`, `name`, `email`, `phone`, `courseObtained`, `facultyName`, `overallRatingCourse`, `topicSequenceCourse`, `courseMaterial`, `courseObjectiveExpectation`, `facultyCommunication`, `facultyPreperation`, `facultyQueryResponse`, `facultyTrainingMethod`, `courseProblemFaced`, `futureSuggestion`, `otherComments`) VALUES ('','$name','$email','$phone','$courseObtained','$facultyName','$overallRating','$topicSequence','$courseMaterial','$objectiveExpectation','$facultyCommunication','$facultyPreperation','$queryResponse','$trainingMethod','$courseProblem','$futureSuggestion','$otherComments')");
	

	} else if(isset($_POST['func'])&& $_POST['func'] == 'corporateFeedbackListing'){
	    
	    $return_arr = array();

		$fetch = mysqli_query($conn, "SELECT * FROM corporateFeedback"); 

		while ($row = mysqli_fetch_array($fetch, MYSQL_ASSOC)) {
		    $row_array['id'] = $row['id'];
		    $row_array['studentName'] = $row['name'];
		    $row_array['courseObtained'] = $row['courseObtained'];
		    $row_array['facultyName'] = $row['facultyName'];
		    $row_array['overallRating'] = $row['overallRatingCourse'];
		    
		    array_push($return_arr,$row_array);
		}

		$finalJSON['data'] = $return_arr;
		echo json_encode($finalJSON);

	} else if(isset($_POST['func'])&& $_POST['func'] == 'filledCorporateFeedback'){
	    
		$userId = mysqli_real_escape_string($conn, $_POST["userId"]);

	    $query = "SELECT * FROM corporateFeedback WHERE id = '$userId'";
	    $result = mysqli_query($conn, $query) or die ("Unable to verify user because " . mysqli_error());

	    $count = mysqli_num_rows($result);
	    
	    if ($count > 0)
	    {	
	    	while($count = $result->fetch_assoc()) {
		        //echo "id: " . $count["id"]. " - Name: " . $count["fname"]. " " . $count["password"]. "<br>";
		        $mainresponse['isavailable'] = 'true' ;
		        $mainresponse['message'] = 'User Profile Exist';
		        $mainresponse['name'] = $count['name'];
		        $mainresponse['email'] = $count['email'];
		        $mainresponse['phone'] = $count['phone'];
		        $mainresponse['courseObtained'] = $count['courseObtained'];
		        $mainresponse['facultyName'] = $count['facultyName'];
		        $mainresponse['overallRatingCourse'] = $count['overallRatingCourse'];
		        $mainresponse['topicSequenceCourse'] = $count['topicSequenceCourse'];
		        $mainresponse['courseMaterial'] = $count['courseMaterial'];
		        $mainresponse['courseObjectiveExpectation'] = $count['courseObjectiveExpectation'];
		        $mainresponse['facultyCommunication'] = $count['facultyCommunication'];
		        $mainresponse['facultyPreperation'] = $count['facultyPreperation'];
		        $mainresponse['facultyQueryResponse'] = $count['facultyQueryResponse'];
		        $mainresponse['facultyTrainingMethod'] = $count['facultyTrainingMethod'];
		        $mainresponse['courseProblemFaced'] = $count['courseProblemFaced'];
		        $mainresponse['futureSuggestion'] = $count['futureSuggestion'];
		        $mainresponse['otherComments'] = $count['otherComments'];
		    } 
	    }
	    else
	    {
	        $mainresponse['isavailable'] = 'false';
	        $mainresponse['message'] = 'Login failed, username or password incorrect';
	    }
	    
	    $final = json_encode($mainresponse);
	    echo $final;
	}
?>