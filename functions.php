<?php

        function getPasteString(){
                $time = microtime();
                $string = explode(" ", $time);
                return $string[1];
        }

	#Test the functions I've written
        echo getPasteString();

?>