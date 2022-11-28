<?php
$gioiTinh = array(
    0 => 'Nam',
    1 => 'Nữ'
);
$khoa = array(
    '' => '',
    'MAT' => 'Khoa học máy tính',
    'KDL' => 'Khoa học vật liệu'
);
// error from inputs
$errors = [];
if ($_SERVER['REQUEST_METHOD']=== 'POST') {

    if (!$_POST['name']) {
        $errors[]='Hãy nhập tên.';
    }

    if(!isset($_POST['gender'])) {
        $errors[]='Hãy nhập giới tính.';
    }

    if (!$_POST['faculty']) {
        $errors[]='Hãy nhập Khoa.';
    }

    if (!$_POST['date']) {
        $errors[]='Hãy nhập ngày sinh.';
    }

    $image=$_FILES['image'] ?? null;

    // echo '<pre>';
    // var_dump($_FILES["image"]);
    // echo '</pre>';

    $imgType = array('image/jpeg','image/png','image/avif','image/webp','image/apng','image/svg+xml');

    if(!in_array($image["type"],$imgType) and $image["name"]!=null) {
        $errors[]='Ảnh không đúng định dạng!';
    }

    if(empty($errors)){
        if (!is_dir('upload/')) {
            mkdir('upload/');
        }

        // handle the image 
        if ($image["name"]!=null) {
            $currentDate=date("YmdHis");
            $nameArr=str_split($image["name"],strrpos($image["name"],"."));

            // add date and time to the image's name
            $image["name"]=$nameArr[0]."_".$currentDate.".".substr($nameArr[1],1);
            $imagePath = 'upload/'.$image['name'];
            mkdir(dirname($_POST['image']));
            move_uploaded_file($image['tmp_name'],$imagePath);
        }
        
        // format the date
        $date=date_create($_POST['date']);
        $date =date_format($date,"d/m/Y");
    
        session_start();
        $_SESSION['name'] = $_POST['name'];
        $_SESSION['gender'] = $_POST['gender'];
        $_SESSION['faculty'] = $_POST['faculty'];
        $_SESSION['date'] = $date;
        $_SESSION['address']=$_POST['address'];
        $_SESSION['image']=$imagePath;
        header('location:filledForm.php');
    }
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
        <form method="POST" style="position: center !important;
    width:80%;
    margin-left: 10%;
    margin-right: 10%;"  enctype="multipart/form-data">
        <?php if (!empty($errors)): ?>
            <div id="error">
                <?php foreach ($errors as $error): ?>
                    <div><?php echo $error ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
            <!-- fill the name info  -->
            <div class="infoDiv" class="required-field">
                <label id="label" class="h-100" for="name">Họ và tên </label>
                <input id="input" class="h-100" type="text" name="name" >
            </div>

            <!-- choose genders -->
            <div class="infoDiv">
                <label id="label" class="h-100" for="gender"> Giới tính </label>
                <div id="radioBtn" >
                    <?php
                    for ($i = 0; $i < 2; $i++) {
                    ?>
                        <input id="radioBtn" type="radio" name="gender" value='<?php echo $gioiTinh[$i] ?>' >
                        <?php echo $gioiTinh[$i] ?>
                    <?php
                    }
                    ?>
                </div>
            </div>

            <!-- fill in faculty info -->
            <div class="infoDiv">
                <label id="label" class="h-100">Phân khoa </label>
                <select id="input" class="h-100" name="faculty">
                    <?php foreach ($khoa  as $i) : ?>
                        <option><?php echo $i ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- fill the DOB -->
            <div class="infoDiv">
                <label id="label" class="h-100" for="birthday">Ngày sinh </label>
                <td height = '40px'>
                    <input type='date' id="input" class="h-100" name="date" data-date="" data-date-format="DD MMMM YYYY">
                </td>
                <script>
                    $(document).ready(function() {
                        $("#input").datepicker({
                            format: 'dd-mm-yyyy'    
                        });
                    });
                </script>
            </div>
            <div class="infoDiv">
                <label id="labelH" class="h-100" for="address">Địa Chỉ </label>
                <input id="input" class="h-100" type="text" name="address">
            </div>
            
            <!-- fil in image -->
            <div class="infoDiv">
                <label id="labelH" class="h-100">Hình ảnh </label>
                <input id="img" class="h-100" type="file" name="image">
            </div>

            <div id="btnDiv">
                <button class="btn btn-success" id="submitId" >Đăng ký</button>
            </div>
        </form>
    </div>
</body>
</html>