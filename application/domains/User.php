<?php 
class Domain_User {

    //http://transport-core.microfox.ru/api/user.login?phone=89094294989&password=123

    public $isRegistered = FALSE;
    public $registeredCode;
    public $isCorrectPassword = FALSE;
    public $user;

    function register() {
        global $pdo;

        $name			= Parameters::Get('name');
        $surname		= Parameters::Get('surname');
        $password		= Parameters::Get('password');
        $email			= Parameters::Get('email');
        $phone			= Parameters::Get('phone');
        $password_hash	= crypt($password, SALT);

        $isUserQuery = $pdo->prepare(
            "SELECT id FROM `clients` WHERE phone = :phone"
        );
        $isUserQuery->execute([
            ':phone' => $phone
        ]);

        if (!$isUserQuery->rowCount()){
            //$sql = $mysqli->query("	INSERT INTO `clients` (`name`, `surname`, `email`, `phone`, `password`) VALUES ('".$name."', '".$surname."', '".$email."', '".$phone."', '".$user_pass_hash."')");

            //http://transport-core.microfox.ru/api/user.register?phone=89094294989&password=123

            $addUserQuery = $pdo->prepare(
                "INSERT INTO `clients` (`name`, `surname`, `email`, `phone`, `password`) VALUES (:name, :surname, :email, :phone, :password_hash)"
            );
            $addUserQuery->execute([
                ':name'          => $name,
                ':surname'       => $surname,
                ':email'         => $email,
                ':phone'         => $phone,
                ':password_hash' => $password_hash
            ]);
            if ($addUserQuery){
                $this->isRegistered = TRUE;
                $this->registeredCode = 200;
            } else {
                $this->isRegistered = TRUE;
                $this->registeredCode = -2;
            }
        } else {
            $this->isRegistered = FALSE;
            $this->registeredCode = 201;
        }
    }

    function login() {
        $password   = Parameters::Get('password');
        $phone      = Parameters::Get('phone');

        $this->user = $this->getUserInfo($phone);

        if ($this->user) {
            $this->isCorrectPassword = $this->checkPassword($password);

            if ($this->isCorrectPassword) {
                $_SESSION['now_user'] = [
                    'id'         => $this->user->id,
                    'token'      => Token::generate(),
                    'ip'         => $_SERVER['REMOTE_ADDR'],
                    'user_agent' => $_SERVER['HTTP_USER_AGENT']
                ];
                Token::insert($_SESSION['now_user'][id], $_SESSION['now_user'][token], $_SESSION['now_user'][ip], $_SESSION['now_user'][user_agent]);
            }
        } else {

        }
    }

    function checkPassword($password) {
        if ( hash_equals( $this->user->password, crypt($password, SALT)) ) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function getUserInfo($phone) {
        global $pdo;

        $userInfoQuery = $pdo->prepare(
            "SELECT * FROM `clients` WHERE phone = :phone"
        );

        $userInfoQuery->execute([
            ':phone' => $phone
        ]);

        // Возвращает объект или false
        if ($userInfoQuery->rowCount()){
            return $userInfoQuery->fetch();
        } else {
            return FALSE;
        }
    }
}