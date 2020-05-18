<?php 

date_default_timezone_set('Africa/Lagos');
require_once 'classControllers/init.php';
$intern = new Intern;
$lockForm = new LockRegForm();
$status = $lockForm->checkStatus();

if (isset($_POST['submit'])) {
    $res = '';
    $fullname = $database->escape_string($_POST['fullname']);
    $email = $database->escape_string($_POST['email']);
    $phoneNo = $database->escape_string($_POST['phoneNo']);
    $linkCV = "blank";
    $interest = $database->escape_string($_POST['interest']);
    $country = $database->escape_string($_POST["country"]);
    $location = $database->escape_string($_POST['location']);    
    $about = $database->escape_string($_POST['about']);
    $date = $database->escape_string($_POST['date']);

    $empStatus = $database->escape_string($_POST['empStatus']);
    $professionalStatus = $database->escape_string($_POST['professional_status']);
    $gender = $database->escape_string($_POST['gender']);
    $incomeAmount = $database->escape_string($_POST['income_amount']);

    

    $count = $intern->emailExists($email);

    if ($count === 0) {
        $res = $intern->internSignup();
        $request_mess = '<p style="text-align:center;">Application successful. Check your mail for registration message. Thank you!</a>';
    } else {
        $res = "Email has been use by another user";
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Join as an intern</title>
    <link rel="shortcut icon" href="https://res.cloudinary.com/dekillerj/image/upload/v1570648980/brand-logo.png" />

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css"
        integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/header-footer.css">
    <link rel="stylesheet" href="css/join-intern.css">
    <link rel="icon" type="img/png" href="images/hng-favicon.png">
    <script type="text/JavaScript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>

    <style>
        h2.heading {
            color: #084482;
            font-weight: bolder;
            margin-top: 50px;
        }

        p.para {
            width: 100%;
            text-align: center;
            margin-top: 20px;
            margin-bottom: 100px;
        }
    </style>
</head>

<body>
    <section class="navigation">
        <?php include 'fragments/site_header.php';?>
    </section>

    <section class="container-fluid1">
        <section class="jumbo">

            <h2 class="heading">Join as an Intern</h2>
            <p class="para">
                Complete the form below to begin your journey as an Intern.<br>
                <!-- To become a mentor <a href="mentor-registration">Click here</a> -->
            </p>
        </section>

        <div class="form-area">

            <?php
$errMsg = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
if (strpos($errMsg, 'join-intern.php?successful') !== false) {
    echo '<script type="text/javascript">
            sessionStorage.hng_ref = true
            window.location = "http://www.google.com/"
       </script>';
    // echo '<div style="margin:auto 30vw; background: green; padding: 5px 10px 5px 10px; width: 40vw !important; text-align: center; color: white; ">
    //     Your registration was  successful and an email has been sent to your mail. We will get back to you as soon as possible.
    // </div>';
}
$errMsg = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
if (strpos($errMsg, 'join-intern.php?failed') !== false) {
    echo '<div style="margin:auto 30vw; background: red; padding: 5px 10px 5px 10px; width: 40vw !important; text-align: center; color: white; ">
                Your registration failed because Email already exist.
            </div>';
}
?>

            <?php
if ($status !== 1) {
    ?>
            <form class="form-container" action="" method="post" id="myForm">

                <?php
if (!empty($request_mess)) {
    $_SESSION['FROM_INTERN_REGISTRATION'] = true;

        echo '<script type="text/javascript">
                    sessionStorage.hng_reg = true
                    window.location.assign("reg-successful")

               </script>';
        // echo "<center><h4 class='text-success text-center success' style='background: #D3ECDB; color: #2B5036; padding: 6px; width:66%;'>" . $request_mess . "</h4></center>";
    }
    if (!empty($res)) {
        echo "<h4 style='text-align:center; color: red;'>$res</h4>";
    }
    ?>
                <!-- Name, Email and phone number -->
                <input type="text" name="fullname" id="fullname" required placeholder="Full Name" />
                <input type="email" name="email" id="email" required placeholder="E-mail Address" />
                <input type="text" name="phoneNo" id="phoneNo" required placeholder="Phone Number" />

                <!-- Gender -->
                <select id="gender" name="gender" value="" class="gender" required>
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>

                <!-- Country -->
                <div class='text-danger' id="invalidCountry"></div>
                <input type="text" placeholder="Select Country" onchange="openState(event), validateCountry(event)"
                    list="country" name="country" id="countrySelect" required>
                <!-- Country Data list -->
                <datalist id="country" required>
                    <option value="">What country are you currently located?</option>
                    <!-- <option value="">Nigeria</option> -->
                    <!-- List is gotten from the api call -->
                </datalist>

                <!-- State, Optional -->
                <input type="text" style="display: none;" class="state" name="location" list="state"
                    placeholder="Select your current state" />

                <!-- State Data list -->
                <datalist id="state" required>
                    <!-- <option value="">What state are you currently located? </option> -->
                    <option value="FCT">FCT</option>
                    <option value="Abia">Abia</option>
                    <option value="Adamawa">Adamawa</option>
                    <option value="Akwa Ibom">Akwa Ibom</option>
                    <option value="Anambra">Anambra</option>
                    <option value="Bauchi">Bauchi</option>
                    <option value="Bayelsa">Bayelsa</option>
                    <option value="Benue">Benue</option>
                    <option value="Borno">Borno</option>
                    <option value="Cross River">Cross River</option>
                    <option value="Delta">Delta</option>
                    <option value="Ebonyi">Ebonyi</option>
                    <option value="Edo">Edo</option>
                    <option value="Ekiti">Ekiti</option>
                    <option value="Enugu">Enugu</option>
                    <option value="Gombe">Gombe</option>
                    <option value="Imo">Imo</option>
                    <option value="Jigawa">Jigawa</option>
                    <option value="Kaduna">Kaduna</option>
                    <option value="Kano">Kano</option>
                    <option value="Katsina">Katsina</option>
                    <option value="Kebbi">Kebbi</option>
                    <option value="Kogi">Kogi</option>
                    <option value="Kwara">Kwara</option>
                    <option value="Lagos">Lagos</option>
                    <option value="Nasarawa">Nasarawa</option>
                    <option value="Niger">Niger</option>
                    <option value="Ogun">Ogun</option>
                    <option value="Ondo">Ondo</option>
                    <option value="Osun">Osun</option>
                    <option value="Oyo">Oyo</option>
                    <option value="Borno">Borno</option>
                    <option value="Plateau">Plateau</option>
                    <option value="Rivers">Rivers</option>
                    <option value="Sokoto">Sokoto</option>
                    <option value="Taraba">Taraba</option>
                    <option value="Yobe">Yobe</option>
                    <option value="Zamfara">Zamfara</option>
                </datalist>

                <!-- Interest -->
                <select class="interest" value="" name="interest" aria-placeholder="What is your main interest?">
                    <option value="">Select Interested Track</option>
                    <option value="Backend">Backend</option>
                    <!-- <option value="Digital Marketing">Digital Marketing</option> -->
                    <option value="Frontend">Frontend</option>
                    <!-- <option value="Machine Learning">Machine Learning</option> -->
                    <option value="Mobile Development">Mobile Development</option>
                    <option value="UI/UX Design">UI/UX Design</option>
                </select>

                <!-- Professional Status -->
                <select name="professional_status" id="" value="">
                    <option value="new_bie">Select Professional Status on Interested Track</option>
                    <option value="new_bie">Beginner</option>
                    <option value="junior_dev">Junior Developer</option>
                    <option value="intermediate_dev">Intermediate Developer</option>
                    <option value="senior_dev">Senior Developer</option>
                </select>

                <!-- Employment Status -->
                <input type="text" list="empStatus" name="empStatus" placeholder="What is your Employment Status?">
                <datalist id="empStatus" class="empStatus" required>
                    <option value="Recently Employed (3 months or less)">Recently Employed (3 months or less)</option>
                    <option value="Employed">Employed</option>
                    <option value="Self-employed">Self-employed</option>
                    <option value="Freelance">Freelance</option>
                    <option value="Unemployed">Unemployed</option>
                    <option value="student">Student</option>
                </datalist>

                <!-- Current income Amount -->
                <select name="income_amount" id="" value="lt500">
                    <option value="">What is your income range from tech?</option>
                    <option value="lt30">Less than ₦30,000</option>
                    <option value="lt60">Between ₦30,000 to ₦60,000</option>
                    <option value="lt100">Between ₦60,001 to ₦100,000</option>
                    <option value="lt300">Between ₦100,001 to ₦300,000</option>
                    <option value="lt500">Between ₦300,001 to ₦500,000</option>
                    <option value="ab500">Above ₦500,001</option>
                </select>

                <!-- Brief Descriotion -->
                <textarea name="about" id="about" required cols="30" rows="10"
                    placeholder="Briefly tell us about yourself (not more than 100 words)"></textarea>
                <input type='hidden' name='date' id="date" value='<?=date('Y-m-d H:i:s');?>'>
                <p id="result"></p>

                <button type="submit" name="submit" value="Submit" class="submitBtn btn" id="submitBtn">
                    Submit
                </button>

            </form>
            <?php
} else {
    ?>
            <div style="width: 100%; margin: 0 auto; text-align: center; padding: 30px; color: #6F0503; ">
                <h1>Registration will commence soon! Check back.</h1>
            </div>
            <?php
}
?>


        </div>
        <?php include "fragments/site_footer.php";?>
    </section>
    <?php // include('fragments/chat.php'); ?>
</body>
<script>
    let countrySelect = document.querySelector("#country");
    let stateSelect = document.querySelector(".state");
    const url = 'https://restcountries.eu/rest/v2/all';
    let countries = []
    fetch(url).
        then(res => res.json())
        .then(data => {
            countries = data
            data.map(country => {
                if (country && country.name) {
                    const option_ = document.createElement("option")
                    const optionText = document.createTextNode(country.alpha3Code)
                    option_.appendChild(optionText)
                    option_.setAttribute("value", country.name)
                    countrySelect.append(option_)
                }
            })
            console.log(countrySelect)

        })

    function openState(e) {
        if (e.target.value === "Nigeria") {
            stateSelect.style.display = 'block';
            stateSelect.focus()
        } else {
            stateSelect.style.display = 'none'
            // set the state value to null if country is not Nigeria
            stateSelect.value = ''
        }
    }

    // validate country selected by the user; makes sure country is in the list; disables button if country is not in the list
    function validateCountry(e) {
        let invalidCountry = document.querySelector("#invalidCountry");
        let submitBtn = document.querySelector('#submitBtn');
        let valid = false;
        countries.map(country => {
            if (country.name === e.target.value) {
                valid = true;
            }
        })
        if (valid === false) {
            invalidCountry.style.display = 'block';
            invalidCountry.textContent = 'Please select a country from the list';
            countrySelect.value = '';
            submitBtn.disabled = true;
        } else {
            invalidCountry.style.display = 'none';
            invalidCountry.textContent = '';
            submitBtn.disabled = false;
        }
    }
</script>

</html>