<?php

namespace App;

class HelperFunctions
{
    public static function getFullContactHead(String $contacthead){

        switch($contacthead){
            case 'TH':
                return 'Theory';
            case 'PR-A':
                return 'Practical Batch A';
            case 'PR-B':
                return 'Practical Batch B';
            case 'PR-C':
                return 'Practical Batch C';
            case 'PR-D':
                return 'Practical Batch D';
        }
    
    }

    public static function getYear($termid)
    {
    	return substr($termid, 0, 2);;
    }

    public static function getProgram($termid)
    {
    	$programId = substr($termid, 2, 1);

    	switch ($programId) {
    		case '0':
    			return 'BE';
    		
    		case '1':
    			return 'ME';

			case '2':
    			return 'MCA';    		

    		case '3':
    			return 'Phd';

    		default:
    			return 'Invald';
    	}
    }

    public static function getDepartment($termid)
    {
    	$deptid = substr($termid, 3, 1);

    	switch ($deptid) {
    		case '1':
    			return 'ETRX';
    		
    		case '2':
    			return 'CMPN';

			case '3':
    			return 'INST';    		

    		case '4':
    			return 'EXTC';

    		case '5':
    			return 'INFT';

    		default:
    			return 'Invald';
    	}
    }

    public static function getSem($termid)
    {
    	return substr($termid, 4, 1);;
    }
}