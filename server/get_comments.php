<?php

    require './server/db_connection.php';

    function get_comments($id_string) {
        global $server_connection;

        $ids = array_map('intval', explode(' ', $id_string));

        $result = array();

        $request = "SELECT * FROM comments JOIN users ON comments.user_id = users.user_id WHERE comments.comment_id IN ({$id_string});";
        $query = mysqli_query($server_connection, $request);

        if ($query) {
            while ($comment = mysqli_fetch_array($query)) {
                $result[] = $comment;
            }
        }

        return $result;
    }

?>