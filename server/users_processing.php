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

    function login($nickname, $password) {
        global $server_connection;

        $nickname = trim($nickname);
        $password = trim($password);

        $user = user_exists($nickname);
        if ($user == null) {
            return -2;
        } else {
            if (password_verify($password, $user['password'])) {
                return 0;
            } else {
                return -1;
            }
        }
    }

    function register($nickname, $name, $password) {
        global $server_connection;

        $nickname = trim($nickname);
        $name = trim($name);
        $password = trim($password);

        $user = user_exists($nickname);
        if ($user != null) {
            return -2;
        } else {
            // prepare и bind_param для обеспечения защиты от SQL инъекций
            $date = date('Y-m-d', time());
            $stmt = $server_connection->prepare("INSERT INTO users (nickname, name, reg_date, password) VALUES (?, ?, '$date', ?);");
            $stmt->bind_param('sss', $nickname, $name, password_hash($password, PASSWORD_DEFAULT));

            if ($stmt->execute()) {
                $stmt->close();
                return 0;
            } else {
                $stmt->close();
                return -1;
            }
        }
    }

    function user_exists($nickname) {
        global $server_connection;

        // prepare и bind_param для обеспечения защиты от SQL инъекций
        $stmt = $server_connection->prepare('SELECT * FROM users WHERE nickname = ?;');
        $stmt->bind_param('s', $nickname);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $stmt->close();
            if ($result == null) return null;
            
            while ($user = $result->fetch_assoc()) {
                return $user;
            }
        } else {
            return null;
        }
    }

?>