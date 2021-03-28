<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\Product;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use DB;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;


class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        Fortify::loginView(function () {
            return view('auth.login');
        });

        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return false;
            }

            if ($user->role_id !== 1) {
                return false;
            }

            if ($user->login_attempts >= 15 || $user->status == 'LOCKED') {
                $user->status = "LOCKED";
                $user->save();

                return false;
            }

            if ($user && Hash::check($request->password, $user->password)) {
                $user->login_attempts = 0;
                $user->status = 'ACTIVE';
                $user->save();

                return $user;
            } else {
                $user->increment('login_attempts');
                $user->save();
                return false;
            }

        });

        Fortify::registerView(function () {
            return view('auth.register');
        });

        Fortify::requestPasswordResetLinkView(function () {
            return view('auth.forgot');
        });

        Fortify::resetPasswordView(function ($request) {
            return view('auth.reset', ['request' => $request]);
        });

        Fortify::verifyEmailView(function (){
            return view('auth.verify-email');
        });
    }
}
