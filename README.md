MiniFun PHP Script - 少女前線GirlsFrontline
===================

__此作品為開源項目,歡迎幫忙更新__

## NOTICE: 暫存範例!!


功能(Behavior)
-------------
```
<?php
require_once('[MiniFun.php](https://github.com/DeachSword/MiniFun/blob/master/MiniFun.php)');

$Girls=json_decode(file_get_contents("./Girls"),true); //decode data
$TimeGuns=json_decode(file_get_contents("./TimeGuns"),true); //decode data

$ID="65";
$NAME="hk416"; //must be lowercase
$TIME="0030"; //can not be divided

$MAKEGUNS=null;
$MAKEEQUIPMENT=null;
//$MAKEFAIRY=null;


echo GirlsFrontline::Name($ID); //output: hk416
echo GirlsFrontline::Profile($NAME); //output: hk416 data
echo GirlsFrontline::Time($TIME); //output: gun list


/*
以下為[Girls](https://github.com/DeachSword/MiniFun/blob/%E5%B0%91%E5%A5%B3%E5%89%8D%E7%B7%9A/Girls)修改資料
$Girls為已解析資料(Array)
$Girls[$NAME]則是獲取資料中$NAME的詳細資料(Array):['id'] ['level'] ['info']
*/

$Girls[$NAME]['id'] = $ID;
$Girls[$NAME]['level'] = '★★★★★';  //star
$Girls[$NAME]['info'] = '...'; //簡介
$date=json_encode($Girls); //轉碼數據為json格式
file_put_contents("./Girls",$date); //儲存至文件

?>
```

多餘(Additional)
-------------
- [X] 人形資料(Girls)
- [X] 人形製造時間(TimeGuns)
- [ ] 裝備製造時間
- [ ] 人形模擬製造
- [ ] 裝備模擬製造
* More will be updated


關於(About)
===
此PHP專案運行在[DeachSword](https://www.facebook.com/DeachSword.tw/)開發於Line Messager Bot計畫中的[第0號實驗BOT](https://line.me/R/ti/p/%40rvi1169z)
