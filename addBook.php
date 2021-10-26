<?php
session_start();
if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !==true) {
    header("location:login.php");
    exit();
}
?>
<?php

require_once "config.php";

$authorid = $tittle =  $ISBN =$pub_year = $available = "";
$authorid_err = $tittle_err = $ISBN_err = $pub_year_err = $available_err ="";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate authorid
    $input_authorid = trim($_POST["authorid"]);
    if(empty($input_authorid)){
        $authorid_err = "Please enter a Author code.";
    }elseif (!filter_var($input_authorid,FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/^[0-9]+$/")))){
        $authorid_err = "Please enter a valid Author code.";
    }else{
        $authorid = $input_authorid;
    }

    //validate tittle
    $input_tittle=trim($_POST["tittle"]);
    if(empty($input_tittle)){
        $tittle_err="Please enter a tittle book.";
    }elseif (!filter_var($input_tittle,FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $tittle_err="Please enter a valid Reader name.";
    }else{
        $tittle = $input_tittle;
    }

    //validate ISBN
    $input_ISBN=trim($_POST["ISBN"]);
    if(empty($input_tittle)){
        $ISBN_err="Please enter a ISBN book.";
    }elseif (!filter_var($input_ISBN,FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $ISBN_err="Please enter a valid ISBN book.";
    }else{
        $ISBN = $input_ISBN;
    }

    // Validate Publishing year
    $input_pub_year = trim($_POST["PubYear"]);
    if(empty($input_pub_year)){
        $pub_year_err = "Please enter a publishing year.";
    }elseif (!filter_var($input_pub_year,FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/^[0-9]+$/")))){
        $pub_year_err = "Please enter a valid publishing year.";
    }else{
        $pub_year = $input_pub_year;
    }

    $input_available = trim($_POST["available"]);
    if(empty($input_available)){
        $available_err = "Please enter a available.";
    }elseif (!filter_var($input_available,FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/^[0-9]+$/")))){
        $available_err = "Please enter a valid available.";
    }else{
        $available = $input_available;
    }

    //check input errors before inserting in database
    if(empty($authorid_err) && empty($tittle_err) && empty($ISBN_err)
     && empty($pub_year_err) && empty($available_err)){
        
        $sql = "INSERT INTO books(authorid,tittle,ISBN,pub_year,available) value (?,?,?,?,?)";
        global $mysqli;
        if($stmt =$mysqli->prepare($sql)){
            
            $stmt->bind_param("sssss",$param_authorid,$param_tittle,$param_ISBN,$param_pub_year,$param_available);

            $param_authorid = $authorid;
            $param_tittle = $tittle;
            $param_ISBN = $ISBN;
            $param_pub_year = $pub_year;
            $param_available = $available;

            if($stmt->execute()){
                header("location: ManageBooks.php");
                exit();
            }else{
                echo "Oops! Something went wrong.Please try again later.";
            }
        }
        //close statement
        $stmt->close();
    }
    //close connection
    global $mysqli;
    $mysqli->close();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>

</head>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-ml-12">
                <h2 class="mt-5">New Book</h2>
                <p>Add new books, where books guide knowledge.</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                
                    <!-- author id -->
                    <div class="form-group">
                        <label for="#">Author Code</label>
                        <input type="text" name="authorid" class="form-control
                            <?php echo (!empty($authorid_err)) ? 'is-invalid' : '';?>" value="<?php echo $authorid;?>">
                        <span class="invalid-feedback"><?php echo $authorid_err;?></span>
                    </div>

                    <!-- Tittle -->
                    <div class="form-group">
                        <label for="#">Tittle Book</label>
                        <input name="tittle" class="form-control
                              <?php echo (!empty($tittle_err)) ? 'is-invalid' : '';?>" value="<?php echo $tittle;?>"></input>
                        <span class="invalid-feedback"><?php echo $tittle_err;?></span>
                    </div>

                    <!-- ISBN : mã sách tiêu chuẩn Quốc tế -->
                    <div class="form-group">
                        <label for="#">ISBN Book</label>
                        <input name="ISBN" class="form-control
                              <?php echo (!empty($ISBN_err)) ? 'is-invalid' : '';?>" value="<?php echo $ISBN;?>"></input>
                        <span class="invalid-feedback"><?php echo $ISBN_err;?></span>
                    </div>

                    <!-- năm xb -->
                    <div class="form-group">
                        <label for="#">Publishing year</label>
                        <input name="PubYear" class="form-control
                              <?php echo (!empty($pub_year_err)) ? 'is-invalid' : '';?>" value="<?php echo $pub_year;?>"></input>
                        <span class="invalid-feedback"><?php echo $pub_year_err;?></span>
                    </div>

                    <!-- có sẵn trong tv k -->
                    <div class="form-group">
                        <label for="#">Available</label>
                        <input type="text" name="available" class="form-control
                            <?php echo (!empty($available_err)) ? 'is-invalid' : '';?>" value="<?php echo $available;?>">
                        <span class="invalid-feedback"><?php echo $available_err;?></span>
                    </div>

                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a href="ManageBooks.php" class="btn btn-secondary m1-2">Cancel</a>
                </form>
            </div>
        </div>
    </div>

</div>
</body>
</html>
