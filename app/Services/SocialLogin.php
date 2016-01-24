<?php
namespace App\Services;

use Config;
use Redirect;
use Hybrid_Auth;
use Hybrid_Endpoint;

class SocialLogin
{
	public static function getSocialProfile($provider = null, $auth = null)
    {
        if($auth == 'auth') {
            try {
                Hybrid_Endpoint::process();
            } catch(Exception $e) {
                return Redirect::to('login');
            }
        return ;
        }
        if($provider) {
            if(Config::get('hybridauth.base_url') == "")
                self::setBaseUrl($provider);
            $oauth = new Hybrid_Auth(Config::get('hybridauth'));
            
            $adapter = $oauth->authenticate($provider);
            $profile = $adapter->getUserProfile();
            
            return $profile;
        }
        return null;
    }

    private static function setBaseUrl($provider = null)
    {
    	switch (strtolower($provider)) {
    		case 'google':
    			Config::set('hybridauth.base_url', 'http://www.blogspot.example.com/registers/login/google/auth');
    			break;
    		case 'facebook':
    			Config::set('hybridauth.base_url', 'http://www.blogspot.example.com/registers/login/facebook/auth');
    			break;
    		case 'twitter':
    			Config::set('hybridauth.base_url', 'http://www.blogspot.example.com/registers/login/twitter/auth');
    			break;
    	}
    }
}