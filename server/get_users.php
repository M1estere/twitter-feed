<?php

    require './server/db_connection.php';

    function get_users() {
        global $server_connection;

        $result = array();

        $request = 'SELECT * FROM users;';
        $query = mysqli_query($server_connection, $request);

        if ($query) {
            while ($user = mysqli_fetch_array($query)) {
                $result[] = $user;
            }
        }

        return $result;
    }

?>