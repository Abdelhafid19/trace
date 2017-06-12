<?php
session_start();
require_once("trace.php");
if(isset($result))
{
	header("Content-Type: text/csv;charset=UTF-8");
	header("Content-Disposition: attachment; filename=file.csv");
	echo "startTime;cgi;lai;caller;callerParty;mscSource;mscDest;endTime;releaseCause\n";
	foreach($result as $ligne)
	{
		echo isset($ligne['startTime'])?'"'.$ligne['startTime'].'";':';';
		echo isset($ligne['cgi'])?'"'.$ligne['cgi'].'";':';';
		echo isset($ligne['lai'])?'"'.$ligne['lai'].'";':';';
		echo isset($ligne['caller'])?'"'.$ligne['caller'].'";':';';
		echo isset($ligne['callerParty'])?'"'.$ligne['callerParty'].'";':';';
		echo isset($ligne['mscSource'])?'"'.$ligne['mscSource'].'";':';';
		echo isset($ligne['mscDest'])?'"'.$ligne['mscDest'].'";':';';
		echo isset($ligne['endTime'])?'"'.$ligne['endTime'].'";':';';
		echo isset($ligne['releaseCause'])?'"'.$ligne['releaseCause'].'"':'';
		echo "\n";
	}

}
?>