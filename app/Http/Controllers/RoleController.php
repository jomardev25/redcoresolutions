<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Http\Requests\RoleRequest;
class RoleController extends Controller
{
    const ENTITY = 'Role';

    public function index()
    {
        $roles = Role::query()->select(["id", "name", "description"])->filter();
        return $this->vueTableResponse($roles->toArray());
    }

    public function store(RoleRequest $request)
    {
        $validated = $request->validated();
        $this->transaction(function() use($validated){
            Role::create($validated);
        });
        return $this->successResponse([], __('status.create', ['entity' => self::ENTITY]));
    }

    public function show(Role $role)
    {
        return $this->successResponse($role->only('id', 'name', 'description'));
    }

    public function edit(Role $role)
    {
        return $this->successResponse($role->only('id', 'name', 'description'));
    }

    public function update(RoleRequest $request, Role $role)
    {
        $validated = $request->validated();
        $this->transaction(function() use($role, $validated){
            $role->update($validated);
        });
        return $this->successResponse([], __('status.update', ['entity' => self::ENTITY]));
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return $this->successResponse([], __('status.delete', ['entity' => self::ENTITY]));
    }
}
