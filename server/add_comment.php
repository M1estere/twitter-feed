<?php

    require './server/db_connection.php';

    function add_comment($user_id, $post_id, $text) {
        global $server_connection;

        $date = date('Y-m-d h:i:s', time());
        $stmt = $server_connection->prepare("INSERT INTO comments (user_id, text, add_date) VALUES (?, ?, ?);");
        $stmt->bind_param('iss', $user_id, $text, $date);

        if ($stmt->execute()) {
            $comment_id = mysqli_insert_id($server_connection);
            echo $comment_id;
            $stmt->close();

            $request = "SELECT * FROM posts WHERE post_id = '$post_id';";
            $query = mysqli_query($server_connection, $request);

            if ($query) {
                $post = mysqli_fetch_array($query);

                $comments = $post['comments'];
                if (strlen($comments) == 0) {
                    $comments = "$comment_id";
                } else {
                    $comments = $comments.",$comment_id";
                }

                $request = "UPDATE posts SET comments = '$comments' WHERE post_id = '$post_id';";
                $query = mysqli_query($server_connection, $request);

                if ($query) {
                    return 0;
                } else {
                    return -1;
                }
            } else {
                return -1;
            }
        } else {
            $stmt->close();
            return -1;
        }
    }

?>