<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>
<?php
include 'config/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Books</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="assets/js/script.js"></script>

    <style>
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        table {
            width: 100%;
        }

        th, td {
            padding: 10px;
            text-align: left;
            background-color: white;
            border: none;

        }

        input[type="text"], input[type="number"] {
            width: 95%;
            padding: 8px;
        }

        button {
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .message {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body class="bod">

    <h1 class="h">Add Books</h1>

    <form action="add_books.php" method="post" class="for">
        <table class="tab">
            <tr>
                <th>Book Name</th>
                <td><input type="text" id="name" name="name" placeholder="Enter Book Name" required></td>
            </tr>
            <tr>
                <th>Author Name</th>
                <td><input type="text" id="author" name="author" placeholder="Enter Author Name" required></td>
            </tr>
            <tr>
                <th>NOS</th>
                <td><input type="number" id="number" name="number" placeholder="Enter Number of Books" required></td>
            </tr>
        </table>

        <button type="submit" name="submit" onclick="showAlert()">Add Book</button>
    </form>

    <div class="message">
    <?php
    if(isset($_POST["submit"])){
        if($conn){
            $sql="SELECT * FROM book WHERE title='$_POST[name]' AND author='$_POST[author]'";
            $res=mysqli_query($conn,$sql);
            if($res){
                if(mysqli_num_rows($res) > 0){
                    $sql1="UPDATE book SET available=available+$_POST[number] WHERE title='$_POST[name]'";
                    $res1=mysqli_query($conn,$sql1);
                    if($res1){
                        echo "Book quantity updated successfully.";
                    } else {
                        echo "Failed to update book.";
                    }
                } else {
                    $sql2="INSERT INTO book(title, author, available) VALUES ('$_POST[name]','$_POST[author]','$_POST[number]')";
                    $res2=mysqli_query($conn,$sql2);
                    if($res2){
                        echo "Book added successfully.";
                    } else {
                        echo "Failed to add book.";
                    }
                }
            } else {
                echo "Error checking book.";
            }
        } else {
            echo "Database connection failed.";
        }
    }
    ?>
    </div>

</body>
</html>
<?php include 'includes/footer.php'; ?>