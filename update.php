
<?php
session_start();

if (!isset($_SESSION['user'])) {
  header("location: index.php");
  exit;
}

include("con_db.php");
$id = $_GET['id'];
$select = mysqli_query($con, "SELECT * FROM student WHERE id = $id");
$student = mysqli_fetch_assoc($select);

if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $address = $_POST['title'];
  $phone = $_POST['phone'];
  $year = $_POST['year'];
  $class = $_POST['class'];
  $id = $_GET['id'];

  if(empty($name)){
    $error_name="من فضلك ادخل اسم الطالب" ;
  }elseif(strlen($name)>=255){$error_name="الأسم كبير جدا" ;
}else{
    if(empty($address)){
        $error_address="من فضلك ادخل عنوان الطالب" ;
      }elseif(strlen($address)>=255){ $error_address="العنوان كبير جدا" ;}
      else{
        if(empty($phone)){$error_phone="من فضلك ادخل رقم التلفون" ;
        }elseif(strlen($phone)>=25){$error_phone="يجب ان يكون رقم الهاتف اقل من 25" ;}
        else{
            $update = mysqli_query($con, "UPDATE student SET name = '$name', address = '$address', phone = '$phone', class = '$class', year = '$year' WHERE id = $id");

            if ($update) {
              header("location: home.php");
              exit;
            }

        }
      }
}

 
  


 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
<div class="container mt-5 border">
    <h1 class="text-center">
        التعديل على الطالب <?php echo $student['name'] ?>
    </h1>
    <form method="POST">
        <div class="form-group">
            <label for="exampleFormControlInput1">اسم الطالب</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" name="name" value="<?php echo $student['name'] ?>">
        <?php if(isset($error_name)){echo "<p class='text-danger'>" .$error_name ."</p>";} ?>
        </div>
        <br>
        <div class="form-group">
            <label for="exampleFormControlInput1">عنوان الطالب</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" name="title" value="<?php echo $student['address'] ?>">
            <?php if(isset($error_address)){echo "<p class='text-danger'>" .$error_address ."</p>";} ?>
        </div>
        <br>
        <div class="form-group">
            <label for="exampleFormControlInput1">رقم التلفون</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" name="phone" value="<?php echo $student['phone'] ?>">
            <?php if(isset($error_phone)){echo "<p class='text-danger'>" .$error_phone ."</p>";} ?>
        </div>
        <br>
        <div class="form-group">
            <label for="exampleFormControlSelect1">الفصل الدراسي</label>
            <select class="form-control" id="exampleFormControlSelect1" name="class">
                <option value="الفصل الدراسي الأول" <?php if ($student['class'] == 'الفصل الدراسي الأول') echo "selected"; ?>>الفصل الدراسي الأول</option>
                <option value="الفصل الدراسي الثاني" <?php if ($student['class'] == 'الفصل الدراسي الثاني') echo "selected"; ?>>الفصل الدراسي الثاني</option>
            </select>
        </div>
        <br>
        <div class="form-group">
            <label for="exampleFormControlSelect1">العام الدراسي</label>
            <select class="form-control" id="exampleFormControlSelect1" name="year">
            <option value="2023/2024" <?php if(isset($_POST['year']) && $_POST['year']=='2023/2024'){echo "selected" ;} ?>>2023/2024</option>
    <option value="2024/2025" <?php if($student['year'] =='2024/2025'){echo "selected" ;} ?> >2024/2025</option>
    <option value="2026/2027" <?php if($student['year'] =='2026/2027'){echo "selected" ;} ?>>2026/2027</option>
    <option value="2028/2029" <?php if($student['year'] =='2028/2029'){echo "selected" ;} ?>>2028/2029</option>
    <option value="2030/2031" <?php if($student['year'] =='2030/2031'){echo "selected" ;} ?>>2030/2031</option>

           
            </select>
        </div>
        <br>
        <!-- <div class="form-group">
            <label for="exampleFormControlInput1">السنة الدراسية</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" name="year" value="<?php echo $student['year'] ?>">
        </div> -->
        <br>
        <div class="text-center">
            <button type="submit" class="btn btn-primary" name="submit">تحديث</button>
        </div>
    </form>
</div>
</body>
</html>


