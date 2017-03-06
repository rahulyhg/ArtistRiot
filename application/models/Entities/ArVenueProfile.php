<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ArVenueProfile
 *
 * @ORM\Table(name="ar_venue_profile")
 * @ORM\Entity
 */
class ArVenueProfile
{
    /**
     * @var integer
     *
     * @ORM\Column(name="profile_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $profileId;

    /**
     * @var string
     *
     * @ORM\Column(name="venue_description", type="string", length=500, nullable=true)
     */
    private $venueDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=20, nullable=true)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=50, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook_page_url", type="string", length=400, nullable=true)
     */
    private $facebookPageUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="twitter_page_url", type="string", length=400, nullable=true)
     */
    private $twitterPageUrl;

    /**
     * @var integer
     *
     * @ORM\Column(name="fans", type="integer", nullable=true)
     */
    private $fans;

    /**
     * @var string
     *
     * @ORM\Column(name="capacity", type="string", length=40, nullable=true)
     */
    private $capacity;

    /**
     * @var string
     *
     * @ORM\Column(name="event_types", type="string", length=200, nullable=true)
     */
    private $eventTypes;

    /**
     * @var \ArUsers
     *
     * @ORM\ManyToOne(targetEntity="ArUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;


    /**
     * Get profileId
     *
     * @return integer 
     */
    public function getProfileId()
    {
        return $this->profileId;
    }

    /**
     * Set venueDescription
     *
     * @param string $venueDescription
     * @return ArVenueProfile
     */
    public function setVenueDescription($venueDescription)
    {
        $this->venueDescription = $venueDescription;
    
        return $this;
    }

    /**
     * Get venueDescription
     *
     * @return string 
     */
    public function getVenueDescription()
    {
        return $this->venueDescription;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return ArVenueProfile
     */
    public function setCountry($country)
    {
        $this->country = $country;
    
        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return ArVenueProfile
     */
    public function setCity($city)
    {
        $this->city = $city;
    
        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set facebookPageUrl
     *
     * @param string $facebookPageUrl
     * @return ArVenueProfile
     */
    public function setFacebookPageUrl($facebookPageUrl)
    {
        $this->facebookPageUrl = $facebookPageUrl;
    
        return $this;
    }

    /**
     * Get facebookPageUrl
     *
     * @return string 
     */
    public function getFacebookPageUrl()
    {
        return $this->facebookPageUrl;
    }

    /**
     * Set twitterPageUrl
     *
     * @param string $twitterPageUrl
     * @return ArVenueProfile
     */
    public function setTwitterPageUrl($twitterPageUrl)
    {
        $this->twitterPageUrl = $twitterPageUrl;
    
        return $this;
    }

    /**
     * Get twitterPageUrl
     *
     * @return string 
     */
    public function getTwitterPageUrl()
    {
        return $this->twitterPageUrl;
    }

    /**
     * Set fans
     *
     * @param integer $fans
     * @return ArVenueProfile
     */
    public function setFans($fans)
    {
        $this->fans = $fans;
    
        return $this;
    }

    /**
     * Get fans
     *
     * @return integer 
     */
    public function getFans()
    {
        return $this->fans;
    }

    /**
     * Set capacity
     *
     * @param string $capacity
     * @return ArVenueProfile
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;
    
        return $this;
    }

    /**
     * Get capacity
     *
     * @return string 
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * Set eventTypes
     *
     * @param string $eventTypes
     * @return ArVenueProfile
     */
    public function setEventTypes($eventTypes)
    {
        $this->eventTypes = $eventTypes;
    
        return $this;
    }

    /**
     * Get eventTypes
     *
     * @return string 
     */
    public function getEventTypes()
    {
        return $this->eventTypes;
    }

    /**
     * Set user
     *
     * @param \ArUsers $user
     * @return ArVenueProfile
     */
    public function setUser(\ArUsers $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \ArUsers 
     */
    public function getUser()
    {
        return $this->user;
    }
}
