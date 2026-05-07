<?php
    global $config;
    use Dompdf\Dompdf;
     class MySqliDriver implements DB
	 {

		var $sql;
		var $rs;
		var $numrows;
		var $limit;
        var $noofpage;
		var $offset;
		var $page;
		var $style;
		var $parameter;
		var $activestyle;
		var $buttonstyle;
		private $host;
		private $user;
		private $pass;
		private $database;
		private $cnx;
		

	    function __construct()
            {
			//register_shutdown_function(array(&$this, 'ShutDown')); 
          
				$this->host =  HOST;
				$this->user = USER;
				$this->pass = PASSWORD;
				$this->database = DATABASE;
				
				$this->cnx = mysqli_connect($this->host,$this->user,$this->pass,$this->database)or die("Cannot connect to MySQL" . mysqli_error());
				if(mysqli_connect_error())
				{
					trigger_error('Database connection failed: '. mysqli_connect_error(),E_USER_ERROR);
				}				
            }

		 
function singleValue_new($tbl,$id,$con) {
			
                $sql="select ".$id." from ".$tbl." where ".$con;
				$result=mysqli_query($this->cnx,$sql) or die(mysqli_error($this->cnx));
                $rows=mysqli_num_rows($result);
                if($rows>0)
                {
					$rec = mysqli_fetch_array($result);
                    return $rec[0];
                }
                else
                {
                   return $rec[0];
                } 
        }
function get_group_concat_val($tbl,$field,$con) 
	{
		$rec = array();
		$sql = "SELECT GROUP_CONCAT(".$field." SEPARATOR  ',') as ".$field." FROM ".$tbl." WHERE ".$con;
		$result = mysqli_query($this->cnx,$sql) or die(mysqli_error($this->cnx));
		if($result)
		{
			$rows = $this->num_rows($result);
			if($rows>0)
			{
				$rec = $this->fetch_object($result);				
				return $rec->$field;
			}
			else
			{
			   return $rec->$field;
			} 
		}
	}
		
		
		function selectQry($table,$condition,$limitS,$limitE)
		{
                    $dataSet = array();
                    if(!$condition){
				if((!$limitS) && (!$limitE))
					$sql="select * from ".$table;
				else
					$sql="select * from ".$table." limit ".$limitS.", ".$limitE;
			}
			else {
				if((!$limitS) && (!$limitE))
					$sql="select * from ".$table." where  ".$condition;
				else
					$sql="select * from ".$table." where  ".$condition." limit ".$limitS.", ".$limitE;
			}
                       // echo  $sql;
			$dataSet=$this->executeQry($sql);
                       // print_r($dataSet);
			return $dataSet;
		}
		

		function executeQry(string $sql)
		{
			if (!is_string($sql)) {
	            //throw new Exception("Illegal parameter. Must be string.");
				die("Illegal parameter. Must be string.");
	        }
			else {
			$rsSet = mysqli_query($this->cnx,$sql);
			}

            return $rsSet;
		}
	/* 	public function executeQry(string $sql) {
        if (!is_string($sql)) {
            //throw new Exception("Illegal parameter. Must be string.");
            die("Illegal parameter. Must be string.");
        } else {
            // Execute the query
            $rsSet = mysqli_query($this->cnx, $sql);

            // Check if the query was successful
            if ($rsSet !== false) {
                // Update the affected rows count property
                $this->affected_rows_count = mysqli_affected_rows($this->cnx);
            }
        }

        return $rsSet;
    }

    public function affectedRows() {
        // Return the affected rows count
        return $this->affected_rows_count;
    } */
		function insert_id()  
		{
			return mysqli_insert_id($this->cnx);
		}

		
		

		 

		function getTotalRow($DataSet) { 
			return mysqli_num_rows($DataSet);
		}

		 

	    function fetchValue(string $tbl, string $field, string $con) 
	    {
                $response = (object) array();
                $sql="select ".$field." from ".$tbl." where ".$con;
	        $result = mysqli_query($this->cnx,$sql) or die(mysqli_error($this->cnx));
                $rows=mysqli_num_rows($result);
                if($rows>0)
                {
                   $rec = mysqli_fetch_object($result);
                   $response = $rec->$field ;

                }

			return $response;
	    }
            
function DynamicSelectedDropDown(string $query, string $id_field, string  $name_field, $selected_id="")
	{
		//echo $query;
		$result = $this->executeQry($query);
		while($row = $this->fetch_array($result))
		{
			$a = trim($row[$id_field]);
			echo '<option value="'.trim($row[$id_field]).'"';
			if(is_array($selected_id))
			{			
				foreach($selected_id as $id_select)
				if($a==$id_select)
				{
					echo 'selected';
				}
			}
			else
			{
				
				if($a==$selected_id)
				{
					echo 'selected';
				}
			}
			echo '>'. ucwords(trim($row[$name_field])) . '</option>'."\n";
		}    
	}
	
	function DynamicMultiLabalDropDown(string $query, string $id_field, string  $name_field, string $name_field2 )
	{
		//echo $query;
		$result = $this->executeQry($query);
		while($row = $this->fetch_array($result))
		{
			$a = trim($row[$id_field]);
			echo '<option value="'.trim($row[$id_field]).'"';
			 
			echo '>'. trim($row[$name_field]) .' ('. trim($row[$name_field2]).') '. '</option>'."\n";
		}    
	}


function DynamicDropDown(string $tbl,string $id_field,string $name_field,string $name_field2) 
{
    if(empty($name_field2) || $name_field2 == '')
        $Query = "select $id_field, $name_field from  ".$tbl." ORDER BY $name_field ASC" ;
    else
        $Query = "select $id_field, $name_field, $name_field2 from  ".$tbl." ORDER BY $name_field ASC" ;
    $result = $this->executeQry($Query);

    while($row = $this->fetch_array($result))
    {
        if(empty($name_field2) || $name_field2 == '')
            echo '<option value="'.trim($row[0]).'">'. trim($row[1]). '</option>';
        else
            echo '<option value="'.trim($row[0]).'">'. trim($row[1]) .' '.trim($row[2]). '</option>';
    }
}

function DynamicDropDownOrderby(string $tbl,string $id_field, string $name_field, string $name_field2, string $orderby)
{
    if(empty($name_field2) || $name_field2 == '')
        $Query = "select $id_field, $name_field from  ".$tbl." ORDER BY $orderby ASC" ;
    else
        $Query = "select $id_field, $name_field, $name_field2 from  ".$tbl." ORDER BY $orderby ASC" ;
    $result = $this->executeQry($Query);
	
    while($row = $this->fetch_array($result))
    {
        if(empty($name_field2) || $name_field2 == '')
            echo '<option value="'.trim($row[0]).'">'. trim($row[1]). '</option>';
        else
            echo '<option value="'.trim($row[0]).'">'. trim($row[1]) .' '.trim($row[2]). '</option>';
    }
}

 function GetNameByID(string $tbl, string $id_field, string $name_field, $id) 
                {
                  $query = "select ". $name_field. " from "  .$tbl.  " where $id_field = '$id'";
                   $result = $this->executeQry($query);
                   $rows = $this->getTotalRow($result);
                    $Name = "";
                    if($rows>0)
                    {
                        while($row = $this->fetch_array($result))
                        {
                            $Name =  trim($row[$name_field]);
                        }
                    }
                    return $Name ;
                }

  function ShowDetails($tbl,$id,$id_field)
                {
                    $query = "select * from " .$tbl.  "  where $id_field = $id ";
                    $result = $this->executeQry($query) ;
                    //  echo "<script>alert('$query')</script>";
                    if(!isset($result))
                    {
                        echo "Sorry, This is an Invalid Account Id";
                    }
                    else
                    {
                        $row = $this->fetch_array($result);
                        return $row;
                    }
                }
            function fetchRows($tbl, $field, $con)
	    {
                $response = "";
                $sql="select ".$field." from ".$tbl." where ".$con;
	        $result = mysqli_query($this->cnx,$sql) or die(mysqli_error($this->cnx));
                $rows=mysqli_num_rows($result);
                return $rows;
	    }

	    
	     
		
		function singleRowObject($tbl,$con)
	    {
		$rec = array();
              $sql="select * from ".$tbl." where ".$con;
	        $result=mysqli_query($this->cnx,$sql) or die(mysqli_error($this->cnx));
                 $rows=mysqli_num_rows($result);
                if($rows>0)
                {
			$rec=mysqli_fetch_object($result);
                        return $rec;
                }
                else
                {
                   // $rec[0] = "";
                    return $rec;
                }
	    }
		
		 
		
		function singleRowAssoc_new($select,$tbl,$con)
	    {
		$rec = array();
               $sql="select ".$select." from ".$tbl." where ".$con;
	        $result=mysqli_query($this->cnx,$sql) or die(mysqli_error($this->cnx));
                 $rows=mysqli_num_rows($result);
                if($rows>0)
                {
			$rec=mysqli_fetch_assoc($result); 
                        return $rec;
                }
                else
                {
                   // $rec[0] = "";
                    return $rec;
                }
	    }

            function check_var($var)
            {
                if(isset($var))
                    echo $var;
            }
	    function deleteRec(string $table, string $condition)  
	    {

			if(!$condition){
				$sql="delete from ".$table;
			}
			else{
				$sql="delete from ".$table." where ".$condition;
			}
	    //echo $sql;
	    //exit;
	    $dataSet=$this->executeQry($sql);
			return $dataSet;
	    }


		///// Alok Changes

	function updateTable($table, $pk, $pkval,$post)
	{
	    $query = "UPDATE ".$table." SET ";
	    $trigger = 0;
	    foreach($post as $field => $value){
			if(substr($field,0,3) == "db_"){
				$field = str_replace("db_","",$field);
				$field." = ".$value."<br><br>";
			    $value = mysqli_real_escape_string($value);
				if($trigger > 0) $query = $query . ", ";
			    $query = $query . $field." = trim('$value')";
			    $trigger++;
	    	}
		}
	    $query = $query . " WHERE ".$pk." = '$pkval'";
	   	// echo $query."<br><br>";exit;
	    if($result = mysqli_query($query)) return(0);
	    else echo(mysqli_error());
	}

        function newmsg ($id)
        {
           echo $response =  '<div style="display:none" id="newmsgdiv" class="bubble me">
                        <div class="media"><small class="text-muted">'.$_SESSION["name"].' | Just Now</small>
                       <span id="del^'.$id.'" onclick="editchat(this.id)" style="margin-left:05px; cursor:pointer" class="label label-danger label-sm pull-right"><i class="fa fa-trash-o fa-1x"></i></span>
                   <span id="edit^'.$id.'" onclick="editchat(this.id);" style="cursor:pointer" class="label label-info label-sm pull-right"><i class="fa fa-edit fa-1x"></i></span>
                       <div style="word-wrap:break-word;" class="media-body" ><p style="width:90%;"  id="txtdiv'.$id.'" class="text">
                                </p>
                            </div>
                        </div>
                    </div>';
        }

        function singleValue(string $tbl, string $col, string $con) {
			
				$sql="select ".$col." from ".$tbl." where ".$con;
				$result=mysqli_query($this->cnx,$sql) or die(mysqli_error($this->cnx));
                $rows=mysqli_num_rows($result);
				
                if($rows>0)
                {
					$rec=mysqli_fetch_object($result);
					$col = $rec->$col;
					return $col;
                }
                else
                {
                    $col = "";
                    return $col;
                }
        }

       function getMySqlColumns(string $table)  
	{
	  	$query = "SELECT * FROM {$table} LIMIT 1";
	  	$result = mysqli_query($query);
	  	$row = mysqli_fetch_assoc($result);
	  	$columns = array_keys($row);
	  	return $columns;
	}

 	function mysqli_column_names(string $table)   {
 		return $this->getMySqlColumns($table);
	}

	// Paging Test

	function paging(string $query){
		$this->offset=0;
		$this->page=1;
		$this->sql=$query;
		$this->rs=mysqli_query($this->sql);
		$this->numrows=mysqli_num_rows($this->rs);
	}
	function getNumRows() : int {
		return $this->numrows;
	}
	function setLimit(int $no) {
        if($no)
		$this->limit=$no;
		else
		$this->limit=10;
	}
	function getLimit() {
		return $this->limit;
	}
	function getNoOfPages() {
		return ceil($this->noofpage=($this->getNumRows()/$this->getLimit()));
	}
	function getPageNo() {
		$str="";
		$str=$str."<table width='100%' border='0' align='right'><tr>";
		$str=$str."<td width='100%' align='right' valign='top' height='25'>";
		if($this->getPage()>1) {
			$str=$str."<a href='".$_SERVER['PHP_SELF']."?page=".($this->getPage()-1).$this->getParameter()."' class='".$this->getStyle()."'>Prev </a>|&nbsp;";
		}
		if($this->getPage() > 6)
		{
		    $l = 1;
			for($i=$this->getPage()-1;$i>0;$i--) {
				$arr[] = "<a href='".$_SERVER['PHP_SELF']."?page=".$i.$this->getParameter()."' class='".$this->getStyle()."'>".$i."</a>&nbsp;";
				if($l == 5)
				break;
				$l++;
			}
			if($this->getNoOfPages()-$this->getPage() < 5)
			{
			   $start = $i -1;
			   $diff = $this->getNoOfPages()-$this->getPage();
			   $loop = 5-$diff;
			   for($m = 1; $m<=$loop; $m++) {
			     if($start>0)
			     $arr[] = "<a href='".$_SERVER['PHP_SELF']."?page=".$start.$this->getParameter()."' class='".$this->getStyle()."'>".$start."</a>&nbsp;";
			     $start--;
				}
			}
			$arrrev = array_reverse($arr);
			foreach($arrrev as $val)
			  $str = $str.$val;
		}

		$current = $this->getPage();
		if($current > 6)
		{
		    $k = 1;
			for($i=$current;$i<=$this->getNoOfPages();$i++) {
				if($i==$this->getPage()) {
					$str=$str."<span class='".$this->getActiveStyle()."'>".$i."&nbsp;</span>";
				}
				else {
					$str=$str."<a href='".$_SERVER['PHP_SELF']."?page=".$i.$this->getParameter()."' class='".$this->getStyle()."'>".$i."</a>&nbsp;";
				}
				if($k == 6)
				break;
				$k++;
			}
		}
		else
		{
			$j = 1;
			for($i=1;$i<=$this->getNoOfPages();$i++) {
				if($i==$this->getPage()) {
					$str=$str."<span class='".$this->getActiveStyle()."'>".$i."&nbsp;</span>";
				}
				else {
					$str=$str."<a href='".$_SERVER['PHP_SELF']."?page=".$i.$this->getParameter()."' class='".$this->getStyle()."'>".$i."</a>&nbsp;";
				}
			   if($j == 11)
			   break;
			   $j++;
			}
		  	if($this->getNoOfPages() > $i+1)
		  	{
		   	 	$str=$str."<a href='".$_SERVER['PHP_SELF']."?page=".($i+1).$this->getParameter()."' class='".$this->getStyle()."'>.. </a>";
		  	}
		}

		if($this->getPage()<$this->getNoOfPages()) {
			$str=$str."|<a href='".$_SERVER['PHP_SELF']."?page=".($this->getPage()+1).$this->getParameter()."' class='".$this->getStyle()."'> Next</a>";
		}
		$str=$str."</td>";
		$str=$str."</tr></table>";
		return $str;
	}

	function getOffset($page) {
		if($page>$this->getNoOfPages()) {
			$page=$this->getNoOfPages();
		}
		if($page=="") {
			$this->page=1;
			$page=1;
		}
		else {
			$this->page=$page;
		}
		if($page=="1") {
			$this->offset=0;
			return $this->offset;
		}
		else {
			for($i=2;$i<=$page;$i++) {
				$this->offset=$this->offset+$this->getLimit();
			}
			return $this->offset;
		}
	}
	function getPage() {
		return $this->page;
	}
	function setStyle($style) {
		$this->style=$style;
	}
	function getStyle() {
		return $this->style;
	}
	function setActiveStyle($style) {
		$this->activestyle=$style;
	}
	function getActiveStyle() {
		return $this->activestyle;
	}
	function setButtonStyle($style) {
		$this->buttonstyle=$style;
	}
	function getButtonStyle() {
		return $this->buttonstyle;
	}
	function setParameter($parameter) {
		$this->parameter=$parameter;
	}
	function getParameter() {
		return $this->parameter;
	}


	function getQueryString()
	{
	  	$queryString_arr = explode('&',$_SERVER['QUERY_STRING']);
	  	$queryStringNew = "";
	  	if(count($queryString_arr) > 0)
	  	{
	   		$srchString = "age=";
	   		$srchStringLimit = "imit=";
	   		foreach($queryString_arr as $queryString_arr2)
	   		{
	    		$posString = strpos($queryString_arr2,$srchString);
	    		$posStringLim = strpos($queryString_arr2,$srchStringLimit);
	    		if($posString != 1 && $queryString_arr2 != '')
	    		$queryStringNew .= "&".$queryString_arr2;
	   		}
	   		//echo  $queryStringNew; exit;
	  	}
	  	/*if($_GET['limit'] != '') {
	    	$queryStringNew .= "&limit=".$_GET['limit'];
	  	}*/
	  	return $queryStringNew;
	}

	public function errno()
	{
		return mysqli_errno($this->cnx);
	}
	public function error()
	{
		return mysqli_error($this->cnx);
	}
	public function escape($string)
	{
		return mysqli_real_escape_string($this->cnx,$string);

	}
	
	public function fetch_array($result, $array_type = MYSQLI_BOTH)
	{
		return mysqli_fetch_array($result, $array_type);
	}
	public function fetch_row($result)
	{
	   return mysqli_fetch_row($result);
	}
	public function fetch_assoc($result)
	{
	   return mysqli_fetch_assoc($result);
	}
	public function fetch_object($result)
	{
	   return mysqli_fetch_object($result);
	}
	public function num_rows($result)
	{
	   return mysqli_num_rows($result);
	}
	public function curPageInfo() {
    return substr($_SERVER["REQUEST_URI"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
	}


	 public  function safe_b64encode($string) {
    $data = base64_encode($string);
    $data = str_replace(array('+','/','='),array('-','_',''),$data);
    return $data;
    }

    public function safe_b64decode($string) {
    $data = str_replace(array('-','_'),array('+','/'),$string);
    $mod4 = strlen($data) % 4;
    if ($mod4) {
    $data .= substr('====', $mod4);
    }
    return base64_decode($data);
    }
	
	 
	
	public function encode($string)
    {
		$options = 0; 
		$ciphering = "AES-256-OFB"; 
		$encryption_iv = '7970970978812341'; 
		$encryption_key = "@dministratorq1w2e3r4@sagacious";
		
        if (function_exists('mcrypt_encrypt'))
            $val = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, $string, MCRYPT_MODE_ECB);
        else
            $val = openssl_encrypt($string, $ciphering, $encryption_key, $options, $encryption_iv);

        return $val;
    }

	public function decode($string)
    {
		$decryption_iv = '7970970978812341'; 
		$decryption_key = "@dministratorq1w2e3r4@sagacious"; 
		$ciphering = "AES-256-OFB";
		$options = 0; 

        if (function_exists('mcrypt_encrypt'))
            $val = mcrypt_decrypt(MCRYPT_BLOWFISH, $decryption_key, $string, MCRYPT_MODE_ECB);
        else
           $val = openssl_decrypt($string, $ciphering, $decryption_key, $options, $decryption_iv); 
		
        return $val;
    }
	
    public function formatdate ($RecTimeStamp,$format)
    {
         //$format = "j-M-Y h:i:A";
         if(!empty($RecTimeStamp) || $RecTimeStamp != "")
         $RecTimeStamp = Date($format, strtotime(str_replace("/", "-", $RecTimeStamp)));

         return $RecTimeStamp;

    }

    function geturlvalue($decrypt_val,$value)
{

	$arrV = explode('&',$decrypt_val);
	foreach($arrV as $val)
	{
		$arrI = explode('=',$val);
		if($arrI[0]==$value)
		{
			$finalValue = $arrI[1];
			return $finalValue;
		}
	 }
}

 
 
function geturlvalueMod($arr)
{
	$ar = array();
	if (is_array($arr))
	{
		foreach($arr as $value)
		{
			$val = explode('=',$value);
			if($val[0] == 'stat')
				$ar[$val[0]] = $this->encode($val[1]);
			else
				$ar[$val[0]] = $val[1];
				
		}
	}
	else
	{
		$val = explode('=',$arr);
		$ar[$val[0]] = $this->encode($val[1]);
	}
	
	return $ar;
}
function option($name)
		
	{
		//echo $this->encode('stat=listuser');
		//$name = $_SERVER['REQUEST_URI'];
		$url = explode("?", $name);
		$urlvalueMod = array();
			if (count($url) > 0)
			{
				if (isset($url['1']))
				{
					$spliturl = explode("&", $this->decode($url['1']));
					//print_r($spliturl); die;
				}
				else
					$spliturl = array();
			
				if (is_array($spliturl))
				{
					if (isset($spliturl['0']))
						$decrypt_val = $spliturl['0'];
				}
				else
				{
					if (isset($url['1']))
						$decrypt_val = $url['1'];
				}
				if (isset($decrypt_val))
				{
					$urlvalueMod = $this->geturlvalueMod($spliturl);
				}
			}
		 return $urlvalueMod;
	}
	
	function catchError($errno = '', $errstr = '', $errfile = '', $errline = '', $appname = '') {
		$strerror = "";
        $strerror .="Eroor Type : " . $errno . "<br>";
        $strerror .= "Eroor Message : " . $errstr . "<br>";
        $strerror .= "Line Number : " . $errline . "<br>";
		$strerror .= "File Name : " . $errfile;
        $subject = "Error Reporting from ".$appname;
        echo $body = "Error:\n" . $strerror;
        $fromName = $appname;
        $attachmentPath = '';
		if (method_exists($this, 'sendEmails')) {
			$this->sendEmails($subject, $body, '', EXCEPTION_EMAIL, APP_FULL_NAME, DEVELOPER_EMAIL, 'Chandan Singh','');
		}
        exit();
    }
	
	function ShutDown() 
	{
        $lasterror = error_get_last();
        #print_r($lasterror);
		if(isset($lasterror['type']))
		{	
                    //E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR, E_RECOVERABLE_ERROR, E_CORE_WARNING, E_COMPILE_WARNING, E_PARSE
			if (in_array($lasterror['type'], Array(E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR, E_RECOVERABLE_ERROR, E_COMPILE_WARNING, E_PARSE)))
			{
				$this->catchError($lasterror['type'], $lasterror['message'], $lasterror['file'], $lasterror['line'], APP_NAME);
			}
		}
    }
	
	function addpadding($string, $blocksize = 32)
		{
				$len = strlen($string);
				$pad = $blocksize - ($len % $blocksize);
				$string .= str_repeat(chr($pad), $pad);
				return $string;
		}
	
	function encrypt($string = "")
		{
			$key = base64_decode("PSVJQRk9QTEpNVU1DWUZCRVFGV1VVT0ZOV1RRU1NaWR=");
			$iv = base64_decode("YWlFLVEZZUFNaWlhPQ01ZT0lLWU5HTFJQVFNCRUJZVA=");
			return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $this->addpadding($string), MCRYPT_MODE_CBC, $iv));
		}

// PHP:Decrypt Code:
	function strippadding($string)
		{
			$slast = ord(substr($string, -1));
			$slastc = chr($slast);
			$pcheck = substr($string, -$slast);
			if(preg_match("/$slastc{".$slast."}/", $string)){
			$string = substr($string, 0, strlen($string)-$slast);
				return $string;
			} else {
				return false;
			}
	   }
	function decrypt($string)
		{
			$key = base64_decode("PSVJQRk9QTEpNVU1DWUZCRVFGV1VVT0ZOV1RRU1NaWR=");
			$iv = base64_decode("YWlFLVEZZUFNaWlhPQ01ZT0lLWU5HTFJQVFNCRUJZVA=");
			$string = base64_decode($string);
			return $this->strippadding(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $string, MCRYPT_MODE_CBC, $iv));
		}
	
	
	
	function distinct_dropdown($col,$tbl,$con,$select)
	{
			
		echo $sql = " select distinct($col) from $tbl $con order by $col ASC";
						$result = $this->executeQry($sql);
						while($row = $this->fetch_array($result))
						{
							if($row[$col] == '' || strpos($row[$col], "?") !== false || $row[$col] == '1')
								continue;
							else
							{
							echo '<option value="'.trim($row[$col]).'"';
							if($row[$col] == $select)
								echo 'selected';							
							}
						
							echo '>'.strtoupper(($row[$col])). '</option>'."\n";
						}
						
       
	}
	
	
	
	function qry($arr, $tbl)
	{
		$count = 0;
		$fields = '';
		foreach($arr as $col => $val) 
		{
			if ($count++ != 0) $fields .= ', ';
			if(is_array($val))
				{
					$val = implode(',',$val);
				}
			$fields .= "`$col` = '".$val."'";
		}
		$query = "INSERT INTO ".$tbl." SET $fields;";
		return $query;
	}
	
	function update_qry($arr,$tbl,$condition)
	{
		$count = 0;
		$fields = '';
		foreach($arr as $col => $val) 
		{
			if ($count++ != 0) $fields .= ', ';
			if(is_array($val))
				{
					$val = implode(',',$val);
					
				}
			$fields .= "`$col` = '".$val."'";
		}
		$query = "update ".$tbl." SET $fields $condition";
		return $query;
	}
	 
	function generateRandomString($length,$type="")
	{
		if($type=="SMALL_STR")			
			$characters = '0123456789abcdefghijklmnopqrstuvwxyz';		
		else if($type=="CAPITAL_STR")			
			$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		else if($type=="SMALL_STR_WITHOUT_NUM")			
			$characters = 'abcdefghijklmnopqrstuvwxyz';		
		else if($type=="CAPITAL_STR_WITHOUT_NUM")			
			$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		else
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	
	
	 
	
	function send_message($mobile,$messagecontent)
	{
		$username = urlencode(SMS_UNAME);
		$password = urlencode(SMS_PASSWORD);
		$sender   = urlencode(SMS_SENDERID);		
		$message  = urlencode($messagecontent);
		$customer_id = $_SESSION['User_Id'];
		$account_id = $_SESSION['account_id'];
		$RecTimeStamp = Date("Y/m/d H:m:s");
		$url = SMS_URL."uname=$username&pwd=$password&senderid=$sender&to=$mobile&msg=$message&route=T";		
		$request = curl_init();
		$timeOut = 0;
		curl_setopt ($request, CURLOPT_URL, $url);
		curl_setopt ($request, CURLOPT_RETURNTRANSFER, 1);		
		curl_setopt ($request, CURLOPT_CONNECTTIMEOUT, $timeOut);
		$response = curl_exec($request);
		curl_close($request); 
		$response = trim($response);
		$sql = "INSERT INTO ".MESSAGE." (mob_no, account_id, customer_id, message, response_code, request_url, RecTimeStamp) VALUES ('$mobile', '$account_id', '$customer_id', '$messagecontent', '$response', '$url', '$RecTimeStamp')";
		$result = $this->executeQry($sql);  
		return $response;
	}
	

	function create_directory($folder_path)
	{
		if(!is_dir ($folder_path))
		{
			if (mkdir($folder_path, 0, true))
			{
			   chmod($folder_path, 0777);
			   return 1;
			}
			else
			{
				$msg = "Unable to create folder.";
				return $msg;
			}
		}
		else
		{
			return 1;
		}
	}
	
	function Resquest_Response_log($logid, $request_type = '', $response_array = '', $requestStr = '', $record_id = '', $log = array()) 
	{
		$table = 'tbl_request_response_log';
		$record = '';
		$log_text = '';	
		if($record_id != '')
		{
			$record = " , record_id = '" . addslashes($record_id) . "'";
		}
		
		if(count($log) > 0)
		{
			$log_text = " , log = '".addslashes(json_encode($log))."'";
		}
		if ($this->num_rows($this->executeQry("SHOW TABLES LIKE '" . $table . "'")) == 1) 
		{
			if ($logid > 0) 
			{
				if (is_array($response_array)) 
				{
					$response = json_encode($response_array);
				} 
				else 
				{
					$response = $response_array;
				}
				$sql = "update " . $table . " set response='" . addslashes($response) . "' , date_time_response = NOW(3), timetaken = (TIMESTAMPDIFF(MICROSECOND, date_time_request, now(3))/1000) ".$record.$log_text. " where id='$logid'";

				$this->executeQry($sql);
			} 
			else 
			{
				$user_name = '';
				$ip = $this->get_user_ip();
				if(isset($_SESSION['login_id']))
				{
					$user_name = $_SESSION['login_id'];
				}
				
				 $sql = "insert into " . $table . " set response='" . addslashes($response_array) . "' , request_type='" . addslashes($request_type) . "', request='" . addslashes($requestStr) . "',  date_time_request = NOW(3), user_name = '".$user_name."', ip = '".$ip."'  ".$record.$log_text;
				$this->executeQry($sql);
				$logid = $this->insert_id();
			}
			return $logid;
		} 
	}  

	function get_user_ip()  
	{		
		$ip_address = "";
		//whether ip is from share internet
		if (!empty($_SERVER['HTTP_CLIENT_IP']))   
		{
			$ip_address = $_SERVER['HTTP_CLIENT_IP'];
		}
		//whether ip is from proxy
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
		{
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		//whether ip is from remote address
		else
		{
			$ip_address = $_SERVER['REMOTE_ADDR'];
		}
		return $ip_address;
	}
	
	/* function sendEmailNotifocation($subject, $body, $attachmentPath = '', $fromEmail = '', $fromName = '', $toEmail='',  $toName = '', $bcc = '') 
	{
		include_once('class.phpmailer.php');
		if ($fromName == '')
			$fromName = APPLICATION_FULL_NAME;
		$mail = new PHPMailer();
		$mail->From = FROM_EMAIL;
		$mail->AddReplyTo($fromEmail, $fromName);
		$mail->SMTPDebug  = 1;
		$mail->FromName = $fromName;
		$mail->Host = EMAIL_HOST;
		//$mail->Mailer = "smtp";
		$mail->SMTPAuth = "true";
		$mail->Port = 587;
		$mail->Username = USER_EMAIL;
		$mail->Password = MAIL_PASSWORD;
		$mail->ContentType = "text/html";
		$mail->Subject = $subject;
		$mail->Body = "<p>" . nl2br($body) . "</p>";
		//echo "<pre>";
		//print_r($mail); exit;
		if ($toEmail != '') {
			$toemail = explode(',', $toEmail);
			$toname = explode(',', $toName);
			$i = 0;
			foreach ($toemail as $email) {
				$name = @$toname[$i];
				if ($i == 0) {
					$mail->AddAddress($email, $name);
				} else {
					$mail->AddCC($email, $name);
				}
				$i++;
			}
		if($bcc != '')
		{
			$mail->addBCC($bcc);
		}
		
			if (is_array($attachmentPath)) {
				foreach ($attachmentPath as $attach) {
					$mail->AddAttachment($attach);
				}
			} else {
				$attach = $attachmentPath;
				if ($attach != '')
					$mail->AddAttachment($attach);
			}
			$response = $mail->Send();
			$mail->ClearAddresses();
			$mail->ClearAttachments();
			
		}
		return $response;
	} */
	function sendEmails(string $subject, $body, string $attachmentPath = '', string $fromEmail = '', string $fromName = '', string $toEmail = '',  string $toName = '', string $bcc = '')
	{
		$log = array();
		$logid = $this->Resquest_Response_log("", "EMAIL_NOTIFICATION", '', json_encode(array($toEmail,$subject)), '');
		//include_once('class.phpmailer.php');
		if (ENVIRONMENT == 'LOCAL') {
			return false;
		}
		if ($fromName == '') {
			$fromName = APPLICATION_FULL_NAME;
		}
		$mail = new PHPMailer\PHPMailer\PHPMailer(true);
		$mail->From = $fromEmail;
		$mail->AddReplyTo($fromEmail, $fromName);
		$mail->SMTPDebug  = 0;
		$mail->FromName = $fromName;
		$mail->Host = EMAIL_HOST;
		$mail->Port = 465;
		$mail->Username = USER_EMAIL;
		$mail->Password = MAIL_PASSWORD;
		$mail->ContentType = "text/html";
		$mail->isHTML(true);
		$mail->Subject = $subject;
		$mail->Body = nl2br($body);
		if ($toEmail != '') {
			$toemail = explode(',', $toEmail);
			$toname = explode(',', $toName);
			$i = 0;
			foreach ($toemail as $email) {
				$name = @$toname[$i];
				if ($i == 0) {
					$mail->AddAddress($email, $name);
				} else {
					$mail->AddCC($email, $name);
				}
				$i++;
			}
			if ($bcc != '') {
				$mail->addBCC($bcc);
			}

			if (is_array($attachmentPath)) {
				foreach ($attachmentPath as $attach) {
					$mail->AddAttachment($attach);
				}
			} else {
				$attach = $attachmentPath;
				if ($attach != '')
					$mail->AddAttachment($attach);
			}
			$response = $mail->Send();
			$mail->ClearAddresses();
			$mail->ClearAttachments();
		}
		
		 $record_id = '1';
		$logid = $this->Resquest_Response_log($logid, '', $response, '', $record_id,array($mail,$toemail));
		unset($mail->Body);
		return $response;
	}
	function uploaddocs($filename,$allowed,$target_dir,$max_size,$prefix="",$db_path="") 
	{
		$response = array();
		$target_file = $target_dir . basename($filename["name"]);
		$file_ext = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		 
		if(!in_array($file_ext,$allowed) && count($allowed) > 0)
		{ 
			$response['upload'] = 0;
			$response['error'] = "File type not allowed.";
			$response['file_path'] = "";
		}
		else if($filename["size"] > $max_size)
		{
			$response['upload'] = 0;
			$response['error'] = "File size exceeded, only ".($max_size/1000)." KB File allowed.";
			$response['file_path'] = "";
		}
		else
		{
			$new_filename = $prefix.date('Ymdhis').".".$file_ext;     
			$target_file = $target_dir.$new_filename;	
			if(!empty($target_file))
			{
				if(move_uploaded_file($filename['tmp_name'], $target_file))
				{
					$response['upload'] = 1;
					$response['error'] = "";
					if($db_path != '')
					{
						$response['file_path'] = $db_path.$new_filename;
					}
					else
					{
						$response['file_path'] = $target_file;
					}
				}
				else
				{
					$response['upload'] = 0;
					$response['error'] = "Unable to upload file.";
					$response['file_path'] = "";
				}
			} 
		}
		return $response; 
	}
	function custompaging_table_response($cur_page, $no_of_paginations, $previous_btn, $next_btn, $first_btn, $last_btn, $current_page_url = '')
	{
		$msg = '';
		if ($cur_page >= 7) {
			$start_loop = $cur_page - 3;
			if ($no_of_paginations > $cur_page + 3)
				$end_loop = $cur_page + 3;
			else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
				$start_loop = $no_of_paginations - 6;
				$end_loop = $no_of_paginations;
			} else {
				$end_loop = $no_of_paginations;
			}
		} else {
			$start_loop = 1;
			if ($no_of_paginations > 7)
				$end_loop = 7;
			else
				$end_loop = $no_of_paginations;
		}
		/* ----------------------------------------------------------------------------------------------------------- */
		$msg .= "<ul class='pagination pagination-sm no-margin pull-right'>";



		//$url = $this->encode($current_page_url);
		$Qstring = $this->option($current_page_url);

		$new_url_array = array();
		foreach ($Qstring as $key => $value) {

			if ($key != 'cu_page') {
				if (in_array($key, array('pagetype'))) {
					$new_url_array[$key] = $value;
				} else {
					$new_url_array[$key] = $this->decode($value);
				}
			}
		}

		//echo '<pre>';
		//print_r($new_url_array);

		// FOR ENABLING THE FIRST BUTTON
		if ($first_btn && $cur_page > 1) {
			$new_url = APPLICATION_URL . "index.php?" . $this->encode(http_build_query($new_url_array) . "&cu_page=1");
			$msg .= "<li p='1' link='" . $new_url . "' class=' page-item actives'><a class='page-link' href='javascript:void(0)'>&lt;</a></li>";
		} else if ($first_btn) {
			$new_url = APPLICATION_URL . "index.php?" . $this->encode(http_build_query($new_url_array) . "&cu_page=1");
			$msg .= "<li p='1' link='" . $new_url . "' class=' page-item disabled'><a class='page-link' href='javascript:void(0)'>&lt;</a></li>";
		}

		// FOR ENABLING THE PREVIOUS BUTTON
		if ($previous_btn && $cur_page > 1) {
			$pre = $cur_page - 1;
			$new_url = APPLICATION_URL . "index.php?" . $this->encode(http_build_query($new_url_array) . "&cu_page=" . $pre);
			$msg .= "<li p='$pre' link='" . $new_url . "' class='page-item actives'><a  class='page-link' href='javascript:void(0)'>&lt;&lt;</a></li>";
		} else if ($previous_btn) {
			$msg .= "<li class='page-item disabled'><a class='page-link' href='javascript:void(0)'>&lt;&lt;</a></li>";
		}
		for ($i = $start_loop; $i <= $end_loop; $i++) {

			if ($cur_page == $i) {
				$new_url = APPLICATION_URL . "index.php?" . $this->encode(http_build_query($new_url_array) . "&cu_page=" . $i);
				$msg .= "<li p='$i' link='" . $new_url . "' class='page-item active'><a class='page-link' href='javascript:void(0)'>{$i}</a></li>";
			} else {
				$new_url = APPLICATION_URL . "index.php?" . $this->encode(http_build_query($new_url_array) . "&cu_page=" . $i);
				$msg .= "<li p='$i' link='" . $new_url . "' class='page-item actives'><a  class='page-link' href='javascript:void(0)'>{$i}</a></li>";
			}
		}

		// TO ENABLE THE NEXT BUTTON
		if ($next_btn && $cur_page < $no_of_paginations) {
			$nex = $cur_page + 1;
			$new_url = APPLICATION_URL . "index.php?" . $this->encode(http_build_query($new_url_array) . "&cu_page=" . $nex);
			$msg .= "<li p='$nex' link='" . $new_url . "' class='page-item actives'><a  class='page-link' href='javascript:void(0)'>&gt;&gt;</a></li>";
		} else if ($next_btn) {
			$msg .= "<li class='page-item disabled'><a class='page-link' href='javascript:void(0)'>&gt;&gt;</a></li>";
		}

		// TO ENABLE THE END BUTTON
		if ($last_btn && $cur_page < $no_of_paginations) {
			$new_url = APPLICATION_URL . "index.php?" . $this->encode(http_build_query($new_url_array) . "&cu_page=" . $cur_page);
			$msg .= "<li p='$no_of_paginations' link='" . $new_url . "' class='page-item actives'><a  class='page-link' href='javascript:void(0)'>&gt;</a></li>";
		} else if ($last_btn) {
			$new_url = APPLICATION_URL . "index.php?" . $this->encode(http_build_query($new_url_array) . "&cu_page=" . $cur_page);
			$msg .= "<li p='$no_of_paginations' link='" . $new_url . "' class='page-item disabled'><a  class='page-link' href='javascript:void(0)'>&gt;</a></li>";
		}
		$msg = $msg . "</ul>"; // Content for pagination
		return $msg;
	}
	
	function custompaging($cur_page, $no_of_paginations, $previous_btn, $next_btn, $first_btn, $last_btn) {
    $msg = '';
    if ($cur_page >= 7) {
        $start_loop = $cur_page - 3;
        if ($no_of_paginations > $cur_page + 3)
            $end_loop = $cur_page + 3;
        else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
            $start_loop = $no_of_paginations - 6;
            $end_loop = $no_of_paginations;
        } else {
            $end_loop = $no_of_paginations;
        }
    } else {
        $start_loop = 1;
        if ($no_of_paginations > 7)
            $end_loop = 7;
        else
            $end_loop = $no_of_paginations;
    }
    /* ----------------------------------------------------------------------------------------------------------- */
    $msg .= "<ul class='pagination pagination-sm no-margin pull-right'>";

// FOR ENABLING THE FIRST BUTTON
    if ($first_btn && $cur_page > 1) {
        $msg .= "<li p='1' class=' page-item actives'><a class='page-link' href='javascript:void(0)'>First</a></li>";
    } else if ($first_btn) {
        $msg .= "<li p='1' class=' page-item disabled'><a class='page-link' href='javascript:void(0)'>First</a></li>";
    }

// FOR ENABLING THE PREVIOUS BUTTON
    if ($previous_btn && $cur_page > 1) {
        $pre = $cur_page - 1;
        $msg .= "<li p='$pre' class='page-item actives'><a class='page-link' href='javascript:void(0)'>&lt;&lt;Previous</a></li>";
    } else if ($previous_btn) {
        $msg .= "<li class='page-item disabled'><a class='page-link' href='javascript:void(0)'>&lt;&lt;Previous</a></li>";
    }
    for ($i = $start_loop; $i <= $end_loop; $i++) {

        if ($cur_page == $i)
            $msg .= "<li p='$i' class='page-item active'><a class='page-link' href='javascript:void(0)'>{$i}</a></li>";
        else
            $msg .= "<li p='$i' class='page-item actives'><a class='page-link' href='javascript:void(0)'>{$i}</a></li>";
    }

// TO ENABLE THE NEXT BUTTON
    if ($next_btn && $cur_page < $no_of_paginations) {
        $nex = $cur_page + 1;
        $msg .= "<li p='$nex' class='page-item actives'><a class='page-link' href='javascript:void(0)'>Next&gt;&gt;</a></li>";
    } else if ($next_btn) {
        $msg .= "<li class='page-item disabled'><a class='page-link' href='javascript:void(0)'>Next&gt;&gt;</a></li>";
    }

// TO ENABLE THE END BUTTON
    if ($last_btn && $cur_page < $no_of_paginations) {
        $msg .= "<li p='$no_of_paginations' class='page-item actives'><a class='page-link' href='javascript:void(0)'>Last</a></li>";
    } else if ($last_btn) {
        $msg .= "<li p='$no_of_paginations' class='page-item disabled'><a class='page-link' href='javascript:void(0)'>Last</a></li>";
    }
    $msg = $msg . "</ul>";  // Content for pagination
    return $msg;
}


function custompaging_new($cur_page, $no_of_paginations, $previous_btn, $next_btn, $first_btn, $last_btn,$stat='projects',$ff1='',$ffv1='',$ff2='',$ffv2='',$ff3='',$ffv3='',$ff4='',$ffv4='',$ff5='',$ffv5='') {
		 
    $msg = '';
    if ($cur_page >= 7) {
        $start_loop = $cur_page - 3;
        if ($no_of_paginations > $cur_page + 3)
            $end_loop = $cur_page + 3;
        else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
            $start_loop = $no_of_paginations - 6;
            $end_loop = $no_of_paginations;
        } else {
            $end_loop = $no_of_paginations;
        }
    } else {
        $start_loop = 1;
        if ($no_of_paginations > 7)
            $end_loop = 7;
        else
            $end_loop = $no_of_paginations;
    }
    /* ----------------------------------------------------------------------------------------------------------- */
    $msg .= "<ul class='pagination pagination-sm no-margin pull-right'>";
	
	 

// FOR ENABLING THE FIRST BUTTON
    if ($first_btn && $cur_page > 1) {
        $msg .= "<li p='1' class=' page-item actives'><a class='page-link' href=".APP_URL.'index.php?'.$this->encode('stat='.$stat.'&pageno=1&'.$ff1.'='.$ffv1.'&'.$ff2.'='.$ffv2.'&'.$ff3.'='.$ffv3.'')." >First</a></li>";
    } else if ($first_btn) {
        $msg .= "<li p='1' class=' page-item disabled'><a class='page-link' href=".APP_URL.'index.php?'.$this->encode('stat='.$stat.'&pageno=1')." >First</a></li>";
    }

// FOR ENABLING THE PREVIOUS BUTTON
    if ($previous_btn && $cur_page > 1) {
        $pre = $cur_page - 1;
        $msg .= "<li p='$pre' class='page-item actives'><a class='page-link' href=".APP_URL.'index.php?'.$this->encode('stat='.$stat.'&pageno='.$pre.'&'.$ff1.'='.$ffv1.'&'.$ff2.'='.$ffv2.'&'.$ff3.'='.$ffv3.'')." >&lt;&lt;Previous</a></li>";
    } else if ($previous_btn) {
        $msg .= "<li class='page-item disabled'><a class='page-link' href='javascript:void(0)'>&lt;&lt;Previous</a></li>";
    }
    for ($i = $start_loop; $i <= $end_loop; $i++) {

        if ($cur_page == $i)
            $msg .= "<li p='$i' class='page-item active'><a class='page-link' href=".APP_URL.'index.php?'.$this->encode('stat='.$stat.'&pageno='.$i.'&'.$ff1.'='.$ffv1.'&'.$ff2.'='.$ffv2.'&'.$ff3.'='.$ffv3.'')." >{$i}</a></li>";
        else
            $msg .= "<li p='$i' class='page-item actives'><a class='page-link' href=".APP_URL.'index.php?'.$this->encode('stat='.$stat.'&pageno='.$i.'&'.$ff1.'='.$ffv1.'&'.$ff2.'='.$ffv2.'&'.$ff3.'='.$ffv3.'')." >{$i}</a></li>";
    }

// TO ENABLE THE NEXT BUTTON
    if ($next_btn && $cur_page < $no_of_paginations) {
        $nex = $cur_page + 1;
        $msg .= "<li p='$nex' class='page-item actives'><a class='page-link' href=".APP_URL.'index.php?'.$this->encode('stat='.$stat.'&pageno='.$nex.'&'.$ff1.'='.$ffv1.'&'.$ff2.'='.$ffv2.'&'.$ff3.'='.$ffv3.'').">Next&gt;&gt;</a></li>";
    } else if ($next_btn) {
        $msg .= "<li class='page-item disabled'><a class='page-link' href='javascript:void(0)'>Next&gt;&gt;</a></li>";
    }

// TO ENABLE THE END BUTTON
    if ($last_btn && $cur_page < $no_of_paginations) {
        $msg .= "<li p='$no_of_paginations' class='page-item actives'><a class='page-link'  href=".APP_URL.'index.php?'.$this->encode('stat='.$stat.'&pageno='.$no_of_paginations.'&'.$ff1.'='.$ffv1.'&'.$ff2.'='.$ffv2.'&'.$ff3.'='.$ffv3.'').">Last</a></li>";
    } else if ($last_btn) {
        $msg .= "<li p='$no_of_paginations' class='page-item disabled'><a class='page-link' href='javascript:void(0)'>Last</a></li>";
    }
    $msg = $msg . "</ul>";  // Content for pagination
    return $msg;
}


 

function autocommit($opt)
{
	return mysqli_autocommit($this->cnx, $opt);
}

function commit()
{
	return mysqli_commit($this->cnx);
}

function rollback()
{
	return mysqli_rollback($this->cnx);
}

function validate_recaptcha($google_post)
{
	$ans = 0;
	if(isset($_POST['captcha']))
	{
		$captcha = $_POST['captcha'];
		if($captcha == $_SESSION["vercode"])
		{
			$ans = 1;
		}
	}
	else
	{
		$secret = SECRET_KEY;
		$url =  "https://www.google.com/recaptcha/api/siteverify";
		$data = array(
				'secret' => $secret,
				'response' => $google_post
			); 
		$verify = curl_init();
		curl_setopt($verify, CURLOPT_URL, $url);
		curl_setopt($verify, CURLOPT_POST, true);
		curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
		curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($verify);
		$responseData = json_decode($response);
		if($responseData->success)  
		{
			$ans = 1;		
		} 
	}
	
	return $ans;
}

function cleanMe($input) 
	{
		$input = $this->escape($input); 
		$input = htmlspecialchars($input, ENT_IGNORE, 'utf-8');
		$input = strip_tags($input);
		$input = stripslashes($input); 
		$input = $this->escape($input); 
		return $input;
	}


function callCURL($method, $url, $data, $headers, $request_type='', $record_id='')
	{
		print_r($url);exit;
		//$headers = array('APIKEY: 111111111111111111111', 'Content-Type: application/json');
		$requestStr = json_encode(func_get_args()); 
		$logid = $this->Resquest_Response_log('', $request_type, '', $requestStr, $record_id);
		$curl = curl_init();
		switch ($method){
		   case "POST":
			  curl_setopt($curl, CURLOPT_POST, 1);
			  if ($data)
				 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			  break;
		   case "PUT":
			  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
			  if ($data)
				 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
			  break;
		   default:
			  if ($data)
				 $url = sprintf("%s?%s", $url, http_build_query($data));
		}
		// OPTIONS:
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		// EXECUTE:
		$response = curl_exec($curl);
		$curl_getinfo = curl_getinfo($curl);	
		$response_array = json_decode($response, true);
		if(is_array($response_array) && isset($curl_getinfo['http_code']) && $curl_getinfo['http_code'] != '')
		{
			$response_array['http_code'] = $curl_getinfo['http_code'];
		}
		else
		{
			$response_array = array();
			$response_array['http_code'] = '';
		}
		
		curl_close($curl);
		$result = json_encode($response_array);
		$logid = $this->Resquest_Response_log($logid,'', $result, '', '');
		return $result;
	}
  
function arrayToString($str)
{
	$response  = '';
	if( is_array($str))
	{
		$response = implode(', ', $str);
	}
	else
	{
		$response = (!empty($str)) ? $str : '-';
	}
	if($response == '')
	{
		$response =  '-';
	}
	return $response; 
}



function signup_email_tmpl($contact_name, $username, $password, $source="")
{
	$history_link = APP_URL.'index.php?'.$this->encode("stat=new_order");
	$trial = "";
	if($source == 'LIVE_TRIAL')
	{
		$trial_end_date = $this->formatdate(date('Y-m-d',strtotime('+'.DEFAULT_TRIAL_DAYS.' days')), "j-M-Y");
		$trial = "<p><b>This is a trial account which will be deactivated automatically on ".$trial_end_date.".</b></p>";
	}
	
	$body = '<table class="main" style="margin-top:10px !important; width: 100%; background: #e4dede; border-radius: 3px;"> <tr>
		<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
		  <table border="0" cellpadding="10" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color:#fff;">
			<tr> 
			  <td style="font-family: sans-serif; font-size: 16px; vertical-align: top;">
				<p width="30%" style="width:25% !important;" ><img width="25%" style="width:25% !important;" src="'.APP_URL.LOGO_PATH.'" /></p>
				<p style="font-family: sans-serif; font-size: 16px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Welcome  '.ucwords($contact_name).' ,</br>
				We are so happy to have you on-boarded! </br>
				Now you can get your own AI based search done <a href="'.$history_link.'">here</a> </br></br>'.$trial.'</br>If you have any questions regarding your account, click <b>Reply</b> on your email and we will be happy to help.</br> </br> For your record, here is a copy of the information you submitted: <p>User Name : <b><u>'.$username.'</u></b></p><p>Password : <b><u>'.$password.'</u></b></p></p>
				
				<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Thank you,<p>'.APP_NAME.' Team</p></p></br>
				
			  </td>
			</tr>
	</table></td>
		</tr>
	</table>';
	return $body;
}

function forgot_password_email_tmpl($contact_name, $password)
{
	$body = '<table class="main" style="margin-top:10px !important; width: 100%; background: #e4dede; border-radius: 3px;"> <tr>
		<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">  
		  <table border="0" cellpadding="30" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color:#fff;">
			<tr>
			  <td style="font-family: sans-serif; font-size: 16px; vertical-align: top;">
				<p width="30%" style="width:30% !important;" ><img width="50%" style="50% !important;" src="'.APP_URL.LOGO_PATH.'" /></p>
				<p style="font-family: sans-serif; font-size: 16px; font-weight: normal; margin: 0; ">Hi  '.ucwords($contact_name).' ,</p>
				<p>We have successfully reset your password.</p>
				<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">If you have any questions regarding your account, click <b>Reply</b> on your email and we will be happy to help.</p>
				<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Your new password is :  <b><u>'.$password.'</u></b></p>
				
				<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Thank you,<p>'.APP_NAME.' Team</p></p></br>
				<p><center><span  style="color: #999999; font-size: 12px; text-align: center;"><h2>"'.APP_FULL_NAME.'"</h2></span></center></p>
			  </td>
			</tr>
	</table></td>
		</tr>
	</table>';
	return $body;
}

function getResultsArray(string $tbl, string $fields, $con)
{
  	$query = "select ".$fields. " from "  .$tbl.  " where ".$con;
    $result = $this->executeQry($query);
	if($result)
	{
		$rows = $this->getTotalRow($result);
	}
	else
	{
		$rows = 0;
	}
    
    $response = array();
	if($rows>0)
	{
		while($rows = $this->fetch_assoc($result))
		{			
			$response[] = $rows;		
		}
	}
	return $response;	
}

function generateCSRF($action)
{
	if($action == "GENERATE")
	{
		$length = 32;
		$_SESSION['csrf_token'] = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $length); 
		// 1 hour = 60 seconds * 60 minutes = 3600
		$_SESSION['token-expire'] = time() + 1800;
		return $_SESSION['csrf_token'];
	}
	else
	{
		// THEN CHECK FOR THE EXPIRY ON REQUEST
		if (isset($_SESSION['csrf_token']) && $_SESSION['csrf_token']==$_POST['token']) 
		{
			if (time() >= $_SESSION['token-expire'])
			{
				return false;
			} 
			else 
			{
				return true;
			}
		}
	}
}
function generate_family_id()
{
    $generate_num = '';
    $sql = "SELECT (id+1) as id FROM ".FAMILY_ID." WHERE 1 order by id DESC LIMIT 1";
    $result = $this->executeQry($sql);
    if($this->num_rows($result) > 0)
    {
        $row = $this->fetch_object($result);
        if($row->id > 0)
        {
           
            $generate_num = date('y').'-'.$row->id;
            
        }
    }else{
		$generate_num = date('y').'- 1';
	}
	return $generate_num;
}
  function create_pdf($content,$filepath,$papersize)
{
try {
	$dompdf = new Dompdf();
	$dompdf->loadHtml($content);
	if ($papersize == 'A5') {
			$dompdf->setPaper('A5', 'portrait');
		} else {
			$dompdf->setPaper('A4', 'portrait');
		}
	$dompdf->set_option( 'defaultFont' , 'DejaVu Sans' );
	$dompdf->set_option( 'isRemoteEnabled' , TRUE );
	$dompdf->set_option( 'debugKeepTemp' , FALSE );
	$dompdf->set_option( 'isHtml5ParserEnabled' , true );
	$dompdf->set_option('DOMPDF_UNICODE_ENABLED', 'true');
	$dompdf->render();
	//$dompdf->stream(); exit;
	$output = $dompdf->output();
	file_put_contents($filepath , $output);
	if(file_exists($filepath))
	{
	return 1;
	}
	else
	{
	return 0;
	}
} catch (\Exception $e) {
	return 0;
}
} 

function invoiceSafeText($value)
{
	return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function saveCompressedProfileImage($base64_image, $upload_dir)
{
	if (trim($base64_image) == '') {
		return '';
	}
	if (!is_dir($upload_dir)) {
		@mkdir($upload_dir, 0775, true);
	}
	$image_parts = explode(";base64,", $base64_image);
	if (count($image_parts) < 2) {
		return '';
	}
	$image_data = base64_decode($image_parts[1]);
	if ($image_data === false) {
		return '';
	}
	$file_name = uniqid().'.jpg';
	$file_path = rtrim($upload_dir, '/\\').'/'.$file_name;
	if (!function_exists('imagecreatefromstring')) {
		file_put_contents($file_path, $image_data);
		return file_exists($file_path) ? $file_name : '';
	}
	$source = @imagecreatefromstring($image_data);
	if (!$source) {
		file_put_contents($file_path, $image_data);
		return file_exists($file_path) ? $file_name : '';
	}
	$width = imagesx($source);
	$height = imagesy($source);
	$max_size = 900;
	$ratio = min($max_size / max($width, 1), $max_size / max($height, 1), 1);
	$new_width = (int)max(1, round($width * $ratio));
	$new_height = (int)max(1, round($height * $ratio));
	$target = imagecreatetruecolor($new_width, $new_height);
	$white = imagecolorallocate($target, 255, 255, 255);
	imagefilledrectangle($target, 0, 0, $new_width, $new_height, $white);
	imagecopyresampled($target, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
	imagejpeg($target, $file_path, 88);
	imagedestroy($source);
	imagedestroy($target);
	return file_exists($file_path) ? $file_name : '';
}

function invoiceLogoDataUri()
{
	$logo_path = ABSOLUTE_ROOT_PATH.'images/logos/logo.png';
	if (!is_file($logo_path)) {
		$logo_path = ABSOLUTE_ROOT_PATH.'images/logos/logo.jpg';
	}
	if (!is_file($logo_path)) {
		return LOGO_PATH;
	}
	$type = strtolower(pathinfo($logo_path, PATHINFO_EXTENSION));
	$mime = ($type == 'jpg' || $type == 'jpeg') ? 'image/jpeg' : 'image/png';
	return 'data:'.$mime.';base64,'.base64_encode(file_get_contents($logo_path));
}

function deleteInvoiceFile($file_name)
{
	$file_name = basename(trim($file_name));
	if ($file_name == '' || !preg_match('/^Invoice_[0-9]+\.pdf$/', $file_name)) {
		return false;
	}
	$base_path = realpath(ABSOLUTE_ROOT_INV);
	$file_path = ABSOLUTE_ROOT_INV.$file_name;
	$real_path = realpath($file_path);
	if ($base_path === false || $real_path === false || strpos($real_path, $base_path) !== 0) {
		return false;
	}
	if (is_file($real_path)) {
		return @unlink($real_path);
	}
	return false;
}

function invoiceHtml($id,$type = '', $with_logo = true)
{
    $sql = "SELECT * FROM " . MEMBERS . " where id ='".$this->escape($id)."'";
    $result = $this->executeQry($sql);
    $rows = $this->fetch_assoc($result);
	if (empty($rows)) {
		return '';
	}
    $plan_details = $this->singleRowAssoc_new('*', PLANS, 'id = "'.$this->escape($rows['plan_id']).'"');
    $sql123 = "SELECT COUNT(id) AS count_rows FROM ".MEMBERS." WHERE member_id = '".$this->escape($rows['member_id'])."'";
    $result123 = $this->executeQry($sql123);
    $num_arr = $this->fetch_array($result123);
	if($type == 'Single' || (isset($rows['membership_type']) && $rows['membership_type'] == 'Single')){
		$num = isset($num_arr['count_rows']) ? $num_arr['count_rows'] : 1;
	}else{
		$num = 'Family Group';
	}
	$plan_title = isset($plan_details['title']) ? $plan_details['title'] : '';
	$plan_price = isset($plan_details['price']) ? $plan_details['price'] : '';
	$paid = isset($rows['discounted_price']) ? $rows['discounted_price'] : 0;
	$invoice_no = 'SGA-'.str_replace(array(' ', '/'), '-', $rows['member_id']).'-'.date('YmdHis');
	$generated_on = date('d M Y, h:i A');
	$period = $rows['start_date'].' to '.$rows['end_date'];
	$logo = $with_logo ? $this->invoiceLogoDataUri() : '';
	$logo_html = ($logo != '') ? '<img src="'.$logo.'" class="logo" />' : '<div class="logo-text">SGA</div>';

    return '<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Invoice '.$this->invoiceSafeText($invoice_no).'</title>
<style type="text/css">
	* { box-sizing: border-box; }
	@page { margin: 18px; }
	body { margin: 0; padding: 0; font-family: DejaVu Sans, Arial, sans-serif; color: #202833; background: #ffffff; font-size: 10.5px; }
	.invoice { border: 1px solid #d8e0ea; page-break-inside: avoid; }
	.header { background: #4b5563; color: #ffffff; padding: 14px 18px; }
	.brand-table, .section-table, .items { width: 100%; border-collapse: collapse; }
	.logo { width: 54px; height: 42px; object-fit: contain; }
	.logo-text { width: 54px; height: 42px; border: 1px solid #ffffff; text-align: center; line-height: 42px; font-size: 17px; font-weight: bold; }
	.company { font-size: 18px; font-weight: bold; letter-spacing: .3px; margin: 0; }
	.subtle { color: #6f7d8c; }
	.header .subtle { color: #edf0f4; }
	.invoice-title { text-align: right; font-size: 23px; font-weight: bold; }
	.invoice-meta { text-align: right; line-height: 1.45; font-size: 9px; }
	.content { padding: 16px 18px; }
	.label { color: #6f7d8c; font-size: 8.5px; text-transform: uppercase; letter-spacing: .4px; margin-bottom: 4px; }
	.value { font-size: 10.5px; line-height: 1.45; }
	.box { border: 1px solid #d8e0ea; padding: 10px; background: #fbfcfe; min-height: 82px; }
	.items { margin-top: 14px; }
	.items th { background: #edf3f8; color: #24364a; text-align: left; padding: 7px; border-bottom: 1px solid #d8e0ea; font-size: 9.5px; }
	.items td { padding: 8px 7px; border-bottom: 1px solid #edf0f4; vertical-align: top; }
	.items tfoot td { padding: 7px; font-weight: bold; border-bottom: 0; }
	.text-right { text-align: right; }
	.grand-label, .grand-value { background: #4b5563; color: #ffffff; font-size: 12px; }
	.note { margin-top: 12px; padding: 9px; background: #fff8e6; border: 1px solid #f0d88a; line-height: 1.45; clear: both; }
	.footer { margin-top: 10px; color: #6f7d8c; font-size: 9.5px; line-height: 1.45; clear: both; }
</style>
</head>
<body>
<div class="invoice">
	<div class="header">
		<table class="brand-table">
			<tr>
				<td width="70%">
					<table>
						<tr>
							<td>'.$logo_html.'</td>
							<td style="padding-left:12px;">
								<p class="company">Swim Gym Academy</p>
								<div class="subtle">Rohtak | Professional Swimming Academy</div>
							</td>
						</tr>
					</table>
				</td>
				<td width="30%">
					<div class="invoice-title">INVOICE</div>
					<div class="invoice-meta">
						Invoice No: '.$this->invoiceSafeText($invoice_no).'<br/>
						Date: '.$this->invoiceSafeText($generated_on).'
					</div>
				</td>
			</tr>
		</table>
	</div>
	<div class="content">
		<table class="section-table">
			<tr>
				<td width="50%" style="padding-right:10px;">
					<div class="box">
						<div class="label">Billed To</div>
						<div class="value">
							<strong>'.$this->invoiceSafeText($rows['name']).'</strong><br/>
							Mobile: '.$this->invoiceSafeText($rows['mobile']).'<br/>
							Email: '.$this->invoiceSafeText($rows['email']).'<br/>
							Membership ID: '.$this->invoiceSafeText($rows['member_id']).'
						</div>
					</div>
				</td>
				<td width="50%" style="padding-left:10px;">
					<div class="box">
						<div class="label">Membership Details</div>
						<div class="value">
							Plan: <strong>'.$this->invoiceSafeText($plan_title).'</strong><br/>
							Period: '.$this->invoiceSafeText($period).'<br/>
							Timing: '.$this->invoiceSafeText(isset($rows['timing']) ? $rows['timing'] : '').'<br/>
							Members: '.$this->invoiceSafeText($num).'
						</div>
					</div>
				</td>
			</tr>
		</table>
		<table class="items">
			<thead>
				<tr>
					<th width="8%">#</th>
					<th width="32%">Description</th>
					<th width="22%">Duration</th>
					<th width="16%" class="text-right">Base Price</th>
					<th width="22%" class="text-right">Amount Paid</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>1</td>
					<td>'.$this->invoiceSafeText($plan_title).'</td>
					<td>'.$this->invoiceSafeText($period).'</td>
					<td class="text-right">Rs. '.$this->invoiceSafeText($plan_price).'</td>
					<td class="text-right">Rs. '.$this->invoiceSafeText($paid).'</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="3"></td>
					<td class="text-right">Subtotal</td>
					<td class="text-right">Rs. '.$this->invoiceSafeText($paid).'</td>
				</tr>
				<tr>
					<td colspan="3"></td>
					<td class="grand-label text-right">Total Paid</td>
					<td class="grand-value text-right">Rs. '.$this->invoiceSafeText($paid).'</td>
				</tr>
			</tfoot>
		</table>
		<div class="note">
			<strong>Note:</strong> Fees once paid are non-returnable, non-transferable, and non-refundable under any circumstances.
		</div>
		<div class="footer">
			This is a computer-generated invoice from Swim Gym Academy. Generated on '.$this->invoiceSafeText($generated_on).'.<br/>
			Thank you for choosing Swim Gym Academy.
		</div>
	</div>
</div>
</body>
</html>';
}

function generate_membership_id()
{
    $generate_num = '';
    $sql = "SELECT (id+1) as id FROM ".MEMBERS." WHERE 1 order by id DESC LIMIT 1";
    $result = $this->executeQry($sql);
    if($this->num_rows($result) > 0)
    {
        $row = $this->fetch_object($result);
        if($row->id > 0)
        {
           
            $generate_num = date('y').'-'.$row->id;
            
        }
    }else{
		$generate_num = date('y').'- 1';
	}
	return $generate_num;
}
function xss_clean($data)
{
        // Fix &entity\n;
        $data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
        $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
        $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
        $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

        // Remove any attribute starting with "on" or xmlns
        $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

        // Remove javascript: and vbscript: protocols
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

        // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

        // Remove namespaced elements (we do not need them)
        $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

        do
        {
                // Remove really unwanted tags
                $old_data = $data;
                $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
        }
        while ($old_data !== $data);

        // we are done...
        return $data;
}

function RemoveSpecialChapr($str)
	{
		$str = str_replace("\n", '', str_replace("\r", '', $str));		
		return $str;
	}
function escapeJsonString($value) { # list from www.json.org: (\b backspace, \f formfeed)
    $escapers = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c");
    $replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b");
    $result = str_replace($escapers, $replacements, $value);
    return $result;
}
 /* function create_pdf($content, $filepath)
{
        $dompdf = new Dompdf();
        $dompdf->loadHtml($content);
        $dompdf->setPaper('A4');
        $dompdf->set_option('defaultFont', 'Courier');
        $dompdf->set_option('isRemoteEnabled', true);
        $dompdf->set_option('debugKeepTemp', true);
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->set_option('DOMPDF_UNICODE_ENABLED', true);
        $dompdf->render();
        
        $output = $dompdf->output();
        
        // Attempt to write the file
        if (file_put_contents($filepath, $output) !== false) {
            return 1; // File successfully created
        } else {
            return 0; // File creation failed
        }
   
}
 */
 
function RecTimeStamp($format)
{
	$zone = 3600*+5.45;	
	$date = gmdate($format, time() + $zone);		
	return $date;
}

function prompt($prompt_msg){
        echo("<script type='text/javascript'> var answer = confirm('".$prompt_msg."'); </script>");
        $answer = "<script type='text/javascript'> document.write(answer); </script>";
        return($answer);
    }

function decimalHours($time)
{
	$hms = explode(":", $time);
	//return ($hms[0] + ($hms[1]/60) + ($hms[2]/3600));
	return ($hms[0].".".$hms[1]);
}
		
function decimalHoursOnly($time)
{
	$hms = explode(":", $time);
	return ($hms[0]);
}


function Getdatediff($date1,$date2)
{
	$date_a = new DateTime($date1);
	$date_b = new DateTime($date2);
	$interval = date_diff($date_a,$date_b);
	$time = $interval->format('%h:%i:%s');
	return $time;
}
		
 function Getdatediff_new($date1,$date2)
{
	$date_a = new DateTime($date1);
	$date_b = new DateTime($date2);
	$interval = date_diff($date_a,$date_b);
	$hms = explode(":", $interval);
	//$time = (int) $interval->format('%h.%i');
	$totaltime = ($hms[0].".".$hms[1]);
	return $totaltime;
}

function date_diff_in_days($date1,$date2)
{

	$date1=date_create($date1);
	$date2=date_create($date2);
	$diff=date_diff($date1,$date2);
	$days = $diff->format("%a")+1;
	return $days;
}

function isJson($string) {
   json_decode($string);
   return json_last_error() === JSON_ERROR_NONE;
}


function get1MGUrlFromGoogle($title){
    $url = "http://www.google.com/search?q=substitute + of + ".rawurlencode($title)." + 1 MG";
    echo $html = $this->geturl($url);
	$urls = $this->match_all('/<a href="(http:\/\/www.1mg.com\/drugs\/)".*?>.*?<\/a>/ms', $html, 1);
	print_r($urls);
    if (!isset($urls[0]))
        return NULL;
    else
        return $urls[0]; //return first 1mg result

}  

function get1MgUrl($title)
{
    include_once(ABSOLUTE_ROOT_PATH.'simple_html_dom.php');
	$url = "http://www.google.com/search?q=substitute+of+".rawurlencode($title)."+1MG";
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 5.1; rv:2.0.1) Gecko/20100101 Firefox/4.0.1");
    $result = curl_exec($ch);
    curl_close($ch);
	$domResult = new simple_html_dom();
	$domResult->load($result);
	
	 
	foreach($domResult->find('a[href^=/url?]') as $link)
	{
		
		if(strpos($link->href,"1mg.com") !== false)
		{
			$link_only = explode("&",$link->href);
			
			return str_replace("/url?q=","",$link_only[0]);
		}
	}
}

function verify_otp($otp)
{
	$RecTimeStamp = $this->RecTimeStamp("Y-m-d");
	$otp_verify = false;
	$expr = '/^[1-9][0-9]*$/';
	if (preg_match($expr,$otp) && filter_var($otp, FILTER_VALIDATE_INT))
	{
		$first = substr($otp,0,2);
		$last_arr = explode($first,$otp);
		$last = $last_arr[1]; 
		$num = (($last+12)/3)+5;	
		
		if(($num - $first) == 8)
		{
			$before15days = Date('Y-m-d',strtotime('-2 days',strtotime($RecTimeStamp)))." 00:00:00";
			$current = $RecTimeStamp." 23:59:59";
			$sql = "SELECT * FROM tbl_attendance_otp WHERE otp = '".$otp."' and rectimestamp >= '".$before15days."' and rectimestamp <= '".$current."'";
			$result = $this->executeQry($sql);
			if($this->num_rows($result))
			{
				$otp_verify = false;
			}
			else
			{
				$otp_verify = true;
			}
		}
	}
	return $otp_verify;
}
function generateInvoice($id,$type) {
    $file_name = 'Invoice_' . date("Ymd") . rand() . ".pdf";
    $html_content = $this->invoiceHtml($id,$type);
	if ($html_content == '') {
		return '';
	}
    $file_path = ABSOLUTE_ROOT_INV . $file_name;
    $created = $this->create_pdf($html_content, $file_path,'A4');
	if (!$created) {
		$html_content = $this->invoiceHtml($id,$type,false);
		$created = $this->create_pdf($html_content, $file_path,'A4');
	}
    return file_exists($file_path) ? $file_name : '';
}
function createcookie($name,$value)
{
	$timeout = time()+60*60*24*15;
	setcookie($name,"$value",$timeout);	
}
function deletecookie($name)
{
	$timeout = time() - 60 * 60 * 24 * 16;
    setcookie($name,'',$timeout);
}


	function add_remove_ip($ip_adress,$action)
	{
		copy('.htaccess', 'htaccess_bkp');
		$rules = "Require ip ".$ip_adress."\n";
		$htaccess = file_get_contents('.htaccess');
		if($action == "add")
		{
			$htaccess = str_replace('###CUSTOM RULES###', $rules."\n###CUSTOM RULES###", $htaccess);			
		}
		else if($action == "remove")
		{
			$htaccess = str_replace($rules, "", $htaccess);
		}
		#echo $rules;
		#echo "#############";
		#echo $htaccess; exit;
		file_put_contents('.htaccess', $htaccess);
	}
	
	function formatPhoneNumber($phoneNumber) 
	{
		$phoneNumber = preg_replace('/[^0-9]/','',$phoneNumber);

		if(strlen($phoneNumber) > 10) {
			$countryCode = substr($phoneNumber, 0, strlen($phoneNumber)-10);
			$areaCode = substr($phoneNumber, -10, 3);
			$nextThree = substr($phoneNumber, -7, 3);
			$lastFour = substr($phoneNumber, -4, 4);

			$phoneNumber = '+'.$countryCode.' ('.$areaCode.') '.$nextThree.'-'.$lastFour;
		}
		else if(strlen($phoneNumber) == 10) {
			$areaCode = substr($phoneNumber, 0, 3);
			$nextThree = substr($phoneNumber, 3, 3);
			$lastFour = substr($phoneNumber, 6, 4);

			$phoneNumber = '('.$areaCode.') '.$nextThree.'-'.$lastFour;
		}
		else if(strlen($phoneNumber) == 7) {
			$nextThree = substr($phoneNumber, 0, 3);
			$lastFour = substr($phoneNumber, 3, 4);

			$phoneNumber = $nextThree.'-'.$lastFour;
		}

		return $phoneNumber;
	}

	function whatsappTableExists($table)
	{
		$table = $this->escape($table);
		$result = $this->executeQry("SHOW TABLES LIKE '".$table."'");
		return ($result && $this->num_rows($result) > 0);
	}

	function whatsappColumnExists($table, $column)
	{
		$table = $this->escape($table);
		$column = $this->escape($column);
		$result = $this->executeQry("SHOW COLUMNS FROM `".$table."` LIKE '".$column."'");
		return ($result && $this->num_rows($result) > 0);
	}

	function whatsappEnsureColumn($table, $column, $definition)
	{
		if (!$this->whatsappColumnExists($table, $column)) {
			$this->executeQry("ALTER TABLE `".$table."` ADD `".$column."` ".$definition);
		}
	}

	function whatsappRunMigration()
	{
		$this->executeQry("CREATE TABLE IF NOT EXISTS `".WHATSAPP_TEMPLATES."` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`system_key` varchar(100) DEFAULT NULL,
			`template_name` varchar(150) NOT NULL,
			`provider_template_name` varchar(150) NOT NULL,
			`category` enum('Utility','Marketing') NOT NULL DEFAULT 'Utility',
			`language_code` varchar(20) NOT NULL DEFAULT 'en',
			`header_format` varchar(30) NOT NULL DEFAULT 'NONE',
			`header_sample_url` text NULL,
			`body` text NOT NULL,
			`footer_text` text NULL,
			`placeholder_order` text NULL,
			`status` enum('Pending','Approved','Rejected') NOT NULL DEFAULT 'Pending',
			`provider_status` varchar(50) DEFAULT NULL,
			`api_response` longtext NULL,
			`created_by` varchar(100) DEFAULT NULL,
			`created_on` datetime DEFAULT NULL,
			`modified_on` datetime DEFAULT NULL,
			PRIMARY KEY (`id`),
			UNIQUE KEY `system_key` (`system_key`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

		$this->executeQry("CREATE TABLE IF NOT EXISTS `".WHATSAPP_QUEUE."` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`batch_key` varchar(100) DEFAULT NULL,
			`user_id` int(11) DEFAULT NULL,
			`member_id` varchar(100) DEFAULT NULL,
			`mobile` varchar(30) NOT NULL,
			`template_id` int(11) DEFAULT NULL,
			`template_name` varchar(150) DEFAULT NULL,
			`message_type` varchar(50) DEFAULT NULL,
			`event_key` varchar(150) DEFAULT NULL,
			`unique_key` varchar(190) NOT NULL,
			`payload` longtext NULL,
			`status` enum('Pending','Sent','Failed','Skipped') NOT NULL DEFAULT 'Pending',
			`retry_count` int(11) NOT NULL DEFAULT 0,
			`max_retry` int(11) NOT NULL DEFAULT 3,
			`api_request` longtext NULL,
			`api_response` longtext NULL,
			`error_message` text NULL,
			`scheduled_on` datetime DEFAULT NULL,
			`sent_on` datetime DEFAULT NULL,
			`created_by` varchar(100) DEFAULT NULL,
			`created_on` datetime DEFAULT NULL,
			`modified_on` datetime DEFAULT NULL,
			PRIMARY KEY (`id`),
			UNIQUE KEY `unique_key` (`unique_key`),
			KEY `status_retry` (`status`,`retry_count`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

		$this->executeQry("CREATE TABLE IF NOT EXISTS `".WHATSAPP_LOGS."` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`queue_id` int(11) DEFAULT NULL,
			`user_id` int(11) DEFAULT NULL,
			`member_id` varchar(100) DEFAULT NULL,
			`mobile` varchar(30) DEFAULT NULL,
			`template_id` int(11) DEFAULT NULL,
			`template_name` varchar(150) DEFAULT NULL,
			`message_type` varchar(50) DEFAULT NULL,
			`event_key` varchar(150) DEFAULT NULL,
			`status` enum('Pending','Sent','Failed','Skipped') NOT NULL DEFAULT 'Pending',
			`request_payload` longtext NULL,
			`response_payload` longtext NULL,
			`error_message` text NULL,
			`retry_count` int(11) NOT NULL DEFAULT 0,
			`created_on` datetime DEFAULT NULL,
			PRIMARY KEY (`id`),
			KEY `queue_id` (`queue_id`),
			KEY `status` (`status`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

		$this->whatsappEnsureColumn(WHATSAPP_TEMPLATES, 'created_by', "varchar(100) DEFAULT NULL");
		$this->whatsappEnsureColumn(WHATSAPP_TEMPLATES, 'modified_on', "datetime DEFAULT NULL");
		$this->whatsappEnsureColumn(WHATSAPP_TEMPLATES, 'header_format', "varchar(30) NOT NULL DEFAULT 'NONE'");
		$this->whatsappEnsureColumn(WHATSAPP_TEMPLATES, 'header_sample_url', "text NULL");
		$this->whatsappEnsureColumn(WHATSAPP_TEMPLATES, 'footer_text', "text NULL");
		$this->whatsappEnsureColumn(WHATSAPP_QUEUE, 'retry_count', "int(11) NOT NULL DEFAULT 0");
		$this->whatsappEnsureColumn(WHATSAPP_QUEUE, 'api_response', "longtext NULL");
		$this->whatsappEnsureColumn(WHATSAPP_QUEUE, 'error_message', "text NULL");
		$this->whatsappEnsureColumn(WHATSAPP_LOGS, 'response_payload', "longtext NULL");
	}

	function whatsappSeedDefaultTemplates()
	{
		$templates = array(
			array('account_created', 'Account Created', 'swimgym_account_created', 'Hello {{user_name}}, your Swim Gym Academy membership is created. Membership ID: {{member_id}}. Plan: {{plan_name}}. Start: {{start_date}}. Expiry: {{expiry_date}}. Timing: {{timing}}. Thank you, {{company_name}}.', array('user_name','member_id','plan_name','start_date','expiry_date','timing','company_name')),
			array('expiry_today', 'Expiring Today Reminder', 'swimgym_expiry_today', 'Hello {{user_name}}, your {{company_name}} membership expires today. Membership ID: {{member_id}}. Plan: {{plan_name}}. Please renew at reception to continue your swimming journey.', array('user_name','company_name','member_id','plan_name')),
			array('diwali_greeting', 'Diwali Greeting', 'swimgym_diwali_greeting', 'Hello {{user_name}}, {{company_name}} wishes you and your family a happy Diwali.', array('user_name','company_name')),
			array('new_year_greeting', 'New Year Greeting', 'swimgym_new_year_greeting', 'Hello {{user_name}}, {{company_name}} wishes you a happy New Year.', array('user_name','company_name')),
			array('service_update', 'Service Information Update', 'swimgym_service_update', 'Hello {{user_name}}, important update from {{company_name}}: {{message}}', array('user_name','company_name','message'))
		);
		foreach ($templates as $tpl) {
			$exists = $this->singleValue(WHATSAPP_TEMPLATES, 'id', "system_key = '".$this->escape($tpl[0])."'");
			if ($exists == '') {
				$sql = "INSERT INTO ".WHATSAPP_TEMPLATES." SET system_key = '".$this->escape($tpl[0])."', template_name = '".$this->escape($tpl[1])."', provider_template_name = '".$this->escape($tpl[2])."', category = 'Utility', language_code = 'en', body = '".$this->escape($tpl[3])."', placeholder_order = '".$this->escape(json_encode($tpl[4]))."', status = 'Pending', created_by = 'SYSTEM', created_on = NOW()";
				$this->executeQry($sql);
			}
		}
	}

	function whatsappHasCredentials()
	{
		return (defined('WHATSAPP_API_MESSAGE_URL') && WHATSAPP_API_MESSAGE_URL != '' && defined('WHATSAPP_WABA_NUMBER') && WHATSAPP_WABA_NUMBER != '' && defined('WHATSAPP_API_KEY') && WHATSAPP_API_KEY != '');
	}

	function whatsappNormalizeMobile($mobile)
	{
		$mobile = preg_replace('/[^0-9]/', '', $mobile);
		if (strlen($mobile) == 10 && defined('WHATSAPP_DEFAULT_COUNTRY_CODE')) {
			$mobile = WHATSAPP_DEFAULT_COUNTRY_CODE.$mobile;
		}
		return $mobile;
	}

	function whatsappIsValidMobile($mobile)
	{
		$mobile = $this->whatsappNormalizeMobile($mobile);
		return (preg_match('/^[1-9][0-9]{10,14}$/', $mobile) === 1);
	}

	function whatsappUtilityContentHasMarketingWords($content)
	{
		return (preg_match('/\b(offer|discount|promotion|promotional|campaign|sale|deal|coupon|cashback|free trial|advertisement|buy now)\b/i', $content) === 1);
	}

	function whatsappExtractPlaceholders($content)
	{
		preg_match_all('/\{\{([a-zA-Z0-9_]+)\}\}/', $content, $matches);
		return array_values(array_unique($matches[1]));
	}

	function whatsappProviderBodyText($body, $placeholders)
	{
		$text = $body;
		$index = 1;
		foreach ($placeholders as $placeholder) {
			$text = str_replace('{{'.$placeholder.'}}', '{{'.$index.'}}', $text);
			$index++;
		}
		return $text;
	}

	function whatsappPlaceholderExample($placeholder)
	{
		$examples = array(
			'user_name' => 'Romit',
			'mobile' => '919999999999',
			'member_id' => 'MEM001',
			'expiry_date' => date('Y-m-d'),
			'plan_name' => 'Monthly Plan',
			'company_name' => COMPANY_NAME,
			'message' => 'Your service information'
		);
		if (isset($examples[$placeholder])) {
			return $examples[$placeholder];
		}
		return ucwords(str_replace('_', ' ', $placeholder));
	}

	function whatsappProviderCategory($category)
	{
		return ($category == 'Marketing') ? 'MARKETING' : 'UTILITY';
	}

	function whatsappIsValidProviderTemplateName($provider_template_name)
	{
		return (preg_match('/^[a-z]{1,15}$/', $provider_template_name) === 1);
	}

	function whatsappCreateProviderTemplate($provider_template_name, $category, $language_code, $body)
	{
		$result = array('success' => false, 'request' => '', 'response' => '', 'error' => '', 'http_code' => 0);
		if (!$this->whatsappHasCredentials()) {
			$result['error'] = 'WhatsApp API credentials are missing';
			return $result;
		}
		if (!defined('WHATSAPP_API_CREATE_TEMPLATE_URL') || WHATSAPP_API_CREATE_TEMPLATE_URL == '') {
			$result['error'] = 'WhatsApp create template API is not provided in WhatsAppAPIDocument. Create the template in dgasskyworld dashboard, then use Sync Provider Template List.';
			return $result;
		}
		$placeholders = $this->whatsappExtractPlaceholders($body);
		$examples = array();
		foreach ($placeholders as $placeholder) {
			$examples[] = $this->whatsappPlaceholderExample($placeholder);
		}
		$body_component = array(
			'type' => 'BODY',
			'text' => $this->whatsappProviderBodyText($body, $placeholders)
		);
		if (count($examples) > 0) {
			$body_component['example'] = array('body_text' => array($examples));
		}
		$payload = array(
			'name' => $provider_template_name,
			'category' => $this->whatsappProviderCategory($category),
			'language' => $language_code,
			'components' => array($body_component)
		);
		$request_json = json_encode($payload);
		$headers = array(
			'wabaNumber: '.WHATSAPP_WABA_NUMBER,
			'Key: '.WHATSAPP_API_KEY,
			'Content-Type: application/json'
		);
		$ch = curl_init(WHATSAPP_API_CREATE_TEMPLATE_URL);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $request_json);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		$response = curl_exec($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if (curl_errno($ch)) {
			$result['error'] = curl_error($ch);
		}
		curl_close($ch);
		$result['request'] = $request_json;
		$result['response'] = $response;
		$result['http_code'] = $http_code;
		$result['success'] = ($result['error'] == '' && in_array($http_code, array(200, 201, 202)));
		$response_data = $this->whatsappDecodeProviderResponse($response);
		if (is_array($response_data) && isset($response_data['error'])) {
			$result['success'] = false;
			$error = $response_data['error'];
			if (is_array($error)) {
				$result['error'] = isset($error['error_user_msg']) ? $error['error_user_msg'] : (isset($error['message']) ? $error['message'] : json_encode($error));
			} else {
				$result['error'] = (string)$error;
			}
		}
		if (!$result['success'] && $result['error'] == '') {
			$result['error'] = 'WhatsApp create template API returned HTTP '.$http_code;
		}
		$this->Resquest_Response_log('', 'WHATSAPP_CREATE_TEMPLATE', $response, $request_json, '', array('http_code' => $http_code, 'error' => $result['error']));
		return $result;
	}

	function whatsappCreateTemplate($template_name, $provider_template_name, $category, $language_code, $body, $created_by = '')
	{
		$this->whatsappRunMigration();
		$response = array();
		$category = ($category == 'Marketing') ? 'Marketing' : 'Utility';
		$provider_template_name = strtolower(trim($provider_template_name));
		if (!$this->whatsappIsValidProviderTemplateName($provider_template_name)) {
			$response['msg_code'] = '05';
			$response['msg'] = 'Provider template name can only use lowercase alphabetic characters a-z, no spaces, no numbers, no special characters, maximum 15 characters. Example: welcome';
			return $response;
		}
		if ($category == 'Utility' && $this->whatsappUtilityContentHasMarketingWords($body)) {
			$response['msg_code'] = '05';
			$response['msg'] = 'Offer, discount, promotion, or campaign messages are treated as Marketing templates and should not be created under Utility.';
			return $response;
		}
		$placeholders = $this->whatsappExtractPlaceholders($body);
		$provider_response = $this->whatsappCreateProviderTemplate($provider_template_name, $category, $language_code, $body);
		if (!$provider_response['success']) {
			$response['msg_code'] = '05';
			$response['msg'] = $provider_response['error'];
			return $response;
		}
		$api_response = $provider_response['success'] ? $provider_response['response'] : $provider_response['error'].' '.$provider_response['response'];
		$provider_status = $provider_response['success'] ? 'SUBMITTED' : 'CREATE_FAILED';
		$existing_id = $this->singleValue(WHATSAPP_TEMPLATES, 'id', "provider_template_name = '".$this->escape($provider_template_name)."'");
		if ($existing_id != '') {
			$sql = "UPDATE ".WHATSAPP_TEMPLATES." SET template_name = '".$this->escape($template_name)."', category = '".$this->escape($category)."', language_code = '".$this->escape($language_code)."', header_format = 'NONE', header_sample_url = '', body = '".$this->escape($body)."', footer_text = '', placeholder_order = '".$this->escape(json_encode($placeholders))."', status = 'Pending', provider_status = '".$this->escape($provider_status)."', api_response = '".$this->escape($api_response)."', modified_on = NOW() WHERE id = '".$existing_id."'";
		} else {
			$sql = "INSERT INTO ".WHATSAPP_TEMPLATES." SET template_name = '".$this->escape($template_name)."', provider_template_name = '".$this->escape($provider_template_name)."', category = '".$this->escape($category)."', language_code = '".$this->escape($language_code)."', header_format = 'NONE', header_sample_url = '', body = '".$this->escape($body)."', footer_text = '', placeholder_order = '".$this->escape(json_encode($placeholders))."', status = 'Pending', provider_status = '".$this->escape($provider_status)."', api_response = '".$this->escape($api_response)."', created_by = '".$this->escape($created_by)."', created_on = NOW(), modified_on = NOW()";
		}
		$this->executeQry($sql);
		$single_sync = $this->whatsappSyncTemplateByName($provider_template_name);
		if (!isset($single_sync['msg_code']) || $single_sync['msg_code'] != '00') {
			$this->whatsappSyncTemplateList();
		}
		$response['msg_code'] = '00';
		$response['msg'] = 'WhatsApp template submitted to provider and saved with Pending status.';
		return $response;
	}

	function whatsappGetApprovedTemplate($provider_template_name)
	{
		if (!$this->whatsappTableExists(WHATSAPP_TEMPLATES)) {
			return array();
		}
		$provider_template_name = trim($provider_template_name);
		if ($provider_template_name == '') {
			return array();
		}
		return $this->singleRowAssoc_new('*', WHATSAPP_TEMPLATES, "provider_template_name = '".$this->escape($provider_template_name)."' and status = 'Approved'");
	}

	function whatsappGetTemplateById($template_id, $approved_only = true)
	{
		if (!$this->whatsappTableExists(WHATSAPP_TEMPLATES)) {
			return array();
		}
		$con = "id = '".$this->escape($template_id)."'";
		if ($approved_only) {
			$con .= " and status = 'Approved'";
		}
		return $this->singleRowAssoc_new('*', WHATSAPP_TEMPLATES, $con);
	}

	function whatsappAddLog($queue_id, $user_id, $member_id, $mobile, $template_id, $template_name, $message_type, $event_key, $status, $request_payload = '', $response_payload = '', $error_message = '', $retry_count = 0)
	{
		if (!$this->whatsappTableExists(WHATSAPP_LOGS)) {
			return 0;
		}
		$sql = "INSERT INTO ".WHATSAPP_LOGS." SET queue_id = '".$this->escape($queue_id)."', user_id = '".$this->escape($user_id)."', member_id = '".$this->escape($member_id)."', mobile = '".$this->escape($mobile)."', template_id = '".$this->escape($template_id)."', template_name = '".$this->escape($template_name)."', message_type = '".$this->escape($message_type)."', event_key = '".$this->escape($event_key)."', status = '".$this->escape($status)."', request_payload = '".$this->escape($request_payload)."', response_payload = '".$this->escape($response_payload)."', error_message = '".$this->escape($error_message)."', retry_count = '".$this->escape($retry_count)."', created_on = NOW()";
		$this->executeQry($sql);
		return $this->insert_id();
	}

	function whatsappEnqueueTemplateForMember($member, $template, $params, $message_type, $event_key, $unique_suffix = '', $created_by = '')
	{
		$this->whatsappRunMigration();
		$user_id = isset($member['id']) ? $member['id'] : 0;
		$member_id = isset($member['member_id']) ? $member['member_id'] : '';
		$mobile = isset($member['mobile']) ? $this->whatsappNormalizeMobile($member['mobile']) : '';
		$template_id = isset($template['id']) ? $template['id'] : 0;
		$template_name = isset($template['provider_template_name']) ? $template['provider_template_name'] : '';
		if (!$this->whatsappIsValidMobile($mobile)) {
			$this->whatsappAddLog(0, $user_id, $member_id, $mobile, $template_id, $template_name, $message_type, $event_key, 'Skipped', '', '', 'Mobile number empty or invalid');
			return 0;
		}
		if (empty($template) || !isset($template['status']) || $template['status'] != 'Approved') {
			$this->whatsappAddLog(0, $user_id, $member_id, $mobile, $template_id, $template_name, $message_type, $event_key, 'Skipped', '', '', 'WhatsApp template is missing or not approved');
			return 0;
		}
		$unique_key = $event_key.':'.$user_id;
		if ($unique_suffix != '') {
			$unique_key .= ':'.$unique_suffix;
		}
		$exists = $this->singleValue(WHATSAPP_QUEUE, 'id', "unique_key = '".$this->escape($unique_key)."'");
		if ($exists != '') {
			$this->whatsappAddLog($exists, $user_id, $member_id, $mobile, $template_id, $template_name, $message_type, $event_key, 'Skipped', '', '', 'Duplicate scheduled WhatsApp message skipped');
			return 0;
		}
		$payload = json_encode($params);
		$batch_key = date('YmdHis').'_'.rand(1000,9999);
		$sql = "INSERT INTO ".WHATSAPP_QUEUE." SET batch_key = '".$this->escape($batch_key)."', user_id = '".$this->escape($user_id)."', member_id = '".$this->escape($member_id)."', mobile = '".$this->escape($mobile)."', template_id = '".$this->escape($template_id)."', template_name = '".$this->escape($template_name)."', message_type = '".$this->escape($message_type)."', event_key = '".$this->escape($event_key)."', unique_key = '".$this->escape($unique_key)."', payload = '".$this->escape($payload)."', status = 'Pending', max_retry = '".WHATSAPP_MAX_RETRY."', scheduled_on = NOW(), created_by = '".$this->escape($created_by)."', created_on = NOW()";
		$this->executeQry($sql);
		$queue_id = $this->insert_id();
		$this->whatsappAddLog($queue_id, $user_id, $member_id, $mobile, $template_id, $template_name, $message_type, $event_key, 'Pending', '', '', 'Queued for WhatsApp batch sending');
		return $queue_id;
	}

	function whatsappEnqueueDocumentForMember($member, $document_link, $filename, $caption, $message_type, $event_key, $unique_suffix = '', $created_by = '', $template_name = '')
	{
		$this->whatsappRunMigration();
		$template = $this->whatsappGetApprovedTemplate($template_name);
		$user_id = isset($member['id']) ? $member['id'] : 0;
		$member_id = isset($member['member_id']) ? $member['member_id'] : '';
		$mobile = isset($member['mobile']) ? $this->whatsappNormalizeMobile($member['mobile']) : '';
		$template_id = isset($template['id']) ? $template['id'] : 0;
		if (!$this->whatsappIsValidMobile($mobile)) {
			$this->whatsappAddLog(0, $user_id, $member_id, $mobile, $template_id, $template_name, $message_type, $event_key, 'Skipped', '', '', 'Mobile number empty or invalid');
			return 0;
		}
		if (empty($template) || !isset($template['status']) || $template['status'] != 'Approved') {
			$this->whatsappAddLog(0, $user_id, $member_id, $mobile, $template_id, $template_name, $message_type, $event_key, 'Skipped', '', '', 'WhatsApp invoice template is missing or not approved');
			return 0;
		}
		if (trim($document_link) == '') {
			$this->whatsappAddLog(0, $user_id, $member_id, $mobile, $template_id, $template_name, $message_type, $event_key, 'Skipped', '', '', 'Invoice PDF link is missing');
			return 0;
		}
		$unique_key = $event_key.':'.$user_id;
		if ($unique_suffix != '') {
			$unique_key .= ':'.$unique_suffix;
		}
		$exists = $this->singleValue(WHATSAPP_QUEUE, 'id', "unique_key = '".$this->escape($unique_key)."'");
		if ($exists != '') {
			$this->whatsappAddLog($exists, $user_id, $member_id, $mobile, 0, $template_name, $message_type, $event_key, 'Skipped', '', '', 'Duplicate scheduled WhatsApp document skipped');
			return 0;
		}
		$payload = json_encode(array(
			'document_link' => $document_link,
			'document_filename' => ($filename != '') ? $filename : 'invoice.pdf',
			'caption' => $caption,
			'template_params' => $this->whatsappMemberParams($member, isset($member['plan_details']) ? $member['plan_details'] : array())
		));
		$batch_key = date('YmdHis').'_'.rand(1000,9999);
		$sql = "INSERT INTO ".WHATSAPP_QUEUE." SET batch_key = '".$this->escape($batch_key)."', user_id = '".$this->escape($user_id)."', member_id = '".$this->escape($member_id)."', mobile = '".$this->escape($mobile)."', template_id = '".$this->escape($template_id)."', template_name = '".$this->escape($template_name)."', message_type = '".$this->escape($message_type)."', event_key = '".$this->escape($event_key)."', unique_key = '".$this->escape($unique_key)."', payload = '".$this->escape($payload)."', status = 'Pending', max_retry = '".WHATSAPP_MAX_RETRY."', scheduled_on = NOW(), created_by = '".$this->escape($created_by)."', created_on = NOW()";
		$this->executeQry($sql);
		$queue_id = $this->insert_id();
		$this->whatsappAddLog($queue_id, $user_id, $member_id, $mobile, $template_id, $template_name, $message_type, $event_key, 'Pending', '', '', 'Queued invoice PDF for WhatsApp template sending');
		return $queue_id;
	}

	function whatsappBuildParams($template, $params)
	{
		$order = array();
		if (isset($template['placeholder_order']) && $this->isJson($template['placeholder_order'])) {
			$order = json_decode($template['placeholder_order'], true);
		}
		if (!is_array($order) || count($order) == 0) {
			$order = $this->whatsappExtractPlaceholders(isset($template['body']) ? $template['body'] : '');
		}
		$default_order = $this->whatsappTemplateDefaultOrder($template, count($order));
		$parameters = array();
		foreach ($order as $index => $placeholder) {
			if (is_numeric($placeholder) && isset($default_order[$index])) {
				$placeholder = $default_order[$index];
			}
			$value = isset($params[$placeholder]) ? $params[$placeholder] : '';
			$parameters[] = array('type' => 'text', 'text' => (string)$value);
		}
		return $parameters;
	}

	function whatsappTemplateDefaultOrder($template, $placeholder_count = 0)
	{
		$name = isset($template['provider_template_name']) ? strtolower($template['provider_template_name']) : '';
		if ($name == (defined('WHATSAPP_TEMPLATE_ACCOUNT_CREATED') ? WHATSAPP_TEMPLATE_ACCOUNT_CREATED : '')) {
			if ($placeholder_count == 6) {
				return array('user_name','member_id','plan_name','start_date','expiry_date','timing');
			}
			if ($placeholder_count == 7) {
				return array('company_name','user_name','member_id','plan_name','start_date','expiry_date','timing');
			}
			return array('user_name','company_name','plan_name','expiry_date');
		}
		if ($name == (defined('WHATSAPP_TEMPLATE_RENEWED') ? WHATSAPP_TEMPLATE_RENEWED : '')) {
			if ($placeholder_count == 4) {
				return array('user_name','member_id','plan_name','expiry_date');
			}
			return array('user_name','company_name','member_id','plan_name','expiry_date');
		}
		if ($name == (defined('WHATSAPP_TEMPLATE_FREEZE') ? WHATSAPP_TEMPLATE_FREEZE : '')) {
			if ($placeholder_count == 5) {
				return array('user_name','member_id','freeze_days','freeze_till','new_expiry_date');
			}
			return array('user_name','company_name','member_id','freeze_days','freeze_till','new_expiry_date');
		}
		if ($name == (defined('WHATSAPP_TEMPLATE_EXPIRY_TODAY') ? WHATSAPP_TEMPLATE_EXPIRY_TODAY : '')) {
			if ($placeholder_count == 4) {
				return array('user_name','member_id','plan_name','expiry_date');
			}
			return array('user_name','company_name','member_id','plan_name','expiry_date');
		}
		if ($name == (defined('WHATSAPP_TEMPLATE_DIWALI') ? WHATSAPP_TEMPLATE_DIWALI : '') || $name == (defined('WHATSAPP_TEMPLATE_NEW_YEAR') ? WHATSAPP_TEMPLATE_NEW_YEAR : '')) {
			if ($placeholder_count == 1) {
				return array('user_name');
			}
			return array('user_name','company_name');
		}
		return array();
	}

	function whatsappBuildTemplateRequest($mobile, $template, $params)
	{
		$components = array();
		$parameters = $this->whatsappBuildParams($template, $params);
		if (count($parameters) > 0) {
			$components[] = array('type' => 'body', 'parameters' => $parameters);
		}
		return array(
			'to' => $mobile,
			'type' => 'template',
			'template' => array(
				'language' => array('policy' => 'deterministic', 'code' => isset($template['language_code']) ? $template['language_code'] : 'en'),
				'name' => $template['provider_template_name'],
				'components' => $components
			)
		);
	}

	function whatsappBuildDocumentRequest($mobile, $document_link, $filename, $caption)
	{
		return array(
			'messaging_product' => 'whatsapp',
			'to' => $mobile,
			'type' => 'document',
			'document' => array(
				'caption' => $caption,
				'link' => $document_link,
				'filename' => $filename
			)
		);
	}

	function whatsappSendDocumentMessage($mobile, $document_link, $filename, $caption)
	{
		$result = array('success' => false, 'request' => '', 'response' => '', 'error' => '', 'http_code' => 0);
		if (!$this->whatsappHasCredentials()) {
			$result['error'] = 'WhatsApp API credentials are missing';
			return $result;
		}
		$request_payload = $this->whatsappBuildDocumentRequest($mobile, $document_link, $filename, $caption);
		$request_json = json_encode($request_payload);
		$headers = array(
			'wabaNumber: '.WHATSAPP_WABA_NUMBER,
			'Key: '.WHATSAPP_API_KEY,
			'Content-Type: application/json'
		);
		$ch = curl_init(WHATSAPP_API_MESSAGE_URL);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $request_json);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		$response = curl_exec($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if (curl_errno($ch)) {
			$result['error'] = curl_error($ch);
		}
		curl_close($ch);
		$result['request'] = $request_json;
		$result['response'] = $response;
		$result['http_code'] = $http_code;
		$result['success'] = ($result['error'] == '' && in_array($http_code, array(200, 201, 202)));
		if (!$result['success'] && $result['error'] == '') {
			$result['error'] = 'WhatsApp document API returned HTTP '.$http_code;
		}
		return $result;
	}

	function whatsappSendTemplateMessage($mobile, $template, $params)
	{
		$result = array('success' => false, 'request' => '', 'response' => '', 'error' => '', 'http_code' => 0);
		if (!$this->whatsappHasCredentials()) {
			$result['error'] = 'WhatsApp API credentials are missing';
			return $result;
		}
		$request_payload = $this->whatsappBuildTemplateRequest($mobile, $template, $params);
		$request_json = json_encode($request_payload);
		$headers = array(
			'wabaNumber: '.WHATSAPP_WABA_NUMBER,
			'Key: '.WHATSAPP_API_KEY,
			'Content-Type: application/json'
		);
		$ch = curl_init(WHATSAPP_API_MESSAGE_URL);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $request_json);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		$response = curl_exec($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if (curl_errno($ch)) {
			$result['error'] = curl_error($ch);
		}
		curl_close($ch);
		$result['request'] = $request_json;
		$result['response'] = $response;
		$result['http_code'] = $http_code;
		$result['success'] = ($result['error'] == '' && in_array($http_code, array(200, 201)));
		if (!$result['success'] && $result['error'] == '') {
			$result['error'] = 'WhatsApp API returned HTTP '.$http_code;
		}
		return $result;
	}

	function whatsappGetTemplateList()
	{
		$result = array('success' => false, 'request' => '{}', 'response' => '', 'error' => '', 'http_code' => 0);
		if (!$this->whatsappHasCredentials()) {
			$result['error'] = 'WhatsApp API credentials are missing';
			return $result;
		}
		if (!defined('WHATSAPP_API_TEMPLATE_LIST_URL') || WHATSAPP_API_TEMPLATE_LIST_URL == '') {
			$result['error'] = 'WhatsApp template list URL is missing';
			return $result;
		}
		$headers = array(
			'wabaNumber: '.WHATSAPP_WABA_NUMBER,
			'Key: '.WHATSAPP_API_KEY,
			'Content-Type: application/json'
		);
		foreach (array('{}', '') as $body) {
			$ch = curl_init(WHATSAPP_API_TEMPLATE_LIST_URL);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			$response = curl_exec($ch);
			$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$error = '';
			if (curl_errno($ch)) {
				$error = curl_error($ch);
			}
			curl_close($ch);
			$result['request'] = $body;
			$result['response'] = $response;
			$result['http_code'] = $http_code;
			$result['error'] = $error;
			$result['success'] = ($error == '' && in_array($http_code, array(200, 201)));
			if ($result['success']) {
				break;
			}
		}
		if (!$result['success'] && $result['error'] == '') {
			$result['error'] = 'WhatsApp template list API returned HTTP '.$result['http_code'];
		}
		return $result;
	}

	function whatsappGetWalletBalance()
	{
		$result = array('success' => false, 'balance' => '', 'request' => '', 'response' => '', 'error' => '', 'http_code' => 0);
		if (!defined('WHATSAPP_API_KEY') || WHATSAPP_API_KEY == '') {
			$result['error'] = 'WhatsApp API key is missing';
			return $result;
		}
		if (!defined('WHATSAPP_API_WALLET_URL') || WHATSAPP_API_WALLET_URL == '') {
			$result['error'] = 'WhatsApp wallet URL is missing';
			return $result;
		}
		$result['request'] = 'GET '.WHATSAPP_API_WALLET_URL;
		$headers = array(
			'Key: '.WHATSAPP_API_KEY
		);
		$ch = curl_init(WHATSAPP_API_WALLET_URL);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPGET, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		$response = curl_exec($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if (curl_errno($ch)) {
			$result['error'] = curl_error($ch);
		}
		curl_close($ch);
		$result['response'] = $response;
		$result['http_code'] = $http_code;
		$result['success'] = ($result['error'] == '' && in_array($http_code, array(200, 201, 202)));
		if ($result['success'] && $this->isJson($response)) {
			$data = json_decode($response, true);
			if (isset($data['balance'])) {
				$result['balance'] = $data['balance'];
			}
		}
		if (!$result['success'] && $result['error'] == '') {
			$result['error'] = 'WhatsApp wallet API returned HTTP '.$http_code;
		}
		return $result;
	}

	function whatsappGetProviderTemplate($provider_template_name)
	{
		$result = array('success' => false, 'request' => '', 'response' => '', 'error' => '', 'http_code' => 0);
		if (!$this->whatsappHasCredentials()) {
			$result['error'] = 'WhatsApp API credentials are missing';
			return $result;
		}
		if (!defined('WHATSAPP_API_TEMPLATE_GET_URL') || WHATSAPP_API_TEMPLATE_GET_URL == '') {
			$result['error'] = 'WhatsApp get template URL is missing';
			return $result;
		}
		$template_name = trim($provider_template_name);
		if ($template_name == '') {
			$result['error'] = 'Provider template name is required';
			return $result;
		}
		$url = rtrim(WHATSAPP_API_TEMPLATE_GET_URL, '/').'/'.rawurlencode($template_name);
		$result['request'] = 'GET '.$url;
		$headers = array(
			'wabaNumber: '.WHATSAPP_WABA_NUMBER,
			'Key: '.WHATSAPP_API_KEY
		);
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPGET, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		$response = curl_exec($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if (curl_errno($ch)) {
			$result['error'] = curl_error($ch);
		}
		curl_close($ch);
		$result['response'] = $response;
		$result['http_code'] = $http_code;
		$result['success'] = ($result['error'] == '' && in_array($http_code, array(200, 201)));
		if (!$result['success'] && $result['error'] == '') {
			$result['error'] = 'WhatsApp get template API returned HTTP '.$http_code;
		}
		$this->Resquest_Response_log('', 'WHATSAPP_TEMPLATE_GET', $response, $result['request'], '', array('http_code' => $http_code, 'error' => $result['error']));
		return $result;
	}

	function whatsappNormalizeProviderKey($key)
	{
		return strtolower(preg_replace('/[^a-z0-9]/i', '', $key));
	}

	function whatsappProviderValue($data, $keys)
	{
		if (!is_array($data)) {
			return '';
		}
		$wanted = array();
		foreach ($keys as $key) {
			$wanted[] = $this->whatsappNormalizeProviderKey($key);
		}
		foreach ($data as $key => $value) {
			if (!is_array($value) && in_array($this->whatsappNormalizeProviderKey($key), $wanted)) {
				return trim((string)$value);
			}
		}
		return '';
	}

	function whatsappDecodeProviderResponse($response)
	{
		$data = json_decode($response, true);
		if (is_array($data)) {
			return $data;
		}
		$data = json_decode(stripslashes(trim($response, "\"' \r\n\t")), true);
		if (is_array($data)) {
			return $data;
		}
		return array();
	}

	function whatsappFlattenProviderTemplates($data, &$templates)
	{
		if (is_string($data) && $this->isJson($data)) {
			$data = json_decode($data, true);
		}
		if (!is_array($data)) {
			return;
		}
		$name = $this->whatsappProviderValue($data, array('name', 'templateName', 'template_name', 'elementName', 'provider_template_name', 'template'));
		$status = $this->whatsappProviderValue($data, array('status', 'templateStatus', 'template_status', 'approval_status', 'approvalStatus', 'state'));
		if ($name != '' && $status != '') {
			$templates[] = array('name' => $name, 'status' => $status, 'raw' => $data);
		}
		foreach ($data as $value) {
			if (is_array($value)) {
				$this->whatsappFlattenProviderTemplates($value, $templates);
			}
		}
	}

	function whatsappMapProviderTemplateStatus($status)
	{
		$status = strtoupper(trim($status));
		if ($status == 'APPROVED') {
			return 'Approved';
		}
		if ($status == 'REJECTED') {
			return 'Rejected';
		}
		return 'Pending';
	}

	function whatsappProviderBodyFromComponents($raw_data)
	{
		if (!is_array($raw_data) || !isset($raw_data['components']) || !is_array($raw_data['components'])) {
			return '';
		}
		foreach ($raw_data['components'] as $component) {
			if (!is_array($component)) {
				continue;
			}
			$type = $this->whatsappProviderValue($component, array('type'));
			if (strtoupper($type) == 'BODY') {
				return $this->whatsappProviderValue($component, array('text', 'body', 'message', 'content'));
			}
		}
		return '';
	}

	function whatsappProviderHeaderFormatFromComponents($raw_data)
	{
		if (!is_array($raw_data) || !isset($raw_data['components']) || !is_array($raw_data['components'])) {
			return 'NONE';
		}
		foreach ($raw_data['components'] as $component) {
			if (!is_array($component)) {
				continue;
			}
			$type = $this->whatsappProviderValue($component, array('type'));
			if (strtoupper($type) == 'HEADER') {
				$format = strtoupper($this->whatsappProviderValue($component, array('format')));
				return ($format != '') ? $format : 'TEXT';
			}
		}
		return 'NONE';
	}

	function whatsappProviderFooterFromComponents($raw_data)
	{
		if (!is_array($raw_data) || !isset($raw_data['components']) || !is_array($raw_data['components'])) {
			return '';
		}
		foreach ($raw_data['components'] as $component) {
			if (!is_array($component)) {
				continue;
			}
			$type = $this->whatsappProviderValue($component, array('type'));
			if (strtoupper($type) == 'FOOTER') {
				return $this->whatsappProviderValue($component, array('text'));
			}
		}
		return '';
	}

	function whatsappApplyProviderTemplate($template, &$response)
	{
		$name = isset($template['name']) ? trim($template['name']) : '';
		$provider_status = isset($template['status']) ? trim($template['status']) : '';
		if ($name == '' || $provider_status == '') {
			return false;
		}
		$status = $this->whatsappMapProviderTemplateStatus($provider_status);
		$raw_data = isset($template['raw']) ? $template['raw'] : array();
		$raw = $this->escape(json_encode($raw_data));
		$name_sql = $this->escape($name);
		$body = $this->whatsappProviderBodyFromComponents($raw_data);
		if ($body == '') {
			$body = $this->whatsappProviderValue($raw_data, array('body', 'templateText', 'template_text', 'text', 'message', 'templateMessage', 'template_message', 'content'));
		}
		$body_sql = '';
		if ($body != '') {
			$placeholders = $this->whatsappExtractPlaceholders($body);
			$body_sql = ", body = '".$this->escape($body)."', placeholder_order = '".$this->escape(json_encode($placeholders))."'";
		}
		$header_format = $this->whatsappProviderHeaderFormatFromComponents($raw_data);
		$footer_text = $this->whatsappProviderFooterFromComponents($raw_data);
		$sql = "UPDATE ".WHATSAPP_TEMPLATES." SET status = '".$status."', provider_status = '".$this->escape($provider_status)."', api_response = '".$raw."', header_format = '".$this->escape($header_format)."', footer_text = '".$this->escape($footer_text)."'".$body_sql.", modified_on = NOW() WHERE provider_template_name = '".$name_sql."'";
		$this->executeQry($sql);
		if (mysqli_affected_rows($this->cnx) > 0) {
			$response['updated']++;
			return true;
		}
		$exists = $this->singleValue(WHATSAPP_TEMPLATES, 'id', "provider_template_name = '".$name_sql."'");
		if ($exists == '') {
			$template_title = ucwords(str_replace('_', ' ', $name));
			$category = 'Utility';
			$provider_category = $this->whatsappProviderValue($raw_data, array('category', 'templateCategory', 'template_category'));
					if (strtoupper($provider_category) == 'MARKETING') {
						$category = 'Marketing';
					}
			$language_code = $this->whatsappProviderValue($raw_data, array('language', 'languageCode', 'language_code'));
			if ($language_code == '') {
				$language_code = 'en';
			}
			$header_format = $this->whatsappProviderHeaderFormatFromComponents($raw_data);
			$footer_text = $this->whatsappProviderFooterFromComponents($raw_data);
			$body = $this->whatsappProviderBodyFromComponents($raw_data);
			if ($body == '') {
				$body = $this->whatsappProviderValue($raw_data, array('body', 'templateText', 'template_text', 'text', 'message', 'templateMessage', 'template_message', 'content'));
			}
			if ($body == '') {
				$body = 'Imported from WhatsApp provider. Please update local body/placeholders if needed.';
			}
			$placeholders = $this->whatsappExtractPlaceholders($body);
			$insert = "INSERT INTO ".WHATSAPP_TEMPLATES." SET template_name = '".$this->escape($template_title)."', provider_template_name = '".$name_sql."', category = '".$category."', language_code = '".$this->escape($language_code)."', header_format = '".$this->escape($header_format)."', body = '".$this->escape($body)."', footer_text = '".$this->escape($footer_text)."', placeholder_order = '".$this->escape(json_encode($placeholders))."', status = '".$status."', provider_status = '".$this->escape($provider_status)."', api_response = '".$raw."', created_by = 'PROVIDER_SYNC', created_on = NOW(), modified_on = NOW()";
			$this->executeQry($insert);
			$response['updated']++;
			return true;
		}
		return true;
	}

	function whatsappSyncTemplateByName($provider_template_name)
	{
		$this->whatsappRunMigration();
		$api = $this->whatsappGetProviderTemplate($provider_template_name);
		$response = array('msg_code' => '05', 'msg' => 'Unable to sync WhatsApp template.', 'updated' => 0, 'api' => $api);
		if (!$api['success']) {
			$response['msg'] = $api['error'];
			return $response;
		}
		$data = $this->whatsappDecodeProviderResponse($api['response']);
		if (!is_array($data)) {
			$response['msg'] = 'Template API response is not valid JSON.';
			return $response;
		}
		$provider_templates = array();
		$this->whatsappFlattenProviderTemplates($data, $provider_templates);
		if (count($provider_templates) == 0) {
			$status = $this->whatsappProviderValue($data, array('status', 'templateStatus', 'template_status', 'approval_status', 'approvalStatus', 'state'));
			if ($status != '') {
				$provider_templates[] = array('name' => $provider_template_name, 'status' => $status, 'raw' => $data);
			}
		}
		if (count($provider_templates) == 0) {
			$response['msg'] = 'Template API responded, but status was not found in the response. Raw response is saved in request/response logs under WHATSAPP_TEMPLATE_GET.';
			return $response;
		}
		$applied = false;
		foreach ($provider_templates as $template) {
			if (strtolower($template['name']) == strtolower($provider_template_name)) {
				$this->whatsappApplyProviderTemplate($template, $response);
				$applied = true;
				break;
			}
		}
		if (!$applied && count($provider_templates) == 1) {
			$provider_templates[0]['name'] = $provider_template_name;
			$this->whatsappApplyProviderTemplate($provider_templates[0], $response);
		}
		$response['msg_code'] = '00';
		$response['msg'] = 'WhatsApp template synced from provider.';
		return $response;
	}

	function whatsappSyncTemplateList()
	{
		$this->whatsappRunMigration();
		$api = $this->whatsappGetTemplateList();
		$response = array('msg_code' => '05', 'msg' => 'Unable to sync WhatsApp templates.', 'updated' => 0, 'api' => $api);
		if (!$api['success']) {
			$response['msg'] = $api['error'];
			return $response;
		}
		$this->Resquest_Response_log('', 'WHATSAPP_TEMPLATE_LIST', $api['response'], $api['request'], '', array('http_code' => $api['http_code'], 'error' => $api['error']));
		$data = $this->whatsappDecodeProviderResponse($api['response']);
		if (!is_array($data)) {
			$response['msg'] = 'Template list API response is not valid JSON.';
			return $response;
		}
		$provider_templates = array();
		$this->whatsappFlattenProviderTemplates($data, $provider_templates);
		if (count($provider_templates) == 0) {
			$response['msg_code'] = '05';
			$response['msg'] = 'Template list API responded, but no templates were found in the response. Raw response is saved in request/response logs under WHATSAPP_TEMPLATE_LIST.';
			return $response;
		}
		foreach ($provider_templates as $template) {
			$this->whatsappApplyProviderTemplate($template, $response);
			if (isset($template['name']) && trim($template['name']) != '') {
				$single_sync = $this->whatsappSyncTemplateByName($template['name']);
				if (isset($single_sync['updated']) && $single_sync['updated'] > 0) {
					$response['updated'] += $single_sync['updated'];
				}
			}
		}
		$response['msg_code'] = '00';
		$response['msg'] = 'WhatsApp template list synced. Updated templates: '.$response['updated'];
		return $response;
	}

	function whatsappProcessQueue($batch_size = 100)
	{
		$this->whatsappRunMigration();
		$batch_size = (int)$batch_size;
		if ($batch_size <= 0) {
			$batch_size = WHATSAPP_BATCH_SIZE;
		}
		$response = array('sent' => 0, 'failed' => 0, 'skipped' => 0, 'processed' => 0);
		$sql = "SELECT * FROM ".WHATSAPP_QUEUE." WHERE status IN ('Pending','Failed') AND retry_count < max_retry ORDER BY id ASC LIMIT ".$batch_size;
		$result = $this->executeQry($sql);
		while ($row = $this->fetch_assoc($result)) {
			$response['processed']++;
			$template = $this->whatsappGetTemplateById($row['template_id'], true);
			$params = ($this->isJson($row['payload'])) ? json_decode($row['payload'], true) : array();
			if (isset($params['template_params']) && is_array($params['template_params'])) {
				$params = array_merge($params['template_params'], $params);
				unset($params['template_params']);
			}
			if (!$this->whatsappIsValidMobile($row['mobile'])) {
				$error = 'Mobile number empty or invalid';
				$this->executeQry("UPDATE ".WHATSAPP_QUEUE." SET status = 'Skipped', error_message = '".$this->escape($error)."', modified_on = NOW() WHERE id = '".$row['id']."'");
				$this->whatsappAddLog($row['id'], $row['user_id'], $row['member_id'], $row['mobile'], $row['template_id'], $row['template_name'], $row['message_type'], $row['event_key'], 'Skipped', '', '', $error, $row['retry_count']);
				$response['skipped']++;
				continue;
			}
			if (empty($template)) {
				$error = 'WhatsApp template is missing or not approved';
				$this->executeQry("UPDATE ".WHATSAPP_QUEUE." SET status = 'Skipped', error_message = '".$this->escape($error)."', modified_on = NOW() WHERE id = '".$row['id']."'");
				$this->whatsappAddLog($row['id'], $row['user_id'], $row['member_id'], $row['mobile'], $row['template_id'], $row['template_name'], $row['message_type'], $row['event_key'], 'Skipped', '', '', $error, $row['retry_count']);
				$response['skipped']++;
				continue;
			}
			$send = $this->whatsappSendTemplateMessage($row['mobile'], $template, $params);
			$status = $send['success'] ? 'Sent' : 'Failed';
			$retry_count = $row['retry_count'] + 1;
			$sent_on = $send['success'] ? ", sent_on = NOW()" : "";
			$this->executeQry("UPDATE ".WHATSAPP_QUEUE." SET status = '".$status."', retry_count = '".$retry_count."', api_request = '".$this->escape($send['request'])."', api_response = '".$this->escape($send['response'])."', error_message = '".$this->escape($send['error'])."', modified_on = NOW() ".$sent_on." WHERE id = '".$row['id']."'");
			$this->whatsappAddLog($row['id'], $row['user_id'], $row['member_id'], $row['mobile'], $row['template_id'], $template['provider_template_name'], $row['message_type'], $row['event_key'], $status, $send['request'], $send['response'], $send['error'], $retry_count);
			if ($send['success']) {
				$response['sent']++;
			} else {
				$response['failed']++;
			}
		}
		return $response;
	}

	function whatsappMemberParams($member, $plan_details = array(), $extra = array())
	{
		$params = array(
			'user_name' => isset($member['name']) ? $member['name'] : '',
			'mobile' => isset($member['mobile']) ? $member['mobile'] : '',
			'member_id' => isset($member['member_id']) ? $member['member_id'] : '',
			'plan_name' => isset($plan_details['title']) ? $plan_details['title'] : '',
			'start_date' => isset($member['start_date']) ? $member['start_date'] : (isset($member['joining_date']) ? $member['joining_date'] : ''),
			'expiry_date' => isset($member['end_date']) ? $member['end_date'] : '',
			'timing' => isset($member['timing']) ? $member['timing'] : '',
			'company_name' => COMPANY_NAME
		);
		foreach ($extra as $key => $value) {
			$params[$key] = $value;
		}
		return $params;
	}

	function whatsappInvoiceLink($member)
	{
		$invoice_file = isset($member['invoice']) ? trim($member['invoice']) : '';
		if ($invoice_file == '') {
			return '';
		}
		return ABSOLUTE_ROOT_INV_DOWNLOAD.$invoice_file;
	}

	function whatsappAccountCreatedCaption($member, $plan_details = array())
	{
		$plan_name = isset($plan_details['title']) ? $plan_details['title'] : '';
		$caption = "Welcome to ".COMPANY_NAME.", ".(isset($member['name']) ? $member['name'] : '').".\n\n";
		$caption .= "Your membership has been created successfully.\n\n";
		$caption .= "Membership ID: ".(isset($member['member_id']) ? $member['member_id'] : '')."\n";
		$caption .= "Plan Name: ".$plan_name."\n";
		$caption .= "Start Date: ".(isset($member['start_date']) ? $member['start_date'] : '')."\n";
		$caption .= "Expiry Date: ".(isset($member['end_date']) ? $member['end_date'] : '')."\n";
		$caption .= "Class Timing: ".(isset($member['timing']) ? $member['timing'] : '')."\n\n";
		$caption .= "Your invoice PDF is attached with this WhatsApp message for your records.\n\n";
		$caption .= "Thank you for choosing ".COMPANY_NAME.".";
		return $caption;
	}

	function whatsappQueueAccountCreated($member_id)
	{
		$member = $this->singleRowAssoc_new('*', MEMBERS, "id = '".$this->escape($member_id)."'");
		if (empty($member)) {
			return 0;
		}
		$plan = $this->singleRowAssoc_new('*', PLANS, "id = '".$this->escape($member['plan_id'])."'");
		$template = $this->whatsappGetApprovedTemplate(defined('WHATSAPP_TEMPLATE_ACCOUNT_CREATED') ? WHATSAPP_TEMPLATE_ACCOUNT_CREATED : '');
		$params = $this->whatsappMemberParams($member, $plan);
		return $this->whatsappEnqueueTemplateForMember($member, $template, $params, 'ACCOUNT_CREATED', 'account_created', date('YmdHis'), 'SYSTEM');
	}

	function whatsappQueueMembershipRenewed($member_id)
	{
		$member = $this->singleRowAssoc_new('*', MEMBERS, "id = '".$this->escape($member_id)."'");
		if (empty($member)) {
			return 0;
		}
		$plan = $this->singleRowAssoc_new('*', PLANS, "id = '".$this->escape($member['plan_id'])."'");
		$template = $this->whatsappGetApprovedTemplate(defined('WHATSAPP_TEMPLATE_RENEWED') ? WHATSAPP_TEMPLATE_RENEWED : '');
		$params = $this->whatsappMemberParams($member, $plan);
		return $this->whatsappEnqueueTemplateForMember($member, $template, $params, 'MEMBERSHIP_RENEWED', 'membership_renewed', date('YmdHis'), 'SYSTEM');
	}

	function whatsappQueueMembershipFreeze($member_id, $freeze_days = '', $freeze_till = '')
	{
		$member = $this->singleRowAssoc_new('*', MEMBERS, "id = '".$this->escape($member_id)."'");
		if (empty($member)) {
			return 0;
		}
		$plan = $this->singleRowAssoc_new('*', PLANS, "id = '".$this->escape($member['plan_id'])."'");
		$template = $this->whatsappGetApprovedTemplate(defined('WHATSAPP_TEMPLATE_FREEZE') ? WHATSAPP_TEMPLATE_FREEZE : '');
		$params = $this->whatsappMemberParams($member, $plan, array(
			'freeze_days' => $freeze_days,
			'freeze_till' => $freeze_till,
			'new_expiry_date' => isset($member['end_date']) ? $member['end_date'] : ''
		));
		return $this->whatsappEnqueueTemplateForMember($member, $template, $params, 'MEMBERSHIP_FREEZE', 'membership_freeze', date('YmdHis'), 'SYSTEM');
	}

	function whatsappQueueExpiryTodayForMember($member)
	{
		$plan = $this->singleRowAssoc_new('*', PLANS, "id = '".$this->escape($member['plan_id'])."'");
		$template = $this->whatsappGetApprovedTemplate(defined('WHATSAPP_TEMPLATE_EXPIRY_TODAY') ? WHATSAPP_TEMPLATE_EXPIRY_TODAY : '');
		$params = $this->whatsappMemberParams($member, $plan);
		return $this->whatsappEnqueueTemplateForMember($member, $template, $params, 'EXPIRY_TODAY', 'expiry_today', date('Ymd'), 'CRON');
	}

	function whatsappQueueFestivalMessages($festival_key, $year)
	{
		$template_key = ($festival_key == 'diwali') ? 'diwali_greeting' : 'new_year_greeting';
		$provider_template_name = ($festival_key == 'diwali') ? (defined('WHATSAPP_TEMPLATE_DIWALI') ? WHATSAPP_TEMPLATE_DIWALI : '') : (defined('WHATSAPP_TEMPLATE_NEW_YEAR') ? WHATSAPP_TEMPLATE_NEW_YEAR : '');
		$template = $this->whatsappGetApprovedTemplate($provider_template_name);
		$expiry_months = ($festival_key == 'diwali') ? 2 : 4;
		$expired_from = date('Y-m-d', strtotime('-'.$expiry_months.' months'));
		$today = date('Y-m-d');
		$sql = "SELECT * FROM ".MEMBERS." WHERE (status = 'Active' OR (end_date >= '".$this->escape($expired_from)."' AND end_date < '".$this->escape($today)."')) AND (membership_type = 'Single' OR (membership_type = 'Family' AND family_head = '1'))";
		$result = $this->executeQry($sql);
		$count = 0;
		while ($member = $this->fetch_assoc($result)) {
			$params = $this->whatsappMemberParams($member, array());
			$count += ($this->whatsappEnqueueTemplateForMember($member, $template, $params, strtoupper($festival_key), $template_key, $year, 'CRON') > 0) ? 1 : 0;
		}
		return $count;
	}

	function whatsappQueueBulkTemplate($template_id, $audience, $selected_users = array(), $created_by = '')
	{
		$template = $this->whatsappGetTemplateById($template_id, true);
		if (empty($template)) {
			return array('msg_code' => '05', 'msg' => 'Only approved WhatsApp templates can be sent.');
		}
		$con = "1";
		if ($audience == 'Active') {
			$con .= " AND status = 'Active'";
		} else if ($audience == 'Inactive') {
			$con .= " AND status != 'Active'";
		}
		if ($audience == 'Selected') {
			$ids = array();
			foreach ($selected_users as $id) {
				$ids[] = (int)$id;
			}
			if (count($ids) == 0) {
				return array('msg_code' => '05', 'msg' => 'Please select at least one member.');
			}
			$con .= " AND id IN (".implode(',', $ids).")";
		}
		$con .= " AND (membership_type = 'Single' OR (membership_type = 'Family' AND family_head = '1'))";
		$sql = "SELECT * FROM ".MEMBERS." WHERE ".$con;
		$result = $this->executeQry($sql);
		$count = 0;
		$event = 'panel_template_'.$template_id.'_'.date('YmdHis');
		while ($member = $this->fetch_assoc($result)) {
			$params = $this->whatsappMemberParams($member, array(), array('message' => $template['body']));
			$count += ($this->whatsappEnqueueTemplateForMember($member, $template, $params, 'PANEL', $event, '', $created_by) > 0) ? 1 : 0;
		}
		return array('msg_code' => '00', 'msg' => 'WhatsApp messages queued: '.$count.'. Cron will send '.WHATSAPP_BATCH_SIZE.' per batch.');
	}

	function blockUnblockUser($apiKey, $employeeCode, $employeeName, $serialNumber, $isBlock, $userName, $userPassword, $commandId) {
			$log =array();
			// The URL of the web service
			//$url = 'http://192.168.1.107:85/iclock/WebAPIService.asmx';
			$url = 'http://166.0.244.12:82/iclock/WebAPIService.asmx';
			// The XML payload with dynamic data
			 $xmlPayload = <<<XML
		<?xml version="1.0" encoding="utf-8"?>
		<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
		  <soap:Body>
			<BlockUnblockUser xmlns="http://tempuri.org/">
			  <APIKey>$apiKey</APIKey>
			  <EmployeeCode>$employeeCode</EmployeeCode>
			  <EmployeeName>$employeeName</EmployeeName>
			  <SerialNumber>$serialNumber</SerialNumber>
			  <IsBlock>$isBlock</IsBlock>
			  <UserName>$userName</UserName>
			  <UserPassword>$userPassword</UserPassword>
			  <CommandId>$commandId</CommandId>
			</BlockUnblockUser>
		  </soap:Body>
		</soap:Envelope>
		XML;
		//print_r($xmlPayload);exit;

			$ch = curl_init($url);

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, [
				'Content-Type: text/xml; charset=utf-8',
				'SOAPAction: "http://tempuri.org/BlockUnblockUser"'
			]);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlPayload);
				
			$response = curl_exec($ch);
			
			if (curl_errno($ch)) {
				$error_msg = curl_error($ch);
				$bio_response = $error_msg;
			} else {
				$bio_response = $response;
			}
			$log['biometric'] = str_replace(["\r", "\n", "\t"], '', $xmlPayload);
			$logid = $this->Resquest_Response_log('0', 'BIOMETRIC', $bio_response, 'Biometric_command', '', $log);
			curl_close($ch);
			return $bio_response;
	}
	function addEmployee($apiKey, $employeeCode, $employeeName, $cardNumber, $serialNumber, $userName, $userPassword, $commandId) {
			$log =array();
			// The URL of the web service
			$url = 'http://166.0.244.12:82/iclock/WebAPIService.asmx';
			//$url = 'http://http://182.76.161.219:81/iclock/WebAPIService.asmx';

			// The XML payload with dynamic data
			$xmlPayload = <<<XML
		<?xml version="1.0" encoding="utf-8"?>
		<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
		  <soap:Body>
				<AddEmployee xmlns="http://tempuri.org/">
			  <APIKey>$apiKey</APIKey>
			  <EmployeeCode>$employeeCode</EmployeeCode>
			  <EmployeeName>$employeeName</EmployeeName>
			  <CardNumber>$cardNumber</CardNumber>
			  <SerialNumber>$serialNumber</SerialNumber>
			  <UserName>$userName</UserName>
			  <UserPassword>$userPassword</UserPassword>
			  <CommandId>$commandId</CommandId>
			</AddEmployee>
		  </soap:Body>
		</soap:Envelope>
		XML;
			$ch = curl_init($url);

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, [
				'Content-Type: text/xml; charset=utf-8',
				'SOAPAction: "http://tempuri.org/AddEmployee"'
			]);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlPayload);

			$response = curl_exec($ch);
			
			if (curl_errno($ch)) {
				$error_msg = curl_error($ch);
				$bio_response = $error_msg;
			} else {
				$bio_response = $response;
			}
			$log['biometric'] = str_replace(["\r", "\n", "\t"], '', $xmlPayload);
			$logid = $this->Resquest_Response_log('0', 'BIOMETRIC', $bio_response, 'Biometric_command', '', $log);
			curl_close($ch);
			return $bio_response;
	}
	
	
}

?>
