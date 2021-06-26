<?php

namespace App\ViewModels;

use App\ViewModels\BaseViewModel;
use App\Models\Role;
use App\User;

class UserViewModel extends BaseViewModel
{
    private $id;
    
	public function __construct(int $id = null)
	{
		$this->id = $id;
	}

	public function user()
	{   
		return is_null($this->id) ? null : User::with('role:id,name,description')->find($this->id, ['id', 'name', 'email', 'role_id']);
    }
    
    public function roles()
    {
        return Role::all(['id', 'name', 'description']);
    }	
}