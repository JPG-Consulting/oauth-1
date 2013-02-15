<?php

namespace OAuth\Provider;

class Dropbox extends \OAuth\OAuth1\Provider
{
    public $name = 'dropbox';

    public function requestTokenUrl()
    {
        return 'https://api.dropbox.com/1/oauth/request_token';
    }

    public function authorizeUrl()
    {
        return 'http://www.dropbox.com/1/oauth/authorize';
    }

    public function accessTokenUrl()
    {
        return 'https://api.dropbox.com/1/oauth/access_token';
    }

    public function getUserInfo()
    {
        // Create a new GET request with the required parameters
        $request = OAuth_Request::forge('resource', 'GET', 'https://api.dropbox.com/1/account/info', array(
            'oauth_consumer_key' => $consumer->key,
            'oauth_token' => $token->access_token,
        ));

        // Sign the request using the consumer and token
        $request->sign($this->signature, $consumer, $token);

        $user = json_decode($request->execute());

        // Create a response from the request
        return array(
            'uid' => $token->uid,
            'name' => $user->display_name,
            'email' => $user->email,
            'location' => $user->country,
        );
    }

} // End Provider_Dropbox
