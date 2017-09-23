<?php

if(!empty($_GET['name'])){
    if(!empty($_GET['mode'])){
        Minecraft::Skin($_GET['name'], $_GET['mode']);
    }else{
        Minecraft::Skin($_GET['name']);
    }
}
if(!empty($_GET["tra"])){
Translation::tra($_GET["tra"]);
}


class MiniFun{

    public $Project="LastStarduts";
    public $Version="5.1.7";

    public function Info(){
        return "DeachSword © 2016-".date('Y')." 『".$this->Version()."』";
    }

    public function Version(){
        return "MiniFun ".$this->Version." Project ".$this->Project;
    }

    public function Shooting($dead, $killer=null, $tool=null){
        /***
        Version: 2.0.0 beta
        Author: 隱歿
        Protocol: MiniFun::Shooting()
        ***/
        
        $rand=rand(1,10);
        
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

    public function Dice($dc, $dcs, $ds, $add=0){
        /***
        Version: 1.5.0
        Author: Wind Rainy
        Protocol: MiniFun::Dice()
        ***/
        $ex=null;
        $reply=null;
        if($dc>20){
            return "親~複數骰超過20次是不對的行為喔Σ(=ω= ;)";
            $dc=0; //bug
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
                        $dollc=$dollc.$rand.","; //was corrected from '+' to ','
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

    public function Captch($num="4",$str=null){
        /***
        Version: 1.0.1
        Author: DeachSword
        Protocol: MiniFun::Captch()
        ***/
        $Default = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = !empty($str) ? $str : $Default;
        $date=substr(str_shuffle($str), 0, $num);
        
        return $date;
    }

    public function Bingo($range="6",$file, $mode=1){
        /***
        Version: 1.0.0
        Author: LDX
        Protocol: MiniFun::Bingo()
        ***/
        $bingo=array();
        $count=$range*$range;
        $eff=1;
        $ev=null;
        $title="Bingo活動！\n\n";

        if(is_file($file)){
            @$data=json_decode(file_get_contents($file),true);
            if(empty($data["main"])){
                $eff=0;
                if(!empty($data)){
                    $bingo=$data;
                }
            }else{
                $bingo=$data;
            }
        }else{
            $eff=0;
        }

        if($eff==0){
            
            while(count($bingo["main"]) < $count){
                $rand_c=rand(1,$count);
                $c=count($bingo["main"]);
                $bingo["main"][$c]=$rand_c;
                $bingo["main"]=array_unique($bingo["main"]);
            }

            if(count($bingo["main"]) == $count){
                file_put_contents($file, json_encode($bingo));
                $eff=1;
            }
        }

        if(count($bingo["safe"])==$count){
            $mode=0;
            $eff=2;
            $reply="恭喜已完成BINGO！\n\n得分總計: ".$bingo["score"]."！";
        }

        if($mode==1){
            if($bingo["over"]>0){
                $bingo["over"]--;
                $rand_c=rand(1,$count);
                $y=array_keys($bingo["main"], $rand_c);
                $y=$y[0];
                if(empty($bingo["safe"][$rand_c])){
                    $z=1;
                    $sl=1;
                    $hl=1;
                    $ol=0;

                    /***直列***/
                    for($s=$range; ($y-$s)>=0; $s=$s+$range){
                        $r=$y-$s;
                        $r=$bingo["main"][$r];
                        if(!empty($bingo["safe"][$r])){
                            $sl++;
                        }
                        $z++;
                    }
                    for($s=$range; ($y+$s)<$count; $s=$s+$range){
                        $r=$y+$s;
                        $r=$bingo["main"][$r];
                        if(!empty($bingo["safe"][$r])){
                            $sl++;
                        }
                    }

                    /***橫列***/
                    for($h=$y+1; $h<($z*$range); $h++){
                        $r=$bingo["main"][$h];
                        if(!empty($bingo["safe"][$r])){
                            $hl++;
                        }
                    }
                    for($h=$y-1; $h>=(($z-1)*$range); $h--){
                        $r=$bingo["main"][$h];
                        if(!empty($bingo["safe"][$r])){
                            $hl++;
                        }
                    }

                    /***斜排***/


                    /***結算***/
                    if($sl==$range){
                        $ev=empty($ev) ? "\n恭喜連成 直線！獎勵 100 積分！" : $ev."\n恭喜連成 直線！獎勵 100 積分！";
                        $bingo["score"]=!empty($bingo["score"]) ? $bingo["score"]+100 : 100;
                    }
                    if($hl==$range){
                    $ev=empty($ev) ? "\n恭喜連成 橫線！獎勵 100 分！" : $ev."\n恭喜連成 橫線！獎勵 100 積分！";
                    $bingo["score"]=!empty($bingo["score"]) ? $bingo["score"]+100 : 100;
                    }
                    if($ol>1){
                        $half=($y+1)/2;
                        $ev=empty($ev) ? "\n恭喜連成 斜線！獎勵 100 積分！" : $ev."\n恭喜連成一條斜線！獎勵 100 積分！";
                        if(($range%2)!=0&&(($range*$half)-$half)==$y){
                            $ev=empty($ev) ? "\n恭喜一次連成兩條斜線！獎勵 300 積分！" : $ev."\n恭喜一次連成兩條斜線！獎勵 300 積分！";
                            $bingo["score"]=!empty($bingo["score"]) ? $bingo["score"]+300 : 300; //特別獎勵100
                        }else{
                            $bingo["score"]=!empty($bingo["score"]) ? $bingo["score"]+100 : 100;
                        }
                    }

                    if(count($bingo["safe"])==$count){
                        $ev=empty($ev) ? "\n\n恭喜完成BINGO！獎勵 1000 積分！" : $ev."\n\n恭喜完成BINGO！獎勵 1000 積分！";
                        $bingo["score"]=!empty($bingo["score"]) ? $bingo["score"]+1000 : 1000;
                    }

                    $reply="恭喜獲得數字 ".$rand_c." ！".$ev."\n\n";
                    $bingo["safe"][$rand_c]=1;
                    file_put_contents($file, json_encode($bingo));
                }else{
                    $reply="恭喜獲得數字 ".$rand_c." ！\n已有這個數字已轉換成 10 積分！\n\n";
                    $bingo["safe"][$rand_c]++;
                    $bingo["score"]=!empty($bingo["score"]) ? $bingo["score"]+10 : 10;
                    file_put_contents($file, json_encode($bingo));
                }
            }else{
                $eff=3;
                $reply="智商餘額為不足！";
            }
        }

        if($eff==1){
            $bingo_data=null;
            $c=0;
            for($s=1; $s<=$range; $s++){

                for($i=1; $i<=$range; $i++){
                    $main_c=$bingo["main"][$c];

                    while(strlen($main_c)<strlen($count)){
                        $main_c="0".$main_c;
                    }

                    if(!empty($bingo["safe"][$bingo["main"][$c]])){
                        $main_c="[".$main_c."]";
                    }else{
                        $main_c=" ".$main_c." ";
                    }

                    $bingo_data=empty($bingo_data) ? $main_c : $bingo_data.$main_c;

                    if($i==$range&&$s!=$range){
                        $bingo_data=$bingo_data."\n";
                    }
                    $c++;
                }
            }
        $reply=$title.$bingo_data;
        }

        if($eff==2||$mode==3){
            $rank=array();
            $files=glob("./Bingo/**");
            for($i=0; $i<count($files); $i++){
                $detail=json_decode(file_get_contents($files[$i]),true);
                $name=!empty($detail["name"]) ? $detail["name"] : "NoName";
                $r=MiniFun::Captch(15);
                $scored =!empty($detail["score"]) ? $detail["score"] : "0";
                $rank[$r]=$scored;
                $rank_n[$r]=$name;
                if(count($rank)==count($files)){
                    arsort($rank);
                    reset($rank);
                    for($i=1; $i<=10; $i++){
                        $r=each($rank);
                        if(!empty($r)){
                            $a="No.".$i." ".$rank_n[$r["key"]]." : ".$r["value"]." 分";
                        }else{
                            $a="No.".$i." EMPTY";
                        }

                        $ranking=!empty($ranging) ? $a : $ranking."\n".$a;

                    }
                }
            }

            if($mode==3){
                $reply="BINGO RANKING\n". $ranking;
            }else{
                $reply=$reply."\n\n".$ranking;
            }

        }
        return $reply;
    }

    public static function Probability($probability=array(80,5,3,1), $value=array("非洲","歐洲","大佬","巨佬"), $percent=100, $num=5, $m=0){
        /***
        Version: 1.0.0.63
        Author: 隱歿
        Protocol: MiniFun::Probability()
        ***/
        $str = array();
        $score = array();
        $out = null;

        if($num>30){
            return "Please do not use more than 30";
        }

        if(!empty($probability&&$value&&$percent&&$num)){
            while(count($str) != $percent){
                for($s = 0; $s < count($value); $s++){
                    if(!is_numeric($probability[$s])){
                        return $probability[$s]." 必須是一個數字！";
                    }
                    if(count($str) < $percent){
                        $r = rand(0, 99999);
                        while(strlen($r) != 5){
                            $r = "0".$r;
                        }
                        $r = rand(0, 100).".".$r;
                        if(round($probability[$s],5) >= $r){
                            $str[] = $value[$s];
                            $score[] = $probability[$s];
                        }
                    }
                }
            }
            while(count($str) == $percent){
                $r = rand(0, $percent);
                for($i = 0; $i < $num; $i++){
                    $rs=rand(-100, $percent);
                    $c = $i + 1;
                    $rs = $r + $i; //!
                    if($rs >= $percent){
                        $r = 0;
                        $rs = 0;
                    }
                    $score_a = rand(0,100);
                    if($score_a == 100){
                        $score_b = "00";
                    }else{
                        $score_b = rand(0,99);
                    }
                    while(strlen($score_b) != 2){
                        $score_b = "0".$score_b;
                    }
                    $score_c = $score_a.".".$score_b;
                    $score_x = $score_c/$score[$rs]; //個體差異
                    $score_y = 100/$score[$rs];
                    $score_z = empty($score_z) ? $score_y : $score_z+$score_y;
                    $Scores = !empty($scores) ? $scores + $score_x : $score_x;
                    $scores = empty($score_z) ? $score_y : $score_z+$score_y;
                    if($m){
                        $out = empty($out) ? $str[$rs] : $out."\n".$str[$rs];
                    }else{
                        $def = $c.'. '.$str[$rs];
                        $out = empty($out) ? $def." ".round($score_c)."%" : $out."\n".$def." ".round($score_c)."%";
                    }
                    
                }
                $score = ($Scores/$scores)*100;
                $ex = null;
                if($score>100){
                    $ex=" 極限突破！此人已經超凡！";
                }elseif($score==100){
                    $ex=" 完美無瑕！";
                }elseif($score<=10&&$score>0){
                    $ex=" LifeLoser！接近於0的存在...";
                }elseif($score>10&&$score<=30){
                    $ex=" Noob. Can’t you do anything right?";
                }elseif($score<=0){
                    $ex=" 絕對0度!你還有甚麼好失去的?";
                }elseif($score>=70&&$score<100){
                    $ex=" 高人一等！";
                }else{
                    $ex=" 普普通通。";
                }
                return $out;
            }
        }
        //return "發生錯誤!";
    }
/****
* E *
* N *
* D *
****/
}
class GirlsFrontline{

    public static function Profile($gf){
        /***
        Version: 2.2.1
        Author: 夜樱
        Protocol: GirlsFrontline::Profile()
        ***/
        $minifun = "https://raw.githubusercontent.com/DeachSword/MiniFun/%E5%B0%91%E5%A5%B3%E5%89%8D%E7%B7%9A/Girls";
        @$GirlsFrontline = json_decode(file_get_contents("./Girls"),true);
        $GirlsFrontline = !empty($GirlsFrontline) ? $GirlsFrontline : json_decode(file_get_contents($minifun),true);

        $str = !empty($GirlsFrontline[$gf]['info']) ? "【Girls'Frontline - ".$gf."】\n".$GirlsFrontline[$gf]['info'] :
"指揮官, 目前".$gf."的資料並不完善2333\n歡迎幫忙新增資料: https://github.com/DeachSword/MiniFun/tree/%E5%B0%91%E5%A5%B3%E5%89%8D%E7%B7%9A";
        $str = !empty($GirlsFrontline[$gf]) ? $str :
"指揮官, 找不到有關於".$gf."的資料";

        return $str;
    }

    public static function Name($id, $lv=false){
        /***
        Version: 2.3.0
        Author: 夜樱
        Protocol: GirlsFrontline::Name()
        ***/
        $minifun = "https://raw.githubusercontent.com/DeachSword/MiniFun/%E5%B0%91%E5%A5%B3%E5%89%8D%E7%B7%9A/Girls";
        @$GirlsFrontline=json_decode(file_get_contents("./Girls"),true);
        $level=null;
        $GirlsFrontline = !empty($GirlsFrontline) ? $GirlsFrontline : json_decode(file_get_contents($minifun),true);

        while($fruit_name = current($GirlsFrontline)){
            if($fruit_name['id'] == $id){
                if($lv){
                    $level = !empty($GirlsFrontline[key($GirlsFrontline)]['level']) ? "【".(strlen($GirlsFrontline[key($GirlsFrontline)]['level']))/3 ."星】" : "【Unknown】";
                }
                $str = empty($str) ? $level.key($GirlsFrontline) : $str."\n".$level.key($GirlsFrontline);
            }
            next($GirlsFrontline);
        }
        $str = !empty($str) ? $str : "指揮官, 找不到編號".$id."的資料";

        return $str;
    }
    
    public static function GirlLevel($id){
        /***
        Version: 1.0.1
        Author: 夜樱
            Revise: 隱歿
            Version: 1.1
        Protocol: GirlsFrontline::GirlLevel()
        ***/
        $minifun = "https://raw.githubusercontent.com/DeachSword/MiniFun/%E5%B0%91%E5%A5%B3%E5%89%8D%E7%B7%9A/Girls";
        $GirlsFrontline = json_decode(file_get_contents($minifun),true);
        
        $str=null;
        
        if(empty($str)){
            foreach ($GirlsFrontline as $value){
                if($value['id'] == $id){
                    $str = strlen($value["level"])/3;
                }
            }
        }
        
        $str = !empty($str) ? $str : 0;

        return $str;
    }

    public static function Time($time){
        /***
        Version: 2.6.0
        Author: 夜樱
        Protocol: GirlsFrontline::Time()
        ***/
        
        while(strlen($time)<4){
            $time = "0".$time;
        }
        
        $minifun_g = "https://raw.githubusercontent.com/DeachSword/MiniFun/%E5%B0%91%E5%A5%B3%E5%89%8D%E7%B7%9A/TimeGuns";
        $GirlsFrontline = json_decode(file_get_contents($minifun_g),true);
        
        $minifun_f = "https://raw.githubusercontent.com/DeachSword/MiniFun/%E5%B0%91%E5%A5%B3%E5%89%8D%E7%B7%9A/Fairy";
        $Fairy = json_decode(file_get_contents($minifun_f),true);

        if(!empty($GirlsFrontline[$time])){
            $c=count($GirlsFrontline[$time]);
            for($i=0; $i<$c; $i++){
                $date=empty($date) ? self::Name($GirlsFrontline[$time][$i], true) : $date."\n".self::Name($GirlsFrontline[$time][$i], true);
            }
        }
        if(!empty($Fairy[$time])){
            $c=count($Fairy[$time]);
            for($i=0; $i<$c; $i++){
                $date=empty($date) ? $Fairy[$time][$i] : $date."\n".$Fairy[$time][$i];
            }
        }
        
        $str = empty($date) ? "找不到可建造的人形或妖精(＞﹏＜)" : $date;

        return $str;
    }

    public static function MakeGuns($manpower = 30, $rations = 30, $ammunition = 30, $components = 30, $core=0,$num = 1,$key=null){
        /***
        Version: 3.2.0
        Author: 隱歿
            Revise: 夜樱
                Version: 2.0.2
            Revise: DeachSword
                Version: 3.1.2
        Protocol: GirlsFrontline::MakeGuns()
        ***/

        $R = $manpower + $rations + $ammunition + $components;
        
        if($R < 4000){
            $manpower = $manpower <= 999 && $manpower >= 30 ? $manpower : Null;
            $rations = $rations <= 999 && $rations >= 30 ? $rations : Null;
            $ammunition = $ammunition <= 999 && $ammunition >= 30 ? $ammunition : Null;
            $components = $components <= 999 && $components >= 30 ? $components : Null;
            $core = "0";
        }else{
            $manpower = $manpower <= 9999 && $manpower >= 1000 ? $manpower : Null;
            $rations = $rations <= 9999 && $rations >= 1000 ? $rations : Null;
            $ammunition = $ammunition <= 9999 && $ammunition >= 1000 ? $ammunition : Null;
            $components = $components <= 9999 && $components >= 1000 ? $components : Null;
            if($core == 0){
                $core = 1;
            }elseif($core > 3 || $core < 0){
                return "重造檔數只能在1~3之間喔~";
            }
        }
        
        if(!empty($manpower && $rations && $ammunition && $components)){
            if($manpower != 416 && $rations != 416 && $ammunition != 416 && $components != 416){
                if($core == 0){
                    $probability = array(0, 0, 60, 27, 10, 3);
                    $ar = ($rations >= 400 && $ammunition >= 400) ? true : false;
                    $smg = $manpower >= 400 && $rations >= 400 ? true : false;
                    $rf = $manpower >= 300 && $ammunition >= 300 ? true : false;
                    $rfs = $manpower >= 400 && $ammunition >= 400 ? true : false;
                    $mg = $manpower >= 400 && $rations >= 600 && $components >= 300 ? true : false;
                    $mgs = $manpower >= 600 && $rations >= 600 && $ammunition >= 100 && $components >= 400 ? true : false;
                }else{
                    $probability = array(0, 0, 0, 40, 45, 15);
                    $ar = ($rations >= 4000 && $ammunition >= 4000) ? true : false;
                    $smg = $manpower >= 4000 && $rations >= 4000 ? true : false;
                    $rf = $manpower >= 3000 && $ammunition >= 3000 ? true : false;
                    $rfs = $manpower >= 4000 && $ammunition >= 4000 ? true : false;
                    $mg = $manpower >= 4000 && $rations >= 6000 && $components >= 3000 ? true : false;
                    $mgs = $manpower >= 6000 && $rations >= 6000 && $components >= 4000 ? true : false;
                    if($core == 1){
                        $probability = array(0, 0, 0, 40, 45, 15);
                    }elseif($core == 2){
                        $probability = array(0, 0, 0, 20, 60, 20);
                    }elseif($core == 3){
                        $probability = array(0, 0, 0, 0, 75, 25);
                    }
                }
                
                $R = $manpower + $rations + $ammunition + $components;
                $L = $manpower."/".$rations."/".$ammunition."/".$components."/".$core;
                $str=array();

                if($mode=="n"){
                    $strs = array(
                    "16","17","18","21","22","24","25","26","27","31","32","33","92","93","94"
                    );
                    $str = array_merge($str,$strs);
                }
                if($ar){
                    $strs = array(
                        "64","72",
                        "62","106","129","130"
                    );
                    $str = array_merge($str,$strs);
                }
                if($mgs){
                    $strs = array(
                        "85",
                        "112"
                    );
                    $str = array_merge($str,$strs);
                }
                if($rfs){
                    $strs = array(
                        "95",
                        "46","50","128"
                    );
                    $str = array_merge($str,$strs);
                }
                if($mg){
                    $strs = array(
                        "81","82","87","110","111",
                        "77","80","86","89",
                        "75","78","88","121",
                        "109","125"
                    );
                    $str = array_merge($str,$strs);
                }
                if($rf){
                    $strs = array(
                        "40","41","47","51","52",
                        "34","37","44",
                        "36","39","42","43",
                        "48","53"
                    );
                    $str = array_merge($str,$strs);
                }
                if($manpower >= 6000 && $ammunition >= 6000){
                    $strs = array(
                        "152","154","158","159","190",
                        "153","155","156","162","189",
                        "151","157","160","188"
                    );
                    $str = array_merge($str,$strs);
                }
                if($smg){
                    $strs = array(
                        "29",
                        "23","101","103",
                        "20","104","115","127","135"
                    );
                    $str = array_merge($str,$strs);
                }
                if($R >= 800){
                    $strs = array(
                        "63","68","71","74","107",
                        "58","61","70","145",
                        "60","66","69","118",
                        "65","122"
                    );
                    $str = array_merge($str,$strs);
                }
                if($R <= 920){
                    if($manpower >= 130 && $rations >= 130 && $ammunition >= 130){
                        //7 97 114 183
                        $strs = array(
                            "1","2","3","5","6","7","8","9","10","11","12","13","14","90","91","96","97","99","100","114","123","139","141","168","183"
                        );
                    }else{
                        $strs = array(
                            "1","2","3","5","6","8","9","10","11","12","13","14","90","91","96","99","100","123","139","141","168"
                        );
                    }
                    $str = array_merge($str,$strs);
                }

                if(count($str) > 0){
                    $debuga = date("YmdHis");
                    $num = $num > 10 ? 10 : $num;
                    for($a = 0; $a < count($str); $a++){
                        $level = self::GirlLevel($str[$a]);
                        $levels[$a] = $probability[$level];
                    }
                    if(count($levels) == count($str)){
                        $guns = MiniFun::Probability($levels, $str, count($str), $num, 1);
                    }
                }
                $debugb = date("YmdHis");
                @$db = Github::content("DeachSword","MiniFun","GF_MakeGuns","Database",$key);
                $gun = explode("\n",$guns);
                $h = ">>";
                if(empty($db)){
                    @$db = json_decode(file_get_contents("https://raw.githubusercontent.com/DeachSword/MiniFun/Database/GF_MakeGuns"),true);
                    $h = ">X";
                }
                for($g = 0; $g < count($gun); $g++){
                    $db[$L]["count"]++;
                    $db[$L]["make"][$gun[$g]]++;
                    if($db[$L]["count"] >= 15){
                        $seed=$h.round(100*($db[$L]["make"][$gun[$g]]/$db[$L]["count"]),2)."%";
                    }else{
                        $seed=$h."ネロ";
                    }
                    $gn = self::Name($gun[$g], true). $seed;
                    $gun_name = !empty($gun_name) ? $gun_name."\n".$gn : $gn;
                }
                $sha = Github::sha("DeachSword","MiniFun","GF_MakeGuns","Database",$key);
                $res = Github::PUT("DeachSword","MiniFun","GF_MakeGuns","Database",json_encode($db),$sha,$key);
            }else{
                 $gun_name = self::Name(65, true).">>♥%";
            }
            $reply = $gun_name;
        }else{
            $reply = "資源設定有誤( *｀ω´)\n\n普造: 30~999\n重造: 1000~9999";
        }
        $debug = $debugb - $debuga;
        
        return $reply;
    }
/****
* E *
* N *
* D *
****/ 
}
class Minecraft{

    public function Skin($user, $mode=2){
        /***
        Version: 2.1.3
        Author: 隱歿
        Protocol: Minecraft::Skin()
        ***/
        ini_set("display_errors",FALSE);
        header("Content-type: image/png");

        $size = 256;
        $name = $user;

        $src = imagecreatefrompng("http://skins.minecraft.net/MinecraftSkins/".$name.".png");
        $src = !$src ? null : $src;

        $final = imagecreatetruecolor($size, $size);
        $bg = imagecolorallocatealpha($final,0,0,0,127);
        imagecolortransparent($final,$bg);
        imagefill($final,0,0,$bg);

        if(!empty($src)){
            if($mode==1){
                imagecopyresized($final, $src, 0, 0, 0, 0, $size, $size, 64, 64);
            }elseif($mode==2){
                $dest = imagecreatetruecolor(8, 8);
                imagecopy($dest, $src, 0, 0, 8, 8, 8, 8);
        
                $bg_color = imagecolorat($src, 1, 1);
                $no_helm = true;
                
                for($i = 1; $i <= 8; $i++){
                    for($j = 1; $j <= 8; $j++){
                        if (imagecolorat($src, 40 + $i, 8 + $j) != $bg_color) {
                            $no_helm = false;
                        }
                    }
                    if(!$no_helm)
                    break;
                }
        
                if(!$no_helm){
                    imagecopy($dest, $src, 0, 0, 40, 8, 8, 8);
                }
                
                imagecopyresized($final, $dest, 0, 0, 0, 0, $size, $size, 8, 8);
            }elseif($mode==3){
                $dest = imagecreatetruecolor(32, 32);
                
                imagecopy($dest, $src, 12, 0, 8, 8, 8, 8);
                imagecopy($dest, $src, 8, 8, 44, 20, 4, 12);
                imagecopy($dest, $src, 20, 8, 36, 52, 4, 12);
                imagecopy($dest, $src, 12, 8, 20, 20, 8, 12);
                imagecopy($dest, $src, 12, 20, 4, 20, 4, 12);
                imagecopy($dest, $src, 16, 20, 20, 52, 4, 12);
                
                imagecopy($dest, $src, 12, 0, 40, 8, 8, 8);
                imagecopy($dest, $src, 12, 8, 20, 36, 8, 12);
                imagecopy($dest, $src, 8, 8, 44, 36, 4, 12);
                imagecopy($dest, $src, 20, 8, 52, 52, 4, 12);
                
                imagecopy($dest, $src, 12, 20, 4, 36, 4, 12);
                imagecopy($dest, $src, 16, 20, 4, 52, 4, 12);

                //imagecopy($dest, $src, 12, 8, 56, 20, 8, 12);
                
                imagecopyresized($final, $dest, 0, 0, 0, 0, $size, $size, 32, 32);
            }
            
            $textcolor = imagecolorallocate($final, 128, 128, 128);
            imagestring($final, 3, 180, 240, "DeachSword", $textcolor);

            imagepng($final);

            @imagedestroy($src);
            @imagedestroy($dest);
            @imagedestroy($final);
        
            //return "https://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?name=".$user."&&mode=".$mode;
            return "https://".$_SERVER['HTTP_HOST']."/MiniFun.php?name=".$user."&&mode=".$mode;
        }else{
            header("Content-Type: text/html");
            echo "404 Not Found";
            return null;
        }
    }
/****
* E *
* N *
* D *
****/ 
}

class Github{
    
    public function PUT($user, $git, $fn, $branch, $str, $sha = null, $key = null, $upmessage = "Data update."){
        /***
        Version: 1.0.0
        Author: DeachSword
        Protocol: Github::PUT()
        ***/
        
        $url = "https://api.github.com/repos/".$user."/".$git."/contents/".$fn."?ref=".$branch."&access_token=". $key;
        
        $data["message"] = $upmessage;
        //$data["committer"]["name"] = "DeachSword";
        //$data["committer"]["email"] = null;
        $data["content"] = base64_encode($str);
        $data["branch"] = $branch;
        
        if(!empty($sha)){
            $data["sha"] = $sha;
        }
        
        $ch = curl_init();
        
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HTTPHEADER,array("User-Agent: Awesome-Octocat-App","Content-Type: apllication/json"));
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_BINARYTRANSFER,true);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST,"PUT");
        curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($data));
        
        $res = curl_exec($ch);
        
        curl_close($ch);
        
        return $res;
    }

    public function sha($user, $git, $fn, $branch, $key){
        /***
        Version: 1.0.0
        Author: DeachSword
        Protocol: Github::PUT()
        ***/

        $url="https://api.github.com/repos/".$user."/".$git."/contents/".$fn."?ref=".$branch."&access_token=". $key;
        
        $ch = curl_init();
        
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HTTPHEADER,array("User-Agent: Awesome-Octocat-App"));
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_BINARYTRANSFER,true);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST,"GET");
        
        $res=curl_exec($ch);
        
        curl_close($ch);
        
        return json_decode($res,true)["sha"];
    }

    public function content($user, $git, $fn, $branch, $key){
        /***
        Version: 1.0.0
        Author: DeachSword
        Protocol: Github::PUT()
        ***/
        
        $url="https://api.github.com/repos/".$user."/".$git."/contents/".$fn."?ref=".$branch."&access_token=". $key;
    
        $ch=curl_init();

        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HTTPHEADER,array("User-Agent: Awesome-Octocat-App"));
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_BINARYTRANSFER,true);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST,"GET");

        $res=curl_exec($ch);

        curl_close($ch);

        return json_decode(base64_decode(json_decode($res,true)["content"]),true);
    }
/****
* E *
* N *
* D *
****/ 
}

?>