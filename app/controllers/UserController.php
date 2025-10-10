<?php


namespace App\Controllers;

use App\Models\User;
use App\Core\Database;
use function App\helpers\jsonResponse;

class UserController
{
    private $user;
    private $data;

    public function __construct()
    {
        $db = new Database();
        $this->user = new User($db->getConnection());
        $this->data = json_decode(file_get_contents("php://input"), true);
    }
    public function getAll()
    {
        return jsonResponse($this->user->getAll());
    }
    public function getUser($id){
        return $this->user->getUser($id);
    }

    public function delete($id)
    {

        if ($this->user->delete($id)) {
            return JsonResponse(["message" => "User deleted"]);
        } else {
            return JsonResponse(["error" => "Delete failed"], 500);
        }
    }
    public function update($id)
    {
        $user = $this->getUser($id);
        $name = $this->data["name"] ?? $user["name"];
        $email = $this->data["email"] ?? $user["email"];
        // var_dump($user,$name,$email);
        if (!$id || !$name || !$email) {
            return  jsonResponse(["error" => "Missing fields"], 400);
        }

        if ($this->user->update($id, $name, $email)) {
            return jsonResponse(["message" => "User updated"]);
        } else {
            return jsonResponse(["error" => "Update failed"], 500);
        }
    }
}
