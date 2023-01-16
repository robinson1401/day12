<?php
$class = array(
    0 => 'Giáo viên',
    1 => 'Sinh viên'
);

// error from inputs
$errors = [];
if ($_SERVER['REQUEST_METHOD']=== 'POST') {

    if (empty(trim($_POST['name']))) {
        $errors['name']['required']='Hãy nhập họ và tên.';
    }
    else{
        if(strlen(trim($_POST['name'])) > 100 ){
            $errors['name']['min'] = 'Họ và tên nhỏ hơn 100 ký tự';
        }
    }

    if(empty($_POST['classification'])) {
        $errors['classification']['invaild']='Hãy nhập phân loại.';
    }

    if (empty($_POST['ID'])) {
        $errors['ID']['invaild']='Hãy nhập ID.';
    }

    $image=$_FILES['image'] ?? null;

    if (empty($_POST['description'])) {
        $errors['description']['invaild']='Hãy nhập mô tả chi tiết.';
    }

    $imgType = array('image/jpeg','image/png','image/avif','image/webp','image/apng','image/svg+xml');

    if(!in_array($image["type"],$imgType) and $image["name"]!=null) {
        $errors['type']['invaild']='Hãy chọn lại avatar!';
    }

    if(empty($errors)){
        if (!is_dir('web/avatar/')) {
            mkdir('web/avatar/');
        }

        // handle the image 
        if ($image["name"]!=null) {
            $currentDate=date("YmdHis");
            $nameArr=str_split($image["name"],strrpos($image["name"],"."));

            // add date and time to the image's name
            $image["name"]=$nameArr[0]."_".$currentDate.".".substr($nameArr[1],1);
            $imagePath = 'web/avatar/'.$image['name'];
            mkdir(dirname($_POST['image']));
            move_uploaded_file($image['tmp_name'],$imagePath);
        }
        
    
        session_start();
        $_SESSION['name'] = $_POST['name'];
        $_SESSION['classification'] = $_POST['classification'];
        $_SESSION['ID'] = $_POST['ID'];
        $_SESSION['description']=$_POST['description'];
        $_SESSION['image']=$imagePath;
        header('location:UpdateUserConfirmView.php');


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

<style>
    #backDiv {
    border-color    : #EBEBEB;
    background-color: #EBEBEB;
    border-width    : 1px;
    border-style    : solid;
    display         : flex;
    width           : 1200px;
    height          : 500px;
    margin-left     : auto;
    margin-right    : auto;
    margin-top      : 150px;
}

.title {
    width : 684px;
    height: 67px;

    font-family: 'Inter';
    font-style : normal;
    font-weight: 500;
    font-size  : 35px;
    line-height: 67px;
    margin-left: 80px;
    /* identical to box height */

    text-align: center;

    color: #000000;
}

.infoDiv {
    display    : flex;
    height     : 35px;
    margin-top : 15px;
    margin-left: 100px;
    width      : 100%;
    color      : #000000;
    font-size  : 18px;
}

.errors {
    margin-left: 220px;
}


.info {
    padding    : 5px;
    text-align : center;
    margin-left: 12%;
}

#btnDiv {
    height       : 35px;
    margin-top   : 35px;
    margin-bottom: 5%;
}

#label {
    width     : 120px;
    color     : black;
    padding   : 5px;
    text-align: center;
}

#labelH {
    width        : 120px;
    color        : black;
    padding      : 5px;
    text-align   : center;
    display      : inline-block;
    margin-bottom: 0.5rem;
    width        : 150px;
}

.fillLabel {
    width        : 120px;
    border       : 2px solid #41719C;
    color        : white;
    background   : #70ad47;
    padding      : 5px;
    text-align   : center;
    margin-bottom: 0px;
    block-size   : fit-content;
}

#input {
    border     : 2px solid #41719C;
    margin-left: 10%;
    width      : 55%;
}

#img {
    border     : 2px solid #fdfdfd;
    margin-left: 10%;
    width      : 55%;
}

#inputdate {
    border     : 2px solid #41719C;
    margin-left: 10%;
    width      : 55%;
}

#radioBtn {
    margin-left    : 15%;
    display        : flex;
    justify-content: center;
    align-items    : center;
}

#btnDiv {
    text-align: center;
}

#error {
    color: red;
}

.submitId {
    border-color: #41719C;
    border-width: 2px;
    border-style: solid;
}

.imgInfo {
    margin-left: 50px;

}

a {
    text-decoration: none;
    color          : #FFF;
}

.imgShow {
    margin-left: 10%;
}

#cfmBtn {
    text-align   : center;
    margin-top   : 60px;
    height       : 35px;
    margin-bottom: 5%;
}
</style>

<body>
    <div id='backDiv'>
        <form method="POST" style="position: center !important;
    width:80%;
    margin-left: 10%;
    margin-right: 10%;"  enctype="multipart/form-data">

            <!-- Title -->
            <div class="title">
                <p>Sửa thông tin người dùng</p>
            </div>
            <!-- fill the name info  -->
            <div class="infoDiv" class="required-field">
                <label id="label" class="h-100" for="name">Họ và tên </label>
                <input id="input" class="h-100" type="text" name="name" value="<?php echo(!empty($_POST['name']))?$_POST['name']:false;?>">
                
            </div>
            <div class="errors">
            <?php
                    echo(!empty($errors['name']['required']))?
                        '<label style="color: red;">' .$errors['name']['required']. '</label>':false; 
                    echo(!empty($errors['name']['min']))?
                        '<label style="color: red;">' .$errors['name']['min']. '</label>':false;
                ?>
            </div>
            <!-- choose classifications -->
            <div class="infoDiv">
                <label id="label" class="h-100" for="classification">Phân loại </label>
                <div id="radioBtn" >
                    <?php
                    for ($i = 0; $i < 2; $i++) {
                    ?>
                        <input id="radioBtn" type="radio" name="classification" value='<?php echo $class[$i] ?>' >
                        <?php echo $class[$i] ?>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="errors">
            <?php
                    echo(!empty($errors['classification']['invaild']))?
                        '<span style="color: red;">' .$errors['classification']['invaild']. '</span>':false; 
                ?>
            </div>
            <!-- fill the ID info  -->
            <div class="infoDiv" class="required-field">
                <label id="label" class="h-100" for="ID">ID </label>
                <input id="input" class="h-100" type="text" name="ID" value="<?php echo(!empty($_POST['ID']))?$_POST['ID']:false;?>" >
                
            </div>
            <div class="errors">
            <?php
                    echo(!empty($errors['ID']['invaild']))?
                        '<span style="color: red;">' .$errors['ID']['invaild']. '</span>':false; 
                ?>
            </div>
           
             <!-- fil in image -->
             <div class="infoDiv">
                <label id="label" class="h-100">Avatar </label>
                <input id="img" class="h-100" type="file" name="image" value="<?php echo(!empty($_POST['image']))?$_POST['image']:false;?>" >
                
            </div>
            <div class="errors">
            <?php
                    echo(!empty($errors['type']['invaild']))?
                        '<span style="color: red;">' .$errors['type']['invaild']. '</span>':false; 
                ?>
            </div>

            
            <div class="infoDiv">
                <label id="label" class="h-100" for="description">Mô tả chi tiết </label>
                <input id="input" class="h-100" type="text" name="description" value="<?php echo(!empty($_POST['description']))?$_POST['description']:false;?>">
            </div>
            <div class="errors">
            <?php
                    echo(!empty($errors['description']['invaild']))?
                        '<span style="color: red;">' .$errors['description']['invaild']. '</span>':false; 
                ?>
            </div>
            
           
            <div id="btnDiv">
                <button class="btn btn-success" id="submitId" >Xác nhận</button>
            </div>
        </form>
    </div>
</body>
</html>