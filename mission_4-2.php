<!DOCTYPE html>
<html lang="ja">
<head>
<meta http-equiv="content-type"charset="UTF-8">
<title>Mission4-2-掲示板</title>
</head>

<body>
<?php
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn,$user,$password);
$sql = "CREATE TABLE test4"
."("
	."bango INT PRIMARY KEY AUTO_INCREMENT,"
	."namae char(32),"
	."comment TEXT,"
	."hiniti TIMESTAMP,"
	."ara varchar(50)"
.");";
$stmt = $pdo->query($sql);
$sql = 'SHOW TABLES';
$result = $pdo->query($sql);
foreach($result as $row)
{
	echo $row[0];
	echo '<br>';
}
echo "<hr>";
$sql = 'SHOW CREATE TABLE test4';
$result = $pdo->query($sql);
foreach($result as $row)
{
	print_r($row);
}
echo"<hr>";
?>
<form action ="" method="post">
	<input type ="text" name="name" placeholder="投稿者名">
<br>	<input type ="text" name="come" placeholder="コメント">
<br>	<input type ="password" name="pasu" placeholder="パスワード">
	<input type ="submit" value="投稿">
</form>
<form action ="" method="post">
	<input type ="text" name="kesu" placeholder="削除対象番号">
<br>	<input type ="password" name="pasu" placeholder="パスワード">
	<input type ="submit" value="削除">
</form>
<form action="" method="post">
	<input type ="text" name="henshu" placeholder="編集対象番号">
<br>	<input type ="text" name="henshun" placeholder="編集後の名前">
<br>	<input type ="text" name="henshuc" placeholder="編集後のコメント">
<br>	<input type ="password" name="pasu" placeholder="パスワード">
	<input type ="submit" value="編集へ">
</form>

<?php
$sql=$pdo->prepare("INSERT INTO tasuke(pass) VALUES(:pass)");
$sql->bindParam(':pass',$pass,PDO::PARAM_STR);
$pass='kaijo';
$sql->execute();
?>

<?php
$name=$_POST['name'];
$come=$_POST['come'];
$pasu=$_POST['pasu'];

$kesu=$_POST['kesu'];//delete
$bango=$kesu;
if(!empty($kesu)&&($kesu)==($bango))
{
if(($pasu)==($pass))
	{	
	$sql="delete from test4 where bango=$bango";
	$result=$pdo->query($sql);
	}
}			//delete

$henshu=$_POST['henshu'];//編集機能
$henshun=$_POST['henshun'];
$henshuc=$_POST['henshuc'];
if(!empty($henshu)&&($henshun)&&!empty($henshuc))
{
if(($pasu)==($pass))
	{			
	$bango=$henshu;
	$na=$henshun;
	$co=$henshuc;
	$sql="update test4 set namae='$na', comment='$co' where bango=$bango";
	$result=$pdo->query($sql);
	}
}						//編集機能

if(!empty($name)&&($come)) //投稿機能
{
if(($pasu)==($pass))
	{
	$sql=$pdo->prepare("INSERT INTO test4 (bango,namae,comment,hiniti) VALUES(:bango,:namae,:comment,:hiniti)");
	$sql->bindValue(':bango',$bango,PDO::PARAM_INT);
	$sql->bindParam(':namae',$namae,PDO::PARAM_STR);
	$sql->bindParam(':comment',$comment,PDO::PARAM_STR);
	$sql->bindParam(':hiniti',$hiniti,PDO::PARAM_STR);
	$namae=$name;
	$comment=$come;
	$sql->execute();
	}
}

$sql='SELECT*FROM test4 ORDER BY bango';

	$results=$pdo->query($sql);
foreach($results as $row)
{
	echo $row['bango'].' ';
	echo $row['namae'].' ';
	echo $row['comment'].' ';
	echo $row['hiniti'].'<br>'; 
} //投稿機能
?>

</body>
</html>