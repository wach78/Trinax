<?php

if (!$_SERVER['REQUEST_METHOD'] === 'POST')
{
	exit('error');
}

require_once ('callapi.php');
require_once ('view.php');
require_once ('database.php');

$apicalls = new callapi();
$view = new view();
$db = new database();

$who = isset($_POST['who']) ? $_POST['who'] : -1;

switch ($who)
{
	case 'filtertimereports':
		
		$WPID = isset($_POST['WPID']) ? $_POST['WPID'] : -1;
		$fromdate = isset($_POST['fromdate']) ? $_POST['fromdate'] : -1;
		$todate = isset($_POST['todate']) ? $_POST['todate'] : -1;
		
		$data = array();
		if (varHasValue($WPID))
		{
			$data['workplace'] = $WPID;
		}
		
		if (varHasValue($fromdate))
		{
			$data['from_date'] = $fromdate;
		}
			
		if (varHasValue($todate))
		{
			$data['to_date'] = $todate;
		}
		
		
		$d = http_build_query($data);
		
		$retdata = $apicalls->gettAllTimeReports($d);

		$view->showTableWorkplace($retdata);
		
		
		break;
		
		
	case 'addtimereport':
		
		$date = isset($_POST['date']) ? $_POST['date'] : -1;
		$hour = isset($_POST['hour']) ? $_POST['hour'] : -1;
		$WPID = isset($_POST['WPID']) ? $_POST['WPID'] : -1;
		$comment = isset($_POST['comment']) ? $_POST['comment'] : -1;
		$file = isset($_FILES['file']) ? $_FILES['file'] : -1;
		
		
		$vararr = array($date,$WPID,$hour,$comment);
		$colarr = array('date','workplace_id','hours','info');
		$data = array();
		
		foreach ($vararr as $key => $var) {
			
			if (varHasValue($var))
			{
				$data[$colarr[$key]] = $var;
			}
			else 
			{
				// date , workplace_id and hours is require
				if ($colarr[$key] != 'info')
				{
					// returnera bättre felhantering 
					return false;
				}
			}
		}
		
		$postfields = http_build_query($data);
		$retvalue = $apicalls->createTimeReport($postfields);
		
		$id = $retvalue[1]['id'];
	
		
		$dbdata = array($id,$file['name']);
		$db->addTimereport($dbdata);
		savefile($file);	
		
		break;
	default:
		exit('error');
		break;
}

function varHasValue($data)
{
	if ($data == -1)
	{
		return false;
	}
	else if (empty($data) || $data == '')
	{
		return false;
	}
	
	return true;
	
}


function savefile($file)
{
	$targetFolder = '../files/';
	$targetFile = $targetFolder . basename($file['name']);
	
	if (file_exists($targetFile)) 
	{
		echo "already exists.";
		return false;
	}
	if (!move_uploaded_file($file['tmp_name'],$targetFile ))
	{
		return false;
	}
	
	return true;	
	
}

?>


