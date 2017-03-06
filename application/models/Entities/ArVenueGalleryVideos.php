<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ArVenueGalleryVideos
 *
 * @ORM\Table(name="ar_venue_gallery_videos")
 * @ORM\Entity
 */
class ArVenueGalleryVideos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="video_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $videoId;

    /**
     * @var string
     *
     * @ORM\Column(name="video_url", type="string", length=200, nullable=false)
     */
    private $videoUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="video_description", type="string", length=200, nullable=true)
     */
    private $videoDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="youtube_video_id", type="string", length=30, nullable=false)
     */
    private $youtubeVideoId;

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
     * Get videoId
     *
     * @return integer 
     */
    public function getVideoId()
    {
        return $this->videoId;
    }

    /**
     * Set videoUrl
     *
     * @param string $videoUrl
     * @return ArVenueGalleryVideos
     */
    public function setVideoUrl($videoUrl)
    {
        $this->videoUrl = $videoUrl;
    
        return $this;
    }

    /**
     * Get videoUrl
     *
     * @return string 
     */
    public function getVideoUrl()
    {
        return $this->videoUrl;
    }

    /**
     * Set videoDescription
     *
     * @param string $videoDescription
     * @return ArVenueGalleryVideos
     */
    public function setVideoDescription($videoDescription)
    {
        $this->videoDescription = $videoDescription;
    
        return $this;
    }

    /**
     * Get videoDescription
     *
     * @return string 
     */
    public function getVideoDescription()
    {
        return $this->videoDescription;
    }

    /**
     * Set youtubeVideoId
     *
     * @param string $youtubeVideoId
     * @return ArVenueGalleryVideos
     */
    public function setYoutubeVideoId($youtubeVideoId)
    {
        $this->youtubeVideoId = $youtubeVideoId;
    
        return $this;
    }

    /**
     * Get youtubeVideoId
     *
     * @return string 
     */
    public function getYoutubeVideoId()
    {
        return $this->youtubeVideoId;
    }

    /**
     * Set uploadDate
     *
     * @param integer $uploadDate
     * @return ArVenueGalleryVideos
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
     * @return ArVenueGalleryVideos
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
