<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #333;
        }

        .modal-content {
            background-color: #222;
            color: #fff;
            border: 1px solid #444;
        }

        .input-field input {
            background-color: #333;
            color: #ccc;
            border-color: #555;
        }

        .input-field input:focus {
            border-color: #777;
            outline: none;
        }
    </style>
</head>

<body class="flex justify-center items-center h-screen">
    <div class="modal-content p-8 rounded-lg w-96">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="space-y-4">
            <h1 class="text-lg font-bold text-center mb-4">Login</h1>
            <?php
                session_start();
                $errorMessage = '';
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $servername = "localhost";
                    $username = "kobe";
                    $password = "denshi";
                    $dbname = "prosite";
                    $input_username = $_POST["username"];
                    $input_password = $_POST["password"];

                    try {
                        $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $stmt = $conn->prepare("SELECT * FROM users WHERE user_name = :username AND user_pass = :password");
                        $stmt->bindParam(':username', $input_username);
                        $stmt->bindParam(':password', $input_password);
                        $stmt->execute();
                        $result = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($result) {
                            $_SESSION["username"] = $input_username;
                            echo "<script>window.location.href='../question/questionHome.php';</script>";
                            exit();
                        } else {
                            $errorMessage = 'ユーザー名またはパスワードが違います';
                        }
                    } catch (PDOException $e) {
                        $errorMessage = "エラー: " . $e->getMessage();
                    }
                }
            ?>
            <?php if ($errorMessage): ?>
                <p class="text-red-500 text-xs italic"><?php echo $errorMessage; ?></p>
            <?php endif; ?>
            <div class="input-field">
                <input type="text" id="username" name="username" placeholder="ユーザー名" required class="mt-1 block w-full px-3 py-2 rounded-md">
            </div>
            <div class="input-field">
                <input type="password" id="password" name="password" placeholder="パスワード" required class="mt-1 block w-full px-3 py-2 rounded-md">
            </div>
            <button type="submit" class="bg-red-600 hover:bg-red-800 text-white font-bold py-2 px-4 w-full rounded focus:outline-none focus:shadow-outline">ログイン</button>
            <p class="text-xs text-gray-400 mt-3">初めてご利用ですか？ <a href="signup.php" class="text-red-500 hover:text-red-700">新規登録はこちら</a></p>
        </form>
    </div>

    <!-- JavaScript for Modal, etc -->
    <script>
        // Add necessary JavaScript if needed
    </script>
</body>

</html>
