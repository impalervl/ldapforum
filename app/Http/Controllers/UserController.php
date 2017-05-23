<?php

namespace App\Http\Controllers;

use Adldap\AdldapInterface;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Adldap\Laravel\Facades\Adldap;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    protected $adldap;

    /**
     * Constructor.
     *
     * @param AdldapInterface $adldap
     */
    public function __construct(AdldapInterface $adldap)
    {
        $this->adldap = $adldap;
    }

    /**
     * Displays the all LDAP users.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view ('auth.login');

    }


    public function login(Request $request)
    {
        $credentials = $request->only(['username', 'password']);

        try {

            if ($this->adldap->auth()->attempt($credentials['username'],$credentials['password'])) {

                $user = User::where('username', $credentials['username']."@contoso.com")->first();
                $ldap_user = $this->adldap->search()->users()->find($credentials['username']);

                if(isset($user)){

                    //сравнить данные модели пользвоателся приложения и ldap при отличии обновить пользователя в приложении
                    Auth::login($user);

                    return redirect('/');
                }
                else{

                    $ldap_user = $this->adldap->search()->users()->find($credentials['username']);

                    $query['name'] = $ldap_user->getDisplayName();
                    $query['username'] = $ldap_user->getUserPrincipalName();
                    $query['password'] = bcrypt($credentials['password']);


                    $user = User::create($query);

                    Auth::login($user);

                    return redirect('/');
                }


            }
            else{

                return redirect('/login');
            }

        } catch (Exception $e) {
            return redirect()->back()->withErrors('Connection is missing');
        }

    }

    public function logout(){

        Auth::logout();

        return redirect('/login');
    }


}
