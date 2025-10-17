<?php


namespace App\Controllers;

use App\Core\Validator;
use App\Models\User;
use App\Core\Database;
use App\Helpers\Helper;
class UserController
{
    private $user;
    private $data;
    private $db;
    public function __construct()
    {
        $this->db = new Database();
        $this->user = new User($this->db->getConnection());
        $this->data = Helper::getInput();
    }
    public function getAll()
    {
        return Helper::jsonResponse($this->user->getAll());
    }
    public function getUser($id){
        // var_dump($id);
        return Helper::jsonResponse($this->user->readById($id));
    }

    public function delete($id)
    {

        if ($this->user->delete($id)) {
            return Helper::jsonResponse(["message" => "User deleted"]);
        } else {
            return Helper::jsonResponse(["error" => "Delete failed"], 500);
        }
    }
    public function update($id)
    {
        $user = $this->user->readById($id);
        $name = htmlspecialchars(strip_tags($this->data["name"] ?? $user["name"] ));
        $password = $this->data["password"] ?? $user["password"];
        // var_dump($this->data);
        if (!$id || !$name || !$password) {
            return  Helper::jsonResponse(["error" => "Missing fields"], 400);
        }
        $pdo = $this->db->getConnection();
        $data_to_validate = [
            "name" => $name,
            "password" => $password
        ];
        $validator = new Validator($data_to_validate, [
            'name' => 'required|min:3|max:100',
            'password' => 'required|min:6'
        ], $pdo);
        if (!$validator->validate()) {
            http_response_code(401); //not authorized
            echo json_encode(['errors' => $validator->errors()], JSON_UNESCAPED_UNICODE);
            return;
        }

        ($password!=$user["password"])?$password=password_hash($password, PASSWORD_DEFAULT):$password=$user["password"];

        if ($this->user->update($id, compact("name", "password"))) {
            return Helper::jsonResponse(["message" => "User updated"]);
        } else {
            return Helper::jsonResponse(["error" => "Update failed"], 500);
        }
    }
}
