<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
</head>
<body>
<?php
$dsn= 'データベース';
$user='ユーザー';
$password='パスワード';
$pdo=new  PDO($dsn,$user,$password);

$stmt = $pdo -> query('SET NAMES utf8');
 
$name = $_POST['name'];
$comment = $_POST['comment'];
$now = date("Y/m/d H:i:s");
$delete = $_POST['delete'];
$edit = $_POST['edit'];
$edit_num = $_POST['edit_num'];
$password = $_POST['password'];
$delete_pass = $_POST['delete_pass'];
$edit_pass = $_POST['edit_pass'];
 

$sql= "CREATE TABLE list13"
." ("
. "id INT AUTO_INCREMENT PRIMARY KEY,"
. "name char(32),"
. "comment TEXT,"
. "now DATETIME,"
. "password TEXT"
. ");"
;

$stmt = $pdo->query($sql);
 

if(!empty($name)&&!empty($comment)&&!empty($password)){
 
    if(!empty($_POST['edit_num'])&&!empty($_POST['name'])&&!empty($_POST['comment'])){
        
        $sql = "update list13 set name='$name', comment='$comment', password = '$password' where id = $edit_num";
        $result = $pdo->query($sql);
    }else{
    
    $sql = $pdo -> prepare("INSERT INTO list13 (id,name, comment, now, password) VALUES (null, :name, :comment, :now, :password)");
    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
    $sql -> bindparam(':now',$now,PDO::PARAM_STR);
    $sql -> bindparam(':password',$password,PDO::PARAM_STR);
    $sql -> execute();
    }
}
 

if(!empty($_POST['delete'])&&is_numeric($_POST['delete'])&&!empty($_POST['delete_pass'])){
    $sql = "select * from list13  where id = $delete";
    $result = $pdo->query($sql);
    $row2 = $result -> fetch();
    if($row2['password'] == $delete_pass){
        $sql = "DELETE FROM list13 WHERE id = $delete";
        $results = $pdo -> query($sql);
    }
}
 

if(isset($_POST['edit'])&&$_POST['edit']!=""&&!empty($_POST['edit_pass'])){
    $sql = "select * from list13  where id = $edit";
    $result = $pdo->query($sql);
    $row1 = $result -> fetch();
    if($row1['password'] == $edit_pass){
        $row1_id = $row1['id'];
        $row1_name = $row1['name'];
        $row1_comment = $row1['comment'];
    }
}      
 
$sql = "DROP TABLE IF EXISTS result[CASCADE]";
$result = $pdo->query($sql);
 
$sql = "DROP TABLE IF EXISTS keijiban[CASCADE]";
$result = $pdo->query($sql);
 

 
?>
<body>

 <form action=""method="POST">
  <p><input type="text" name="name" value = "<?php echo($row1_name);?>" placeholder="名前"></p>
  <p><input type="text" name="comment" value = "<?php echo($row1_comment);?>" placeholder="コメント"></p>
  <p><input type="password" name="password" placeholder = "パスワード">
     <input type="submit"  value="送信"></p>
  <p><input type="hidden" name="edit_num" value="<?php echo ($row1_id); ?>"> </p>
  <p><input type="text" name="delete" placeholder="削除番号"></p>
  <p><input type="password" name="delete_pass" placeholder = "パスワード">
     <input type="submit" value="削除"></p>
  <p><input type="text" name="edit" placeholder="編集番号"></p>
  <p><input type="password" name = "edit_pass" placeholder = "パスワード">
     <input type="submit" value="編集"></p>
</body>
 
<?php

$sql = 'SELECT * FROM list13 order by id';
$results = $pdo -> query($sql);
foreach ($results as $row){    
    echo $row['id'].'<>';    
    echo $row['name'].'<>';    
    echo $row['comment'].'<>';
    echo $row['now'].'<br>';
}
?>
</html>