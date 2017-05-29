<?php
class MiniFun
{

public function Shooting($text,$str="射殺"){
$s=explode($str, $text, 2);
if(!empty($s[0])&&!empty($s[1])){
$reply=$s[0]." 射殺了 ".$s[1];
}elseif(empty($s[0])&&!empty($s[1])){
$reply="咦？你想要射殺 ".$s[1]." 嗎？可我不是那種機器人耶~\n好啦~ ".$s[1]." 已被射殺XD";
}else{
$reply=null;
}
return $reply;
}

//擲骰子
public function Dice($dc, $dcs, $ds, $add=0){

$ex=null;
$reply=null;
if($dc>20){
return "親~複數骰超過20次是不對的行為喔😯";
$dc=0;
}
for($i=0; $i<$dc; $i++){
$ic=$i+1;
$dollc="[";
$dolls=0;
for($is=0; $is<$dcs; $is++){
$rand=rand(1,$ds);
if($is==$dcs-1){
$dolls=$rand+$dolls;
if($dcs<=10){
$dollc=$dolls.$dollc.$rand. "]";
}else{
$dollc=$dolls."[(投擲次數過多省略)]";
}
if($add>0){
$dolls=$dolls+$add;
$dollc=$dollc."+".$add."=".$dolls;
}else{
$dollc=$dollc."=".$dolls;
}
}else{
if($dcs<=10){
$dollc=$dollc.$rand."+";
}else{
$dollc=$dollc;
}
$dolls=$rand+$dolls;
}
}
if($ic<$dc){
$reply=$reply."第".$ic."次擲骰: ".$dollc."\n";
}else{
$reply=$reply."第".$ic."次擲骰: ".$dollc;
}
}
return $reply;
}
}
?>