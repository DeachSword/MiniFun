<?php
class MiniFun
{

public $Project="LastStarduts";
public $Version="4.7.0";

public function Info()
{
return "DeachSword © 2016-2017 『".$this->Version()."』";
}

public function Version()
{
return "MiniFun ".$this->Version." Project ".$this->Project;
}

//射殺
public function Shooting($dead, $killer=null, $tool=null){
//version 1.1.0
if(!empty($dead)){
if(!empty($killer)){
if(!empty($tool)){
return $killer." 用 ".$tool." 射殺了 ".$dead;
}
return $dead." 被 ".$killer." 射殺了OAO";
}
return $dead." 已被射殺ゝっっっ♥ ";
}
}

//擲骰子
public function Dice($dc, $dcs, $ds, $add=0){
//version 1.0.0
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
$dollc=$dollc.$rand.",";
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

//Minecraft Skin View
public function MCSkin($user){
if(empty($user)){
return 'https://assets.mojang.com/SkinTemplates/steve.png';
}else{
$ch = curl_init('https://skins.minecraft.net/MinecraftSkins/' . $user . '.png');
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_NOBODY, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if($status == 301){
preg_match('/location:(.*)/i', $result, $matches);
curl_setopt($ch, CURLOPT_URL, trim($matches[1]));
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_NOBODY, 0);
$result = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if($status == 200){
$output = $result;
return 'https://skins.minecraft.net/MinecraftSkins/' . $user . '.png';
}
}
curl_close($ch);
}
}

//驗證碼
public function Captch($num="4",$str="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"){
//version 1.0.0
$date=substr(str_shuffle($str), 0, $num);
return $date;
}


//End.
}

class GirlsFrontline
{


function Profile($gf){
@$GirlsFrontline=json_decode(file_get_contents("./GirlsFrontline/Girls"),true);

$str = !empty($GirlsFrontline[$gf]['info']) ? $GirlsFrontline[$gf]['info'] :
"指揮官, 目前".$gf."的資料並不完善2333歡迎幫忙新增資料";
$str = !empty($GirlsFrontline[$gf]) ? $str :
"指揮官, 找不到有關於".$gf."的資料";

return $str;
}

function Name($id, $lv=false){
@$GirlsFrontline=json_decode(file_get_contents("./GirlsFrontline/Girls"),true);
$level=null;
while($fruit_name = current($GirlsFrontline)){
if($fruit_name['id'] == $id){
if($lv){
$level = !empty($GirlsFrontline[key($GirlsFrontline)]['level']) ? $GirlsFrontline[key($GirlsFrontline)]['level'] :
"Unknown";
}
$str = empty($str) ? $level.key($GirlsFrontline) : $str."\n".$level.key($GirlsFrontline);
}
next($GirlsFrontline);
}
$str = !empty($str) ? $str : "指揮官, 找不到編號".$id."的資料";

return $str;
}

function Time($time){
@$GirlsFrontline=json_decode(file_get_contents("./GirlsFrontline/TimeGuns"),true);

if(!empty($GirlsFrontline[$time])){
$c=count($GirlsFrontline[$time]);

for($i=0; $i<$c; $i++){
$date=empty($date) ? GirlsFrontline::Name($GirlsFrontline[$time][$i], true) : $date."\n".GirlsFrontline::Name($GirlsFrontline[$time][$i], true);
}

$str=$date;
}else{
$str="找不到可建造的人形(＞﹏＜)";
}
return $str;
}

//End. 
}
?>