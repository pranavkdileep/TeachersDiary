<?php
// session_start();
include("header.php");
include("../dboperation.php");
$obj = new dboperation();
?>

<div class="container-fluid">
    <div class="content text-center">
        <?php
        // Fetch the teacher's name based on their ID
        $sql1 = "SELECT * FROM tblteacher WHERE teacherid=" . $_SESSION["teacherid"];
        $res1 = $obj->executequery($sql1);
        while ($display1 = mysqli_fetch_array($res1)) {
            ?>
            <h1 class="welcome-message">Welcome <span class="highlight"><?php echo $display1["teachername"]; ?></span><span style="margin-left: 15px;">to</span> Your Teacher's Diary</h1>
            <p class="message">We hope you have a wonderful experience logging your teaching journey. Keep inspiring and shaping the Students!</p>
            <?php
        }
        ?>
    </div>
</div>

<?php
include("footer.php");
?>

<!-- Add the following CSS styles -->
<style>
    .content {
        margin-top: 50px;
    }

    .welcome-message {
        font-size: 2.5em;
        font-weight: bold;
        color: #2c3e50;
    }

    .highlight {
        color: #e74c3c; /* Highlight the teacher's name in a distinct color */
        font-style: italic;
    }

    .message {
        font-size: 1.2em;
        color: #34495e;
        margin-top: 20px;
    }

    .container-fluid {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 80vh; /* Ensure the content is vertically centered */
    }
</style>
