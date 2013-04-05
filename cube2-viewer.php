<?php
require_once('inc/functions.php');
include_once('inc/conf.inc.php');

class cube2_viewer {
private $conf_data = array();
	
protected function callback(array $conf = null) {
	if (! isset($conf)) {
		$self->conf = $servers_conf;
	} else {
		try {
			$self->conf_data = json_decode($conf, true, 2);
			if (! $self->conf_data) {
				throw new Exception(json_last_error());
			}
		} catch (Exception $json_error) {
			die($json_error->getMessage());
		}
	}
	
	json_encode(self::get_servers($self->conf_data));
}	
	
private function get_servers(array $servers) {
$servers_info = array();

foreach ($servers as $server) {
	$res = server_info($server['ip'], $server['port']);
	
	//No random index, fallback to original server name => unique
	$servers_info[$res['port']] = $res;	
	
	/* Old unused method, kinda faster but can't handle mutliple servers at once
	 * array_push($servers_info, self::server_info($server['ip'], $server['port']));
	*/
}

}
	
private function server_info($ip, $port) 
{
	$server = array();
	
	$x = cube2_extinfo::ext_info($ip, $port);
	
	$server['players'] = $x['3'];
	
	$ver = $x['5'];
	$mode = $x['6'];
	
	switch ($ver) {
		case 257: 
			$server['version'] = "Trooper";
			$server['gamemode'] = cube2_extinfo::getmode257($mode);
		case 258: 
			$server['version'] = "Justice";
			$server['gamemode'] = cube2_extinfo::getmode258($mode);
		case 259:
		 	$server['version'] = "Collect";;
		 	$server['gamemode'] = cube2_extinfo::getmode259($mode);
	}
	
	$timeleft = $x['7'];
	
	$server['minutes'] = floor ($timeleft / 60);
	$server['seconds'] = $server['minutes'] % 60;
	$server['timeleft'] = sprintf("%02d:%02d", $server['minutes'], $server['seconds']);

	$server['slots'] = $x['8'];
	$server['map'] = $x['10'];
	$server['name'] = $x['11'];
	return $server;
}	
}
?>
