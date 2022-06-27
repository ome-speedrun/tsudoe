<?php

namespace App\Http\Controllers;

use App\Exceptions\Values\InvalidValueException;
use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Resources\Responses\UserResponse;
use App\Usecases\Users\Exceptions\IdentifierIsDuplicatedException;
use App\Usecases\Users\FindUser;
use App\Usecases\Users\RegisterNewUser;
use App\Values\Users\UserId;
use Illuminate\Http\Request;

class UsersResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function store(
        StoreUserRequest $request,
        RegisterNewUser $registerNewUser,
    ) {
        try {
            $registered = $registerNewUser->execute($request->getIdentifier());
        } catch (IdentifierIsDuplicatedException $e) {
            return response()->noContent(422);
        }
        return new UserResponse($registered);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(
        string $id,
        FindUser $findUser,
    ) {
        try {
            $identifier = new UserId($id);
        } catch (InvalidValueException $e) {
            return response()->noContent(404);
        }

        $user = $findUser->execute($identifier);

        return $user ? new UserResponse($user) : response()->noContent(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
