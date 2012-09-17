<?php
/*
 *      This program is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 2 of the License, or
 *      (at your option) any later version.
 *
 *      This program is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.
 */

	function getPasteString(){
		$time = microtime();
		$string = explode(" ", $time);
		return $string[1] . (rand()%2);
	}

	function checkIfChild($string){
		$string = explode("C", $string);
		if (is_null($string[1])
			return false;
		else
			return true;
	}

/*
	function makeChild($string){
		$string2=explode("C", $string);
		$i=1;
		if (!is_null($string2[$i]))
				i++;
		$string=
		if (file_exists($post_storage.$string)) {
			$post_number=makeChild($post_number);

		}
*/
?>