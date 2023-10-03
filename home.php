<?php session_start();
if(! $_SESSION['user']){
    header('location:index.php') ;}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>جدول الطلاب</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        

    <style>
        body{background:whitesmoke ;font-size:25px }
        .mother{font-family: 'Noto Sans Arabic', sans-serif}
        main{float:left; border:3px solid black ;padding:5px} 
        input {padding:3px ;border:3px solid black;text-align:center; font-size:17px;x}
        aside{float:right  ;text-align:center;width:300px;border:1px solid black ;background:silver;font-size:20px ;}
        #tbl{width:1150px ;margin-left: auto;}
        #tbl th{color:black ;background:silver}
        #tbl tr{text-align:center ; }
        /* main #tbl tr:hover{background:silver ;font-size:26px} */
        button{width:70% ;font-size:20px ;color:white ;background:black ;margin:10px }
        button[name='del']:hover{color:red ;}
        button[name='add']:hover{color:green ;}

        .error{color: red; font-size: 15px;}
     

        </style>
</head>
<body dir='rtl'>

<?php 
include("con_db.php") ;
$res = mysqli_query($con, "SELECT * FROM student");



if(isset($_POST['add'])){
if(empty($_POST['name'])){
    $error_name="من فضلك ادخل اسم الطالب" ;
}else{
    if(empty($_POST['address'])){
        $error_address="من فضلك ادخل عنوان الطالب" ;
    }else{
        if(empty($_POST['phone'])){
            $error_phone=" ادخل رقم التلفون للتواصل ..يجب ان يكون اقل من 25" ;
        }else{
            if(empty($_POST['year'])){
                $error_year="من فضلك ادخل السنه الدراسيه الحاليه للطالب";
            }else{
                if(empty($_POST['class'])){
                    $error_class="من فضلك ادخل الفصل الدراسي";
                }else{
                $name=$_POST['name'] ;
                $address=$_POST['address'] ;
                $phone=$_POST['phone'] ;
                $year=$_POST['year'] ;
                $class=$_POST['class'] ;
                $insert=mysqli_query($con,"INSERT INTO student( name, address, phone, class, year)
                 VALUE('$name','$address','$phone','$class','$year')") ;

                 if($insert){
                    
                    echo"<script> confirm('تم اضافه الطالب بنجاح') </script>" ;
                    echo "<script>window.location.href = 'home.php';</script>";
                    exit;
                  
                   
                 }
                }
            }
        }
    }
}


}


if(isset($_POST['delete'])){
if(empty($_POST['id'])){$error_id="من فضلك ادخل رقم التسلسلي"; }else{ $id=$_POST['id'] ;
    $dele=mysqli_query($con,"DELETE FROM student WHERE id=$id") ;
    if($dele){ 
        // echo"<script> confirm('تم حزف الطالب بنجاح') </script>" ;
                    echo "<script>window.location.href = 'home.php';</script>";
                    exit;
                   }
}

}

if(isset($_POST['deleteall'])){

$deletall=mysqli_query($con,"DELETE FROM student") ;
if($deletall){
    // echo"<script> confirm('تم حزف جميع الطلاب بنجاح ') </script>" ;
    echo "<script>window.location.href = 'home.php';</script>";

    if(isset($_POST['start'])){$start=$_POST['start'] ;}else{$start=10000 ;}

    mysqli_query($con, "ALTER TABLE student AUTO_INCREMENT = $start");
   }
}

?>

<div class="mother">

<form method='POST'>
<div class="div">  
<aside>

<img src=" https://static.vecteezy.com/system/resources/previews/008/846/239/original/illustration-student-with-question-mark-png.png" alt='LOGO' width='100px' >
<h3><?php echo $_SESSION['user']['name'] ?></h3>
<p><?php echo $_SESSION['user']['email'] ?> </p>

<label> اسم الطالب</label><br>
<input type='text' name='name' placeholder='ادخل اسم الطالب' require 
value="<?php if(isset($_POST['name'])){echo $_POST['name'];} ?>"> <br>
<P class="error"><?php if(isset($error_name)){echo $error_name ;} ?></P>

<label> عنوان الطالب </label><br>
<input type ='text' name='address' id='address' placeholder='ادخل عنوان الطالب' require
value="<?php if(isset($_POST['address'])){echo $_POST['address'];} ?>"  > <br>
<P class="error"><?php if(isset($error_address)){echo $error_address ;} ?></P>

<label> رقم التلفون</label><br>
<input  type="text" name='phone' placeholder='ادخل رقم الطالب' require 
value="<?php if(isset($_POST['phone'])){echo $_POST['phone'];} ?>" > <br>
<P class="error"><?php if(isset($error_phone)){echo $error_phone ;} ?></P>

<label for="classs">الفصل الدراسي</label>
<br>
  <select name="class" id="classs" >
    <option value="الفصل الدراسي الأول" <?php if(isset($_POST['class']) && $_POST['class']=='الفصل الدراسي الأول'){echo "selected" ;} ?>>الفصل الدراسي الأول</option>
    <option value="الفصل الدراسي الثاني" <?php if(isset($_POST['class']) && $_POST['class']=='الفصل الدراسي الثاني'){echo "selected" ;} ?>>الفصل الدراسي الثاني</option>
   
  </select>
  <P class="error"><?php if(isset($error_class)){echo $error_class ;} ?></P>


<label for="years">العام الدراسي</label>
<br>
  <select name="year" id="years" >
    <option value="2023/2024" <?php if(isset($_POST['year']) && $_POST['year']=='2023/2024'){echo "selected" ;} ?>>2023/2024</option>
    <option value="2024/2025" <?php if(isset($_POST['year']) && $_POST['year']=='2024/2025'){echo "selected" ;} ?> >2024/2025</option>
    <option value="2026/2027" <?php if(isset($_POST['year']) && $_POST['year']=='2026/2027'){echo "selected" ;} ?>>2026/2027</option>
    <option value="2028/2029" <?php if(isset($_POST['year']) && $_POST['year']=='2028/2029'){echo "selected" ;} ?>>2028/2029</option>
    <option value="2030/2031" <?php if(isset($_POST['year']) && $_POST['year']=='2030/2031'){echo "selected" ;} ?>>2030/2031</option>

  </select>
  <P class="error"><?php if(isset($error_year)){echo $error_year;} ?></P>


<button name='add' type="submit"> اضافه طالب</button>
<p style="color: green;"><?php if(isset($done)){echo $done ;} ?></p>
<hr>
حزف طالب
<br>
<input type="number" name='id' placeholder="اكتب الرقم التسلسلي">
<button name='delete' onclick="return confirm('هل انت متاكد من عمليه الحزف')" type="submit"> حزف طالب</button>
<hr>
<input type="number" name="start" placeholder="اكتب بدايه التسلسل للطلاب">
<button name="deleteall" onclick="return confirm('هل انت متاكد من عمليه حزف الجميع')"> حزف جميع الطلاب </button>

<hr>
<a href="logout.php" onclick="return confirm('هل انت متاكد من عمليه تسجيل الخروج')" class="btn btn-primary mb-3 p-3 w-75"> LogOut</a>
<br>
<!-- contact Me -->

<div class="contact">
<span>
<p> Abdelrahman Ahmed</p>
<a href="https://wa.me/201013230248" target="_blank"><i class="fa-brands fa-whatsapp"></i></a>
<a href="https://www.facebook.com/abdelrahman.algeneral" target="_blank"><i class="fa-brands fa-facebook"></i></a>
<a href="https://github.com/Abdelrahman01013" target="_blank"><i class="fa-brands fa-github"></i></a>
<a href="mailto:generalal@gmail.com" target="_blank"><i class="fa-brands fa-google-plus"></i></a>
<a href="https://wa.me/201118003381" target="_blank"><i class="fa-brands fa-whatsapp"></i></a>
</span>
</div>


<!-- end contact me -->


<aside>

</div>

</form>



<!-- عرض البينات -->
<main> 

<table class="table table-hover" id='tbl'>
<tr>
<th scope="col"> الرقم التسلسلي</th>
<th scope="col"> اسم الطالب</th>
<th scope="col"> عنوان الطالب</th>
<th scope="col"> رقم التلفون</th>
<th scope="col"> السنه الدراسيه</th>
<th scope="col"> الفصل الدراسي</th>
<th scope="col"> التعديل</th>


<?php 

while( $row=mysqli_fetch_array($res)){

    echo"<tr>" ;
    echo "<td>"  .$row['id']  ."</td>" ;
    echo "<td>"  .$row['name']  ."</td>" ;
    echo "<td>"  .$row['address']  ."</td>" ;
    echo "<td>"  .$row['phone']  ."</td>" ;
    echo "<td>"  .$row['year']  ."</td>" ;
    echo "<td>"  .$row['class']  ."</td>" ;
    echo "<td><a href='update.php?id=". $row['id']. "'>تعديل</a></td>";
     
    echo "</tr> " ;

}



?>

</table>

</main>

</form>

</div>


<hr>
    
</body>
</html>












