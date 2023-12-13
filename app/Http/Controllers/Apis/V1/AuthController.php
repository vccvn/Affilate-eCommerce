<?php

namespace App\Http\Controllers\Apis\V1;

use App\Http\Controllers\Apis\ApiController;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Users\UserRepository;
use Carbon\Carbon;
use Exception;
use Gomee\Mailer\Email;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\RefreshTokenRepository;
use Laravel\Passport\TokenRepository;


class AuthController extends ApiController
{

    /**
     * user repository
     *
     * @var UserRepository
     */
    public $repository;
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
        $this->init();
    }


    public function register(Request $request)
    {
        extract($this->apiDefaultData);
        $validator = $this->repository->validator($request, 'Auth\Register');
        $errors = [];
        if (!$validator->success()) {
            $message = "Hình như có gì đó chưa đúng lắm! Hãy kiểm tra lại thông tin!";
            $errors = $validator->errors();
        } else {
            $userData = $validator->inputs();
            $userData['status'] = 0;
            if (!($user = $this->repository->create($userData))) {
                $message = "Lỗi không xác định";
            } else {
                $status = true;
                $this->sendVerifyEmailByUser($user, 'Xin chúc mừng bạn đã đăng ký thành công!');
            }
        }
        return $this->json(compact(...$this->apiSystemVars));
    }


    /**
     * gửi email xác thực từ thông tin người dùng
     *
     * @param \App\Models\User|\App\Masks\Users\UserMask $user
     * @param string $message
     * @return \Illuminate\Support\Facades\Redirect
     */
    protected function sendVerifyEmailByUser($user, $message = null)
    {
        if ($emailToken = $this->emailTokens->createToken($user->email, 'verify', 'account')) {
            $data = [
                'url' => route('client.account.verify-email', [
                    'token' => $emailToken->token
                ]),
                'code' => $emailToken->code,
                'email' => $user->email,
                'user' => $user
            ];
            try {


                // Email::from(siteinfo()->email('no-reply@' . get_non_www_domain()), siteinfo()->site_name('Gomee Support'))
                //     ->to($user->email, $user->name)
                //     ->subject("Xác minh email")
                //     ->body('mails.verify-email')
                //     ->data($data)
                //     ->sendAfter(1);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
    }

    /**
     * @Description
     *
     * @Author TungND
     * @Date   Jun 05, 2022
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = request(['username', 'password']);
        if (!Auth::attempt($credentials))
            throw new Exception('Unauthorized', 401);

        $user        = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token       = $tokenResult->token;
        if ($request->remember_me ?? null) {
            $token->expires_at = Carbon::now()->addWeeks();
            $token->save();
        }

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type'   => 'Bearer',
            'expires_in'   => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    /**
     * @Description
     *
     * @Author TungND
     * @Date   Jun 05, 2022
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $tokenId = Auth::guard('api')->user()->token()->id;

        $tokenRepository        = app(TokenRepository::class);
        $refreshTokenRepository = app(RefreshTokenRepository::class);

        $tokenRepository->revokeAccessToken($tokenId);
        $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($tokenId);

        return response()->json(['message' => 'You have been successfully logged out!']);
    }
}
