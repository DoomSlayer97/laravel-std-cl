<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;

class ProjectController extends Controller
{

    public function create(Request $req) {

        $bodyParams = $req -> only(
            "name", 
            "description",
            "userId"
        );

        $validation = validator($bodyParams, [
            "name"                  =>          "required|string",
            "description"           =>          "required|string",
            "userId"                =>          "required|integer",
        ]);

        if ($validation -> fails()) return response([
            "message"               =>              "invalid_params",
            "errors"                =>              $validation -> errors()
        ], 500);

        $newProject = new Project($bodyParams);

        $newProject -> user() -> associate(User::find($bodyParams["userId"]));

        if (!$newProject -> save()) return response([
            "message"           =>          "create_error"
        ], 500);
        
        return response([
            "message"               =>              "create",
            "project"               =>              $newProject
        ], 201);

    }

    public function findAll() {

        $projects = Project::where("isDeleted", false)
            -> get();

        return response([
            "project"               =>              $projects
        ]);

    }

    public function findOne(int $id) {

        $project = Project::find($id)
            -> with("user")
            -> get();

        if(!$project) return response([
            "message"           =>              "not_founded"
        ], 404);

        return response([
            "project"               =>              $project
        ]);

    }

    public function update(Request $req, int $id) {

        $bodyParams = $req -> only("name", "description");

        $validation = validator($bodyParams, [
            "name"                  =>          "required|string",
            "description"           =>          "required|string"
        ]);

        if ($validation -> fails()) return response([
            "message"               =>              "invalid_params",
            "errors"                =>              $validation -> errors()
        ], 500);

        $project = Project::find($id);

        $project -> name = $bodyParams["name"];
        $project -> description = $bodyParams["description"];

        if (!$project -> save()) return response([
            "message"           =>          "create_error"
        ], 500);

        return response([
            "message"               =>          "project_updated",
            "projects"              =>          $project
        ]);

    }

    public function delete($id) {

        if (!$id) return response([
            "message"               =>             "id_required"
        ], 500);

        $project = Project::id($id);

        $project -> isDeleted = false;

        if (!$project -> save()) return response([
            "message"               =>              "delete_error"
        ], 500);

        return response([
            "message"               =>               "deleted"
        ], 200);

    }
    

}
