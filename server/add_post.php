<?php

    require './server/db_connection.php';

    function add_post($user_id, $text) {
        global $server_connection;

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