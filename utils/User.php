<?php
include 'vendor/autoload.php';
include_once("utils/Db.php");

use PHPMailer\PHPMailer\PHPMailer;

class User
{
    public MySqli $db;
    public function __construct()
    {
        $this->db = Db::getInstance();
    }
    public function login(string $type, array $data)
    {
        $query = "SELECT * FROM users WHERE email='{$data['email']}' AND password='{$data['password']}' AND type='{$type}'";
        $result = $this->db->query($query);
        $row = $result->fetch_assoc();
        if ($result->num_rows > 0) {
            if ($row['active'] == 0) {
                return 0;
            }
            session_start();
            $_SESSION["uid"] = $row['id'];
            $_SESSION["email"] = $data["email"];
            $_SESSION['type'] = $row['type'];
            return true;
        }
        return false;
    }
    public function register(string $type, array $data)
    {
        // if the data is not correct , return the error
        $errors = $this->sanitizeAndValidate($data);
        if ($errors) {
            return $errors;
        }

        $sql = "INSERT INTO users (username, email, phone, password, type)
                VALUES ('{$data['userName']}', '{$data['email']}', '{$data['phone']}','{$data['password']}','{$type}')";

        if ($this->db->query($sql) === true) {
            $userId = $this->db->query("SELECT id FROM users WHERE email='{$data['email']}'")->fetch_assoc()['id'];
            $token = md5($data['email'] . $data['password']);
            // set and send token
            $template = <<<END
            <html>
                <head>
                    <style>
                        body {
                            background-color: #f2f2f2;
                            font-family: 'Open Sans', sans-serif;
                        }

                        h1,
                        h2,
                        h3,
                        p {
                            font-family: 'Open Sans', sans-serif;
                        }

                        .card {
                            width: 600px;
                            background-color: white;
                            margin: 100px auto;
                            border-radius: 10px;
                            box-shadow: 0px 3px 3px rgba(153, 153, 153, 0.288);
                        }

                        .card-header {
                            background-color: #1b1b1b;
                            padding: 10px;
                            border-radius: 10px 10px 0 0;
                        }

                        .card-header h1 {
                            color: white;
                            font-size: 26px;
                            font-weight: bold;
                            text-transform: uppercase;
                            letter-spacing: 2px;
                            text-align: center;
                        }

                        .card-body {
                            padding: 40px;
                            text-align: center;
                        }

                        .card-body p {
                            font-size: 18px;
                            line-height: 1.5;
                        }

                        .main-color {
                            color: crimson;
                        }

                        .button {
                            background-color: crimson;
                            color: white;
                            border: none;
                            padding: 10px 20px;
                            border-radius: 5px;
                            text-decoration: none;
                            font-weight: bold;
                            transition: all 0.3s ease-in-out;
                            display: inline-block;
                        }

                        .button:hover {
                            transform: translateY(-3px);
                            box-shadow: 0px 3px 3px rgba(153, 153, 153, 0.534);
                        }
                    </style>
                </head>

                <body>
                    <div class="card">
                        <div class="card-header">
                            <h1>Welcome to Mending-Hems!</h1>
                        </div>
                        <div class="card-body">
                            <p>We're excited to have you as part of our community. To get started, please activate your account by
                                clicking the button below:</p>
                            <a href="http://localhost/mending-hems/activate.php?token=$token" class="button">Activate Account</a>
                            <p>Activating your account will give you access to all of the features and benefits of being a Mending-Hems
                                member, including the ability to place orders, track your orders, and much more.</p>
                            <p>Best regards,<br>The Mending-Hems Team</p>
                        </div>
                    </div>
                </body>

                </html>
            END;
            self::sendEmail($data['email'], 'activate your account', $template);
            $this->db
                ->query("INSERT INTO activate (user_id,token) VALUES('{$userId}','{$token}')");
            return true;
        }
        return false;
    }
    public function resetPassword($email)
    {
        if ($email === null)
            return false;
        // check if email exists in db
        if (
            $this->db
            ->query("SELECT * FROM users WHERE email = '$email' AND active = 1")
            ->num_rows === 1
        ) {
            // calculate and set the token in db
            $token = md5($email) . time();
            $uId = $this->db->query("SELECT id FROM users WHERE email = '$email'")
                ->fetch_assoc()['id'] ?? null;
            $this->db->query(
                "INSERT INTO activate (user_id,token) VALUES ($uId,'$token')"
            );
            // send mail with token
            $template = <<<END
            <html>
                <head>
                    <style>
                        body {
                            background-color: #f2f2f2;
                            font-family: 'Open Sans', sans-serif;
                        }

                        h1,
                        h2,
                        h3,
                        p {
                            font-family: 'Open Sans', sans-serif;
                        }

                        .card {
                            width: 600px;
                            background-color: white;
                            margin: 100px auto;
                            border-radius: 10px;
                            box-shadow: 0px 3px 3px rgba(153, 153, 153, 0.288);
                        }

                        .card-header {
                            background-color: #1b1b1b;
                            padding: 10px;
                            border-radius: 10px 10px 0 0;
                        }

                        .card-header h1 {
                            color: white;
                            font-size: 26px;
                            font-weight: bold;
                            text-transform: uppercase;
                            letter-spacing: 2px;
                            text-align: center;
                        }

                        .card-body {
                            padding: 40px;
                            text-align: center;
                        }

                        .card-body p {
                            font-size: 18px;
                            line-height: 1.5;
                        }

                        .main-color {
                            color: crimson;
                        }

                        .button {
                            background-color: crimson;
                            color: white;
                            border: none;
                            padding: 10px 20px;
                            border-radius: 5px;
                            text-decoration: none;
                            font-weight: bold;
                            transition: all 0.3s ease-in-out;
                            display: inline-block;
                        }

                        .button:hover {
                            transform: translateY(-3px);
                            box-shadow: 0px 3px 3px rgba(153, 153, 153, 0.534);
                        }
                    </style>
                </head>

                <body>
                    <div class="card">
                        <div class="card-header">
                            <h1>Welcome to Mending-Hems!</h1>
                        </div>
                        <div class="card-body">
                            <p>reset your account's password by
                                clicking the button below:</p>
                            <a href="http://localhost/mending-hems/reset.php?token=$token" class="button">Reset Password</a>
                            <p>Best regards,<br>The Mending-Hems Team</p>
                        </div>
                    </div>
                </body>

                </html>
            END;
            self::sendEmail($email, 'reset your password', $template);
            return true;
        }
        return false;
    }
    private function sanitizeAndValidate(array $data, bool $existenseCheck = true)
    {
        $errors = [];
        $requiredKeys = ["userName", "email", "password", "phone"];
        $uniqueKeys = ["userName", "email", "phone"];
        foreach ($requiredKeys as $key) {
            if (!strlen(trim($data[$key])))
                $errors[$key] = ["desc" => "$key is required"];
        }
        if (count($errors) || !$existenseCheck)
            return $errors;
        foreach ($uniqueKeys as $uKey) {
            if ($this->isAlreadyExists(strtolower($uKey), $data[$uKey]))
                $errors[$uKey] = "$uKey already exists";
        }
        return $errors;
    }
    private function isAlreadyExists(string $key, string $value)
    {
        $query = "SELECT id FROM users WHERE $key='$value'";
        if ($this->db->query($query)->num_rows > 0)
            return true;
        return false;
    }
    public static function sendEmail($to, $subject, $message)
    {
        $config = require("utils/config.php");
        $config = $config['email'];
        try {
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host       = $config['host'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $config['username'];
            $mail->Password   = $config['password'];
            $mail->SMTPSecure = 'tls';
            $mail->Port       = $config['port'];
            $mail->setFrom('mending@hems.com', 'admin@mending-hems.com');
            $mail->addAddress($to);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->AltBody = $message;
            $mail->send();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return true;
    }
}
