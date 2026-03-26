<?php
//variables
$name = "";
$email = "";
$gender = "";
$website = "";
$phone = "";
$password = "";
$confirmPassword = "";

// error variables
$nameErr = "";
$emailErr = "";
$genderErr = "";
$websiteErr = "";
$phoneErr = "";
$passwordErr = "";
$confirmPasswordErr = "";
$termsErr = "";

// counter
$attemptCount = 0;

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // count submissions
    $attemptCount = (int)$_POST["attemptCount"] + 1;

    // check name
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["name"]);
    }

    // check email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    // check gender
    if (empty($_POST["gender"])) {
        $genderErr = "Gender is required";
    } else {
        $gender = test_input($_POST["gender"]);
    }

    // check website (optional but must be valid if filled)
    if (!empty($_POST["website"])) {
        $website = test_input($_POST["website"]);
        if (!filter_var($website, FILTER_VALIDATE_URL)) {
            $websiteErr = "Invalid URL format";
        }
    }

    // check password
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = $_POST["password"];
        if (strlen($password) < 8) {
            $passwordErr = "Password must be at least 8 characters";
        }
    }

    // check confirm password
    if (empty($_POST["confirmPassword"])) {
        $confirmPasswordErr = "Please confirm your password";
    } else {
        $confirmPassword = $_POST["confirmPassword"];
        if ($password != $confirmPassword) {
            $confirmPasswordErr = "Passwords do not match";
        }
    }

    // check terms
    if (!isset($_POST["terms"])) {
        $termsErr = "You must agree to the terms and conditions";
    }

    // check phone
    if (empty($_POST["phone"])) {
        $phoneErr = "Phone number is required";
    } else {
        $phone = test_input($_POST["phone"]);
        if (!preg_match("/^[+]?[0-9 \-]{7,15}$/", $phone)) {
            $phoneErr = "Invalid phone format";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>PHP Form Validation</title>
</head>
<body>

<h2>PHP Form Validation</h2>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

    Name: <input type="text" name="name" value="<?= $name ?>">
    <span style="color:red"><?= $nameErr ?></span>
    <br><br>

    Email: <input type="text" name="email" value="<?= $email ?>">
    <span style="color:red"><?= $emailErr ?></span>
    <br><br>

    Website: <input type="text" name="website" value="<?= $website ?>">
    <span style="color:red"><?= $websiteErr ?></span>
    <br><br>

    Phone: <input type="text" name="phone" value="<?= $phone ?>">
    <span style="color:red"><?= $phoneErr ?></span>
    <br><br>

    Gender:
    <input type="radio" name="gender" value="Female" <?php if($gender=="Female") echo "checked"; ?>> Female
    <input type="radio" name="gender" value="Male" <?php if($gender=="Male") echo "checked"; ?>> Male
    <input type="radio" name="gender" value="Other" <?php if($gender=="Other") echo "checked"; ?>> Other
    <span style="color:red"><?= $genderErr ?></span>
    <br><br>

    Password: <input type="password" name="password">
    <span style="color:red"><?= $passwordErr ?></span>
    <br><br>

    Confirm Password: <input type="password" name="confirmPassword">
    <span style="color:red"><?= $confirmPasswordErr ?></span>
    <br><br>

    <input type="checkbox" name="terms"> I agree to the Terms and Conditions
    <span style="color:red"><?= $termsErr ?></span>
    <br><br>

    <input type="hidden" name="attemptCount" value="<?= $attemptCount ?>">
    <p>Submission attempt: <?= $attemptCount ?></p>

    <input type="submit" value="Submit">

</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($nameErr) && empty($emailErr) && empty($genderErr) && empty($phoneErr) && empty($websiteErr) && empty($passwordErr) && empty($confirmPasswordErr) && empty($termsErr)) {
        echo "<h3>Your Input:</h3>";
        echo "Name: " . $name . "<br>";
        echo "Email: " . $email . "<br>";
        echo "Website: " . $website . "<br>";
        echo "Phone: " . $phone . "<br>";
        echo "Gender: " . $gender . "<br>";
    }
}
?>

</body>
</html>