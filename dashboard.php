<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<!DOCTYPE html>
<html>

<head>
    <title>Library Management Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f4f8;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 60%;
            margin: 100px auto;
            background: white;
            padding: 40px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            border-radius: 10px;
            text-align: center;
        }
        h1 {
            color: #333;
        }
        .menu {
            margin-top: 40px;
        }
        .menu a {
            display: inline-block;
            margin: 15px;
            padding: 15px 25px;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }
        .menu a:hover {
            background: #45a049;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Library Management System</h1>
        <p>Welcome to the Dashboard</p>

        <div class="menu">
            <a href="issue_book.php">Issue Book</a>
            <a href="return_book.php">Return Book</a>
            <a href="view_books.php">View All Books</a>
            <a href="add_books.php"  style=" background-color :blue; ">Add Books</a>

        </div>
    </div>
</body>
</html>
<?php include 'includes/footer.php'; ?>
