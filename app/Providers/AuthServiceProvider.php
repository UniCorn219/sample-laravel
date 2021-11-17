<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     * @throws \Throwable
     */
    public function boot()
    {
        $this->registerPolicies();
        Auth::viaRequest('jwt', function (Request $request) {
            if (!empty($request->bearerToken())) {
                try {
                    $auth = JWT::decode($request->bearerToken(), config('jwt.jwt_service_key'), array('HS256'));
                    if (is_object($auth)) {
                        return User::find((int)$auth->id);
                    } else {
                        return null;
                    }
                } catch (Exception $e) {
                    return null;
                }
            }

            return null;
        });
    }
}
