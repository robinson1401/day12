<?php

session_start();
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=test','root', ''); 
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if ($_SERVER['REQUEST_METHOD']=== 'POST') {
    $date=date_create($_SESSION['date']);
    $date =date_format($date,"Y/d/m");
    $gender;
    if ($_SESSION['gender']=='Nam') {
        $gender=0;
    } else {
        $gender=1;
    }
    $faculty;
    if ($_SESSION['faculty']=='Khoa học máy tính') {
        $faculty='MAT';
    } else {
        $faculty='KDL';
    }
    $statement = $pdo-> prepare("INSERT INTO  student (name, gender ,faculty,birthday ,address,avartar)
    VALUE (:name,:gender,:faculty,:birthday,:address,:avartar)");
    $statement ->bindValue(':name',$_SESSION['name']);
    $statement ->bindValue(':gender',$gender);
    $statement ->bindValue(':faculty',$faculty);
    $statement ->bindValue(':birthday',$date);
    $statement ->bindValue(':address',$_SESSION['address']);
    $statement ->bindValue(':avartar', $_SESSION['image']);
    header('Location: complete_regist.php');
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="style1.css">
</head>

<body>
    <div id='backDiv'>
        <form method="POST" enctype="multipart/form-data" style="position: center !important;
    width:80%;
    margin-left: 10%;
    margin-right: 10%;" >
            <!-- fill the name info  -->
            <div class="infoDiv" class="required-field">
                <label class="fillLabel" class="h-100" for="name">Họ và tên </label>
                <div class="info">
                    <?php echo $_SESSION['name'] ?>
                </div>
            </div>

            <!-- choose genders -->
            <div class="infoDiv">
                <label class="fillLabel" class="h-100" for="gender"> Giới tính </label>
                <div class="info">
                    <?php echo $_SESSION['gender'] ?>
                </div>    
            </div>

            <!-- fill in faculty info -->
            <div class="infoDiv">
                <label class="fillLabel" class="h-100">Phân khoa </label>
                <div class="info">
                    <?php echo $_SESSION['faculty'] ?>
                </div> 
            </div>
            
            <!-- fill the DOB -->
            <div class="infoDiv">
                <label class="fillLabel" class="h-100" for="birthday">Ngày sinh </label>
                <div class="info">
                    <?php echo $_SESSION['date'] ?> 
                </div>
            </div>

            <div class="infoDiv">
                <label class="fillLabel" class="h-100" for="address">Địa Chỉ </label>
                <div class="info">
                    <?php echo $_SESSION['address'] ?>
                </div> 
            </div>

            <div class="infoDiv">
                <label class="fillLabel" class="h-100" >Hình ảnh </label>
                <img id="imgShow" src="<?php if($_SESSION['image']!='images/') {echo $_SESSION['image']; } ?>" class="thump-image" style="margin-left: 10%; height: 60px;">
            </div>

            <div id="cfmBtn">
                <button type="submit" class="btn btn-success" id="submitId" >Xác nhận</button>
            </div>
        </form>
    </div>

</body>

</html>