<?php


namespace App\Http\Controllers\Api;


class UserController extends BaseController
{

    public function index()
    {
        return User::all();
    }

    public function show($id)
    {
        return User::findOrFail($id);

        return $this->response->item($user, new UserTransformer);
    }
}