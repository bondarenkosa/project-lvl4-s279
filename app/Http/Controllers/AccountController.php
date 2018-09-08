<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\AccountRequest;
use Illuminate\Support\Facades\Password;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for editing account.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = auth()->user();

        return view('account.edit', compact('user'));
    }

    /**
     * Update user account.
     *
     * @param  \App\Http\Requests\AccountRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(AccountRequest $request)
    {
        $updated = auth()->user()->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        if ($updated) {
            flash('Your account has been successfully updated')->success()->important();
            return redirect('home');
        } else {
            flash('Something went wrong')->error()->important();
            return back();
        }
    }

    /**
     * Remove user.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $deleted = auth()->user()->delete();

        if ($deleted) {
            flash('Your account has been successfully deleted')->success()->important();
        } else {
            flash('Something went wrong')->error()->important();
        }

        return redirect('/');
    }

    /**
     * Send password reset Email.
     *
     * @return \Illuminate\Http\Response
     */
    public function changePassword()
    {
        $response = Password::sendResetLink(['email' => auth()->user()->email]);
        $message = trans($response);

        $response === Password::RESET_LINK_SENT ? flash($message)->success() : flash($message)->error();

        return redirect('home');
    }
}
