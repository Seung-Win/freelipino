<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="./css/dashboard.css">

</head>

<body>
    <div class="sidebar" id="sidebar">
        <h2>Admin Menu</h2>
        <ul>
            <li><a href="#dashboard">Dashboard</a></li>
            <li><a href="#users">Users</a></li>
            <li><a href="#contracts">Contracts</a></li>
            <li><a href="#about">About Us</a></li>
        </ul>
    </div>
    <div class="main-content">
        <div class="top-bar">
            <div class="burger-icon" id="burger-icon">&#9776;</div>
            <div class="welcome-message">
                Welcome Admin! <span id="currentTime"></span>
            </div>
        </div>
        <div class="dashboard-container" id="dashboard">
            <h1>Admin Dashboard</h1>
            <div class="stats">
                <div class="stat">
                    <h2>Total Users</h2>
                    <?php
                    require '../config.php';
                    $sql = "SELECT COUNT(*) AS total_user FROM user_account ";
                    $result = $conn->query($sql);
                    if ($result) {
                        $row = $result->fetch_assoc();
                        $count = $row['total_user'];
                        echo '<p>' . $count . '</p>';
                    } else {
                        echo "Error: " . $conn->error;
                    }
                    ?>
                </div>
                <div class="stat">
                    <h2>Page Views</h2>
                    <p id="pageViews">0</p>
                </div>
            </div>
        </div>
        <div class="users-container" id="users">
            <h2>Users</h2>
            <ul id="userList">
            </ul>
        </div>
        <div class="contracts-container" id="contracts">
            <h2>Contracts</h2>
        </div>
        <div class="about-container" id="about">
            <h2>About Us</h2>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            fetch('/api/stats')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('userCount').textContent = data.userCount;
                    document.getElementById('pageViews').textContent = data.pageViews;

                    const userList = document.getElementById('userList');
                    data.users.forEach(user => {
                        const listItem = document.createElement('li');
                        listItem.textContent = user.username;
                        userList.appendChild(listItem);
                    });
                })
                .catch(error => console.error('Error fetching stats:', error));

            const burgerIcon = document.getElementById('burger-icon');
            const sidebar = document.getElementById('sidebar');

            burgerIcon.addEventListener('click', () => {
                sidebar.classList.toggle('hidden');
            });

            function updateTime() {
                const currentTime = new Date().toLocaleTimeString();
                document.getElementById('currentTime').textContent = currentTime;
            }

            updateTime();
            setInterval(updateTime, 1000);
        });
    </script>
</body>

</html>