<?php

require_once('XMPPHP/XMPP.php');

class letsjabber {

	private $send_user = "support@support.com";
	private $send_pass = "support_password";
	private $send_resc = "";
	private $send_host = "support.com";
	private $conn;

	function __construct() {
		$this->connect();
	}

	public function send_message($recip, $message) {
		$this->conn->message($recip, $message);
	}

	private function connect() {
		try {
			$this->conn = new XMPPHP_XMPP($this->send_host, 5222, $this->send_user, $this->send_pass, $this->send_resc);
			$this->conn->processUntil('session_start');
			$this->conn->presence();
		} catch(XMPPHP_Exception $e) {
			die($e->getMessage());
		}
	}

	public function disconnect() {
		$this->conn->disconnect();
	}

}

if(isset($_GET['api'])) {
	if($_GET['api'] === "ec0405c5aef93e771cd80e0db180b88b") { // md5(md5("abc"))
		if(!empty($_GET['message'])) {
			$message = base64_decode($_GET['message']);
		} else {
			$message = "";
		}
		if(!empty($_GET['rec'])) {
			$rec = base64_decode($_GET['rec']);
		} else {
			$rec = "admin@support.com";
		}
		$a = new letsjabber();
		$a->send_message($rec, $message);
		$a->disconnect();
	} else {
		die("Invalid API key.");
	}
}


?>
