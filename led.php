<?php 
  /*
  method: set | get
  name: 起个名字
  value: 0 | 1  只有set方法需要这个参数
  */

  $method = $_GET['method'];
  $name = $_GET['name']??'default';
  $value = $_GET['value']??0;

  $data = null;

  //连接数据库
  $conn = mysqli_connect('ip address', 'username', 'password', 'database');
  if (!$conn) {
    die('连接失败: ' . mysqli_connect_error());
  }

  if($method == "set"){
    //SET

    //sql语句
    //如果存在则更新，不存在则插入
    $sql = "INSERT INTO t_led (name, value)
            VALUES ('{$name}', {$value})
            ON DUPLICATE KEY UPDATE
            name = '{$name}', value = {$value};";
    $result = mysqli_query($conn, $sql);
    if($result){
      //更新成功
      $data = array(
        'method' => $method,
        'name' => $name,
        'value' => $value,
        'status' => "success",
        'message' => "LED {$name} set to {$value}",
      );
    }else{
      //更新失败
      $data = array(
        'method' => $method,
        'name' => $name,
        'value' => $value,
        'status' => "fail",
        'message' => "LED {$name} set to {$value} failed",
      );
    }
  }else if($method == 'get'){
    //GET

    //sql语句
    $sql = "SELECT * FROM t_led WHERE name = '{$name}';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if (mysqli_num_rows($result) > 0) {
      //获取成功
      $data = array(
        'method' => $method,
        'name' => $name,
        'value' => $row['value'],//从数据库中获取
        'status' => "success",
        'message' => "LED {$name} is {$row['value']}",   //从数据库中获取
        'status' => "success",
        'message' => "LED {$name} is {$row['value']}",   //从数据库中获取
      ); 
    }else{
      //获取失败
      $data = array(
        'method' => $method,
        'name' => $name,
        'value' => 'null',
        'status' => "fail",
        'message' => "LED {$name} get failed",
      );
    }
     

  }else{
    $data = array(
      'method' => 'null',
      'name' => 'null',
      'value' => 'null',
      'status' => "error",
      'message' => "Invalid method",
    );
  }

  header("Access-Control-Allow-Origin: *");
  header('Content-Type: application/json');
  if($data != null){
    echo json_encode($data);
  }

?>
