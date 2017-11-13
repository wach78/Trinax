<?php

class callapi
{
	private $value;
	private $token;
	private $url;
	
	function __construct()
	{
		$this->value = 'application/json';
		$this->token = 'bearer ed3ed1b3c1a0c9d0d59ca809f774b05d';
		$this->url =  'http://www.arbetsprov.api.trinaxdev.se/api/v1/';
	}
	
	
	private function checkIfError($data)
	{
		$errcode = $errmsg = '**';
		if (is_array($data) && array_key_exists('code',$data))
		{
			$errcode = $data['code'];
			
		}
		else if (is_array($data) && array_key_exists('message',$data))
		{
			$errmsg = $data['message'];
		}
		
		if ($errcode == '**' && $errmsg = '**')
		{
			return [true];
		}
		else 
		{
			return [false,$errcode .' : ' .$errmsg];
		}
		
	}
	
	
	function gettAllWorkspaces()
	{
		
		$url = 'http://www.arbetsprov.api.trinaxdev.se/api/v1/workplace';
		$ch = curl_init();
		$options = array(
				'Authorization: '. $this->token .'',
				'Accept: '. $this->value .''
		);
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $options);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		
		$output = curl_exec($ch);
		
		if ($output === false)
		{
			echo "cURL Error: " . curl_error($ch);
			return [false, 'curl error'];
		}
		
		curl_close($ch);
		
		$jsonDecode = json_decode($output,true);
	
		$errcheck = $this->checkIfError($jsonDecode);
		if (!$errcheck[0])
		{
			//log error
			
			return [false];
		}
		else
		{
			return [true,$jsonDecode];
		}
		
		
	}
	
	function gettAllTimeReports($addToUrl)
	{
		$url = 'http://www.arbetsprov.api.trinaxdev.se/api/v1/timereport?'.$addToUrl;
		
		$ch = curl_init();
		$options = array(
				'Authorization: '. $this->token .'',
				'Accept: '. $this->value .''
		);
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $options);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		
		$output = curl_exec($ch);
		
		if ($output === false)
		{
			echo "cURL Error: " . curl_error($ch);
			return [false,'curl error'];
		}
		
		curl_close($ch);
		
		$jsonDecode = json_decode($output,true);
		

		
		$errcheck = $this->checkIfError($jsonDecode);
		if (!$errcheck[0])
		{
			//log error
			var_dump($errcheck[01]);
			return [false];
		}
		else
		{
			return [true,$jsonDecode];
		}
	}
	
	function getOneWorkplace($WPID)
	{
		$url = 'http://www.arbetsprov.api.trinaxdev.se/api/v1/workplace/' .$WPID;
		$ch = curl_init();
		$options = array(
				'Authorization: '. $this->token .'',
				'Accept: '. $this->value .''
		);
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $options);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		
		$output = curl_exec($ch);
		
		if ($output === false)
		{
			echo "cURL Error: " . curl_error($ch);
			return [false, 'curl error'];
		}
		
		curl_close($ch);
		
		$jsonDecode = json_decode($output,true);
		
		$errcheck = $this->checkIfError($jsonDecode);
		if (!$errcheck[0])
		{
			//log error
			
			return [false];
		}
		else
		{
			return [true,$jsonDecode];
		}
	}
	
	
	
	
	function createTimeReport($postfields)
	{
		$url = 'http://www.arbetsprov.api.trinaxdev.se/api/v1/timereport';
		
		$ch = curl_init();
		$options = array(
				'Authorization: '. $this->token .'',
				'Accept: '. $this->value .''
		);
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $options);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$postfields);
		//curl_setopt($ch, CURLOPT_POST, strlen($postfields));
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		
		$output = curl_exec($ch);
		
		if ($output === false)
		{
			echo "cURL Error: " . curl_error($ch);
			return [false, 'curl error'];
		}
		
		curl_close($ch);
		
		$jsonDecode = json_decode($output,true);
		
		$errcheck = $this->checkIfError($jsonDecode);
		if (!$errcheck[0])
		{
			//log error
			
			return [false];
		}
		else
		{
			return [true,$jsonDecode];
		}


	}
	
	
	function getSingleTimeReport($TRID)
	{
		$url = 'http://www.arbetsprov.api.trinaxdev.se/api/v1/timereport/' .$TRID;
		
		$ch = curl_init();
		$options = array(
				'Authorization: '. $this->token .'',
				'Accept: '. $this->value .''
		);
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $options);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		
		$output = curl_exec($ch);
		
		if ($output === false)
		{
			echo "cURL Error: " . curl_error($ch);
			return [false,'curl error'];
		}
		
		curl_close($ch);
		
		$jsonDecode = json_decode($output,true);
		
		
		
		$errcheck = $this->checkIfError($jsonDecode);
		if (!$errcheck[0])
		{
			//log error
			var_dump($errcheck[01]);
			return [false];
		}
		else
		{
			return [true,$jsonDecode];
		}
	}
	
	
}