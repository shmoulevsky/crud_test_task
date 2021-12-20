<?php

namespace App\Http\Controllers\ApiV1;

use App\Entities\User\AuthDTO;
use App\Entities\User\RegisterDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\AuthEmailRequest;
use App\Http\Requests\User\RegisterEmailRequest;
use App\Http\Resources\Author\AuthorCollection;
use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Services\User\AuthService;
use App\Services\User\RegisterService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private AuthService $authService;
    private RegisterService $registerService;
    private UserRepository $userRepository;

    public function __construct(
        AuthService $authService,
        RegisterService $registerService,
        UserRepository $userRepository
    )
    {

        $this->authService = $authService;
        $this->registerService = $registerService;
        $this->userRepository = $userRepository;
    }

    public function register(RegisterEmailRequest $request)
    {

        $registerDTO = new RegisterDTO(
            $request->name,
            $request->email,
            $request->password,
            $request->device_name
        );

        $token = $this->registerService->registerByEmail($registerDTO);
        return response()->json(['token' => $token], 201);
    }

    public function login(AuthEmailRequest $request)
    {
        $authDTO = new AuthDTO($request->email, $request->password, $request->device_name);
        $token = $this->authService->loginByEmail($authDTO);
        return response()->json(['token' => $token], 200);
    }

    public function index(Request $request)
    {
        $authors = $this->userRepository
            ->withCount()
            ->filterByArticlesCount($request->count)
            ->sortByArticlesCount($request->sort)
            ->paginate(User::getPageLimit());

        return new AuthorCollection($authors);
    }

}
