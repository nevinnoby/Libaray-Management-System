<?php
include 'config/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Books & Issued Details</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 30px;
            background-color: #f4f4f4;
        }
        h2 {
            text-align: center;
            margin-top: 40px;
            color: #4CAF50;
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: white;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #e0e0e0;
        }
        p {
            text-align: center;
        }
    </style>
</head>
<body>

<h2>📚 All Book Inventory</h2>

<?php
$sql = "SELECT b.book_id, b.title, b.author, b.available,
               (SELECT COUNT(*) FROM issued_books i WHERE i.book_id = b.book_id) AS issued
        FROM book b";

$res = mysqli_query($conn, $sql);

if ($res && mysqli_num_rows($res) > 0) {
    echo "<table>
            <tr>
                <th>Book ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Available</th>
                <th>Issued</th>
            </tr>";

    while ($row = mysqli_fetch_assoc($res)) {
        echo "<tr>
                <td>{$row['book_id']}</td>
                <td>{$row['title']}</td>
                <td>{$row['author']}</td>
                <td>{$row['available']}</td>
                <td>{$row['issued']}</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "<p>No books found in the database.</p>";
}
?>

<h2>📋 All Issued Book Details</h2>

<?php
$sql_issued = "SELECT i.student_id, i.student_name, i.book_id, b.title, i.issue_date, i.return_date
               FROM issued_books i
               JOIN book b ON i.book_id = b.book_id";

$res_issued = mysqli_query($conn, $sql_issued);

if ($res_issued && mysqli_num_rows($res_issued) > 0) {
    echo "<table>
            <tr>
                <th>Student ID</th>
                <th>Student Name</th>
                <th>Book ID</th>
                <th>Book Title</th>
                <th>Issued Date</th>
                <th>Return Date</th>
            </tr>";

    while ($row = mysqli_fetch_assoc($res_issued)) {
        echo "<tr>
                <td>{$row['student_id']}</td>
                <td>{$row['student_name']}</td>
                <td>{$row['book_id']}</td>
                <td>{$row['title']}</td>
                <td>{$row['issue_date']}</td>
                <td>{$row['return_date']}</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "<p>No books issued yet.</p>";
}
?>

<h2>⏰ Students with Due Books (Past Return Date)</h2>

<?php
$today = date("Y-m-d");

$sql_due = "SELECT i.student_id, i.student_name, b.title, i.return_date
            FROM issued_books i
            JOIN book b ON i.book_id = b.book_id
            WHERE i.return_date < '$today'";

$res_due = mysqli_query($conn, $sql_due);

if ($res_due && mysqli_num_rows($res_due) > 0) {
    echo "<table>
            <tr>
                <th>Student ID</th>
                <th>Student Name</th>
                <th>Book Title</th>
                <th>Return Date</th>
            </tr>";

    while ($row = mysqli_fetch_assoc($res_due)) {
        echo "<tr>
                <td>{$row['student_id']}</td>
                <td>{$row['student_name']}</td>
                <td>{$row['title']}</td>
                <td>{$row['return_date']}</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "<p>No due books found 🎉</p>";
}
?>

</body>
</html>
