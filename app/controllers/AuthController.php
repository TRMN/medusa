<?php

class AuthController extends BaseController {
    public function signin( $email, $password ) {
        // fetch the user record from the database that matches the email

        // if found, compare the password to the hashed password of the record

        // if successful, return the user record
    }
}