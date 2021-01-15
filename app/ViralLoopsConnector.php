<?php


namespace App;


class ViralLoopsConnector
{
    protected $apiToken;
    const REGISTRATION_URL = 'https://app.viral-loops.com/api/v2/events';
    const VL_GDPR_CONSENT_ID = 2;

    public function __construct()
    {
        $this->apiToken = config('services.viralLoops.token');
    }

    public function register($firstname, $lastname, $email, $referralCode = null, $referralSource = null)
    {
        $data = [
            'apiToken' => $this->apiToken,
            'params' => [
                'event' => 'registration',
                'user' => [
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'email' => $email,
                    'consents' => [static::VL_GDPR_CONSENT_ID],
                ]
            ]
        ];
        if ($referralCode != null) {
            $data['params']['referrer'] = ['referralCode' => $referralCode];
        }
        if ($referralSource != null) {
            $data['params']['refSource'] = $referralSource;
        }
        $response = $this->postRequest(self::REGISTRATION_URL, $data);
        if ($response->successful()) {
            return $response->json()['referralCode'];
        } else {
            return false;
        }
    }

    protected function postRequest($url, $data)
    {
        return \Http::post($url, $data);
    }
}