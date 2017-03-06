<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ArUserProfile
 *
 * @ORM\Table(name="ar_user_profile")
 * @ORM\Entity
 */
class ArUserProfile
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
     * @ORM\Column(name="user_description", type="string", length=2000, nullable=false)
     */
    private $userDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=10, nullable=false)
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=50, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=50, nullable=true)
     */
    private $country;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dob", type="date", nullable=true)
     */
    private $dob;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook_page_url", type="string", length=500, nullable=true)
     */
    private $facebookPageUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="twitter_page_url", type="string", length=500, nullable=true)
     */
    private $twitterPageUrl;

    /**
     * @var integer
     *
     * @ORM\Column(name="is_other_skill", type="integer", nullable=true)
     */
    private $isOtherSkill;

    /**
     * @var \ArArtistCategory
     *
     * @ORM\ManyToOne(targetEntity="ArArtistCategory")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="category_id")
     * })
     */
    private $category;

    /**
     * @var \ArArtistSubCategory
     *
     * @ORM\ManyToOne(targetEntity="ArArtistSubCategory")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sub_category_id", referencedColumnName="sub_category_id")
     * })
     */
    private $subCategory;

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
     * Set userDescription
     *
     * @param string $userDescription
     * @return ArUserProfile
     */
    public function setUserDescription($userDescription)
    {
        $this->userDescription = $userDescription;
    
        return $this;
    }

    /**
     * Get userDescription
     *
     * @return string 
     */
    public function getUserDescription()
    {
        return $this->userDescription;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return ArUserProfile
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    
        return $this;
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return ArUserProfile
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
     * Set country
     *
     * @param string $country
     * @return ArUserProfile
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
     * Set dob
     *
     * @param \DateTime $dob
     * @return ArUserProfile
     */
    public function setDob($dob)
    {
        $this->dob = $dob;
    
        return $this;
    }

    /**
     * Get dob
     *
     * @return \DateTime 
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * Set facebookPageUrl
     *
     * @param string $facebookPageUrl
     * @return ArUserProfile
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
     * @return ArUserProfile
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
     * Set isOtherSkill
     *
     * @param integer $isOtherSkill
     * @return ArUserProfile
     */
    public function setIsOtherSkill($isOtherSkill)
    {
        $this->isOtherSkill = $isOtherSkill;
    
        return $this;
    }

    /**
     * Get isOtherSkill
     *
     * @return integer 
     */
    public function getIsOtherSkill()
    {
        return $this->isOtherSkill;
    }

    /**
     * Set category
     *
     * @param \ArArtistCategory $category
     * @return ArUserProfile
     */
    public function setCategory(\ArArtistCategory $category = null)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return \ArArtistCategory 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set subCategory
     *
     * @param \ArArtistSubCategory $subCategory
     * @return ArUserProfile
     */
    public function setSubCategory(\ArArtistSubCategory $subCategory = null)
    {
        $this->subCategory = $subCategory;
    
        return $this;
    }

    /**
     * Get subCategory
     *
     * @return \ArArtistSubCategory 
     */
    public function getSubCategory()
    {
        return $this->subCategory;
    }

    /**
     * Set user
     *
     * @param \ArUsers $user
     * @return ArUserProfile
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
