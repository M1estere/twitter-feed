<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Feed</title>

    <link href="./css/style.css" rel="stylesheet">
    <link href="./css/output.css" rel="stylesheet">
</head>

<body>
    <?php
        session_start();
        require './server/db_connection.php';

        if (isset($_SESSION['user']) == false) {
            header('Location:./auth.php');
            die;
        }
    ?>

    <?php
        require './server/posts_processing.php';
        require './server/comments_processing.php';
        require './server/likes_processing.php';

        // функция для обработки нового поста
        function handle_new_post() {
            if (isset($_GET['content_text'])) {
                $text = $_GET['content_text'];

                $response = add_post($_SESSION['user']['user_id'], $text);
                if ($response == -1) {
                    echo 'Something went wrong (posts)';
                } else if ($response == 0) {
                    echo 'Post added!';
                } else {
                    echo 'Some error occured';
                }
            }
        }

        // функция для обработки нового комментария
        function handle_new_comment() {
            if (isset($_GET['content-text']) && isset($_GET['post_id'])) {
                $text = $_GET['content-text'];
                $post_id = $_GET['post_id'];

                $response = add_comment($_SESSION['user']['user_id'], $post_id, $text);
                if ($response == -1) {
                    echo 'Something went wrong (comments)';
                } else if ($response == 0) {
                    echo 'Comment added!';
                } else {
                    echo 'Some error occured';
                }
            }
        }

        // функция для обработки нового лайка
        function handle_new_like() {
            if (isset($_GET['post_id'])) {
                $post_id = $_GET['post_id'];

                $response = toggle_like($_SESSION['user']['user_id'], $post_id);
                if ($response == -1) {
                    echo 'Something went wrong (likes)';
                } else if ($response == 0) {
                    echo 'Like added!';
                } else if ($response == 1) {
                    echo 'Like removed!';
                } else {
                    echo 'Some error occured';
                }
            }
        }
    ?>

    <?php
        if (isset($_GET['type'])) {
            $type = $_GET['type'];

            if ($type == 'add_post') {
                handle_new_post();
            } else if ($type == 'add_comment') {
                handle_new_comment();
            } else if ($type == 'add_like') {
                handle_new_like();
            }
        }
    ?>

    <header id="header" class="header">
    </header>

    <main>
        <section id="top">
            <div class="top-bar">
                <span class="h1-text">Welcome</span>
                <span class="grey-h2-text">
                    <?php
                        require './server/sort.php';

                        $posts = sort_by_date(get_posts());
                        echo sizeof($posts).' feeds';
                    ?>
                </span>
            </div>
        </section>

        <section id="content" class="mt-[25px]">
            <div class="wrapper">
                <div id="feed">
                    <div id="new-post">
                        <span class='text-lg text-[var(--main-black)] font-bold uppercase'>What do you want to share today?</span>
                        
                        <div class='top-part'>
                            <div class='personal-section'>
                                <svg height='23px' width='23px' version='1.1' id='Capa_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 60.671 60.671' xml:space='preserve'>
                                    <g>
                                        <g>
                                            <ellipse style='fill:#FAFAFA;' cx='30.336' cy='12.097' rx='11.997' ry='12.097'/>
                                            <path style='fill:#FAFAFA;' d='M35.64,30.079H25.031c-7.021,0-12.714,5.739-12.714,12.821v17.771h36.037V42.9
                                                C48.354,35.818,42.661,30.079,35.64,30.079z'/>
                                        </g>
                                    </g>
                                </svg>
                            </div>

                            <div class='flex flex-col h-full w-fit'>
                                <span class='text-lg text-[var(--main-black)] font-bold'>
                                    <?php
                                        echo $_SESSION['user']['nickname'];
                                    ?>
                                </span>
                            </div>
                        </div>

                        <form method="get" action="#" class="h-fit w-full">
                            <div class="size-full">
                                <input type='text' name='type' value='add_post' hidden />

                                <textarea class="post-textarea" rows="6" name="content_text" placeholder="Share something..." required></textarea>

                                <input class="button" type="submit" value="Create a post" />
                            </div>
                        </form>
                    </div>

                    <?php
                        foreach ($posts as $index => $post_info) {
                            $post_id = $post_info['post_id'];

                            // htmlspecialchars для обеспечения защиты от XSS атак
                            $post_text = htmlspecialchars($post_info['text'], ENT_QUOTES, 'UTF-8');
                            $post_author_name = htmlspecialchars($post_info['nickname'], ENT_QUOTES, 'UTF-8');
                            $post_date = strtotime($post_info['date']);
                            $date_time = date('d M Y | H:i', $post_date);
                                   
                            // обработка информации о комментариях
                            $post_comments = 0;
                            if (strlen($post_info['comments']) > 0) {
                                $post_comments = sizeof(explode(',', $post_info['comments']));
                            }

                            // обработка информации о лайках
                            $post_likes = 0;
                            if (strlen($post_info['likes']) > 0) {
                                $post_likes = sizeof(explode(',', $post_info['likes']));
                            }    

                            $like_image = "
                                <svg fill='#1E1E1E' height='30px' width='30px' version='1.1' id='Capa_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 471.701 471.701' xml:space='preserve'>
                                    <g>
                                        <path d='M433.601,67.001c-24.7-24.7-57.4-38.2-92.3-38.2s-67.7,13.6-92.4,38.3l-12.9,12.9l-13.1-13.1
                                            c-24.7-24.7-57.6-38.4-92.5-38.4c-34.8,0-67.6,13.6-92.2,38.2c-24.7,24.7-38.3,57.5-38.2,92.4c0,34.9,13.7,67.6,38.4,92.3
                                            l187.8,187.8c2.6,2.6,6.1,4,9.5,4c3.4,0,6.9-1.3,9.5-3.9l188.2-187.5c24.7-24.7,38.3-57.5,38.3-92.4
                                            C471.801,124.501,458.301,91.701,433.601,67.001z M414.401,232.701l-178.7,178l-178.3-178.3c-19.6-19.6-30.4-45.6-30.4-73.3
                                            s10.7-53.7,30.3-73.2c19.5-19.5,45.5-30.3,73.1-30.3c27.7,0,53.8,10.8,73.4,30.4l22.6,22.6c5.3,5.3,13.8,5.3,19.1,0l22.4-22.4
                                            c19.6-19.6,45.7-30.4,73.3-30.4c27.6,0,53.6,10.8,73.2,30.3c19.6,19.6,30.3,45.6,30.3,73.3
                                            C444.801,187.101,434.001,213.101,414.401,232.701z'/>
                                    </g>
                                </svg>
                            ";

                            if (has_like($_SESSION['user']['user_id'], $post_id)) {
                                $like_image = "
                                    <svg width='32px' height='32px' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                        <path d='M2 9.1371C2 14 6.01943 16.5914 8.96173 18.9109C10 19.7294 11 20.5 12 20.5C13 20.5 14 19.7294 15.0383 18.9109C17.9806 16.5914 22 14 22 9.1371C22 4.27416 16.4998 0.825464 12 5.50063C7.50016 0.825464 2 4.27416 2 9.1371Z' fill='#1E1E1E'/>
                                    </svg>
                                ";
                            }
                            
                            // создание блока поста пользователя
                            echo "
                                <div id='block'>
                                    <div id='content' class='block-body'>
                                        <div class='w-full flex flex-row gap-x-[15px] items-center'>
                                            <div class='size-fit p-[10px] bg-[var(--main-grey)] rounded-full flex flex-row justify-center items-center'>
                                                <svg height='23px' width='23px' version='1.1' id='Capa_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 60.671 60.671' xml:space='preserve'>
                                                    <g>
                                                        <g>
                                                            <ellipse style='fill:#FAFAFA;' cx='30.336' cy='12.097' rx='11.997' ry='12.097'/>
                                                            <path style='fill:#FAFAFA;' d='M35.64,30.079H25.031c-7.021,0-12.714,5.739-12.714,12.821v17.771h36.037V42.9
                                                                C48.354,35.818,42.661,30.079,35.64,30.079z'/>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </div>

                                            <div class='flex flex-col h-full w-fit'>
                                                <span class='text-lg text-[var(--main-black)] font-bold'>{$post_author_name}</span>
                                                <span class='text-base text-[var(--main-grey)] font-normal'>{$date_time}</span>
                                            </div>
                                        </div>
                
                                        <div class=''>
                                            <span>{$post_text}</span>
                                        </div>
                
                                        <div class='mt-[10px] border-t-2 border-t-[var(--main-black)] h-[50px]'>
                                            <div class='mt-[10px] flex flex-row justify-start items-center'>
                                                <div class='h-full w-full flex flex-row items-center justify-start gap-x-[5px]'>
                                                    <a href='?type=add_like&post_id={$post_id}'>
                                                        <div class='cursor-pointer'>
                                                            {$like_image}
                                                        </div>
                                                    </a>
                                                    <span class='text-xl text-[var(--main-black)] font-bold'>{$post_likes}</span>
                                                </div>
                    
                                                <div class='h-full w-full flex flex-row items-center justify-start gap-x-[5px]'>
                                                    <div class=''>
                                                        <svg width='30px' height='30px' viewBox='0 0 32 32' version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns:sketch='http://www.bohemiancoding.com/sketch/ns'>                                            
                                                        </defs>
                                                            <g id='Page-1' stroke='none' stroke-width='1' fill='none' fill-rule='evenodd' sketch:type='MSPage'>
                                                                <g id='Icon-Set' sketch:type='MSLayerGroup' transform='translate(-100.000000, -255.000000)' fill='#000000'>
                                                                    <path d='M116,281 C114.832,281 113.704,280.864 112.62,280.633 L107.912,283.463 L107.975,278.824 C104.366,276.654 102,273.066 102,269 C102,262.373 108.268,257 116,257 C123.732,257 130,262.373 130,269 C130,275.628 123.732,281 116,281 L116,281 Z M116,255 C107.164,255 100,261.269 100,269 C100,273.419 102.345,277.354 106,279.919 L106,287 L113.009,282.747 C113.979,282.907 114.977,283 116,283 C124.836,283 132,276.732 132,269 C132,261.269 124.836,255 116,255 L116,255 Z' id='comment-1' sketch:type='MSShapeGroup'>
                                                        
                                                        </path>
                                                                </g>
                                                            </g>
                                                        </svg>
                                                    </div>
                                                    <span class='text-xl text-[var(--main-black)] font-bold'>{$post_comments}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            ";

                            $comments = get_comments(strval($post_info['comments']));

                            // создание секции под комментарии
                            echo "
                                <div id='comment-section'>
                                    <span class='text-lg text-[var(--main-black)] font-bold uppercase'>Comments</span>        
                            ";

                            // создание блока под каждый комментарий
                            foreach ($comments as $index => $comment_info) {
                                $comment_name = htmlspecialchars($comment_info['nickname'], ENT_QUOTES, 'UTF-8');
                                $comment_text = htmlspecialchars($comment_info['text'], ENT_QUOTES, 'UTF-8');
                                $comment_add_date = strtotime($comment_info['add_date']);
                                $add_date = date('h:i (d M Y)', $comment_add_date);

                                echo "
                                    <div id='comment-block' class='h-fit'>
                                        <div class='w-full flex flex-row gap-x-[15px] items-start'>
                                            <div class='mt-[5px] size-fit p-[10px] bg-[var(--main-grey)] rounded-full flex flex-row justify-center items-center'>
                                                <svg height='23px' width='23px' version='1.1' id='Capa_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 60.671 60.671' xml:space='preserve'>
                                                    <g>
                                                        <g>
                                                            <ellipse style='fill:#FAFAFA;' cx='30.336' cy='12.097' rx='11.997' ry='12.097'/>
                                                            <path style='fill:#FAFAFA;' d='M35.64,30.079H25.031c-7.021,0-12.714,5.739-12.714,12.821v17.771h36.037V42.9
                                                                C48.354,35.818,42.661,30.079,35.64,30.079z'/>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </div>
            
                                            <div class='flex flex-col h-full w-fit'>
                                                <div class='flex flex-row justify-start items-center'>
                                                    <span class='text-lg text-[var(--main-black)] font-bold'>{$comment_name} |</span>
                                                    <span class='text-base text-[var(--main-grey)] font-normal'>&nbsp{$add_date}</span>
                                                </div>
                                                <span class='text-base text-[var(--main-grey)] font-normal'>{$comment_text}</span>
                                            </div>
                                        </div>
                                    </div>
                                ";
                            }

                            // создание формы под новый комментарий
                            echo "
                                <div id='new-comment-block' class='h-fit mt-[10px] flex flex-col'>
                                    <span class='text-base text-[var(--main-black)] font-bold uppercase'>Add Comment</span>

                                    <div class='w-full flex flex-row gap-x-[15px] items-start'>
                                        <div class='mt-[5px] size-fit p-[10px] bg-[var(--main-grey)] rounded-full flex flex-row justify-center items-center'>
                                            <svg height='23px' width='23px' version='1.1' id='Capa_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 60.671 60.671' xml:space='preserve'>
                                                <g>
                                                    <g>
                                                        <ellipse style='fill:#FAFAFA;' cx='30.336' cy='12.097' rx='11.997' ry='12.097'/>
                                                        <path style='fill:#FAFAFA;' d='M35.64,30.079H25.031c-7.021,0-12.714,5.739-12.714,12.821v17.771h36.037V42.9
                                                            C48.354,35.818,42.661,30.079,35.64,30.079z'/>
                                                    </g>
                                                </g>
                                            </svg>
                                        </div>
        
                                        <div class='flex flex-col h-fit w-full'>
                                            <div class='flex flex-row justify-start items-center'>
                                                <span class='text-lg text-[var(--main-black)] font-bold'>{$_SESSION['user']['nickname']}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <form method='get' action='#' class='w-full h-fit mt-[10px]'>
                                        <div class='size-full'>
                                            <input type='text' name='post_id' value='{$post_id}' hidden />
                                            <input type='text' name='type' value='add_comment' hidden />
            
                                            <textarea class='w-full focus:outline-none resize-none p-[5px] rounded-[10px] shadow-md' rows='3' name='content-text' placeholder='Expose your feelings...' required></textarea>
            
                                            <input class='bg-blue-500 rounded-[10px] h-[35px] w-full text-lg text-[var(--main-white)] font-normal uppercase cursor-pointer' type='submit' value='Place a comment' />
                                        </div>
                                    </form>
                                </div>
                            ";
                            echo "</div>";
                            echo "</div>";
                        }
                    ?>
                </div>

                <div id="users-region" class="w-[20%] h-full absolute top-0 right-[250px]">
                    <span class="text-xl text-[var(--main-black)] font-bold uppercase">Top Users</span>

                    <div class="w-full h-fit flex flex-col justify-start gap-y-[10px]">
                        <?php
                            require './server/users_processing.php'; 
                            
                            $users = get_users();

                            // получение пользователей и создание под каждого блока с информацией
                            foreach ($users as $index => $user_info) {
                                $user_nickname = htmlspecialchars($user_info['nickname'], ENT_QUOTES, 'UTF-8');
                                $user_name = $user_info['name'];
                                $user_reg_date = strtotime($user_info['reg_date']);
                                $date = date('d M Y', $user_reg_date);

                                $nickname_classes = $_SESSION['user']['nickname'] == $user_nickname ? "text-lg font-bold text-blue-500" : "text-lg font-bold text-[var(--main-black)]";

                                echo "
                                    <div id='user-block'>
                                        <div class='w-full flex flex-row gap-x-[15px] items-center'>
                                            <div class='size-fit p-[10px] bg-[var(--main-grey)] rounded-full flex flex-row justify-center items-center'>
                                                <svg height='23px' width='23px' version='1.1' id='Capa_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 60.671 60.671' xml:space='preserve'>
                                                    <g>
                                                        <g>
                                                            <ellipse style='fill:#FAFAFA;' cx='30.336' cy='12.097' rx='11.997' ry='12.097'/>
                                                            <path style='fill:#FAFAFA;' d='M35.64,30.079H25.031c-7.021,0-12.714,5.739-12.714,12.821v17.771h36.037V42.9 C48.354,35.818,42.661,30.079,35.64,30.079z'/>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </div>
            
                                            <div class='flex flex-col h-full w-fit'>
                                                <span class='{$nickname_classes}'>{$user_nickname}</span>
                                                <span class='text-base text-[var(--main-grey)] font-normal'>Reg Date: {$date}</span>
                                            </div>
                                        </div>
                                    </div>
                                ";
                            }
                        ?>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="header">
    </footer>
</body>
</html>