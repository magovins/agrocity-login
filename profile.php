<?php
session_start();

// check user login
if(empty($_SESSION['user_id'])) {
    header("Location: index.php");
}

require_once(__DIR__.'/server/library.php');
$app = new Library();

$user_id = trim($_SESSION['user_id']);
$userProfile = $app->userDetails($_SESSION['user_id']); // USER PROFILE INFO
$userGrades = $app->getGrades($_SESSION['user_id']); // USER GRADES
$skillsList = $app->getSkills();

if (!empty($_POST['btnSaveGrade'])) {
    
    $skillsList = trim($_POST['skillsList']);
    $grade = trim($_POST['grade']);
    $week = trim($_POST['week']);
    
    if ($skillsList == "") {
        $login_error_message = 'Skill field is required!';
    } else if ($grade == "") {
        $login_error_message = 'Grade field is required!';
    } else if ($week == "") {
        $login_error_message = 'Week field is required!';
    } else {
        $app->saveGrade($user_id, $skillsList, $grade, $week);
        header("Refresh:0");
    }
} elseif (isset($_POST['skillAction'])) {
    $skillName = $_POST['skillName'];
    $skillWeek = $_POST['skillWeek'];
  if ($_POST['skillAction'] === 'delete') {
    $app->deleteGrade($user_id, $skillName, $skillWeek);
    header("Refresh:0");
  } else {
    // EDIT
    //$app->editGrade($user_id, $skillName, $skillWeek);
    var_dump($_POST);
  }

} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <!-- Latest compiled and minified CSS -->
    <link 
        rel="stylesheet" 
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" 
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" 
        crossorigin="anonymous" />
    <link 
        rel="stylesheet" 
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
</head>


<body>
    <div class="container">
        <div class="container mt-3">
            <h3>
                User data:
                <?php echo $userProfile->firstName.' ('.$userProfile->email.')' ?>
                <a href="server/logout.php" class="btn btn-primary">Logout</a>
            </h3>
            <br>
            
            <div class="row">
                
                <div class="col-4">
                    <div class="d-inline-flex">
                        <form action="profile.php" method="post">
                        
                        <div class="form-group">
                            <label for="">Choose skill:</label>
                            <input list="list" name="skillsList" class="form-control" required>
                            <datalist id="list">
                                <?php 
                                foreach ($skillsList as $skill) {
                                    echo <<<HTML
                                    <option value="{$skill->name}">
                                    HTML;
                                }                    
                                ?>
                            </datalist>
                        </div>

                        <div class="form-group">
                            <label for="">Insert grade: <i>(1-10)</i></label>
                            <input type="number" name="grade" class="form-control" min="1" max="10" required/>
                        </div>

                        <div class="form-group">
                            <label for="">Insert week: <i>(1-13)</i></label>
                            <input type="number" name="week" class="form-control" min="1" max="13" required/>
                        </div>

                        <div class="form-group">
                            <input type="submit" name="btnSaveGrade" class="btn btn-primary" value="Save"/>
                        </div>

                        </form>
                    </div>
                </div>

                <div class="col-8">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Skill</th>
                                <th scope="col">Grade</th>
                                <th scope="col">Week</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if (!empty($userGrades)) {
                                foreach ($userGrades as $item) {
                                    echo <<<HTML
                                    <tr>
                                        <form action="profile.php" method="post">
                                        <td>
                                            {$item->skill_name}
                                            <input type="hidden" name="skillName" value="{$item->skill_name}"/>
                                        </td>
                                        <td>{$item->grade}</td>
                                        <td>
                                            {$item->week}
                                            <input type="hidden" name="skillWeek" value="{$item->week}"/>
                                        </td>
                                        <td>
                                            <button type="submit" style="background:none;padding: 0px;border: none;" name="skillAction" value="delete">
                                                <i class="fa fa-trash fa-lg" style="color:#ea2938;"></i>
                                            </button>
                                        </td> 
                                        </form>
                                    </tr>
                                    HTML;
                                }                    
                            } else { 
                                echo <<<HTML
                                <tr>
                                <td> no grades </td>
                                </tr>
                                HTML;
                            }
                            ?>   
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</body>
</html>