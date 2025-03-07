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
     <form action="registeraction.php" method="post">
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
                for ($i= 1; $i <=6; $i++) {
                    ?>
                <tr>
                    <td><?php echo $s++ ?></td>
                    
                    <td><input type="text" name="subject" placeholder="enter subject"></td>
                    <td><input type="text" placeholder="enter module" name="module"></td>
                    <td><input type="text" placeholder="enter topics" name="topic"></td>
                </tr>
                <?php
                }
                ?>
                <!-- Additional rows can be added here -->
            </tbody>
        </table><br>
    <button type="submit"  style="margin-left: 85%" name="save">SUBMIT</button>
            </form>
            </div>
</body>
</html>
<?php
include("footer.php");
?>
