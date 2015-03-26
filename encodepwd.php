<?php

$uid = $argv[1];
$unpwd = $argv[2];
$pwdl1 = dropcrypt($argv[2]);
$pwdl2 = dropcrypt($argv[2],'llr',2);

print ("https://mylularoe.com/llrapi/v1/auth/{$uid}?pass={$unpwd}\n");
print ("mwl.controlpad.com:8080/cms/llr/login?username={$uid}&password={$pwdl1}\n");
print "UPDATE users SET password='{$pwdl2}' WHERE username='{$uid}'\n";

function dropcrypt($pass,$cid = 'llr', $level = 1)
{
	if ($level == 1) return base64_encode(md5($pass,true));
	if ($level == 2) return base64_encode(md5('llr'.base64_encode(md5($pass,true)),true));
}
