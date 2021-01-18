<?php


namespace App;


class ViralLoopsConnector
{
    protected $apiToken;
    const REGISTRATION_URL = 'https://app.viral-loops.com/api/v2/events';
    const VL_GDPR_CONSENT_ID = 2;

    public function __construct($apiToken)
    {
        $this->apiToken = $apiToken;
    }

    public function register(ViralLoopsSignup $signup)
    {
        $data = [
            'apiToken' => $this->apiToken,
            'params' => [
                'event' => 'registration',
                'user' => [
                    'firstname' => $signup->getFirstname(),
                    'lastname' => $signup->getLastname(),
                    'email' => $signup->getEmail(),
                    'consents' => [static::VL_GDPR_CONSENT_ID => true],
                ]
            ]
        ];
        if (count($signup->getAdditionalData()) > 0) {
            $data['params']['user']['extraData'] = $signup->getAdditionalData();
        }
        if ($signup->getReferralCode() != null) {
            $data['params']['referrer'] = ['referralCode' => $signup->getReferralCode()];
        }
        if ($signup->getReferralSource() != null) {
            $data['params']['refSource'] = $signup->getReferralSource();
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