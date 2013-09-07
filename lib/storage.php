<?php

/**
 * ownCloud - Documents App
 *
 * @author Frank Karlitschek
 * @copyright 2012 Frank Karlitschek frank@owncloud.org
 * 
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
 * License as published by the Free Software Foundation; either 
 * version 3 of the License, or any later version.
 * 
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU AFFERO GENERAL PUBLIC LICENSE for more details.
 *  
 * You should have received a copy of the GNU Lesser General Public 
 * License along with this library.  If not, see <http://www.gnu.org/licenses/>.
 * 
 */


namespace OCA\Documents;

class Storage {

	public static function getDocuments() {
		$list = array_filter(
				\OCP\Files::searchByMime('application/vnd.oasis.opendocument.text'),
				function($item){
					//filter Deleted
					if (strpos($item['path'], '_trashbin')===0){
						return false;
					}
					return true;
				}
		);
		
		return $list;
	}
	
	/**
	 * @brief Copy files to trash bin
	 * @param array
	 *
	 * This function is connected to the delete signal of OC_Filesystem
	 * to copy the file to the trash bin
	 */
	public static function onDelete($params) {

		if ( \OCP\App::isEnabled('files_trashbin') ) {
			$path = $params['path'];
			Trashbin::move2trash($path);
		}
	}

}
