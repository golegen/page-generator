<?php
/**
 * @description TOF客户端(Tencent OA Framework Client)
 * @author mikeliang
 * @version 1.0
 * @usage IP: 172.25.32.17(内网) IP: 10.130.1.178(外网)
 *
 * $tof = new TOF_Client();
 * $ret = $tof->SendMail('mikeliang', 'mikeliang', 'test mail', '<h1>mail body mail body</h1>');
 *
 */
require("conn.php");

class TOF_Client {
	private $client;

	public function __construct() {
	}

	public function __destruct() {
		unset($this->client);
	}

	private function _initClient($service) {
		$wsURL = "http://ws.tof.oa.com/".$service.".svc?wsdl";
		$appkey = "84d431bfdf4d41c0872beb90393a2cfa";
		$ns = "http://www.w3.org/2001/XMLSchema-instance";
		$nsnode = "http://schemas.datacontract.org/2004/07/Tencent.OA.Framework.Context";

		$appkeyvar = new SoapVar("<Application_Context xmlns:i=\"{$ns}\"><AppKey xmlns=\"{$nsnode}\">{$appkey}</AppKey></Application_Context>",XSD_ANYXML);
		$this->client = new SoapClient($wsURL);
		$header = new SoapHeader($ns, 'Application_Context',$appkeyvar);
		$this->client->__setSoapHeaders(array($header));
	}

	public function SendRTX($Sender, $Receiver, $Title, $MsgInfo, $Priority='Normal') {
		$this->_initClient('MessageService');
		$msg = (object) array(
			'Sender'		=> $Sender,
			'Receiver'		=> $Receiver,
			'Title'			=> $Title,
			'MsgInfo'		=> $MsgInfo,
			'Priority'		=> $Priority
		);
		$param = array('message' => $msg);
		$result = $this->client->SendRTX($param);

		return $result->SendRTXResult;
	}

	public function SendSMS($Receiver, $MsgInfo) {
		$this->_initClient('MessageService');
		// 对于短信，我们不太在意发送者、标题等信息
		$Sender = 'mikeliang';
		$Title = 'TOF_Client';
		$Priority='Normal';
		$msg = (object) array(
			'Sender'		=> $Sender,
			'Receiver'	=> $Receiver,
			'Title'			=> $Title,
			'MsgInfo'		=> $MsgInfo,
			'Priority'		=> $Priority
		);
		$param = array('message' => $msg);
		$result = $this->client->SendSMS($param);

		return $result->SendSMSResult;
	}

	public function SendMail($Sender, $Receiver, $Subject, $Msg, $Priority='Normal') {
		//
		$this->_initClient('MessageService');
		$msg = (object) array(
			//'Attachments'	=> NULL,
			'Bcc'			=> '',
			'BodyFormat'	=> 'Html',
			'CC'			=> '',
			'Content'		=> $Msg,
			'EmailType'		=> 'SEND_TO_ENCHANGE',
			'EndTime'		=> date('c', strtotime('2019-12-25')),
			'From'			=> $Sender,
			'Location'		=> NULL,
			'Priority'		=> $Priority,
			'StartTime'		=> date('c'),
			'Title'			=> $Subject,
			'To'			=> $Receiver,
		);

		$param = array('mail' => $msg);
		$result = $this->client->SendMail($param);
		
		return $result->SendMailResult;
	}

	public function getUser() {
		$auth_key = 'pg_uname';
		if (isset($_GET['ticket'])) {
			try{
				echo "==>通过OA登录后将登录名写入COOKIE";
				$ticket = $_GET['ticket'];
				$et = new eTicket();
				$et->encryptedTicket = $ticket;

				$mySoap = new SoapClient("http://passport.oa.com/services/passportservice.asmx?WSDL"); 

				$soapResult = $mySoap->DecryptTicket($et);
				$LoginName = $soapResult->DecryptTicketResult->LoginName;
				
				
				
				if ($LoginName) {
					setcookie("pg_uname",$LoginName,time()+3600*24*5,"/");
					$this->getUserInfo($LoginName);
					return $LoginName;
				}
			}catch (SoapFault $s) {   
                echo $s->getMessage();  
            } 
			
		}
		if (isset($_COOKIE[$auth_key])) {
			echo "==>如果有登录的话，直接返回COOKIE";
			return $_COOKIE[$auth_key];
		}
		echo "==>本地没有COOKIE的话，直接OA检查";
		$in_url = 'http://passport.oa.com/modules/passport/signin.ashx';
		$out_url = 'http://passport.oa.com/modules/passport/signout.ashx';
		$myurl = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
		$title = 'Page Generator';
		$post_url = "$in_url?url=".urlencode($myurl)."&title=".urlencode($title);
		header("Location: $post_url");
		exit();
	}
	

	//把RTX账户信息写入数据库
	function getUserInfo($loginName){
		$ticket = $_GET['ticket'];
		
		$soap = new SoapClient("http://passport.oa.com/services/passportservice.asmx?WSDL"); 
		$result = $soap->DecryptTicket(array("encryptedTicket" => $_GET['ticket']));
		
		if (!$result->DecryptTicketResult->LoginName){  
            echo "error";
        } 
        else{  
        	
      
      // 2013-11-19 WILLIAMSLI EDIT
      $service = "OrgService";
			$wsURL = "http://ws.tof.oa.com/".$service.".svc?wsdl";
			$appkey = "84d431bfdf4d41c0872beb90393a2cfa";
			$ns = "http://www.w3.org/2001/XMLSchema-instance";
			$nsnode = "http://schemas.datacontract.org/2004/07/Tencent.OA.Framework.Context";
			$appkeyvar = new SoapVar("<Application_Context xmlns:i=\"{$ns}\"><AppKey xmlns=\"{$nsnode}\">{$appkey}</AppKey></Application_Context>",XSD_ANYXML);
			$soap = new SoapClient($wsURL);
			$header = new SoapHeader($ns, 'Application_Context',$appkeyvar);
			$soap->__setSoapHeaders(array($header));
		
      // 2013-11-19 WILLIAMSLI EDIT
		
		
			$result = $soap->GetStaffInfoByLoginName(array('loginName' => $result->DecryptTicketResult->LoginName));  

			if ($result->GetStaffInfoByLoginNameResult) {  

				$db = array(
					"user_id"        => (int) $result->GetStaffInfoByLoginNameResult->ID, 
					"login_name"     =>$result->GetStaffInfoByLoginNameResult->LoginName,  
					"english_name"   =>$result->GetStaffInfoByLoginNameResult->EnglishName,  
					"chinese_name"   =>$result->GetStaffInfoByLoginNameResult->ChineseName, 
					"full_name"      =>$result->GetStaffInfoByLoginNameResult->FullName, 
					"gender"         =>$result->GetStaffInfoByLoginNameResult->Gender, 
					"id_card_number" => 0,  
					"department_id" => (int) $result->GetStaffInfoByLoginNameResult->DepartmentId,  
					"department_name" => $result->GetStaffInfoByLoginNameResult->DepartmentName,  
					"group_id" => $result->GetStaffInfoByLoginNameResult->GroupId,
					"group_name" => $result->GetStaffInfoByLoginNameResult->GroupName  
				);
				
				setcookie("pg_uid",(int) $result->GetStaffInfoByLoginNameResult->ID,time()+3600*24*5,"/");
				$num = $this->checkDBUser($loginName);
				if($num == 0){
					$this->insertDB("tb_users",$db);
				}
			}
		}
			
	}
	
	//插入数据库
	function insertDB($table,$dataArray){
		$field = "";
		$value = "";
		if( !is_array($dataArray) || count($dataArray)<=0) {
			$this->halt('没有要插入的数据');
			return false;
		}
		while(list($key,$val)=each($dataArray)) {
			$field .="$key,";
			$value .="'$val',";
		}
		$field = substr( $field,0,-1);
		$value = substr( $value,0,-1);
		$sql = "insert into $table($field) values($value)";
		if (!mysql_query($sql))
		{
			die('Error: ' . mysql_error());
		}
		//mysql_close($conn);
		return true;
	}
	
	//检查数据库用户是否存在，存在返回记录数
	function checkDBUser($loginName){
		echo $loginName;
		$result = mysql_query("SELECT `user_id`, `user_power`, `user_state` FROM `tb_users` WHERE `login_name` = '". $loginName ."'");
		if(!is_bool($result)) {
			$num = mysql_num_rows($result);
			return $num;
		} else {
			return 0;
		}

	}

	public function logout() {
		$auth_key = 'pg_uname';
		$out_url = 'http://passport.oa.com/modules/passport/signout.ashx';
		$myurl = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
		$title = 'Page Generator';
		$post_url = "$out_url?url=".urlencode($myurl)."&title=".urlencode($title);

		setcookie($auth_key, "", 10);
		header("Location: $post_url");
		exit();
	}

	private function decode($str) {
		return json_decode($str);
	}

	private function encode($obj) {
		return json_encode($obj);
	}
}

class eTicket {
  public $encryptedTicket;
  function eTicket() {
  }
}


?>