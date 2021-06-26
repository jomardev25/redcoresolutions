<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserRequest;
class UserController extends Controller
{
    const ENTITY = 'User';

    public function index()
    {
        $user = User::join('roles', 'roles.id', '=', 'users.role_id')
                    ->select('users.id', 'users.name', 'email', 'roles.name as role')
                    ->filter();
        return $this->vueTableResponse($user->toArray());
    }

    public function create()
    {
        $userViewModel = (new \App\ViewModels\UserViewModel)->toArray();
        return $this->successResponse(array_only($userViewModel, ['roles']), '');
    }

    public function store(UserRequest $request)
    {
        $validated = $request->validated();
        $this->transaction(function() use($validated){
            $user = new User;
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->role_id = $validated['role_id'];
            $user->password = bcrypt($validated['password']);
            $user->save();
            $filename = $user->id . '_' . now()->timestamp . '.png';
            $path = create_upload_folder('avatars', false, true);
            $avatarPath = $path.'/'.$filename;
            $uploadPath = 'storage/uploads/avatars/'.$filename;
            \Avatar::create($validated['name'])->save($avatarPath);
            $user->avatar = $uploadPath;
            $user->save();
        });
        return $this->successResponse($validated, __('status.create', ['entity' => self::ENTITY]));
    }

    public function show($id)
    {
        $userViewModel = (new \App\ViewModels\UserViewModel($id))->toArray();
        return $this->successResponse(array_only($userViewModel, ['user']));
    }

    public function edit($id)
    {
        $userViewModel = (new \App\ViewModels\UserViewModel($id))->toArray();
        return $this->successResponse($userViewModel);
    }

    public function update(UserRequest $request, User $user)
    {
        $validated = $request->validated();
        $this->transaction(function() use($user, $validated){
            $user->update($validated);
        });

        return $this->successResponse([], __('status.update', ['entity' => self::ENTITY]));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return $this->successResponse([], __('status.delete', ['entity' => self::ENTITY]));
    }
}
