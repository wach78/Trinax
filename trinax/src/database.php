<?php
require_once(__DIR__.'/../config/config.php');

class database 
{
	protected $conn;
	protected $stmt;
	
	public function __construct()
	{
		$this->conn = new mysqli(DBTRINAXHOST,DBTRINAXKUSERNAME,DBTRINAXPASS,DBTRINAXNAME,3306);
		
		$this->conn->set_charset("utf8");
		
		$this->stmt = $this->conn->stmt_init();
		
		/* check connection */
		if ($this->conn->connect_errno)
		{
			die('Connect Error: ' . $this->conn->connect_errno);
		}
	}
	
	protected function makeValuesReferenced($arr)
	{
		$refs = array();
		foreach($arr as $key => $value)
		{
			$refs[$key] = &$arr[$key];
		}
		return $refs;
	}
	protected function debug($query, $types, array $data,$varDump = true)
	{
		echo '***query***' .'<br />';
		echo $query;
		echo '<br />';
		echo 'number of question mark: '.substr_count($query,'?');
		echo '<br />';
		echo '***types***'.'<br />';
		echo 'len: ' .strlen($types) .' * ' .$types;
		echo '<br />';
		echo '***data print_r'.'<br />';
		$this->printArr($data);
		echo '<br />';
		
		if ($varDump)
		{
			echo '***data var_dumb***';
			foreach ($data as $v)
			{
				var_dump($v);
				echo '<br />';
			}
		}
	}
	
	private function exeptionsError($e)
	{
		if (SHOWSQLEXCEPTION)
		{
			echo '<pre>';
			echo $e->getFile() .'<br />';
			echo 'line: '.$e->getLine() .'<br />';
			//echo 'Severity: '.$e->getSeverity() .'<br />';
			echo 'code: '.$e->getCode() .'<br />';
			echo 'Message: '.$e->getMessage() .'<br />';
			echo '<br />';
			echo 'Trace: ' .$e->getTraceAsString() .'<br />';
			echo '<br />';
			echo '</pre>';
		}
	}
	
	public function queryWithPrepareStatemnet($query,$types,array $data)
	{
		try
		{
			if (!is_string($query) || !is_string($types) || !is_array($data))
			{
				return [false,'arguments','Error wrong argumnet type'];
			}
			
			array_unshift($data, $types);
			
			if ($this->stmt->prepare($query))
			{
				
				call_user_func_array(array($this->stmt, 'bind_param'), $this->makeValuesReferenced($data));
				
				
				
				if ($this->stmt->execute())
				{
					$affectedRows = $this->stmt->affected_rows;
					if ($affectedRows == 0)
					{
						return [false,'empty','',''];
					}
					else
					{
						return [true,$affectedRows];
					}
				}//query execute
				else
				{
					return [false,'error','Error query execute',$this->stmt->errno];
				}
			}//query prepare
			else
			{
				return [false,'error','Error query prepare',$this->stmt->error,$e->getFile()];
			}
		}
		catch(mysqli_sql_exception $e)
		{
			//echo($e->getMessage().'<pre>'.$e->getTraceAsString().'</pre>');
			$this->exeptionsError($e);
			return [false,'exception',$e];
		}
	}
	
	protected function selecWithPrepareStatemnetReturnArrayOfObject($query,$types,array $data,$cleanData = true,$debug = true)
	{
		$values = array();
		
		try
		{
			array_unshift($data, $types);
			
			if ($this->stmt->prepare($query))
			{
				if (is_array($data) && $types !='')
				{
					call_user_func_array(array($this->stmt, 'bind_param'), $this->makeValuesReferenced($data));	
				}
				
				if ($this->stmt->execute())
				{
					
					$result = $this->stmt->get_result();
					
					if ($result->num_rows > 0)
					{
						while($row =  $result->fetch_object())
						{
							$values[] = $row;
						}
					}//num rows
				}//query execute
				else
				{
					return [false,'error','Error query execute',$this->stmt->errno];
				}
				
			}//query prepare
			else
			{
				return [false,'error','Error query prepare',$this->stmt->error];
			}
		}
		catch(mysqli_sql_exception $e)
		{
			//echo($e->getMessage().'<pre>'.$e->getTraceAsString().'</pre>');
			$this->exeptionsError($e);
			return [false,'exception',$e];
		}
		
		if (count($values) == 0)
		{
			return [false,'empty',$values];
		}
		else
		{
			return [true,$values];
		}
	}
	
	
	function addTimereport($data)
	{
		if (!is_array($data))
		{
			return false;
		}
		
		$query = "INSERT INTO timereports (TRID,filename) VALUES (?,?)";
		$types = 'is';
		
		return $this->queryWithPrepareStatemnet($query,$types,$data);
	}
}