<?php 
class Domain_User {

    //http://transport-core.microfox.ru/api/user.login?phone=89094294989&password=123

    public $isRegistered;
    public $isCorrectPassword = FALSE;
    public $user;

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

    function register() {
        global $pdo;

        $name			= Parameters::Get('name');
        $surname		= Parameters::Get('surname');
        $password		= Parameters::Get('password');
        $email			= Parameters::Get('email');
        $phone			= Parameters::Get('phone');
        $password_hash	= crypt($password, SALT);

        //$sql = $mysqli->query("SELECT id FROM `clients` where phone='".$phone."'");
        $pdoQuery = $pdo->prepare("SELECT id FROM `clients` WHERE phone = :phone");
        $pdoQuery->execute([
            ':phone' => $phone
        ]);

        if (!$pdoQuery -> num_rows){
            //$sql = $mysqli->query("	INSERT INTO `clients` (`name`, `surname`, `email`, `phone`, `password`) VALUES ('".$name."', '".$surname."', '".$email."', '".$phone."', '".$user_pass_hash."')");
            if ($pdoQuery){
                /*echo "Вы успешно зарегистрированы";
                $headers = "From: webmaster@easywork.su\r\nContent-type: text/html; charset=utf-8\r\n";
                //$page = file_get_contents("http://easywork.su/register/mail.html");
                $page = "Awesome Page";
                $text = str_replace("%rep%", crypt($user_pass_hash, $salt)."&t=c", $page);
                $text = str_replace("Да будет красивый текст!", "Здравствуйте, ".$name, $text);
                mail($email,"Подтверждение регистрации в сервисе Easy Work",$text, $headers);*/
                Response::send(array('code'=>'200'));
            } else {
                echo Response::error('-2');
            }
        } else {
            echo Response::error('201');
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