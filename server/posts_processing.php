<?php

    require './server/db_connection.php';

    function get_posts() {
        global $server_connection;

        $result = array();

        $request = 'SELECT * FROM posts JOIN users ON posts.user_id = users.user_id;';
        $query = mysqli_query($server_connection, $request);

        if ($query) {
            while ($post = mysqli_fetch_array($query)) {
                $result[] = $post;
            }
        }

        return $result;
    }

    function add_post($user_id, $text) {
        global $server_connection;

        // prepare и bind_param для обеспечения защиты от SQL инъекций
        $date = date('Y-m-d h:i:s', time());
        $stmt = $server_connection->prepare("INSERT INTO posts (user_id, text, date, likes, comments) VALUES (?, ?, ?, '', '');");
        $stmt->bind_param('iss', $user_id, $text, $date);

        if ($stmt->execute()) {
            $stmt->close();
            return 0;
        } else {
            $stmt->close();
            return -1;
        }
    }

?>