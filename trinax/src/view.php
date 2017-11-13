<?php
require_once ('callapi.php');
require_once ('database.php');

class view
{
	private $DB;
	private $apicalls;
	function __construct()
	{
		$this->apicalls = new callapi();
		//var_dump($this->apicalls->gettAllWorkspaces());
	}
	
	private function getWorkplaceOptions()
	{
		$apidata = $this->apicalls->gettAllWorkspaces();
	//var_dump($apidata);
		if (!$apidata[0])
		{
			return false;
		}
		
		$workplaces =  $apidata[1];
		$len = count($workplaces);

		
		for ($i = 0; $i < $len; $i++)
		{
			$id = $workplaces[$i]['id'];
			$name = $workplaces[$i]['name'];
		
			echo "<option value=$id>".$name.'</option>';
		}
	}
	
	public function showFilterFrm()
	{
		echo '<form id="frmfilter">';
		echo '<fieldset>';
		echo '<select name="selectworkplace" id="selectworkplace">';
		echo '<option value="-1">Välj en arbetsplats</option>';
		$this->getWorkplaceOptions();
		
		echo '</select>';
		
		
		echo '<input placeholder="Från datum" type="text" id="fromdate" class="datepicker">';
		
		echo '<input placeholder="Till datum "type="text" id="todate" class="datepicker">';
		
		echo '</fieldset>';
		echo '</form>';
		

	}
	
	public function showTableWorkplace($data)
	{
	;
		$timeReports =  $data[1];
		$len = count($timeReports);
		
		echo '<table id="timeReportTbl">';
		echo '<thead>';
		
		echo '<tr>';
		echo '<th>';
		echo 'Datum';
		echo '</th>';
		echo '<th>';
		echo 'Arbetsplatsnamn';
		echo '</th>';
		echo '</tr>';
		
		echo '</thead>';
		
		echo '<tbody>';
		
		for ($i = 0; $i < $len; $i++)
		{
			$date = $timeReports[$i]['date'];
			$WPID = $timeReports[$i]['workplace_id'];
			$workplace = $this->apicalls->getOneWorkplace($WPID);
			
			if ($workplace[0])
			{
				$name = $workplace[1]['name'];
			}
			else
			{
				$name = '***';
			}
			
			echo '<tr>';
			echo '<td>'. $date .'</td>';
			echo '<td>'. $name .'</td>';
			echo '</tr>';
			
			
		}
		
		
		echo '</tbody>';
		echo '</table>';
	}
	
	
	public function showCreateTimeReporteFrm()
	{
		echo '<form id="frmcreateTimeReport">';
		echo '<fieldset>';
		echo '<input placeholder="Datum" type="text" id="trdate" class="datepicker">';
		echo '<input placeholder="Antal timmar" type="text" id="numberofhour" >';
		
		echo '<select name="trselectworkplace" id="trselectworkplace">';
		echo '<option value="-1">Välj en arbetsplats</option>';
		$this->getWorkplaceOptions();
		
		echo '</select>';
		
		echo '<textarea id="comment" placeholder="Övrigt"></textarea>';
		
		echo '<input type="file" name="fileToUpload" id="fileToUpload">';
		
		echo '<button type="button" id="btnSendTR">Skicka</button>';
		echo '</fieldset>';
		echo '</form>';
		
	}
}