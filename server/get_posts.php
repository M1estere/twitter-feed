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

?>