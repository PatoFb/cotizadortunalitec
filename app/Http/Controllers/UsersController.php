<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\UsersCreateRequest;
use App\Http\Requests\UsersEditRequest;
use App\Http\Requests\UsersPasswordRequest;
use App\Http\Requests\UsersRequest;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('name')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function search(Request $request)
    {
        $input = $request->input('partner_id');
        if($input != null) {
            $users = User::orderBy('name')->where('partner_id', $input)->get();
        } else {
            $users = User::orderBy('name')->paginate(20);
        }
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'id')->all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersCreateRequest $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($request->password);
        User::create($input);
        return redirect('/admin/users')->withStatus(__('Usuario añadido correctamente'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles = Role::pluck('name', 'id')->all();
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $userUpdateRequest = new UsersEditRequest($user->id);

        $validatedData = $request->validate($userUpdateRequest->rules(), $userUpdateRequest->messages());
        $user->update($validatedData);

        return back()->withStatus(__('Perfil actualizado correctamente.'));
    }

    /**
     * Update the address
     *
     * @param  AddressRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function address(AddressRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());

        return back()->withStatus(__('Dirección actualizada correctamente.'));
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\UsersPasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(UsersPasswordRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update(['password' => Hash::make($request->get('password'))]);

        return back()->withStatusPassword(__('Constraseña actualizada correctamente.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('userCheck');
        $user->delete();
        return redirect('/admin/users')->withStatus('Usuario eliminado correctamente');
    }
}
