<?php

namespace OAuth\Provider;

class Flickr extends \OAuth\OAuth1\Provider
{
    public $name = 'flickr';

    public function requestTokenUrl()
    {
        return 'http://www.flickr.com/services/oauth/request_token';
    }

    public function authorizeUrl()
    {
        return 'http://www.flickr.com/services/oauth/authorize';
    }

    public function accessTokenUrl()
    {
        return 'http://www.flickr.com/services/oauth/access_token';
    }

    public function getUserInfo()
    {
        // Create a new GET request with the required parameters
        $request = OAuth_Request::forge('resource', 'GET', 'http://api.flickr.com/services/rest', array(
            'oauth_consumer_key' => $consumer->key,
            'oauth_token' => $this->token->access_token,
            'nojsoncallback' => 1,
            'format' => 'json',
            'method' => 'flickr.test.login',
        ));

        // Sign the request using the consumer and token
        $request->sign($this->signature, $consumer, $this->token);

        $response = json_decode($request->execute(), true);

        // Create a response from the request
        return array(
            'uid' => $response['user']['id'],
            'name' => $response['user']['username']['_content'],
            'nickname' => $response['user']['username']['_content'],
        );
    }

} // End Provider_Flickr
