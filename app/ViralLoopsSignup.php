<?php


namespace App;


class ViralLoopsSignup
{
    protected $firstname = null;
    protected $lastname = null;
    protected $email = null;
    protected $additionalData = [];
    protected $referralCode = null;
    protected $referralSource = null;

    public function __construct($firstname, $lastname, $email)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
    }

    /**
     * @return array
     */
    public function getAdditionalData(): array
    {
        return $this->additionalData;
    }

    /**
     * @param array $additionalData
     * @return ViralLoopsSignup
     */
    public function setAdditionalData(array $additionalData): ViralLoopsSignup
    {
        $this->additionalData = $additionalData;
        return $this;
    }

    /**
     * @param null $referralCode
     * @return ViralLoopsSignup
     */
    public function setReferralCode($referralCode)
    {
        $this->referralCode = $referralCode;
        return $this;
    }

    /**
     * @param null $referralSource
     * @return ViralLoopsSignup
     */
    public function setReferralSource($referralSource)
    {
        $this->referralSource = $referralSource;
        return $this;
    }

    /**
     * @return null
     */
    public function getReferralCode()
    {
        return $this->referralCode;
    }

    /**
     * @return null
     */
    public function getReferralSource()
    {
        return $this->referralSource;
    }

    /**
     * @return null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return null
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @return null
     */
    public function getLastname()
    {
        return $this->lastname;
    }
}