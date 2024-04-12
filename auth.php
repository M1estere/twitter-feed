<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Auth</title>

    <link href="./css/style.css" rel="stylesheet">
    <link href="./css/output.css" rel="stylesheet">
</head>

<body>
    <?php
        require './server/users_processing.php';

        $error = '';

        if (isset($_POST['type'])) {
            $type = $_POST['type'];

            if ($type == 'login') {
                // обработка логина в систему
                if (isset($_POST['user_nickname']) && isset($_POST['user_password'])) {
                    $response = login($_POST['user_nickname'], $_POST['user_password']);
                    if ($response == -2) {
                        $error = 'User does not exist!';
                    } else if ($response == -1) {
                        $error = 'Wrond password';
                    } else if ($response == 0) {
                        session_start();

                        $_SESSION['user'] = user_exists($_POST['user_nickname']);
                        header('Location:./index.php');
                        $_POST = array();
                        die;
                    } else {
                        $error = 'Some error occured';
                    }
                }
            } else if ($type == 'reg') {
                // обработка регистрации в систему
                if (isset($_POST['user_nickname']) && isset($_POST['user_name']) && isset($_POST['user_password'])) {
                    $response = register($_POST['user_nickname'], $_POST['user_name'], $_POST['user_password']);
                    
                    if ($response == -2) {
                        $error = 'User already exists';
                    } else if ($response == -1) {
                        $error = 'Error adding a new user';
                    } else if ($response == 0) {
                        session_start();

                        $_SESSION['user'] = user_exists($_POST['user_nickname']);
                        header('Location:./index.php');
                        $_POST = array();
                        die;
                    } else {
                        $error = 'Some error occured';
                    }
                }
            }
        }        
    ?>

    <main>
        <section id="content" class="h-svh w-full flex flex-col justify-start">
            <div id="header" class="h-[25px] bg-blue-500 w-full">
            </div>

            <div class="flex-1 w-full h-full flex flex-col justify-center gap-y-[10px] items-center">
                <div>
                    <?php
                        echo "<span class='font-normal text-lg uppercase text-red-500'>{$error}</span>";
                    ?>
                </div>
                <div id="central-block">
                    <div class="flex flex-row justify-center items-center w-full h-fit gap-x-[20px]">
                        <span id="login-button" class='text-lg text-[var(--main-black)] font-bold uppercase border-[var(--main-black)] border-b-2 cursor-pointer'>Login</span>
                        <span id="reg-button" class='text-lg text-[var(--main-black)] font-bold uppercase border-[var(--main-black)] cursor-pointer'>Register</span>
                    </div>

                    <div id="login-form" class="size-full visible">
                        <form method="post" action="#" class="size-full flex flex-col justify-start items-center gap-y-[5px]">
                            <input type='text' name='type' value='login' hidden />

                            <input type='text' name='user_nickname' placeholder="Enter your nickname..." class="w-full h-[50px] p-[5px] font-normal text-lg rounded-[10px] focus:outline-none" required />
                            <input type='password' name='user_password' placeholder="Enter your password..." class="w-full h-[50px] p-[5px] font-normal text-lg rounded-[10px] focus:outline-none" required />
                        
                            <input class="bg-blue-500 rounded-[10px] h-[35px] w-full text-lg text-[var(--main-white)] font-normal uppercase cursor-pointer" type="submit" value="Login" />
                        </form>
                    </div>

                    <div id="reg-form" class="size-full hidden">
                        <form method="post" action="#" class="size-full flex flex-col justify-start items-center gap-y-[5px]">
                            <input type='text' name='type' value='reg' hidden />
                        
                            <input type='text' name='user_nickname' placeholder="Enter your nickname..." class="w-full h-[50px] p-[5px] font-normal text-lg rounded-[10px] focus:outline-none" required />
                            <input type='text' name='user_name' placeholder="Enter your name..." class="w-full h-[50px] p-[5px] font-normal text-lg rounded-[10px] focus:outline-none" required />
                            <input type='password' name='user_password' placeholder="Enter your password..." class="w-full h-[50px] p-[5px] font-normal text-lg rounded-[10px] focus:outline-none" required />
                        
                            <input class="bg-blue-500 rounded-[10px] h-[35px] w-full text-lg text-[var(--main-white)] font-normal uppercase cursor-pointer" type="submit" value="Register" />
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="./js/auth_form_changer.js"></script>
</body>
</html>