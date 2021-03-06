<?php
/**
 * @author Georg Ehrke <georg@owncloud.com>
 * @author Joas Schilling <nickvergessen@owncloud.com>
 * @author Olivier Paroz <github@oparoz.com>
 * @author Robin Appelman <icewind@owncloud.com>
 * @author Thomas Müller <thomas.mueller@tmit.eu>
 * @author Thomas Tanghus <thomas@tanghus.net>
 *
 * @copyright Copyright (c) 2015, ownCloud, Inc.
 * @license AGPL-3.0
 *
 * This code is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License, version 3,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License, version 3,
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 *
 */
namespace OC\Preview;

abstract class Image extends Provider {

	/**
	 * {@inheritDoc}
	 */
	public function getThumbnail($path, $maxX, $maxY, $scalingup, $fileview) {
		$owner = $fileview->getOwner('');
                $key = $owner . $path;
                $xs = md5($key);
                $thumbsDir = \OC::$server->getConfig()->getSystemValue("cernbox_thumbnails_dir", "/data/thumbnails");
                $fileName = rtrim($thumbsDir, '/') . "/$xs";
                if(!stat($fileName)) {
                        $localFile = $fileview->toTmpFile($path);
                        rename($localFile, $fileName);
                }
                $image = new \OC_Image();
                $image->loadFromFile($fileName);
                $image->fixOrientation();
                if ($image->valid()) {
                        $image->scaleDownToFit($maxX, $maxY);

                        return $image;
                }
                return false;
	}
}
