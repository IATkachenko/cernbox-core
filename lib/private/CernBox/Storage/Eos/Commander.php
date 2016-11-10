<?php
/**
 * Created by PhpStorm.
 * User: labkode
 * Date: 9/6/16
 * Time: 4:02 PM
 */

namespace OC\CernBox\Storage\Eos;


class  Commander{


	private $retryAttempts;
	private $eosMgmUrl;
	private $username;
	private $uid;
	private $gid;
	private $logger;

	/**
	 * Commander constructor.
	 */
	public function __construct($eosMgmUrl, $username) {
		$this->logger = \OC::$server->getLogger();
		$this->username = $username;
		if(!$eosMgmUrl) {
			$eosMgmUrl = "root://localhost";
		}
		$this->eosMgmUrl = $eosMgmUrl;

		$value = (int)\OC::$server->getConfig()->getSystemValue("eoscliretryattempts", 2);
		$this->retryAttempts = $value;

		list($uid, $gid) = \OC::$server->getCernBoxEosUtil()->getUidAndGidForUsername($username);
		if(is_int($uid) && is_int($gid) && $uid >= 0 && $gid >= 0) {
			$this->uid = $uid;
			$this->gid = $gid;
		} else {
			$msg = "could not instantiate commander because username($username) does not have a valid uid($uid) and gid($gid)";
			throw new \Exception($msg);
		}
	}

	public function exec($cmd) {
		// we load the env variable EOS_MGM_URL to perform the command
		// with that variable in its context.
		$uid = $this->uid;
		$gid = $this->gid;
		$cmd = "eos -b -r $uid $gid " . $cmd;
		$fullCmd = 'EOS_MGM_URL=' . $this->eosMgmUrl . " " . $cmd;
		return $this->execRaw($fullCmd);

	}

	public function execRaw($cmd) {
		// Keep requesting EOS while we get a 22 error code
		$counter = 0;
		do
		{
			$result = null;
			$errorCode = null;
			exec($cmd, $result, $errorCode);
			$counter++;
		}
		while($errorCode === 22 && $counter !== $this->retryAttempts);

		if($errorCode === 0) {
			$this->logger->info("$cmd => $errorCode");
		} else {
			$this->logger->error("$cmd => $errorCode");
		}
		return array($result, $errorCode);
	}
}