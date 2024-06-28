<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class User extends Model
{
    //
    static public function authUser($username, $password) {
  		return getCurl('get.admin.auth', 'json',["pEmailId" => $username, "pPassword" =>$password ]);
    }
}
