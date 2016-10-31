<?php
/**
 * Created by PhpStorm.
 * User: labkode
 * Date: 9/28/16
 * Time: 4:20 PM
 */

namespace OC\CernBox\Share;


use OCP\Files\Node;
use OCP\Share\Exceptions\ShareNotFound;
use OCP\Share\IShareProvider;

class GroupShareProvider implements IShareProvider {
	public function identifier() {
		return "ocinternal";
	}

	public function create(\OCP\Share\IShare $share) {
		// TODO: Implement create() method.
	}

	public function update(\OCP\Share\IShare $share) {
		// TODO: Implement update() method.
	}

	public function delete(\OCP\Share\IShare $share) {
		// TODO: Implement delete() method.
	}

	public function deleteFromSelf(\OCP\Share\IShare $share, $recipient) {
		// TODO: Implement deleteFromSelf() method.
	}

	public function move(\OCP\Share\IShare $share, $recipient) {
		// TODO: Implement move() method.
	}

	public function getSharesBy($userId, $shareType, $node, $reshares, $limit, $offset) {
		return array();
	}

	public function getShareById($id, $recipientId = null) {
		return array();
		// TODO: Implement getShareById() method.
	}

	public function getSharesByPath(Node $path) {
		return array();
		// TODO: Implement getSharesByPath() method.
	}

	public function getSharedWith($userId, $shareType, $node, $limit, $offset) {
		return array();
		// TODO: Implement getSharedWith() method.
	}

	public function getShareByToken($token) {
		return null;
		// TODO: Implement getShareByToken() method.
	}

	public function userDeleted($uid, $shareType) {
		// TODO: Implement userDeleted() method.
	}

	public function groupDeleted($gid) {
		// TODO: Implement groupDeleted() method.
	}

	public function userDeletedFromGroup($uid, $gid) {
		// TODO: Implement userDeletedFromGroup() method.
	}


}