

<?php include 'includes/header.php'; ?>

<?php include 'includes/navbar.php'; ?>

<?php
include 'config/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Issue Book</title>
    <link rel="stylesheet" href="assets/css/styles.css">


</head>
<body>

<div class="container1">
    <h2>🔍 Book Search</h2>
    <form method="post" action="issue_book.php">
        <label for="name">Book Name</label>
        <input type="text" id="name" name="name" placeholder="Enter Book Name to Search" required>
        <button type="submit" name="submit">Search</button>
    </form>
</div>

<?php
if (isset($_POST["submit"])) {
    if ($conn) {
        $sql = "SELECT * FROM book WHERE title='" . $_POST['name'] . "'";
        $res = mysqli_query($conn, $sql);
        if ($res) {
            if (mysqli_num_rows($res) > 0) {
                if (mysqli_num_rows($res) > 0) {
                    echo "<div class='container1'>";
                    echo "<h2>Book(s) Found</h2>";
                    echo "<table class='book-table'>";
                    echo "<tr><th>Book ID</th><th>Title</th><th>Author</th><th>Available</th></tr>";
                    while ($row = mysqli_fetch_assoc($res)) {
                        $num = $row['available'];
                        echo "<tr>";
                        echo "<td>" . $row['book_id'] . "</td>";
                        echo "<td>" . $row['title'] . "</td>";
                        echo "<td>" . $row['author'] . "</td>";
                        echo "<td>" . $row['available'] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "</div>";
                }
                
            } else {
                echo "<div class='container1'><h2>No Book Found</h2></div>";
            }
        } else {
            echo "<div class='container1'><h2>Error in Query</h2></div>";
        }
    } else {
        echo "<div class='container1'><h2>Connection Failed</h2></div>";
    }
}
?>

<div class="container1">
    <h2>📚 Issue a Book</h2>
    <form method="post" action="issue_book.php">
        <label for="id">Book ID</label>
        <input type="number" id="id" name="id" placeholder="Enter Book ID" required>

        <label for="sid">Student ID</label>
        <input type="text" id="sid" name="sid" placeholder="Enter Student ID" required>

        <label for="name">Student Name</label>
        <input type="text" id="name" name="name" placeholder="Enter Student Name" required>

        <label for="date">Return Date</label>
        <input type="date" id="date" name="date" required>

        <button type="submit" name="submit1">Issue Book</button>
    </form>
</div>

<?php
$da = date("Y-m-d");

if(isset($_POST["submit1"])) {
    if ($conn) {
        // First, get current availability
        $book_id = $_POST['id'];
        $check_sql = "SELECT available FROM book WHERE book_id='$book_id'";
        $check_res = mysqli_query($conn, $check_sql);
        $row = mysqli_fetch_assoc($check_res);
        $num = $row['available'];

        if ($num > 0) {
            $sql = "INSERT INTO issued_books(book_id, student_id, student_name, issue_date, return_date) 
            VALUES ('$_POST[id]', '$_POST[sid]', '$_POST[name]', '$da', '$_POST[date]')";

            $res = mysqli_query($conn, $sql);

            if ($res) {
                echo "<div class='message'>Book Issued Successfully</div>";
                $sql1 = "UPDATE book SET available=available-1 WHERE book_id='$_POST[id]'";
                $res1 = mysqli_query($conn, $sql1);
                if ($res1) {
                    echo "<div class='message'>Stock Updated</div>";
                }

                // Show updated table
                $title_sql = "SELECT * FROM book WHERE book_id='$book_id'";
                $title_res = mysqli_query($conn, $title_sql);
                if (mysqli_num_rows($title_res) > 0) {
                    echo "<div class='container1'>";
                    echo "<h2>Book Issued Details</h2>";
                    echo "<table class='book-table'>";
                    echo "<tr><th>Book ID</th><th>Title</th><th>Author</th><th>Available</th></tr>";
                    while ($row = mysqli_fetch_assoc($title_res)) {
                        echo "<tr>";
                        echo "<td>" . $row['book_id'] . "</td>";
                        echo "<td>" . $row['title'] . "</td>";
                        echo "<td>" . $row['author'] . "</td>";
                        echo "<td>" . $row['available'] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "</div>";
                }
            }
        } else {
            echo "<div class='message' style='color:red;'>No books left to issue</div>";
        }
    } else {
        echo "<div class='message' style='color:red;'>Database connection error</div>";
    }
}

?>
</body>
</html>
<?php include 'includes/footer.php'; ?>
