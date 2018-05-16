<?php

require('routeros_api.class.php');

$API = new routeros_api();
$API->debug = false;
//Запрашиваем сети в блоке РКН
exec("curl -s https://raw.githubusercontent.com/zapret-info/z-i/master/dump.csv | cut -d ';' -f 1 |  tr '|' '\n' | grep '/' | tr -d ' ' | sort -k1 -n > ban_nets.txt ");
$ip_array = file('ban_nets.txt');


if ($API->connect('192.168.1.66', 'exec00t', '123tests')){
    $ARRAY = $API->comm('/ip/dns/cache/print');
    $res_arr =array();
    $state_ip = array();
    foreach($ARRAY as &$value){
	$name = $value['name'];
	$addr = $value['address'];
	$res_arr[$name][]=$addr;
	$state_ip[$addr] = razbor_net($value['address'], $ip_array);
    }
    foreach($res_arr as $key => $value){
	$clear_ip = '';
	$toxic_net = false;
	foreach($value as &$val){
	    if($state_ip[$val] == false) $clear_ip = $val;
	    else $toxic_net = true;
	}
	if($toxic_net) print "toxic ".$key." - ".$val."\n";
	if($toxic_net AND $clear_ip <> ''){
	    $API->comm("/ip/dns/static/add", array(
        	"address" => $clear_ip,
        	"name" => $key,
	    ));
	    print "add ".$key." - ".$val."\n";
	}
    }
}



function razbor_net($cur_ip_adrr, $ip_array){// true  - заблокирован
    $flag = false;
    foreach($ip_array as &$cur_cidr)
    {
	print "ban ip ".$cur_cidr;
	if ((ipCIDRcheck($cur_ip_adrr, $cur_cidr)) == true) $flag = true;  
    }
    return $flag;
}

function ipCIDRcheck($ip, $cidr) {
  list($net, $mask) = explode('/', $cidr);
  return ( ip2long($ip) & (-1<<(32-$mask)) ) == ip2long($net);
}
?>












