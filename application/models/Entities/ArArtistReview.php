<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ArArtistReview
 *
 * @ORM\Table(name="ar_artist_review")
 * @ORM\Entity
 */
class ArArtistReview
{
    /**
     * @var integer
     *
     * @ORM\Column(name="review_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $reviewId;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="review_title", type="string", length=100, nullable=false)
     */
    private $reviewTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="reviewer_name", type="string", length=100, nullable=false)
     */
    private $reviewerName;

    /**
     * @var string
     *
     * @ORM\Column(name="review", type="string", length=500, nullable=false)
     */
    private $review;

    /**
     * @var float
     *
     * @ORM\Column(name="rating", type="float", nullable=false)
     */
    private $rating;

    /**
     * @var integer
     *
     * @ORM\Column(name="review_date", type="integer", nullable=false)
     */
    private $reviewDate;

    /**
     * @var \ArUsers
     *
     * @ORM\ManyToOne(targetEntity="ArUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="artist_id", referencedColumnName="id")
     * })
     */
    private $artist;


    /**
     * Get reviewId
     *
     * @return integer 
     */
    public function getReviewId()
    {
        return $this->reviewId;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return ArArtistReview
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set reviewTitle
     *
     * @param string $reviewTitle
     * @return ArArtistReview
     */
    public function setReviewTitle($reviewTitle)
    {
        $this->reviewTitle = $reviewTitle;
    
        return $this;
    }

    /**
     * Get reviewTitle
     *
     * @return string 
     */
    public function getReviewTitle()
    {
        return $this->reviewTitle;
    }

    /**
     * Set reviewerName
     *
     * @param string $reviewerName
     * @return ArArtistReview
     */
    public function setReviewerName($reviewerName)
    {
        $this->reviewerName = $reviewerName;
    
        return $this;
    }

    /**
     * Get reviewerName
     *
     * @return string 
     */
    public function getReviewerName()
    {
        return $this->reviewerName;
    }

    /**
     * Set review
     *
     * @param string $review
     * @return ArArtistReview
     */
    public function setReview($review)
    {
        $this->review = $review;
    
        return $this;
    }

    /**
     * Get review
     *
     * @return string 
     */
    public function getReview()
    {
        return $this->review;
    }

    /**
     * Set rating
     *
     * @param float $rating
     * @return ArArtistReview
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    
        return $this;
    }

    /**
     * Get rating
     *
     * @return float 
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set reviewDate
     *
     * @param integer $reviewDate
     * @return ArArtistReview
     */
    public function setReviewDate($reviewDate)
    {
        $this->reviewDate = $reviewDate;
    
        return $this;
    }

    /**
     * Get reviewDate
     *
     * @return integer 
     */
    public function getReviewDate()
    {
        return $this->reviewDate;
    }

    /**
     * Set artist
     *
     * @param \ArUsers $artist
     * @return ArArtistReview
     */
    public function setArtist(\ArUsers $artist = null)
    {
        $this->artist = $artist;
    
        return $this;
    }

    /**
     * Get artist
     *
     * @return \ArUsers 
     */
    public function getArtist()
    {
        return $this->artist;
    }
}
