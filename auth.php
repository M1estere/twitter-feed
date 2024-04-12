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
        session_start();
        require './server/db_connection.php';
    ?>

    <?php
        require './server/auth.php';

        $error = '';

        if (isset($_GET['type'])) {
            $type = $_GET['type'];

            if ($type == 'login') {
                if (isset($_GET['user_nickname']) && isset($_GET['user_password'])) {
                    $response = login($_GET['user_nickname'], $_GET['user_password']);
                    if ($response == -2) {
                        $error = 'User does not exist!';
                    } else if ($response == -1) {
                        $error = 'Wrond password';
                    } else if ($response == 0) {
                        // header('Location:./index.php');
                    } else {
                        $error = 'Some error occured';
                    }
                }
            } else if ($type == 'reg') {
                if (isset($_GET['user_nickname']) && isset($_GET['user_name']) && isset($_GET['user_password'])) {
                    $response = register($_GET['user_nickname'], $_GET['user_name'], $_GET['user_password']);
                    
                    if ($response == -2) {
                        $error = 'User already exists';
                    } else if ($response == -1) {
                        $error = 'Error adding a new user';
                    } else if ($response == 0) {
                        // header('Location:./index.php');
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
                <div id="central-block" class="w-[350px] h-[500px] rounded-[15px] border-[1px] border-[var(--main-black)] shadow-lg px-[15px] py-[20px] flex flex-col gap-y-[30px]">
                    <div class="flex flex-row justify-center items-center w-full h-fit gap-x-[20px]">
                        <span id="login-button" class='text-lg text-[var(--main-black)] font-bold uppercase border-[var(--main-black)] border-b-2 cursor-pointer'>Login</span>
                        <span id="reg-button" class='text-lg text-[var(--main-black)] font-bold uppercase border-[var(--main-black)] cursor-pointer'>Register</span>
                    </div>

                    <div id="login-form" class="size-full visible">
                        <form method="get" action="#" class="size-full flex flex-col justify-start items-center gap-y-[5px]">
                            <input type='text' name='type' value='login' hidden />

                            <input type='text' name='user_nickname' placeholder="Enter your nickname..." class="w-full h-[50px] p-[5px] font-normal text-lg rounded-[10px] focus:outline-none" required />
                            <input type='password' name='user_password' placeholder="Enter your password..." class="w-full h-[50px] p-[5px] font-normal text-lg rounded-[10px] focus:outline-none" required />
                        
                            <input class="bg-blue-500 rounded-[10px] h-[35px] w-full text-lg text-[var(--main-white)] font-normal uppercase cursor-pointer" type="submit" value="Login" />
                        </form>
                    </div>

                    <div id="reg-form" class="size-full hidden">
                        <form method="get" action="#" class="size-full flex flex-col justify-start items-center gap-y-[5px]">
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