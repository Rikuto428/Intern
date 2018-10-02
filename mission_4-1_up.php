<html>
<meta charset = "UTF-8">
<head><title>MISSION4</title></head>
<body>

<?php

$dsn = 'mysql:dbname=データベース名;host=localhost';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn,$user,$password); //データベース接続

$sql = "CREATE TABLE mission4_1_re" //新しいテーブル作成
."("
."id INT,"
."name char(32),"
."comment TEXT,"
."date DATETIME," //追加
."pass char(32)" //追加
.");";
$stmt = $pdo -> query($sql);

?> 

<h1>掲示板</h1>
<hr>

<h2>新規投稿</h2>
<?php
if($_SERVER["REQUEST_METHOD"] != "GET"){
if(isset($_POST['button1'])){
if($_POST['num_edit2'] == ""){
if($_POST['name'] == "" || $_POST['comment'] == "" || $_POST['pass'] == ""){
echo "<p>入力不足です。</p>";
}
}
else{
if($_POST['name'] == "" || $_POST['comment'] == ""){
echo "<p>入力不足です。</p>";
}
}
}
} //入力判定
?>
<form method = "post">
<p>名前：<input type = 'text' name = 'name'></p>
<p>コメント：<textarea name = 'comment' rows = '8' cols = '40'></textarea></p>
<?php
if(isset($_POST['button3'])){
if($_SERVER["REQUEST_METHOD"] != "GET"){
$sql = 'SELECT * FROM mission4_1_re';
$results = $pdo -> query($sql);
foreach ($results as $row){
if($_POST['num_edit'] == $row['id'] && $_POST['pass_edit'] == $row['pass']){
$num_edit = $_POST['num_edit'];
}
}
}
}
if($num_edit != ""){
if(isset($_POST['button3'])){
if($_SERVER["REQUEST_METHOD"] != "GET"){
echo "<p>ID".$num_edit."の編集中です。</p>";
}
}
}
else{
echo "<p>パスワード：<input type= 'text' name= 'pass'></p>";
} //編集機能判定
?>
<!--編集中番号：--><input type = 'hidden' value = '<?php echo $num_edit; ?>' name = 'num_edit2'>
<button type = "submit" name = "button1">送信</button><br/>
</form>
<hr>

<h2>削除</h2>
<?php
if(isset($_POST['button2'])){
if($_SERVER["REQUEST_METHOD"] != "GET"){
$sql = 'SELECT * FROM mission4_1_re';
$results = $pdo -> query($sql);
foreach ($results as $row){
if($_POST['num_delete'] == $row['id'] && $_POST['pass_delete'] == $row['pass']){
$j++;
}
}
if($j == 0){
echo "<p>番号とパスワードが一致していません。</p>";
}
}
} //入力判定
?>
<form method="post">
<p>削除対象番号：<input type='text' name='num_delete'></p>
<p>パスワード：<input type='text' name='pass_delete'></p>
<button type="submit" name="button2">送信</button><br/>
</form>
<hr>

<h2>編集</h2>
<?php
if(isset($_POST['button3'])){
if($_SERVER["REQUEST_METHOD"] != "GET"){
$sql = 'SELECT * FROM mission4_1_re';
$results = $pdo -> query($sql);
foreach ($results as $row){
if($_POST['num_edit'] == $row['id'] && $_POST['pass_edit'] == $row['pass']){
$k++;
}
}
if($k == 0){
echo "<p>番号とパスワードが一致していません。</p>";
}
}
} //入力判定
?>
<form method = "post">
<p>編集対象番号：<input type = 'text' name = 'num_edit'></p>
<p>パスワード：<input type= 'text' name = 'pass_edit'></p>
<button type = "submit" name = "button3">送信</button><br/>
</form>
<hr>

<?php

if(isset($_POST['button1'])){
if($_SERVER["REQUEST_METHOD"] != "GET"){
if($_POST['name'] != "" && $_POST['comment'] != ""){

if($_POST['num_edit2'] == ""){
if($_POST['pass'] != ""){
$pdo -> setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true); 
$sql = 'SELECT * FROM mission4_1_re';
$stmt = $pdo -> query($sql);
$stmt -> execute();
$count = $stmt -> rowCount();  //投稿番号計算
$sql = $pdo -> prepare("INSERT INTO mission4_1_re (id, name, comment, date, pass) VALUES (:id, :name, :comment, :date, :pass)");
$sql -> bindParam(':id', $id, PDO::PARAM_STR);
$sql -> bindParam(':name', $name, PDO::PARAM_STR);
$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
$sql -> bindParam(':date', $date, PDO::PARAM_STR);
$sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
$id = $count + 1;
$name = $_POST['name'];
$comment = $_POST['comment'];
$date = date( "Y/m/d H:i:s" );
$pass = $_POST['pass'];
$sql -> execute();
}
}  //新規投稿

else{
$id = $_POST['num_edit2'];
$nm = $_POST['name'];
$kome = $_POST['comment'];
$sql = "update mission4_1_re set name = '$nm', comment = '$kome' where id = $id";
$result = $pdo -> query($sql);
} //編集機能

}
}
}

if(isset($_POST['button2'])){
if($_SERVER["REQUEST_METHOD"] != "GET"){
$sql = 'SELECT * FROM mission4_1_re';
$results = $pdo -> query($sql);
foreach ($results as $row){
if($_POST['num_delete'] == $row['id'] && $_POST['pass_delete'] == $row['pass']){
$id = $_POST['num_delete'];
$sql = "delete from mission4_1_re where id = $id";
$result = $pdo -> query($sql);
}
} //削除
$sql = 'SELECT * FROM mission4_1_re';
$results = $pdo -> query($sql);
foreach ($results as $row){
$id_edit = $row['id'];
$i++;
$sql = "update mission4_1_re set id = '$i' where id = $id_edit";
$result = $pdo -> query($sql); //idを投稿順に
}
}
}  //削除機能

$sql = 'SELECT * FROM mission4_1_re';
$results = $pdo -> query($sql);
foreach ($results as $row){
echo $row['id'].',';
echo $row['name'].',';
echo $row['comment'].',';
//echo $row['pass'].',';
echo $row['date'].'<br>';
}

?>

</body>
</html>