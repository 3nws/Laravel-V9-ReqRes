<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{

    private $api_base;
    private $total_pages;
    private $paginated_cached_data;
        
    /**
     * Runs with every request and refreshes the cache. Probably not optimal.
     *
     * @return void
     */
    public function __construct(){
        $this->api_base = "https://reqres.in/api/";
        $response = file_get_contents($this->api_base . "users?page=1");
        $json_ = json_decode($response);
        $userslist = $json_->data;
        foreach ($userslist as $idx => $user) {
            $user->name = $user->first_name . " " . $user->last_name;
        }
        $this->total_pages = $json_->total_pages;
        // Cache the values from the API response. This is a pattern that repeats in other routes as well.
        if ($this->total_pages >= 2){
            for ($i=2; $i <=$this->total_pages; $i++) {
                $response = file_get_contents($this->api_base . "users?page=" . $i);
                $json_ = json_decode($response);
                $tmp = $json_->data;
                foreach ($tmp as $idx => $user) {
                    $user->name = $user->first_name . " " . $user->last_name;
                    $userslist[] = $user;
                }
            }
        }
        $this->paginated_cached_data = array_chunk($userslist, 10, true);
        session(["users" => $userslist]);
    }
    
    private function _req($method, $url, array $params=array()) {
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
        $users = session("users");
        foreach ($users as $idx => $user) {
            if ($user->id == $id){
                return view("user_detail", ["user" => $user]);
            }
        }
    }

    public function users($page_number=1){
        if ($page_number-1 > $this->total_pages){
            $page_number = $this->total_pages;
        } else if ($page_number-1 <= 0) {
            $page_number = 1;
        }

        // Correct the total page number for pagination.
        $this->total_pages = (int)(sizeof(session("users")) / 10) + 1;
        if (sizeof(session("users")) % 10 == 0){
            $this->total_pages--;
        }
        return view("users", [
            "userslist" => array_chunk(session("users"), 10, true)[$page_number-1], 
            "total_pages" => $this->total_pages,
            "cur_page_number" => (int)$page_number,
        ]);
    }

    public function add(){
        return view("user_addit_form", [
            "name" => null,
            "operation" => 0
        ]);
    }

    public function create(Request $request){
        $name = $request->input("name");
        $job = $request->input("job");
        $response = $this->_req("POST", $this->api_base . "users", array("name" => $name, "job" => $job));
        $date = $response->createdAt;

        // Push the newly created user onto the cache.
        $users = session("users");
        $new_user = new \stdClass();
        $new_user->id = $response->id;
        $new_user->createdAt = $date;
        $new_user->name = ($name) ? $name : "None";
        $new_user->job = $job;
        $new_user->email = " - ";
        $new_user->avatar = "";
        $users[] = $new_user;
        session(["users" => $users]);
        $this->paginated_cached_data = array_chunk($users, 10, true);

        // Handle total page number after addition.
        $this->total_pages = (int)(sizeof($users) / 10) + 1;
        return redirect()->route("list")->with("success", "User created at " . $date);
    }

    /**
     * If the user id is not present on the API, use the cached value.
     *
     * @param  mixed $id
     * @return void
     */
    public function edit($id){
        try{
            $response = file_get_contents($this->api_base . "users/" . $id);
            $json_ = json_decode($response);
            $user = $json_->data;
            return view("user_addit_form", [
                "name" => $user->name,
                "id" => $id,
                "operation" => 1
            ]);
        } catch (\Exception $e){
            $users = session("users");
            foreach ($users as $idx => $user) {
                if ($user->id == $id){
                    return view("user_addit_form", [
                        "name" => $user->name,
                        "id" => $id,
                        "operation" => 1
                    ]);
                }
            }
        }
    }

    public function update(Request $request, $id){
        $name = $request->input("name");
        $job = $request->input("job");
        $response = $this->_req("PUT", $this->api_base . "users/" . $id, array("name" => $name, "job" => $job));
        $date = $response->updatedAt;
        $users = session("users");
        
        // Update the values in the cache.
        foreach ($users as $idx => $user) {
            if ($user->id == $id){
                $users[$idx]->name = ($name) ? $name : "None";
                $users[$idx]->job = $job;
            }
        }
        session(["users" => $users]);
        $this->paginated_cached_data = array_chunk($users, 10, true);
        return redirect()->route("list")->with("success", "User updated " . $date);
    }

    public function delete($id){
        $response = $this->_req("DELETE", $this->api_base . "users/" . $id);
        $users = session("users");
        foreach ($users as $idx => $user) {
            if ($user->id == $id){
                unset($users[$idx]);
            }
        }
        session(["users" => $users]);
        $this->paginated_cached_data = array_chunk($users, 10, true);

        // Handle total page number after deletion.
        $this->total_pages = (int)(sizeof($users) / 10) + 1;
        return redirect()->route("list")->with("success", "User deleted.");
    }
}