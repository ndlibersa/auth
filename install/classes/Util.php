<?php
/*
**************************************************************************************************************************
** CORAL Authentication Module v. 1.0
**
** Copyright (c) 2011 University of Notre Dame
**
** This file is part of CORAL.
**
** CORAL is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
**
** CORAL is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
**
** You should have received a copy of the GNU General Public License along with CORAL.  If not, see <http://www.gnu.org/licenses/>.
**
**************************************************************************************************************************
*/


class Util {

	public static function hashString($hashAlgorithm, $string){

		$hashedString = hash($hashAlgorithm, $string);

		return $hashedString;

	}

	public static function randomString($stringLength){

		$string = '';
		$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		$charsLength = strlen($chars)-1;

		for ($i = 0;  $i != $stringLength; $i++){
			$randInd = rand(0,$charsLength);
			$string .= substr($chars, $randInd, 1);
		}

		return $string;
	}
}

?>
