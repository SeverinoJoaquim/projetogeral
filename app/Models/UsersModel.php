<?php namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $db;

    //===============================================
    public function __construct(){
        $this->db = db_connect();
    }
    //===================================================

    public function verifyLogin($username, $password){

        $params = array(
            $username,
            md5(sha1($password))
        );

        $query = "SELECT * FROM users WHERE username = ? AND passwrd = ?";
        $results = $this->db->query($query,$params)->getResult('array');
        
        if(count($results) == 0){
            return false;
        }else{

            //Lançar data do último login no db
            $params = array(
                $results[0]['id_user']
            );
            $this->db->query("UPDATE users SET last_login = NOW() WHERE id_user = ?", $params);

            //Retornos válidos
            return $results[0];
        }
    }
    
    //===================================================
    public function resetPassword($email){

        // Resets the users password

        // Check if there is a user with the email
        $params = array(
            $email
        );
        $query = "SELECT id_user FROM users WHERE email = ?";
        $results = $this->db->query($query,$params)->getResult('array');

        if(count($results) != 0){
            
            //Existe o email

            //Alterar a senha
            $newPassword = $this->randomPassword();
            $params = array(
                md5(sha1($newPassword)),
                $results[0]['id_user']
            );
            $query = "UPDATE users SET passwrd = ? WHERE id_user = ?";
            $this->db->query($query,$params);

            //Show the new password
            echo '(Mensagem de elmail)';
            echo 'A sua nova senha é: ' . $newPassword;


            return true;
        }else{
            //Não existe
            echo 'Não existe este email registrado!';
            return false;
        }
    }

        //===================================================
        public function checkEmail($email){
            //Verifica se o emailexiste
            $params = array(
                $email
            );
            $query = "SELECT id_user FROM users WHERE email = ?";
            return $this->db->query($query,$params)->getResult('array');            
        }
    
        //===================================================
        public function sendPurl($email, $id_user){

            /*
            1. Gerar um código purl e salvar no bd
            2. Enviar uma mensagem com o link do purl
            */
            $purl = $this->randomPassword(6);
            $params = array(
                $purl,
                $id_user
            );
            $query = "UPDATE users SET purl = ? WHERE id_user = ?";
            $this->db->query($query,$params);

            //Envio do email
            echo '(Mensagem de email) Link para redefinir a sua password: ';
            echo '<a href="'.site_url('users/redefine_password/' . $purl).'">Redefinir password</a>';
        }

    //===================================================
    private function randomPassword($numChars = 8){
        //Gerar uma senha randônica
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        return substr(str_shuffle($chars),0,$numChars);
    }

}