<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ArUserGalleryImages
 *
 * @ORM\Table(name="ar_user_gallery_images")
 * @ORM\Entity
 */
class ArUserGalleryImages
{
    /**
     * @var integer
     *
     * @ORM\Column(name="image_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $imageId;

    /**
     * @var string
     *
     * @ORM\Column(name="image_name", type="string", length=50, nullable=false)
     */
    private $imageName;

    /**
     * @var string
     *
     * @ORM\Column(name="image_description", type="string", length=200, nullable=true)
     */
    private $imageDescription;

    /**
     * @var integer
     *
     * @ORM\Column(name="upload_date", type="integer", nullable=false)
     */
    private $uploadDate;

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
     * Get imageId
     *
     * @return integer 
     */
    public function getImageId()
    {
        return $this->imageId;
    }

    /**
     * Set imageName
     *
     * @param string $imageName
     * @return ArUserGalleryImages
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
    
        return $this;
    }

    /**
     * Get imageName
     *
     * @return string 
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * Set imageDescription
     *
     * @param string $imageDescription
     * @return ArUserGalleryImages
     */
    public function setImageDescription($imageDescription)
    {
        $this->imageDescription = $imageDescription;
    
        return $this;
    }

    /**
     * Get imageDescription
     *
     * @return string 
     */
    public function getImageDescription()
    {
        return $this->imageDescription;
    }

    /**
     * Set uploadDate
     *
     * @param integer $uploadDate
     * @return ArUserGalleryImages
     */
    public function setUploadDate($uploadDate)
    {
        $this->uploadDate = $uploadDate;
    
        return $this;
    }

    /**
     * Get uploadDate
     *
     * @return integer 
     */
    public function getUploadDate()
    {
        return $this->uploadDate;
    }

    /**
     * Set user
     *
     * @param \ArUsers $user
     * @return ArUserGalleryImages
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
