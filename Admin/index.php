<?php
include("header.php");
include("../dboperation.php");
$obj = new dboperation();
?>

    <!-- <section class="main-content">
        <h2>Recent Activity</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla euismod velit eu felis consectetur, eu ultricies justo malesuada.</p>
    </section> -->
    <div class="container-fluid">
    <div class="content text-center">
    <?php
        // Fetch the teacher's name based on their ID
        $sql1 = "SELECT * FROM login_tbl WHERE id=" . $_SESSION["aid"];
        $res1 = $obj->executequery($sql1);
        while ($display1 = mysqli_fetch_array($res1)) {
            ?>
            <h1 class="welcome-message">Welcome <span class="highlight"><?php echo $display1["username"]; ?></span><span style="margin-left: 15px;">to</span> Your Home Page</h1>
            <!-- <p class="message">We hope you have a wonderful experience logging your teaching journey. Keep inspiring and shaping the Students!</p> -->
            <?php
        }
        ?>
        </div>
        </div>
    <?php
    include("footer.php");
    ?>
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
   
