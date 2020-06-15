<?php

$severname = "localhost";
$username = "root";
$password = "";
$database = "notes";
$insert = false;
$update = false;
$delete = false;

$conn = mysqli_connect($severname, $username, $password, $database);
if (!$conn) {
    die("Sorry we failed to connect : " . mysqli_connect_error());
}
if (isset($_GET['delete'])) {
    $sno = $_GET['delete'];
    $delete = true;
    $sql = "DELETE FROM `notes` WHERE `notes`.`sno` = $sno";
    $reult = mysqli_query($conn, $sql);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['snoedit'])) {
        $sno = $_POST['snoedit'];
        $title = $_POST['notet'];
        $desc = $_POST['desc'];
        $sql = " UPDATE `notes` SET `title` = '$title' ,
           `description` = '$desc' WHERE `notes`.`sno` = $sno";
        $reult = mysqli_query($conn, $sql);
        if ($reult) {
            $update = true;
        }
    } else {
        $title = $_POST['notet'];
        $desc = $_POST['desc'];
        $sql = "INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$desc')";
        $reult = mysqli_query($conn, $sql);
        if ($reult) {
            $insert = true;
        } else {
            mysqli_error($con);
            $insert = false;
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <title>iNotes-Notes Taking Made Easy</title>
</head>

<body>
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit This Note</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/Programs/MySQL_CRUD/index.php" method="post">

                        <input type="hidden" name="snoedit" id="snoedit">

                        <div class="form-group">
                            <label for="notet">Note Title</label>
                            <input type="text" class="form-control" id="notetedit" aria-describedby="emailHelp" name="notet">
                        </div>
                        <div class="form-group">
                            <label for="desc">Note Description</label>
                            <textarea class="form-control" id="descedit" name="desc" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Note</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#"><img src="/Programs/MySQL_CRUD/icon.png" height="28px" alt=""></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact Us</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <?php
    if ($insert) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Sucess!</strong> Your note has been submitted successfully.<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
    } elseif ($update) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Sucess!</strong> Your note has been updated successfully.<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
    } elseif ($update) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Sucess!</strong> Your note has been updated successfully.<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
    } elseif ($delete) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Sucess!</strong> Your note has been deleted successfully.<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
    }
    ?>

    <div class="container my-4">
        <h2>Add a Note to iNote</h2>
        <form action="/Programs/MySQL_CRUD/index.php" method="post">
            <div class="form-group">
                <label for="notet">Note Title</label>
                <input type="text" class="form-control" id="notet" aria-describedby="emailHelp" name="notet">
            </div>
            <div class="form-group">
                <label for="desc">Note Description</label>
                <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Note</button>
        </form>
    </div>

    <div class="container my-4">
        <table class="table " id="myTable">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `notes`";
                $reult = mysqli_query($conn, $sql);
                $sno = 0;
                while ($row = mysqli_fetch_assoc($reult)) {
                    $sno = $sno + 1;
                    echo "<tr>
                        <th scope='row'>" . $sno . "</th>
                        <td>" . $row['title'] . "</td>
                        <td>" . $row['description'] . "</td>
                        <td><button class='btn btn-sm btn-primary edit' id=" . $row['sno'] . ">Edit</button>  <button class='delete btn btn-sm btn-primary' id= d" . $row['sno'] . ">Delete</button></td>                    
                        </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <hr>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>

    <script>
        let edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                tr = e.target.parentNode.parentNode;
                let title = tr.getElementsByTagName('td')[0].innerText;
                let desc = tr.getElementsByTagName('td')[1].innerText;
                notetedit.value = title;
                descedit.value = desc;
                snoedit.value = e.target.id;
                $('#editModal').modal('toggle');
            })
        })

        let delets = document.getElementsByClassName('delete');
        Array.from(delets).forEach((element) => {
            element.addEventListener("click", (e) => {
                let sno = e.target.id.substr(1, );
                if (confirm("Are you sure to delete note?")) {
                    window.location = `/Programs/MySQL_CRUD/index.php?delete=${sno}`;
                }
            })
        })
    </script>
</body>

</html>