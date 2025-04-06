<?php include 'config/db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Return Book</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
            padding: 50px;
        }
        .container {
            background-color: #ffffff;
            max-width: 400px;
            margin: auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #2196F3;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }
        input[type="text"],
        select,
        button {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #2196F3;
            color: white;
            font-weight: bold;
            cursor: pointer;
            margin-top: 20px;
        }
        button:hover {
            background-color: #1976D2;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>🔁 Return a Book</h2>
    <form method="post">
        <label for="student_id">Student ID</label>
        <input type="text" id="student_id" name="student_id" placeholder="Enter Student ID" required>
        <button type="submit" name="fetch_books">Fetch Issued Books</button>
    </form>
</div>

<?php
if (isset($_POST['fetch_books'])) {
    $student_id = $_POST['student_id'];

    $sql = "SELECT * FROM issued_books 
            INNER JOIN book ON issued_books.book_id = book.book_id 
            WHERE issued_books.student_id = '$student_id'";
    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res) > 0) {
        echo '
        <div class="container">
        <form method="post">
            <input type="hidden" name="student_id" value="' . $student_id . '">
            <label for="issue_id">Select Issued Book</label>
            <select name="issue_id" id="issue_id" required>';
        while ($row = mysqli_fetch_assoc($res)) {
            echo '<option value="' . $row['issue_id'] . '">' . $row['title'] . ' (Book ID: ' . $row['book_id'] . ', Return By: ' . $row['return_date'] . ')</option>';
        }
        echo '</select>
            <button type="submit" name="return_book">Return Book</button>
        </form>
        </div>';
    } else {
        echo '<div class="container"><p>No issued books found for this student.</p></div>';
    }
}

if (isset($_POST['return_book'])) {
    $issue_id = $_POST['issue_id'];

    $q = "SELECT issued_books.*, book.available 
          FROM issued_books 
          INNER JOIN book ON issued_books.book_id = book.book_id 
          WHERE issue_id = '$issue_id'";
    $res = mysqli_query($conn, $q);
    $row = mysqli_fetch_assoc($res);

    if ($row) {
        $book_id = $row['book_id'];
        $return_date = $row['return_date'];
        $today = date("Y-m-d");

        if ($today > $return_date) {
            echo '<div class="container"><p style="color:red;"> Return date exceeded. Please contact admin for fine clearance.</p></div>';
        } else {
            $delete = mysqli_query($conn, "DELETE FROM issued_books WHERE issue_id = '$issue_id'");
            $update = mysqli_query($conn, "UPDATE book SET available = available + 1 WHERE book_id = '$book_id'");

            if ($delete && $update) {
                echo '<div class="container"><p style="color:green;"> Book returned successfully!</p></div>';
            } else {
                echo '<div class="container"><p style="color:red;"> Something went wrong.</p></div>';
            }
        }
    } else {
        echo '<div class="container"><p style="color:red;">Invalid issue ID.</p></div>';
    }
}
?>

</body>
</html>
