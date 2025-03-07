<?php
    include("header.php");
    include("../dboperation.php");
    $obj=new dboperation();
    $s=1;
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Styled Table</title>
    <link rel="stylesheet" href="styletable.css">
</head>
<body>
    <div class="container">
        <h1>Logbook</h1>
       <!-- Select today's date: <input type="date"><br><br> -->
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Hour</th>
                    <th>Subject</th>
                    <th>Module</th>
                    <th>Topics</th>
                </tr>
            </thead>
            <tbody>
            <?php    
            $sql ="select * from tbl_sub ";
                      $res=$obj->executequery ($sql);
                      while($display=mysqli_fetch_array($res)){
                       ?> 
                <tr>
                          <td><?php echo $s++?></td>
                          <td><?php echo $display["subject"]?></td>
                              <td><?php echo $display["module"]?></td>
                        <td><?php echo $display["topic"]?></td>
                </tr>
                </tr>
                        <?php
                      }
                      ?>
                      </tbody>
                </table>
    </div>
</body>
</html>
<?php
include("footer.php");
?>

