<?php
// Include config file
require_once 'config.php';

// Define variables and initialize with empty values
$name = $address = $salary  = $gender = $designation = "";
$name_err = $address_err = $salary_err = $gender_err = $designation_err = "";

// Processing form data when form is submitted
//if($_SERVER["REQUEST_METHOD"] == "POST"){
if(isset($_POST['submit'])){
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var(trim($_POST["name"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
        $name_err = 'Please enter a valid name.';
    } else{
        $name = $input_name;
    }

    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = 'Please enter an address.';
    } else{
        $address = $input_address;
    }

    // Validate salary
    $input_salary = trim($_POST["salary"]);
    if(empty($input_salary)){
        $salary_err = "Please enter the salary amount.";
    } elseif(!ctype_digit($input_salary)){
        $salary_err = 'Please enter a positive integer value.';
    } else{
        $salary = $input_salary;
    }
    // Validate gender
$input_gender = (isset($_POST["gender"]))? $_POST["gender"] : '';
if(empty($input_gender)){
  $gender_err = "Please fill gender";
} else{
  $gender = $input_gender;
}

  // Validate designation
  $input_designation = $_POST["designation"];
  if($input_designation == ''){
    $designation_err = "Please select designation";
  } else{
    $designation = $input_designation;
  }


    // Check input errors before inserting in database
    if(empty($name_err) && empty($address_err) && empty($salary_err) && empty($gender_err) && empty($designation_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO employees (name, address, salary, gender, designation) VALUES (:name, :address, :salary, :gender, :designation)";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':name', $param_name);
            $stmt->bindParam(':address', $param_address);
            $stmt->bindParam(':salary', $param_salary);
            $stmt->bindParam(':gender', $param_gender);
            $stmt->bindParam(':designation', $param_designation);

            // Set parameters
            $param_name = $name;
            $param_address = $address;
            $param_salary = $salary;
            $param_gender = $gender;
            $param_designation = $designation;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        unset($stmt);
    }

    // Close connection
    unset($pdo);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                            <label>Address</label>
                            <textarea name="address" class="form-control"><?php echo $address; ?></textarea>
                            <span class="help-block"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($salary_err)) ? 'has-error' : ''; ?>">
                            <label>Salary</label>
                            <input type="text" name="salary" class="form-control" value="<?php echo $salary; ?>">
                            <span class="help-block"><?php echo $salary_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($gender_err)) ? 'has-error' : ''; ?>">
                          Gender:
                                <input type="radio" name="gender" <?php if (isset($gender) && $gender=="female") echo "checked";?> value="female">Female
                                <input type="radio" name="gender" <?php if (isset($gender) && $gender=="male") echo "checked";?> value="male">Male
                                <input type="radio" name="gender" <?php if (isset($gender) && $gender=="other") echo "checked";?> value="other">Other
                                <span class="error">* <?php echo $gender_err;?></span>
                        </div>
          <div class="form-group <?php echo (!empty($designation_err)) ? 'has-error' : ''; ?>">
            <span>Please Select Designation</Span>
              <select name="designation" class="dropdown">
                <option value="">-select-</option>
                    <option  <?php if ( $designation=="Senior") ;?> value="Senior">Senior</option>
                    <option  <?php if ($designation=="Junior");?> value="Junior">Junior</option>
                    <option  <?php if ( $designation=="Intern");?> value="Intern">Intern</option>
                  </select>
                  <span class="error">* <?php echo $designation_err;?></span>
                  </div>
              </br></br>

              <div class="">

              </div>
                              <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
