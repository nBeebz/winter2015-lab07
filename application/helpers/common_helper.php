<?php	
	
	function getOrders( $files )
	{
		$result = array();
		foreach( $files as $file )
		{
			if( strpos($file, '.xml') != false && strcmp($file, 'menu.xml') != 0 )
				array_push($result, $file);
		}
		return $result;
	}