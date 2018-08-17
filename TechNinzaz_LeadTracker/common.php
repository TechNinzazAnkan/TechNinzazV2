<?php

header("Access-Control-Allow-Origin: *");
/*$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "techninzaz_leadTracker";
$con = mysql_connect($servername,$username,$password);*/

/*	Prod SET-UP	*/

$servername = "localhost";
$username = "techninz_root";
$password = "rootuser";
$dbname = "techninz_leadtracker";
$con = mysql_connect($servername,$username,$password);

if($con){
	//echo "Connected";
} else {
	//echo "Waste Not Connected";
}
mysql_select_db($dbname);


function AgentSignUpLogic($jsonDecodedArray,$tablename,$defaultVal,$con){
	$st_reg_name = mysql_real_escape_string($jsonDecodedArray["st_reg_name"]);
	$st_reg_email = mysql_real_escape_string($jsonDecodedArray["st_reg_email"]);
	$st_reg_mobile = mysql_real_escape_string($jsonDecodedArray["st_reg_mobile"]);
	$st_reg_password = sha1($jsonDecodedArray["st_reg_password"]);
	$st_reg_role = mysql_real_escape_string($jsonDecodedArray["st_reg_role"]);

	//echo $st_reg_email;
	$query = "SELECT * FROM $tablename WHERE st_reg_email='$st_reg_email' and  st_reg_mobile= '$st_reg_mobile'";
	//echo $query;
	$result = mysql_query($query) or die ("Unable to verify user because " . mysqli_error());

	$count = mysql_num_rows($result);
	//echo $count;

	if($count > 0){
		//echo "Here";
		while($count = mysql_fetch_assoc($result)) {
			$mainresponse['UID'] = $count['st_reg_uid'];
			$mainresponse['status'] = 'User Profile Exist';
			$mainresponse['isavailable'] = 'true';
		}
	} else {
		//echo "New Creation";
		$lastID = "SELECT max(id) as id FROM $tablename";
		$lastestID = mysql_query($lastID);
		
		$value = mysql_num_rows($lastestID);
		//echo $value;
		if ($value > 0)
    	{
    		//echo "In side If Block";
    		while($value = mysql_fetch_assoc($lastestID)) {

    			$lastVal = $value['id'];
    			$newVal = $lastVal+1;
    			$userID = 'TECHNINZAZ00'.$newVal;
    			$q1 = mysql_query("INSERT INTO $tablename(st_reg_uid,st_reg_name,st_reg_email,st_reg_mobile,st_reg_password,st_reg_role) VALUES ('$userID','$st_reg_name','$st_reg_email','$st_reg_mobile','$st_reg_password','$st_reg_role')");

    			$mainresponse['UID'] = $userID;
    			$mainresponse['status'] = 'New Account Created';
    			$mainresponse['isavailable'] = 'true';
    		}
    	}
	}
	$final = json_encode($mainresponse);
	echo $final;
}

function AgentLoginLogic($jsonDecodedArray,$tablename,$defaultVal,$con){
	$st_reg_email = mysql_real_escape_string($jsonDecodedArray["st_reg_email"]);
	$st_reg_password = sha1($jsonDecodedArray["st_reg_password"]);

	$query = "SELECT * FROM $tablename WHERE st_reg_email='$st_reg_email' and  st_reg_password= '$st_reg_password'";
	//echo $query;
	$result = mysql_query($query) or die ("Unable to verify user because " . mysqli_error());

	$count = mysql_num_rows($result);

	if($count > 0){
		while($count = mysql_fetch_assoc($result)) {
			$mainresponse['UID'] = $count['st_reg_uid'];
			$mainresponse['UserName'] = $count['st_reg_name'];
			$mainresponse['USERROLE'] = $count['st_reg_role'];
			$mainresponse['status'] = 'User Profile Exist';
			$mainresponse['isavailable'] = 'true';
		}
	} else {
		$mainresponse['status'] = 'User not registered';
		$mainresponse['isavailable'] = 'false';
	}
	$final = json_encode($mainresponse);
	echo $final;
}

function leadGenerate($jsonDecodedArray,$tablename,$defaultVal,$con){
	//echo "Here";
	$value1 = "";
	$key1 = "";
	foreach ($jsonDecodedArray as $key => $value) {
		if($defaultVal!= $value){
			if (empty($value1) && empty($key1)) {
				$value1 = "'$value'";
				$key1 = $key;
			} else {
				$value1 = $value1.','."'$value'";
				$key1 = $key1.','.$key;
			}
		}
		
	}
	$query = "INSERT INTO $tablename($key1) VALUES ($value1)";
	//echo $query;
	$result = mysql_query($query);

	if($result > 0){
		$response['status'] = 'success';
		$response['message'] = 'Insertion Successful';
	}

	echo json_encode($response);
}

function getLastUpdatedLead($jsonDecodedArray,$tablename,$defaultVal,$con){
	$value1 = "";
	$key1 = "";
	foreach ($jsonDecodedArray as $key => $value) {
		if($defaultVal!= $value){
			if (empty($value1) && empty($key1)) {
				$value1 = "'$value'";
				$key1 = $key;
			} else {
				$value1 = $value1.','."'$value'";
				$key1 = $key1.','.$key;
			}
		}
		
	}
	//$query = "SELECT * from $tablename where $key1 = $value1";
	$query = "SELECT * FROM $tablename ORDER BY `st_id` DESC";
	//echo $query;
	$fetch = mysql_query($query);

	$return_arr = array();
	while ($row = mysql_fetch_array($fetch, MYSQL_ASSOC)) {
		$row_array['st_id'] = $row['st_id'];
	    $row_array['st_date'] = $row['st_date'];
	    $row_array['st_name'] = $row['st_name'];
	    $row_array['st_mobile'] = $row['st_mobile'];
	    $row_array['st_email'] = $row['st_email'];
	    $row_array['st_requirement'] = $row['st_requirement'];
	    $row_array['st_address'] = $row['st_address'];
	    $row_array['st_source_reference'] = $row['st_source_reference'];
	    $row_array['st_availability'] = $row['st_availability'];
	    $row_array['st_lead_type'] = $row['st_lead_type'];
	    $row_array['st_lead_fees'] = $row['st_lead_fees'];
	    $row_array['st_comment'] = $row['st_comment'];
	    $row_array['st_createdby'] = $row['st_createdby'];
	    
	    array_push($return_arr,$row_array);
	}

	$finalJSON = $return_arr;
	echo json_encode($finalJSON);
}

function updateData($jsonDecodedArray,$tablename,$defaultVal,$con){
	$st_id = mysql_real_escape_string($jsonDecodedArray["st_id"]);
	$st_name = mysql_real_escape_string($jsonDecodedArray["st_name"]);
	$st_mobile = mysql_real_escape_string($jsonDecodedArray["st_mobile"]);
	$st_email = mysql_real_escape_string($jsonDecodedArray["st_email"]);
	$st_requirement = mysql_real_escape_string($jsonDecodedArray["st_requirement"]);
	$st_address = mysql_real_escape_string($jsonDecodedArray["st_address"]);
	$st_source_reference = mysql_real_escape_string($jsonDecodedArray["st_source_reference"]);
	$st_availability = mysql_real_escape_string($jsonDecodedArray["st_availability"]);
	$st_lead_type = mysql_real_escape_string($jsonDecodedArray["st_lead_type"]);
	$st_lead_fees = mysql_real_escape_string($jsonDecodedArray["st_lead_fees"]);
	$st_comment = mysql_real_escape_string($jsonDecodedArray["st_comment"]);

	$query = "UPDATE $tablename SET st_name='$st_name', st_mobile='$st_mobile', st_email='$st_email', st_requirement='$st_requirement', st_address='$st_address', st_source_reference='$st_source_reference', st_availability='$st_availability', st_lead_type='$st_lead_type', st_lead_fees='$st_lead_fees', st_comment='$st_comment' WHERE st_id = '$st_id'";
	//echo $query;

	$result = mysql_query($query);

	if($result > 0){
		$response['status'] = 'success';
		$response['message'] = 'Updation Successful';
	}

	echo json_encode($response);
}

function getLeads($jsonDecodedArray,$tablename,$defaultVal,$con){
	$query;
	if($defaultVal == 'getLeads'){
		$query = "SELECT * from $tablename where st_lead_type !='On Hold'";
	} else if($defaultVal == 'onHoldLeads') {
		$query = "SELECT * from $tablename where st_lead_type='On Hold'";
	} else if($defaultVal == 'notInterestedLeads') {
		$query = "SELECT * from $tablename where st_lead_type='Not Interested'";
	} else if($defaultVal == 'enrolledLeads') {
		$query = "SELECT * from $tablename where st_lead_type='Enrolled'";
	}
	
	$fetch = mysql_query($query);
	$return_arr = array();
	while ($row = mysql_fetch_array($fetch, MYSQL_ASSOC)) {
		$row_array['st_id'] = $row['st_id'];
	    $row_array['st_date'] = $row['st_date'];
	    $row_array['st_name'] = $row['st_name'];
	    $row_array['st_mobile'] = $row['st_mobile'];
	    $row_array['st_email'] = $row['st_email'];
	    $row_array['st_requirement'] = $row['st_requirement'];
	    $row_array['st_address'] = $row['st_address'];
	    $row_array['st_source_reference'] = $row['st_source_reference'];
	    $row_array['st_availability'] = $row['st_availability'];
	    $row_array['st_lead_type'] = $row['st_lead_type'];
	    $row_array['st_lead_fees'] = $row['st_lead_fees'];
	    $row_array['st_comment'] = $row['st_comment'];
	    
	    array_push($return_arr,$row_array);
	}

	$finalJSON = $return_arr;
	echo json_encode($finalJSON);
}

function getDataByID($jsonDecodedArray,$tablename,$defaultVal,$con){
	$idValue = mysql_real_escape_string($jsonDecodedArray["st_id"]);

	$query = "SELECT * from $tablename WHERE st_id = '$idValue'";
	$result = mysql_query($query);

	$count = mysql_num_rows($result);
	
	$mainresponse;

    if ($count > 0)
    {	
    	while($count = mysql_fetch_assoc($result)) {
    		$mainresponse['isavailable'] = 'true' ;
	        $mainresponse['message'] = 'User Profile Exist';
	        $mainresponse['st_id'] = $count['st_id'];
		    $mainresponse['st_date'] = $count['st_date'];
		    $mainresponse['st_name'] = $count['st_name'];
		    $mainresponse['st_mobile'] = $count['st_mobile'];
		    $mainresponse['st_email'] = $count['st_email'];
		    $mainresponse['st_requirement'] = $count['st_requirement'];
		    $mainresponse['st_address'] = $count['st_address'];
		    $mainresponse['st_source_reference'] = $count['st_source_reference'];
		    $mainresponse['st_availability'] = $count['st_availability'];
		    $mainresponse['st_lead_type'] = $count['st_lead_type'];
		    $mainresponse['st_lead_fees'] = $count['st_lead_fees'];
		    $mainresponse['st_comment'] = $count['st_comment'];
	    } 
    } else {
    	$mainresponse['isavailable'] = 'false';
	    $mainresponse['message'] = 'Details Not available';
    }

	$finalJSON = $mainresponse;
	echo json_encode($finalJSON);
}







function getOldLeadByDate($jsonDecodedArray,$tablename,$defaultVal,$con){
	//$UserName = mysql_real_escape_string($jsonDecodedArray["loggedInUserName"]);
	//echo $UserName;
	$value1 = "";
	$key1 = "";
	foreach ($jsonDecodedArray as $key => $value) {
		if($defaultVal!= $value){
			if (empty($value1) && empty($key1)) {
				$value1 = "'$value'";
				$key1 = $key;
			} else {
				$value1 = $value1.','."'$value'";
				$key1 = $key1.','.$key;
			}
		}
		
	}
	$query = "SELECT * from $tablename where $key1 = $value1";
	//echo $query;
	//$query = "SELECT * from $tablename WHERE st_createdby = '$UserName'";
	$fetch = mysql_query($query);

	$return_arr = array();
	while ($row = mysql_fetch_array($fetch, MYSQL_ASSOC)) {
		$row_array['st_id'] = $row['st_id'];
	    $row_array['st_source'] = $row['st_source'];
	    $row_array['st_company'] = $row['st_company'];
	    $row_array['st_contactperson'] = $row['st_contactperson'];
	    $row_array['st_email'] = $row['st_email'];
	    $row_array['st_mobile'] = $row['st_mobile'];
	    $row_array['st_mobile2'] = $row['st_mobile2'];
	    $row_array['st_landline'] = $row['st_landline'];
	    $row_array['st_address'] = $row['st_address'];
	    $row_array['st_city'] = $row['st_city'];
	    $row_array['st_website'] = $row['st_website'];
	    $row_array['st_sector'] = $row['st_sector'];
	    $row_array['st_requirement'] = $row['st_requirement'];
	    $row_array['st_status'] = $row['st_status'];
	    $row_array['st_callerdate'] = $row['st_callerdate'];
	    $row_array['st_createdby'] = $row['st_createdby'];
	    $row_array['st_serviceCategory'] = $row['st_serviceCategory'];
	    $row_array['st_nextAction'] = $row['st_nextAction'];
	    $row_array['st_leadStatus'] = $row['st_leadStatus'];
	    $row_array['st_exClosureDate'] = $row['st_exClosureDate'];
	    $row_array['st_businessDetails'] = $row['st_businessDetails'];
	    
	    array_push($return_arr,$row_array);
	}

	$finalJSON = $return_arr;
	echo json_encode($finalJSON);
}




//Update Lead Details Api
function updateLeadDetails($jsonDecodedArray,$tablename,$defaultVal,$con){
	$st_id = mysql_real_escape_string($jsonDecodedArray["st_id"]);
	$st_serviceCategory = mysql_real_escape_string($jsonDecodedArray["st_serviceCategory"]);
	$st_requirement = mysql_real_escape_string($jsonDecodedArray["st_requirement"]);
	$st_remarks = mysql_real_escape_string($jsonDecodedArray["st_remarks"]);
	$st_nextAction = mysql_real_escape_string($jsonDecodedArray["st_nextAction"]);
	$st_nextActionDate = mysql_real_escape_string($jsonDecodedArray["st_nextActionDate"]);
	$st_leadValue = mysql_real_escape_string($jsonDecodedArray["st_leadValue"]);
	$st_leadStatus = mysql_real_escape_string($jsonDecodedArray["st_leadStatus"]);
	$st_salesExecutive = mysql_real_escape_string($jsonDecodedArray["st_salesExecutive"]);
	$st_exClosureDate = mysql_real_escape_string($jsonDecodedArray["st_exClosureDate"]);

	$query = "UPDATE $tablename SET st_serviceCategory='$st_serviceCategory', st_nextActionDate='$st_nextActionDate', st_requirement='$st_requirement', st_leadStatus='$st_leadStatus', st_exClosureDate='$st_exClosureDate', st_leadValue='$st_leadValue', st_remarks='$st_remarks', st_nextAction='$st_nextAction', st_salesExecutive='$st_salesExecutive' WHERE st_id = '$st_id'";
	//echo $query;

	$result = mysql_query($query);

	if($result > 0){
		$response['status'] = 'success';
		$response['message'] = 'Updation Successful';
	}

	echo json_encode($response);
}



function updateSalesCallerData($jsonDecodedArray,$tablename,$defaultVal,$con){
	$st_id = mysql_real_escape_string($jsonDecodedArray["st_id"]);
	$st_source = mysql_real_escape_string($jsonDecodedArray["st_source"]);
	$st_company = mysql_real_escape_string($jsonDecodedArray["st_company"]);
	$st_contactperson = mysql_real_escape_string($jsonDecodedArray["st_contactperson"]);
	$st_email = mysql_real_escape_string($jsonDecodedArray["st_email"]);
	$st_mobile = mysql_real_escape_string($jsonDecodedArray["st_mobile"]);
	$st_mobile2 = mysql_real_escape_string($jsonDecodedArray["st_mobile2"]);
	$st_landline = mysql_real_escape_string($jsonDecodedArray["st_landline"]);
	$st_address = mysql_real_escape_string($jsonDecodedArray["st_address"]);
	$st_city = mysql_real_escape_string($jsonDecodedArray["st_city"]);
	$st_website = mysql_real_escape_string($jsonDecodedArray["st_website"]);
	$st_createdby = mysql_real_escape_string($jsonDecodedArray["st_createdby"]);
	$st_sector = mysql_real_escape_string($jsonDecodedArray["st_sector"]);
	$st_serviceCategory = mysql_real_escape_string($jsonDecodedArray["st_serviceCategory"]);
	$st_callerdate = mysql_real_escape_string($jsonDecodedArray["st_callerdate"]);
	$st_businessDetails = mysql_real_escape_string($jsonDecodedArray["st_businessDetails"]);
	$st_status = mysql_real_escape_string($jsonDecodedArray["st_status"]);

	$st_requirement = mysql_real_escape_string($jsonDecodedArray["st_requirement"]);
	//$st_standard = mysql_real_escape_string($jsonDecodedArray["st_standard"]);
	$st_nextAction = mysql_real_escape_string($jsonDecodedArray["st_nextAction"]);
	$st_nextActionDate = mysql_real_escape_string($jsonDecodedArray["st_nextActionDate"]);
	$st_salesExecutive = mysql_real_escape_string($jsonDecodedArray["st_salesExecutive"]);
	$st_exClosureDate = mysql_real_escape_string($jsonDecodedArray["st_exClosureDate"]);
	$st_leadStatus = mysql_real_escape_string($jsonDecodedArray["st_leadStatus"]);
	$st_leadValue = mysql_real_escape_string($jsonDecodedArray["st_leadValue"]);
	$st_remarks = mysql_real_escape_string($jsonDecodedArray["st_remarks"]);
	

	$query = "UPDATE $tablename SET st_source='$st_source', st_company='$st_company', st_contactperson='$st_contactperson', st_email='$st_email', st_mobile='$st_mobile', st_mobile2='$st_mobile2', st_landline='$st_landline', st_address='$st_address', st_city='$st_city', st_website='$st_website', st_createdby='$st_createdby', st_sector='$st_sector', st_serviceCategory='$st_serviceCategory', st_callerdate='$st_callerdate', st_businessDetails='$st_businessDetails', st_status='$st_status', st_standard='$st_standard', st_nextAction='$st_nextAction', st_nextActionDate='$st_nextActionDate', st_salesExecutive='$st_salesExecutive', st_exClosureDate='$st_exClosureDate', st_leadStatus='$st_leadStatus', st_leadValue='$st_leadValue', st_remarks='$st_remarks' WHERE st_id = '$st_id'";
	//echo $query;

	$result = mysql_query($query);

	if($result > 0){
		$response['status'] = 'success';
		$response['message'] = 'Updation Successful';
	}

	echo json_encode($response);
}





?>