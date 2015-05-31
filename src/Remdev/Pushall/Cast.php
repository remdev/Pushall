<?php

namespace Remdev\Pushall;

use Remdev\Pushall\Exceptions\InvalidTokenException;
use Remdev\Pushall\Exceptions\ConnectionException;

class Cast
{
    /**
    * @var string API URL
    */
    protected $url = 'https://pushall.ru/api.php';
    /**
    * @var int ID канала
    */
    private $id;

    /**
    * @var string Токен для доступа к API
    */
    private $token = null;

    /**
    * @param $id int ID канала
    * @param $token string Токен для доступа к API
    */
    public function __construct($id = null, $token = null)
    {
        if($id!=null && $token!=null) {
            $this->setParams($id,$token);
        }
        
    }

    public function setParams($id, $token)
    {
        $this->id = $id;
        if($this->validateToken($token)) {
            $this->token = $token;
        } else {
            throw new InvalidTokenException();
        }
    }

    /**
    * @param $params array
    *
    * @return ответ результат запроса
    */ 
    public function query($type, $params = array())
    {
        $params['id']   = $this->id;
        $params['key']  = $this->token;
        $params['type'] = $type;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $text = curl_exec($ch); //получить данные о рассылке
        curl_close($ch);
        if($text===false)
            throw new ConnectionException();
        $json = json_decode($text, true);

        return $json;
    }
    /**
    * @param $token string Токен для доступа к API
    */
    private function validateToken($token)
    {
        if(preg_match('/^[a-f0-9]{32}$/i', $token)) {
            return true;
        } else {
            return false;
        }
    }
}