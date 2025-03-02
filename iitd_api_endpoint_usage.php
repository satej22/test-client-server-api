<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userid = $_POST["userid"];
    $password = $_POST["password"];

    $api_url = "http://testing-api-main.great-site.net/iitd_api_endpoint.php/?userid=" . urlencode($userid) . "&pass=" . urlencode($password);

    $response = file_get_contents($api_url);
    $data = json_decode($response, true);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            text-align: center;
        }
        form {
            margin-bottom: 20px;
        }
        table {
            width: 50%;
            margin: 0 auto;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>

    <h2>Login Form</h2>
    <form method="post">
        <label>User ID:</label>
        <input type="text" name="userid" required>
        <br><br>
        <label>Password:</label>
        <input type="password" name="password" required>
        <br><br>
        <button type="submit">Login</button>
    </form>

    <?php if (isset($data)) { ?>
        <h3>Result:</h3>
        <?php if (isset($data["error"])) { ?>
            <p style="color: red;"><?php echo $data["error"]; ?></p>
        <?php } else { ?>
            <table>
                <tr>
                    <th>User ID</th>
                    <th>Password Hash</th>
                    <th>Role</th>
                </tr>
                <?php foreach ($data as $user) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user["userid"]); ?></td>
                        <td><?php echo htmlspecialchars($user["password_hash"]); ?></td>
                        <td><?php echo htmlspecialchars($user["role"]); ?></td>
                    </tr>
                <?php } ?>
            </table>
        <?php } ?>
    <?php } ?>

</body>
</html>
