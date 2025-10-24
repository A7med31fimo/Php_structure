<?php


namespace App\Controllers;

use App\Core\Validator;
use App\Middleware\AuthMiddleware;
use App\Models\Cv;
use App\Core\Database;
use App\Helpers\Helper;

class CvController
{
    private $cv;
    private $data;
    private $db;
    public function __construct()
    {
        $this->db = new Database();
        $this->cv = new Cv($this->db->getConnection());
        $this->data = Helper::getInput();
    }
    public function getCv()
    {
        return Helper::jsonResponse($this->cv->read($this->data["id"]));
    }
    public function create()
    {
        AuthMiddleware::protect();
        $user_id = htmlspecialchars(strip_tags($this->data["user_id"] ?? ""));
        $full_name = htmlspecialchars(strip_tags($this->data["full_name"] ?? ""));
        $job_title = htmlspecialchars(strip_tags($this->data["job_title"] ?? ""));
        $email = htmlspecialchars(strip_tags($this->data["email"] ?? ""));
        $phone = htmlspecialchars(strip_tags($this->data["phone"] ?? ""));
        $linkedin = htmlspecialchars(strip_tags($this->data["linkedin"] ?? ""));
        $github = htmlspecialchars(strip_tags($this->data["github"] ?? ""));
        $summary = htmlspecialchars(strip_tags($this->data["summary"] ?? ""));
        $skills = htmlspecialchars(strip_tags($this->data["skills"] ?? ""));
        $experience = htmlspecialchars(strip_tags($this->data["experience"] ?? ""));
        $education = htmlspecialchars(strip_tags($this->data["education"] ?? ""));
        $projects = htmlspecialchars(strip_tags($this->data["projects"] ?? ""));

        $data_to_validate = [
            "full_name" => $full_name,
            "email" => $email,
            "phone" => $phone,

        ];
        $validator = new Validator($data_to_validate, [
            'user_id'=>'unique:cvs',
            'full_name' => 'required|min:10|max:100',
            'email' => 'email|min:10',
            'phone' => 'phone|min:11|max:11'
        ], $this->db->getConnection());
        if (!$validator->validate()) {
            http_response_code(401); //not authorized
            echo json_encode(['errors' => $validator->errors()], JSON_UNESCAPED_UNICODE);
            return;
        }

        if ($this->cv->create(compact(
            "user_id",
            "full_name",
            "job_title",
            "email",
            "phone",
            "location",
            "linkedin",
            "github",
            "summary",
            "skills",
            "experience",
            "education",
            "projects"
        ))) {
            return Helper::jsonResponse(["message" => "cv created"]);
        } else {
            return Helper::jsonResponse(["error" => "failed"], 500);
        }
    }

    public function delete()
    {

        if ($this->cv->delete($this->data["id"])) {
            return Helper::jsonResponse(["message" => "Cv deleted"]);
        } else {
            return Helper::jsonResponse(["error" => "Delete failed"], 500);
        }
    }
    public function save()
    {
        $cv = $this->cv->read($this->data["id"]);
        if(count($cv) == 0)
        {
            return $this->create();
        }
        $full_name = htmlspecialchars(strip_tags($this->data["full_name"] ?? $cv["full_name"]));
        $job_title = htmlspecialchars(strip_tags($this->data["job_title"] ?? $cv["job_title"]));
        $email = htmlspecialchars(strip_tags($this->data["email"] ?? $cv["email"]));
        $phone = htmlspecialchars(strip_tags($this->data["phone"] ?? $cv["phone"]));
        $linkedin = htmlspecialchars(strip_tags($this->data["linkedin"] ?? $cv["linkedin"]));
        $github = htmlspecialchars(strip_tags($this->data["github"] ?? $cv["github"]));
        $summary = htmlspecialchars(strip_tags($this->data["summary"] ?? $cv["summary"]));
        $skills = htmlspecialchars(strip_tags($this->data["skills"] ?? $cv["skills"]));
        $experience = htmlspecialchars(strip_tags($this->data["experience"] ?? $cv["experience"]));
        $education = htmlspecialchars(strip_tags($this->data["education"] ?? $cv["education"]));
        $projects = htmlspecialchars(strip_tags($this->data["projects"] ?? $cv["projects"]));

        $data_to_validate = [
            "full_name" => $full_name,
            "email" => $email,
            "phone" => $phone,

        ];
        $validator = new Validator($data_to_validate, [
            'full_name' => 'required|min:10|max:100',
            'email' => 'email|min:10',
            'phone' => 'phone|min:11|max:11'
        ], $this->db->getConnection());
        if (!$validator->validate()) {
            http_response_code(401); //not authorized
            echo json_encode(['errors' => $validator->errors()], JSON_UNESCAPED_UNICODE);
            return;
        }

        if ($this->cv->update($this->data["id"], compact(
            "full_name",
            "job_title",
            "email",
            "phone",
            "location",
            "linkedin",
            "github",
            "summary",
            "skills",
            "experience",
            "education",
            "projects"
        ))) {
            return Helper::jsonResponse(["message" => "cv updated"]);
        } else {
            return Helper::jsonResponse(["error" => "Update failed"], 500);
        }
    }
}
