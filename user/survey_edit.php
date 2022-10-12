<?php 
session_start();
include("../header.php");
require "../controller.php";
require "../validate.php";
$validate = new Validator();
//Only teacher can add student
$validate->is_customer();
$id = isset($_GET['id']) ? htmlspecialchars($_GET['id'])  : '';
if ($id){
    $data = get_survey($id);
    if($_SESSION['role'] == 3 && $data['user_id']!==$_SESSION['uid']){
        echo "<center><br><h1>Access Denied</center></h1>";
            exit;
    }
}

if (!empty($_POST['edit'])){
    //validate form edit survey
    $errors = $validate->add_survey_form();
    // If don't have erro -> update  new survey
    if (!$errors){
        edit_survey($data['id'], $data['title'], $data['question'], $data['participants']);
        header("location: ./survey_list.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content=
        "width=device-width, initial-scale=1.0">
    <title>
        Customer Survey Online
    </title>
 
    <style>
 
        /* Styling the Body element i.e. Color,
        Font, Alignment */
        body {
            background-color: blue;
            font-family: Verdana;
            text-align: center;
        }
 
        /* Styling the Form (Color, Padding, Shadow) */
        form {
            background-color: #fff;
            max-width: 500px;
            margin: 50px auto;
            padding: 30px 20px;
            box-shadow: 2px 5px 10px rgba(0, 0, 0, 0.5);
        }
 
        /* Styling form-control Class */
        .form-control {
            text-align: left;
            margin-bottom: 25px;
        }
 
        /* Styling form-control Label */
        .form-control label {
            display: block;
            margin-bottom: 10px;
        }
 
        /* Styling form-control input,
        select, textarea */
        .form-control input,
        .form-control select,
        .form-control textarea {
            border: 1px solid #777;
            border-radius: 2px;
            font-family: inherit;
            padding: 10px;
            display: block;
            width: 95%;
        }
 
        /* Styling form-control Radio
        button and Checkbox */
        .form-control input[type="radio"],
        .form-control input[type="checkbox"] {
            display: inline-block;
            width: auto;
        }
 
        /* Styling Button */
        button {
            background-color: #05c46b;
            border: 1px solid #777;
            border-radius: 2px;
            font-family: inherit;
            font-size: 21px;
            display: block;
            width: 100%;
            margin-top: 50px;
            margin-bottom: 20px;
        }
    </style>
</head>
  
<body>
    <br>
    <h1>Create Your Survey</h1>
  
    <!-- Create Form -->
    <form id="form" action="./survey_edit.php" method="POST">
        <input name="id" type="hidden" value="<?php echo $data['id']; ?>" >
        <!-- Details -->
        <div class="form-control">
            <label for="name" id="label-name">
                Enter Your Title
            </label>
 
            <!-- Input Type Text -->
            <input type="text"
                   id="title" name="title"
                   placeholder="Enter Your Title" value="<?php echo $data['title'] ?>"/>
        </div>
  
  
        <div class="form-control">
            <label for="comment">
                Enter Your Question
            </label>
 
            <!-- multi-line text input control -->
            <textarea name="question"
                placeholder="Enter your question here" ><?php echo $data['question'] ?></textarea>
        </div>

        <div class="form-control">
            <label for="users">
                Enter Your Participants, separated from each other by commas.
            </label>
 
            <!-- multi-line text input control -->
            <textarea name="participants" id="users"
                placeholder="Enter your participants here" ><?php echo $data['participants'] ?></textarea>
        </div>
  
        <!-- Multi-line Text Input Control -->
        <button type="submit" name="edit" value="submit">
            Submit
        </button>
    </form>
</body>
  
</html>
<?php include('../footer.php');