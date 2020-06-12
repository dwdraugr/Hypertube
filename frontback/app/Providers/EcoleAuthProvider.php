<?php

namespace App\Providers;

use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\User;

class EcoleAuthProvider extends AbstractProvider implements ProviderInterface {

    /**
     * @inheritDoc
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase('https://api.intra.42.fr/oauth/authorize', $state);
    }

    /**
     * @inheritDoc
     */
    protected function getTokenUrl()
    {
        return 'https://api.intra.42.fr/oauth/token';
    }

    /**
     * @inheritDoc
     */
    protected function getUserByToken($token)
    {
        $userURL = 'https://api.intra.42.fr/v2/me';
        $response = $this->getHttpClient()->get($userURL, [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);
        return json_decode($response->getBody(), true);
    }

    /**
     * @inheritDoc
     */
    protected function mapUserToObject(array $user)
    {
        return (new User)->setRaw($user)->map([
            'id' => $user['id'],
            'nickname' => $user['login'],
            'email' => $user['email'],
        ]);
    }

    protected function getTokenFields($code)
    {
        return [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'code' => $code,
            'redirect_uri' => $this->redirectUrl,
            'grant_type' => 'authorization_code',
        ];
    }
}
