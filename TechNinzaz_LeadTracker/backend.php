<?php
include('common.php');
header("Access-Control-Allow-Origin: *");


$jsonData = file_get_contents('php://input');
$jsonDecodedArray = json_decode($jsonData,true);
//print_r($var1);

if($jsonDecodedArray['func'] == 'AgentSignUp'){
	AgentSignUpLogic($jsonDecodedArray,'admin_registration','AgentSignUp');
} else if($jsonDecodedArray['func'] == 'AgentLogin'){
	AgentLoginLogic($jsonDecodedArray,'admin_registration','AgentLogin');
} else if($jsonDecodedArray['func'] == 'leadGenerate'){
	leadGenerate($jsonDecodedArray,'techninzaz_lead','leadGenerate');	
} else if($jsonDecodedArray['func'] == 'getLastUpdatedLeads'){
	getLastUpdatedLead($jsonDecodedArray,'techninzaz_lead','getLastUpdatedLeads');
} else if($jsonDecodedArray['func'] == 'updateData'){
	updateData($jsonDecodedArray,'techninzaz_lead','updateData');
} else if($jsonDecodedArray['func'] == 'getLeads'){
	getLeads($jsonDecodedArray,'techninzaz_lead','getLeads');
} else if($jsonDecodedArray['func'] == 'onHoldLeads'){
	getLeads($jsonDecodedArray,'techninzaz_lead','onHoldLeads');
} else if($jsonDecodedArray['func'] == 'notInterestedLeads'){
	getLeads($jsonDecodedArray,'techninzaz_lead','notInterestedLeads');
} else if($jsonDecodedArray['func'] == 'enrolledLeads'){
	getLeads($jsonDecodedArray,'techninzaz_lead','enrolledLeads');
} else if($jsonDecodedArray['func'] == 'getDataByID'){
	getDataByID($jsonDecodedArray,'techninzaz_lead','getDataByID');
}




else if($jsonDecodedArray['func'] == 'getLeadByDate'){
	getOldLeadByDate($jsonDecodedArray,'syprotek_salestracker','getLeadByDate');
} else if($jsonDecodedArray['func'] == 'updateLeadDetails'){
	updateLeadDetails($jsonDecodedArray,'syprotek_salestracker','updateLeadDetails');
} else if($jsonDecodedArray['func'] == 'updateSalesCallerData'){
	updateSalesCallerData($jsonDecodedArray,'syprotek_salestracker','updateSalesCallerData');
} 


?>