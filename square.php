<?php

#$name = 'product';
#$name = 'product[]';
#$name = 'product[qty]';
$name = 'product[attribute][colour]';
#$name = 'product[extra][]';
#$name = 'product[qty';
#$name = 'product]qty';
#$name = 'product[[qty]';
#$name = 'product[0][qty]';
#$name = 'product[1][qty]';
#$name = 'product[][name]';

$keys = array();
while ($name) {
	$open = strpos($name, '[');
	$start = $open + 1;
	$end = strpos($name, ']', $start);
	if ($open === false || $end === false || $end - $start < 0) {
		break;
	}
	$keys[] = substr($name, $start, $end - $start);
	$name = substr($name, $end + 1);
}
echo 'DONE';
