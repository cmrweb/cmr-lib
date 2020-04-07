<?php
namespace cmrweb;

class API
{

    private $pdo;
    private $data;
    private $id;
    private $server;
    private $ip;
    private $token;
    private $date;
    private $valid;

    function __construct($bool = NULL)
    {
        $this->pdo = new DB;
        $this->pdo->select('*', 'security', $bool);
        foreach ($this->pdo->result as $value) {
            $this->data[$value['id']] = [
                'id' => $value['id'],
                'server' => $value['server'],
                'ip' => $value['ip'],
                'token' => $value['token'],
                'date' => $value['date'],
                'valid' => $value['valid']
            ];
            $this->id[] = $value['id'];
            $this->server[] = $value['server'];
            $this->ip[] = $value['ip'];
            $this->token[] = $value['token'];
            $this->date[] = $value['date'];
            $this->valid[] = $value['valid'];
        }
        return $this->data;
    }
    public function getData(): ?array
    {
        return $this->data;
    }
    public function setData($data)
    {
        $this->pdo->insert('security', $data);
    }
    public function update($data, $id)
    {
        $this->pdo->update('security', $data, $id);
    }
    public function delete($data)
    {
        $this->pdo->delete('security', "id=" . $data);
    }
}
