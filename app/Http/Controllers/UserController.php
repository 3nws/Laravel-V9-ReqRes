<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{

    private function _req($method, $url, array $params) {
        if ($method == "POST"){
            $response = Http::post($url, $params);
        } else if ($method == "PUT"){
            $response = Http::put($url, $params);
        } else {
            $response = Http::delete($url);
        }
        return json_decode($response->body());
    }

    public function user($id){
        $api_base = "https://reqres.in/api/";
        $users = session("users");
        foreach ($users as $idx => $user) {
            if ($user->id == $id){
                return view("user_detail", ["user" => $user]);
            }
        }
        try{
            $response = file_get_contents($api_base . "users/" . $id);
            $json_ = json_decode($response);
            $user = $json_->data;
            return view('user_detail', ['user' => $user]);
        } catch (\Exception $e){
        }
    }

    public function users(){
        if ($tmp = session("users")){
            $userslist = $tmp;
        } else {
            $api_base = "https://reqres.in/api/";
            $response = file_get_contents($api_base . "users?page=2");
            $json_ = json_decode($response);
            $userslist = $json_->data;
            foreach ($userslist as $idx => $user) {
                $user->name = $user->first_name . " " . $user->last_name;
            }
            session(["users" => $userslist]);
        }
        return view('users', ['userslist' => $userslist]);
    }

    public function add(){
        return view("user_create_form", [
            "name" => null,
            "operation" => 0
        ]);
    }

    public function create(Request $request){
        $api_base = "https://reqres.in/api/";
        $name = $request->input('name');
        $job = $request->input('job');
        $response = $this->_req("POST", $api_base . "users", array("name" => $name, "job" => $job));
        $date = $response->createdAt;
        $users = session("users");
        $new_user = new \stdClass();
        $new_user->id = $response->id;
        $new_user->createdAt = $date;
        $new_user->name = ($name) ? $name : "None";
        $new_user->job = $job;
        $new_user->email = " - ";
        $users[] = $new_user;
        session(["users" => $users]);
        return redirect()->route('list')->with("success", "User created at " . $date);
    }

    public function edit($id){
        $api_base = "https://reqres.in/api/";
        try{
            $response = file_get_contents($api_base . "users/" . $id);
            $json_ = json_decode($response);
            $user = $json_->data;
            return view("user_create_form", [
                "name" => $user->name,
                "id" => $id,
                "operation" => 1
            ]);
        } catch (\Exception $e){
            $users = session("users");
            foreach ($users as $idx => $user) {
                if ($user->id == $id){
                    return view("user_create_form", [
                        "name" => $user->name,
                        "id" => $id,
                        "operation" => 1
                    ]);
                }
            }
        }
        
    }

    public function update(Request $request, $id){
        $api_base = "https://reqres.in/api/";
        $name = $request->input('name');
        $job = $request->input('job');
        $response = $this->_req("PUT", $api_base . "users/" . $id, array("name" => $name, "job" => $job));
        $date = $response->updatedAt;
        $users = session("users");
        foreach ($users as $idx => $user) {
            if ($user->id == $id){
                $users[$idx]->name = ($name) ? $name : "None";
                $users[$idx]->job = $job;
                session(["users" => $users]);
            }
        }
        return redirect()->route('list')->with("success", "User updated " . $date);
    }

    public function delete($id){
        $api_base = "https://reqres.in/api/";
        $response = $this->_req("DELETE", $api_base . "users/" . $id, array());
        $users = session("users");
        foreach ($users as $idx => $user) {
            if ($user->id == $id){
                unset($users[$idx]);
                session(["users" => $users]);
            }
        }
        return redirect()->route('list')->with('success', 'User deleted.');
    }
}