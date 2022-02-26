<!-- Basic Login Check -->
<!-- ------------------------------------------------------------------------------- -->
<?php
include "partials/_dbconnect.php";

session_start();

// If the user is not logged in he will be redirected to login page
if (!isset($_SESSION['isLoggedIn']))
{
    header("location: login.php");
    exit;
}

?>

<!-- To-Do List Main features - Insert|Update|Delete -->
<!-- ------------------------------------------------------------------------------- -->
<?php

// Setting initial values for insert, update & delete
$insert = false;
$update = false;
$delete = false;

// Die if connection was not successful
if (!$conn)
{
    die("Sorry we failed to connect: " . mysqli_connect_error());
}

if (isset($_GET['delete']))
{
    $sno = $_GET['delete'];
    $delete = true;
    $sql = "DELETE FROM `list` WHERE `sno` = $sno";
    $result = mysqli_query($conn, $sql);
}

// For Sending the data to database
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{

    // Check for updation of data
    if (isset($_POST['snoEdit']))
    {
        // Update the record
        $sno = $_POST['snoEdit'];
        $title = $_POST['titleEdit'];
        $description = $_POST['descriptionEdit'];

        // $sql = "UPDATE `notes` SET `title`='$title', `description`='$description' WHERE `notes`.`sno`=$sno";
        $sql = "UPDATE `list` SET `title` = '$title', `description` = '$description' WHERE `list`.`sno` = $sno;";
        $result = mysqli_query($conn, $sql);
        echo mysqli_error($conn);

        // Check for the record insertion success
        if ($result)
        {
            $update = true;
        }
        else
        {
            echo "The record was not updated successfully because of this error ---> " . mysqli_error($conn);
        }

    }
    else
    {
        // Add the note to database
        $title = $_POST['title'];
        $description = $_POST['description'];
        $user = $_SESSION["username"];

        $sql = "INSERT INTO `list` (`title`, `description`, `user`) VALUES ('$title', '$description', '$user')";
        $result = mysqli_query($conn, $sql);

        // Check for the record insertion success
        if ($result)
        {
            $insert = true;
        }
        else
        {
            echo "The record was not inserted successfully because of this error ---> " . mysqli_error($conn);
        }
    }

}

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Welcome</title>

    <style>
    html,
    body {
        max-width: 100%;
        /* overflow-x: hidden; */
    }

    .collapsible {
        background-color: #777;
        color: white;
        cursor: pointer;
        padding: 8px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 15px;
    }

    .active,
    .collapsible:hover {
        background-color: #555;
    }

    .content {
        padding: 0 18px;
        max-height: 0;
        width: 100%;
        overflow: hidden;
        transition: max-height 0.2s ease-out;
        background-color: #f1f1f1;
    }
    </style>

</head>

<body>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit this Note</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="/ellipsonic/index.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="snoEdit" id="snoEdit" class="visually-hidden">
                        <div class="form-group">
                            <label for="title">Note Title</label>
                            <input type="text" class="form-control" id="titleEdit" name="titleEdit"
                                aria-describedby="emailHelp">
                        </div>

                        <div class="form-group">
                            <label for="description">Note Description</label>
                            <textarea class="form-control" id="descriptionEdit" name="descriptionEdit"
                                rows="3"></textarea>

                        </div>
                    </div>
                    <div class="modal-footer d-block mr-auto">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Navbar -->
    <?php require 'partials/_nav.php' ?>

    <!-- Php code for notifications -->
    <?php
if ($insert)
{
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success !</strong> Your note is inserted successfully.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
}
if ($update)
{
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success !</strong> Your note has been updated successfully.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
}
if ($delete)
{
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success !</strong> Your note has been deleted successfully.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
}

?>

    <div class=" mx-5 my-4">
        <h3 class="font-monospace">Hello,
            <?php echo $_SESSION['username']; ?>!
        </h3>
        <hr />
    </div>

    <?php

if ($_SESSION["role"] == 1)
{

    echo '
        <div class="row">
        <!-- Div for adding a note -->
        <div class="col-6 mt-4 ">
            <div class="container ">
                <h4>Add a new task</h4>
                <form action="/ellipsonic/index.php?update=true" , method="POST" class="my-3">
                    <div class="mb-3">
                        <label for="title" class="form-label ">Task Title</label>
                        <input type="text" class="form-control" name="title" id="title" aria-describedby="emailHelp"
                            required>
                        <div class="mb-3">
                            <label for="description" class="form-label">Task description</label>
                            <textarea class="form-control" name="description" id="description" rows="3"
                                required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Add task</button>
                    </div>
                </form>
            </div>
        </div>';

    echo '
        <!-- Div for displaying the tasks -->
        <div class="col-6 mt-4">
            <div class="container">
                <h4 class="mb-4">List of Pending tasks : </h4>
                <table class="table table-light table-hover table-striped" id="mytable">
                    <thead>
                        <tr>
                            <th scope="col">Serial Number</th>
                            <th scope="col">Title</th>
                            <th scope="col">Description</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>';

    $user = $_SESSION["username"];

    $sql = "SELECT * FROM `list` WHERE `user`='$user'";
    $result = mysqli_query($conn, $sql);
    $sno = 0;
    while ($row = mysqli_fetch_assoc($result))
    {
        $sno += 1;
        echo "<tr>
                            <th scope='row'>$sno</th>
                            <td>" . $row['title'] . "</td>
                            <td>" . $row['description'] . "</td>
                            <td><button class='btn btn-sm btn-primary edit' id=" . $row['sno'] . ">Edit</button> <button class='btn btn-sm btn-primary delete' id=d" . $row['sno'] . ">Remove</button>
                        </tr>";
    }

    echo '
                    </tbody>
                </table>
            </div>
        </div>';

}
else
{

    echo "
            <div class='row mx-5 my-4'>
                <h4 class='col-10'>List of All users and thier Respective To-Do List saved :</h4>
                <input class='col-2'  id='myInput' type='text' placeholder='Search user..'>
            </div>";

    echo "<div id='myDIV' class='mx-5 my-4'>";
    $sql = "SELECT username FROM `users` WHERE role!='2'";
    $result = mysqli_query($conn, $sql);
    $sno = 0;

    // Users selected
    while ($row = mysqli_fetch_assoc($result))
    {

        $user = $row["username"];
        $sql2 = "SELECT list.title, list.description FROM list INNER JOIN users ON users.username=list.user WHERE username='$user'";
        $result2 = mysqli_query($conn, $sql2);
        $numExistRowlist = mysqli_num_rows($result2);

        echo "<div class='collapsible mb-2'> Username : " . $row["username"] . "</div>";

        echo '
                <div class="mb-2 content">';

        if ($numExistRowlist > 0)
        {
            echo '<p class="my-2">Below is list of all tasks of ' . $row["username"] . ':</p>';

            echo '
                    <table class="table table-light table-hover table-striped">
                        <thead>
                            <tr>
                                <td>Task Title</td>
                                <td>Task Description</td>
                            </tr>
                        </thead>
                        <tbody>';

            // List of specific users
            while ($row2 = mysqli_fetch_assoc($result2))
            {

                echo "
                            <tr>
                                <td>" . $row2['title'] . "</td>
                                <td>" . $row2['description'] . "</td>
                            </tr>";

            }

            echo "
                        </tbody>                   
                    </table>";
        }
        else
        {
            echo '<p class="my-2">Currently, the user ' . $row["username"] . ' is not having any saved to-do list tasks</p>';
        }

        echo "
                </div>";
    }

    echo "
            </div>";
}
?>

    </div>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#mytable').DataTable();
    });
    </script>

    <script>
    var coll = document.getElementsByClassName("collapsible");
    var i;

    for (i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            if (content.style.maxHeight) {
                content.style.maxHeight = null;
            } else {
                content.style.maxHeight = content.scrollHeight + "px";
            }
        });
    }
    </script>

    <script>
    edits = document.getElementsByClassName("edit");
    Array.from(edits).forEach((element) => {
        element.addEventListener("click", (e) => {
            console.log("edit ");
            tr = e.target.parentNode.parentNode;
            console.log(tr);
            title = tr.getElementsByTagName("td")[0].innerText;
            description = tr.getElementsByTagName("td")[1].innerText;
            console.log(title, description);
            titleEdit.value = title;
            snoEdit.value = e.target.id;
            console.log(e.target.id);
            descriptionEdit.value = description;
            $('#editModal').modal('toggle');

        })
    })

    deletes = document.getElementsByClassName("delete");
    Array.from(deletes).forEach((element) => {
        element.addEventListener("click", (e) => {
            // Because we have added d letter in id hence removing it :)
            sno = e.target.id.substr(1, );
            if (confirm("Are you sure you want to delete this task?")) {
                console.log("Yes");
                window.location = `/ellipsonic/index.php/?delete=${sno}`;
            } else {
                console.log("No");
            }

        })
    })
    </script>

    <script>
    $(document).ready(function() {
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myDIV *").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
    </script>

    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS 
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
        integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous">
    </script> -->

</body>

</html>