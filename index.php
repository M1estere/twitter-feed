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
    ?>

    <header id="header" class="h-[25px] bg-blue-500 w-full">
    </header>

    <main>
        <section id="top" class="h-fit w-full mt-[25px]">
            <div class="w-[30%] h-fit mx-auto flex justify-between items-center">
                <span class="text-2xl text-[var(--main-black)] font-bold uppercase">Welcome to the feed</span>
                <span class="text-xl text-[var(--main-grey)] font-normal">1 feeds</span>
            </div>
        </section>

        <section id="content" class="mt-[25px]">
            <div class="w-full h-[750px] relative">
                <div id="feed" class="w-[30%] h-full mx-auto flex flex-col gap-y-[15px]">
                    <?php
                        require './server/get_posts.php';
                        require './server/get_comments.php';

                        $posts = get_posts();

                        foreach ($posts as $index => $post_info) {
                            $post_text = $post_info['text'];
                            $post_author_name = $post_info['nickname'];
                            $post_date = strtotime($post_info['date']);
                            $date_time = date('d M Y | H:i', $post_date);
                            $post_likes = sizeof(explode($post_info['likes'], ' '));
                            $post_comments = sizeof(explode($post_info['comments'], ' '));

                            echo "
                                <div id='block'>
                                    <div id='content' class='w-full bg-[var(--main-white)] border-2 border-[var(--main-black)] h-fit rounded-[15px] flex flex-col p-[10px] gap-y-[15px]'>
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
                                                    <div class='cursor-pointer'>
                                                        <svg fill='#000000' height='30px' width='30px' version='1.1' id='Capa_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 471.701 471.701' xml:space='preserve'>
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
                                                    </div>
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

                            foreach ($comments as $index => $comment_info) {
                                if ($index == 0) {
                                    echo "
                                        <div id='comment-section' class='mt-[-2px] w-[85%] h-fit border-2 border-[var(--main-black)] rounded-b-[10px] mx-auto flex flex-col gap-y-[10px] p-[10px]'>
                                            <span class='text-lg text-[var(--main-black)] font-bold uppercase'>Comments</span>        
                                    ";
                                }
                                $comment_name = $comment_info['nickname'];
                                $comment_text = $comment_info['text'];

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
                                                <span class='text-lg text-[var(--main-black)] font-bold'>{$comment_name}</span>
                                                <span class='text-base text-[var(--main-grey)] font-normal'>{$comment_text}</span>
                                            </div>
                                        </div>
                                    </div>
                                ";

                                if ($index == 0) {
                                    echo "</div>";
                                }
                            }

                            echo "</div>";
                        }
                    ?>

                    <!--<div id="block">
                        <div id="content" class="w-full bg-[var(--main-white)] border-2 border-[var(--main-black)] h-fit rounded-[15px] flex flex-col p-[10px] gap-y-[15px]">
                            <div class="w-full flex flex-row gap-x-[15px] items-center">
                                <div class="size-fit p-[10px] bg-[var(--main-grey)] rounded-full flex flex-row justify-center items-center">
                                    <svg height="23px" width="23px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 60.671 60.671" xml:space="preserve">
                                        <g>
                                            <g>
                                                <ellipse style="fill:#FAFAFA;" cx="30.336" cy="12.097" rx="11.997" ry="12.097"/>
                                                <path style="fill:#FAFAFA;" d="M35.64,30.079H25.031c-7.021,0-12.714,5.739-12.714,12.821v17.771h36.037V42.9
                                                    C48.354,35.818,42.661,30.079,35.64,30.079z"/>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                                <div class="flex flex-col h-full w-fit">
                                    <span class="text-lg text-[var(--main-black)] font-bold">M1estere</span>
                                    <span class="text-base text-[var(--main-grey)] font-normal">12/04/2024 15:12</span>
                                </div>
                            </div>
    
                            <div class="">
                                <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</span>
                            </div>
    
                            <div class="mt-[10px] border-t-2 border-t-[var(--main-black)] h-[50px]">
                                <div class="mt-[10px] flex flex-row justify-start items-center">
                                    <div class="h-full w-full flex flex-row items-center justify-start gap-x-[5px]">
                                        <div class="cursor-pointer">
                                            <svg fill="#000000" height="30px" width="30px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 471.701 471.701" xml:space="preserve">
                                                <g>
                                                    <path d="M433.601,67.001c-24.7-24.7-57.4-38.2-92.3-38.2s-67.7,13.6-92.4,38.3l-12.9,12.9l-13.1-13.1
                                                        c-24.7-24.7-57.6-38.4-92.5-38.4c-34.8,0-67.6,13.6-92.2,38.2c-24.7,24.7-38.3,57.5-38.2,92.4c0,34.9,13.7,67.6,38.4,92.3
                                                        l187.8,187.8c2.6,2.6,6.1,4,9.5,4c3.4,0,6.9-1.3,9.5-3.9l188.2-187.5c24.7-24.7,38.3-57.5,38.3-92.4
                                                        C471.801,124.501,458.301,91.701,433.601,67.001z M414.401,232.701l-178.7,178l-178.3-178.3c-19.6-19.6-30.4-45.6-30.4-73.3
                                                        s10.7-53.7,30.3-73.2c19.5-19.5,45.5-30.3,73.1-30.3c27.7,0,53.8,10.8,73.4,30.4l22.6,22.6c5.3,5.3,13.8,5.3,19.1,0l22.4-22.4
                                                        c19.6-19.6,45.7-30.4,73.3-30.4c27.6,0,53.6,10.8,73.2,30.3c19.6,19.6,30.3,45.6,30.3,73.3
                                                        C444.801,187.101,434.001,213.101,414.401,232.701z"/>
                                                </g>
                                            </svg>
                                        </div>
                                        <span class="text-xl text-[var(--main-black)] font-bold">12</span>
                                    </div>
        
                                    <div class="h-full w-full flex flex-row items-center justify-start gap-x-[5px]">
                                        <div class="">
                                            <svg width="30px" height="30px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">                                            
                                            </defs>
                                                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                                    <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-100.000000, -255.000000)" fill="#000000">
                                                        <path d="M116,281 C114.832,281 113.704,280.864 112.62,280.633 L107.912,283.463 L107.975,278.824 C104.366,276.654 102,273.066 102,269 C102,262.373 108.268,257 116,257 C123.732,257 130,262.373 130,269 C130,275.628 123.732,281 116,281 L116,281 Z M116,255 C107.164,255 100,261.269 100,269 C100,273.419 102.345,277.354 106,279.919 L106,287 L113.009,282.747 C113.979,282.907 114.977,283 116,283 C124.836,283 132,276.732 132,269 C132,261.269 124.836,255 116,255 L116,255 Z" id="comment-1" sketch:type="MSShapeGroup">
                                            
                                            </path>
                                                    </g>
                                                </g>
                                            </svg>
                                        </div>
                                        <span class="text-xl text-[var(--main-black)] font-bold">5</span>
                                    </div>
                                </div>
                            </div>
                        </div>
    
                        <div id="comment-section" class="mt-[-2px] w-[85%] h-fit border-2 border-[var(--main-black)] rounded-b-[10px] mx-auto flex flex-col gap-y-[10px] p-[10px]">
                            <span class="text-lg text-[var(--main-black)] font-bold uppercase">Comments</span>

                            <div id="comment-block" class="h-fit">
                                <div class="w-full flex flex-row gap-x-[15px] items-start">
                                    <div class="mt-[5px] size-fit p-[10px] bg-[var(--main-grey)] rounded-full flex flex-row justify-center items-center">
                                        <svg height="23px" width="23px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 60.671 60.671" xml:space="preserve">
                                            <g>
                                                <g>
                                                    <ellipse style="fill:#FAFAFA;" cx="30.336" cy="12.097" rx="11.997" ry="12.097"/>
                                                    <path style="fill:#FAFAFA;" d="M35.64,30.079H25.031c-7.021,0-12.714,5.739-12.714,12.821v17.771h36.037V42.9
                                                        C48.354,35.818,42.661,30.079,35.64,30.079z"/>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
    
                                    <div class="flex flex-col h-full w-fit">
                                        <span class="text-lg text-[var(--main-black)] font-bold">M1estere</span>
                                        <span class="text-base text-[var(--main-grey)] font-normal">You should be really proud of yourself. Not many people in the world can do something like that. You should be really proud of yourself. Not many people in the world can do something like that</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>-->
                </div>

                <div id="users-region" class="w-[20%] h-full absolute top-0 right-[250px]">
                    <span class="text-xl text-[var(--main-black)] font-bold uppercase">Top Users</span>

                    <div class="w-full h-fit flex flex-col justify-start gap-y-[10px]">
                        <?php
                            require './server/get_users.php'; 
                            
                            $users = get_users();
                            foreach ($users as $index => $user_info) {
                                $user_nickname = $user_info['nickname'];
                                $user_name = $user_info['name'];
                                $user_reg_date = strtotime($user_info['reg_date']);
                                $date = date('d M Y', $user_reg_date);

                                echo "
                                <div id='user-block' class='w-full bg-[var(--main-white)] h-fit shadow-lg p-[10px] rounded-[10px]'>
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
                                            <span class='text-lg text-[var(--main-black)] font-bold'>{$user_nickname}</span>
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
</body>
</html>