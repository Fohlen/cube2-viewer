<?php
class cube2_buf {
	protected $stack = array();
	
	protected function getc() { 
		return array_shift($this->stack);
	}
	
	protected function getint() {  
		$c = $this->getc();
		if ($c == 0x80) { 
			$n = $this->getc(); 
			$n |= $this->getc() << 8; 
			return $n;
		}
		else if ($c == 0x81) {
			$n = $this->getc();
			$n |= $this->getc() << 8;
			$n |= $this->getc() << 16;
			$n |= $this->getc() << 24;
			return $n;
		}
		return $c;
	}
	
	protected function getstring($len=100) {
		$r = ""; $i = 0; 
		while (true) { 
			$c = $this->getint();
			if ($c == 0) return $r;
			$r .= chr($c);
		} 
	}
}

class cube2_extinfo{
protected function ext_info($ip, $port) 
{
	try {
		$s = stream_socket_client("udp://".$ip.":".$port);
		stream_set_timeout($s, 0, 50000);
		fwrite($s, chr(0x19).chr(0x01));
		 	
		if (! $s) {
			throw new Exception(socket_last_error());
		}
	} catch (Exception $socket_error) {
		die($socket_error->getMessage);
	}
	
	$b = new cube2_buf();
	$g = fread($s, 4096);
	$b->stack = unpack("C*", $g);
	 
	$s_ext['1']  = $b->getint();
	$s_ext['2']  = $b->getint();
	$s_ext['3']  = $b->getint();
	$s_ext['4']  = $b->getint();
	$s_ext['5']  = $b->getint();
	$s_ext['6']  = $b->getint();
	$s_ext['7']  = $b->getint(); 
	$s_ext['8']  = $b->getint();
	$s_ext['9']  = $b->getint();
	$s_ext['10'] = $b->getstring(); 
	$s_ext['11'] = $b->getstring();
	return $s_ext;
}

protected function getmode257($int) 
{
	switch($int)
	{
		case 0: return 'ffa/default';
		case 1: return 'coop edit';
		case 3: return 'instagib';
		case 5: return 'efficiency';
		case 9: return 'capture';
		case 10: return 'regen capture';
		case 11: return 'ctf';
		case 12: return 'insta ctf';
		case 13: return 'protect';
		case 14: return 'insta protect';
		default: return 'unknown';
	}
}

protected function getmode258($int) 
{
	switch($int) 
	{
		case 0: return 'FFA';
		case 1: return 'coop';
		case 2: return 'teamplay';
		case 3: return 'Insta';
		case 4: return 'Instateam';
		case 5: return 'Effic';
		case 6: return 'Efficteam';
		case 7: return 'Tac';
		case 8: return 'Tacteam';
		case 9: return 'Capture';
		case 10: return 'Rcapture';
		case 11: return 'CTF';
		case 12: return 'iCTF';
		case 13: return 'Protect';
		case 14: return 'iProtect';
		case 15: return 'Hold';
		case 16: return 'iHold';
		case 17: return 'eCTF';
		case 18: return 'eProtect';
		case 19: return 'eHOld';
		default: return 'unknown';
	}
}

protected function getmode259($int)
{
	switch($int) 
    {
    	case 0: return 'FFA';
        case 1: return 'coop';
        case 2: return 'teamplay';
        case 3: return 'Insta';
        case 4: return 'Instateam';
        case 5: return 'Effic';
        case 6: return 'Efficteam';
        case 7: return 'Tac';
        case 8: return 'Tacteam';
        case 9: return 'Capture';
        case 10: return 'Rcapture';
        case 11: return 'CTF';
        case 12: return 'iCTF';
        case 13: return 'Protect';
        case 14: return 'iProtect';
        case 15: return 'Hold';
        case 16: return 'iHold';
        case 17: return 'eCTF';
        case 18: return 'eProtect';
        case 19: return 'eHOld';
		case 20: return 'Collect';
		case 21: return 'iCollect';
		case 22: return 'eCollect';		

        default: return 'unknown';
    }
}
}
?>
