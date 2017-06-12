<?php
if(!isset($_SESSION["login"]))
{
  header("location:login.php");
}
if(!isset( $_SESSION["uploadedFile"]))
{
	header("location:index.php");
}
	$file = fopen($_SESSION["uploadedFile"],"r");
	$list = array();
	$result = array();
	$i=0;

	while($ligne = fgets($file))
	{
		$list[$i] = $ligne;
		$i++;
	}


	for($j = 0;$j<count($list);$j++)
	{
		if(strpos($list[$j],"[Msg Type     ] CM_Service_Request")!==false){
			$ligne = array();
			$ligne["startTime"] = substr($list[$j-2],27);
			$cgi ="";

			//CGI
			for($k=$j+1;$k<count($list);$k++)
			{
				if(strpos($list[$k],"..........................gci")!==false)
				{
					for ($y = $k + 1; $y <= $k + 20; $y++) {
						if(strpos($list[$y],"mcc") !==false || strpos($list[$y],"mnc") || strpos($list[$y],"lac"))
						{
							$length = strpos($list[$y],")")-strpos($list[$y],"(")-1;
							$cgi.= strval(substr($list[$y],strpos($list[$y],"(")+1,$length));
						}
						else if(strpos($list[$y],"ci-value")!==false)
						{
							$length = strpos($list[$y],")")-strpos($list[$y],"(")-1;
							$ciValue = substr($list[$y],strpos($list[$y],"(")+1,$length);
							$ligne["ciValue"] = $ciValue;
						}
					}
					$ligne["cgi"] = $cgi;
					break;
				}
			}

			for($k=$j+1;$k<count($list);$k++)
			{
				if(strpos($list[$k],"[Msg Type     ] Setup")!==false)
				{
					for ($y = $k + 1; $y < count($list); $y++) {
						$string = $list[$y];
						if(strpos($string,"............................number:") !== false)
						{
							$ligne["caller"]=substr($list[$y],strpos($list[$y],":")+1);
							break;
						}
						
					}
					break;
				}
			}

			for($k=$j+1;$k<count($list);$k++)
			{
				if(strpos($list[$k],"[Msg Type     ] MAP_OPEN_REQ")!==false)
				{
					for ($y = $k + 1; $y < count($list); $y++) {
						$string = $list[$y];
						if(strpos($string,"..........content:") !== false)
						{
							$ligne["mscSource"]=substr($list[$y],strpos($list[$y],":")+1);
							break;
						}
						
					}
					break;
				}
			}

			for($k=$j+1;$k<count($list);$k++)
			{
				if(strpos($list[$k],"[Msg Type     ] MAP_SEND_ROUTING_INFORMATION_REQ")!==false)
				{
					for ($y = $k + 1; $y < count($list); $y++) {
						if(strpos($list[$y],"..............gmsc-Address") !== false)
						{
							for ($x = $y + 1; $x < count($list); $x++) {
								if(strpos($list[$x],"................content:") !== false)
								{
									$ligne["mscDest"]=substr($list[$x],strpos($list[$x],":")+1);
									break;
								}
								
							}
							break;
						}
					}
					break;
				}
			}

			for($k=$j+1;$k<count($list);$k++)
			{
				if(strpos($list[$k],"[Msg Type     ] Release")!==false)
				{
					$ligne["endTime"] = substr($list[$k-2],27);
					for ($y = $k + 1; $y < count($list); $y++) {
						$string = $list[$y];
						if(strpos($string,"............................cause-value:") !== false)
						{
							$ligne["releaseCause"]=substr($list[$y],strpos($list[$y],":")+1);
							break;
						}
						
					}
					break;
				}
			}
			for($k=$j+1;$k<count($list);$k++)
			{
				if(strpos($list[$k],"[Msg Type     ] TO_BICC_TYPE_IAM")!==false)
				{
					for ($y = $k + 1; $y < count($list); $y++) {
						if(strpos($list[$y],"........calling-party-number") !== false)
						{
							for ($x = $y + 1; $x < count($list); $x++) {
								if(strpos($list[$x],"..........address-signal:") !== false)
								{
									$ligne["callingParty"]=substr($list[$x],strpos($list[$x],":")+1);
									break;
								}
								
							}
							break;
						}
					}
					break;
				}
			}

			$result[] = $ligne;
		}

	}

	

	fclose($file);
?>

