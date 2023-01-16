<?php

session_start();
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=test','root', ''); 
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if ($_SERVER['REQUEST_METHOD']=== 'POST') {
    
    $classification;
    if ($_SESSION['classification']=='Giáo viên') {
        $classification=0;
    } else {
        $classification=1;
    }

    $statement = $pdo-> prepare("INSERT INTO  student (name, classification,ID, avartar, description)
    VALUE (:name,:classification,:faculty,:birthday,:address,:avartar)");
    $statement ->bindValue(':name',$_SESSION['name']);
    $statement ->bindValue(':classification',$classification);
    $statement ->bindValue(':ID',$_SESSION['ID']);
    $statement ->bindValue(':avartar', $_SESSION['image']);
    $statement ->bindValue(':description',$description);
    header('Location: UpdateUserSuccessView.php');
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
        <form method="POST" enctype="multipart/form-data" style="position: center !important;
    width:80%;
    margin-left: 10%;
    margin-right: 10%;" >
            <!-- Title -->
            <div class="title">
                <p>Sửa thông tin người dùng</p>
            </div>
            <!-- fill the name info  -->
            <div class="infoDiv" class="required-field">
                <label class="label" class="h-100" for="name">Họ và tên </label>
                <div class="info">
                    <?php echo $_SESSION['name'] ?>
                </div>
            </div>

            <!-- choose classifications -->
            <div class="infoDiv">
                <label class="label" class="h-100" for="classification"> Phân loại </label>
                <div class="info">
                    <?php echo $_SESSION['classification'] ?>
                </div>    
            </div>

            <!-- fill in faculty info -->
            <div class="infoDiv">
                <label class="label" class="h-100">ID </label>
                <div class="info">
                    <?php echo $_SESSION['ID'] ?>
                </div> 
            </div>
            
            <div class="infoDiv">
                <label class="label" class="h-100" >Avatar </label>
                <img id="imgShow" src="<?php if($_SESSION['image']!='images/') {echo $_SESSION['image']; } ?>" class="thump-image" style="margin-left: 10%; height: 60px;">
            </div>

            <div class="infoDiv">
                <label class="label" class="h-100" for="description">Mô tả chi tiết </label>
                <div class="info">
                    <?php echo $_SESSION['description'] ?>
                </div> 
            </div>
 

            <div id="cfmBtn">
                <button type="submit" class="btn btn-success" class="submitId" ><a href="./UpdateUserView.php">Sửa lại</a></button>
                <button type="submit" class="btn btn-success" class="submitId" >Đăng ký</button>
            </div>
        </form>
    </div>

</body>

</html>