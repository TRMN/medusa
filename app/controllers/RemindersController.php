<?php

class RemindersController extends \BaseController {

	/**
	 * Display the password reminder view.
	 *
	 * @return Response
	 */
	public function getRemind()
	{
		return View::make('password.remind');
	}

	/**
	 * Handle a POST request to remind a user of their password.
	 *
	 * @return Response
	 */
	public function postRemind()
	{
        $response = Password::remind(
            strtolower(Input::only('email_address')),
            function ($message) {
                $message->subject('TRMN Password Reset');
            }
        );

		switch ($response)
		{
			case Password::INVALID_USER:
				return Redirect::back()->with('message', Lang::get($response));

			case Password::REMINDER_SENT:
				return Redirect::back()->with('message', Lang::get($response));
		}
	}

	/**
	 * Display the password reset view for the given token.
	 *
	 * @param  string  $token
	 * @return Response
	 */
	public function getReset($token = null)
	{
		if (is_null($token)) App::abort(404);

		return View::make('password.reset')->with('token', $token);
	}

	/**
	 * Handle a POST request to reset a user's password.
	 *
	 * @return Response
	 */
	public function postReset()
	{
		$credentials = Input::only(
			'email_address', 'password', 'password_confirmation', 'token'
		);

        $credentials['email_address'] = strtolower($credentials['email_address']);

		$response = Password::reset($credentials, function($user, $password)
		{
			$user->password = Hash::make($password);

            $this->writeAuditTrail(
                'password reset from ' . Request::ip(),
                'update',
                'users',
                (string)$user->_id,
                'Password Update',
                'RemindersController@postReset'
            );

			$user->save();
		});

		switch ($response)
		{
			case Password::INVALID_PASSWORD:
			case Password::INVALID_TOKEN:
			case Password::INVALID_USER:
				return Redirect::back()->with('message', Lang::get($response));

			case Password::PASSWORD_RESET:
				return Redirect::to('/')->with('message', 'Your password has been reset.  You may now login');
		}
	}

}
