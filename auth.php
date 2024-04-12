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

        require './server/get_posts.php';
    ?>

    <main>
        <section id="content" class="h-svh w-full flex flex-col justify-start">
            <div id="header" class="h-[25px] bg-blue-500 w-full">
            </div>

            <div class="flex-1 w-full h-full flex justify-center items-center">
                <div id="central-block" class="w-[500px] h-[650px] rounded-[15px] border-[1px] border-[var(--main-black)] shadow-lg px-[15px] py-[20px] flex flex-col gap-y-[30px]">
                    <div class="flex flex-row justify-center items-center w-full h-fit gap-x-[20px]">
                        <span id="login-button" class='text-lg text-[var(--main-black)] font-bold uppercase border-[var(--main-black)] border-b-2 cursor-pointer'>Login</span>
                        <span id="reg-button" class='text-lg text-[var(--main-black)] font-bold uppercase border-[var(--main-black)] cursor-pointer'>Register</span>
                    </div>

                    <div id="login-form" class="size-full visible">
                        <form method="get" action="./index.php" class="size-full flex flex-col justify-start items-center gap-y-[5px]">
                            <input type='text' name='user_nickname' placeholder="Enter your nickname..." class="w-full h-[50px] p-[5px] font-normal text-lg rounded-[10px] focus:outline-none" />
                            <input type='password' name='user_password' placeholder="Enter your password..." class="w-full h-[50px] p-[5px] font-normal text-lg rounded-[10px] focus:outline-none" />
                        
                            <input class="bg-blue-500 rounded-[10px] h-[35px] w-full text-lg text-[var(--main-white)] font-normal uppercase cursor-pointer" type="submit" value="Login" />
                        </form>
                    </div>

                    <div id="reg-form" class="size-full hidden">
                        <form method="get" action="./index.php" class="size-full flex flex-col justify-start items-center gap-y-[5px]">
                            <input type='text' name='user_nickname' placeholder="Enter your nickname..." class="w-full h-[50px] p-[5px] font-normal text-lg rounded-[10px] focus:outline-none" />
                            <input type='text' name='user_name' placeholder="Enter your name..." class="w-full h-[50px] p-[5px] font-normal text-lg rounded-[10px] focus:outline-none" />
                            <input type='password' name='user_password' placeholder="Enter your password..." class="w-full h-[50px] p-[5px] font-normal text-lg rounded-[10px] focus:outline-none" />
                        
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