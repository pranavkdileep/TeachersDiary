<?php
include_once("../dboperation.php");
$obj=new dboperation();
$id=$_GET['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Program Edit</h2>
        <form action="semestereditaction.php" method="post">
        <?php
            
            $sql="select*from tblsemester where semesterid=$id";
            $res=$obj->executequery($sql);
            $dis=mysqli_fetch_array($res);
            
            $sql1="SELECT * From tblcourse";
            $res1=$obj->executequery($sql1);
            ?>
            Semester:<input type="text" name="txtsemestername" value="<?php echo $dis["semestername"]?>" placeholder="enter semester">
            <input type="hidden" value="<?php echo $id?>"class="form-control" name="id">
          

            Program:<select name="ddlcoursename" class="form-control" disabled="disabled" >
                <option>-----select-----</option>
                    <?php
                    while($display=mysqli_fetch_array($res1))
                    {
                      ?>
                      <option value="<?php echo $display["courseid"];?>" <?php echo ($display["courseid"]== $dis["courseid"])?"selected=selected":"";?>>
                      <?php echo $display["coursename"];?>
                    </option>
                    <?php
                    }
                 ?>
                   </select>
                    <br>
            <input type="submit" value="Update" name="save">
        </form>
    </div>
</body>
</html>
