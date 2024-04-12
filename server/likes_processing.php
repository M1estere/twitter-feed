<?php

    require './server/db_connection.php';

    function has_like($user_id, $post_id) {
        global $server_connection;

        $request = "SELECT * FROM posts WHERE post_id = '$post_id';";
        $query = mysqli_query($server_connection, $request);

        if ($query) {
            $post = mysqli_fetch_array($query);

            $likes_ids = array_map('intval', explode(',', $post['likes']));
            return in_array($user_id, $likes_ids);
        }
            
        return false;
    }

    function toggle_like($user_id, $post_id) {
        global $server_connection;
        
        if (has_like($user_id, $post_id)) {
            // remove like
            $request = "SELECT * FROM posts WHERE post_id = '$post_id';";
            $query = mysqli_query($server_connection, $request);

            if ($query) {
                $post = mysqli_fetch_array($query);
                
                $likes_ids = array_map('intval', explode(',', $post['likes']));

                $key = array_search($user_id, $likes_ids);
                if ($key != -1) {
                    unset($likes_ids[$key]);

                    $likes = implode(',', $likes_ids);

                    $request = "UPDATE posts SET likes = '$likes' WHERE post_id = '$post_id';";
                    $query = mysqli_query($server_connection, $request);

                    if ($query) return 1;
                    else return -1;
                } else {
                    return -2;
                }                
            } else {
                return -1;
            }
        } else {
            // add like
            $request = "SELECT * FROM posts WHERE post_id = '$post_id';";
            $query = mysqli_query($server_connection, $request);

            if ($query) {
                $post = mysqli_fetch_array($query);

                if (strlen($post['likes']) == 0) {
                    $likes = "{$user_id}";
                } else {
                    $likes = $post['likes'].','.$user_id;
                }

                $request = "UPDATE posts SET likes = '$likes' WHERE post_id = '$post_id';";
                $query = mysqli_query($server_connection, $request);
                if ($query) {
                    return 0;
                } else {
                    return -1;
                }
            } else {
                return -1;
            }
        }
    }

?>