<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ArArtistRating
 *
 * @ORM\Table(name="ar_artist_rating")
 * @ORM\Entity
 */
class ArArtistRating
{
    /**
     * @var integer
     *
     * @ORM\Column(name="rating_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ratingId;

    /**
     * @var float
     *
     * @ORM\Column(name="rating", type="float", nullable=false)
     */
    private $rating;

    /**
     * @var integer
     *
     * @ORM\Column(name="num_votes", type="integer", nullable=false)
     */
    private $numVotes;

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
     * Get ratingId
     *
     * @return integer 
     */
    public function getRatingId()
    {
        return $this->ratingId;
    }

    /**
     * Set rating
     *
     * @param float $rating
     * @return ArArtistRating
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
     * Set numVotes
     *
     * @param integer $numVotes
     * @return ArArtistRating
     */
    public function setNumVotes($numVotes)
    {
        $this->numVotes = $numVotes;
    
        return $this;
    }

    /**
     * Get numVotes
     *
     * @return integer 
     */
    public function getNumVotes()
    {
        return $this->numVotes;
    }

    /**
     * Set artist
     *
     * @param \ArUsers $artist
     * @return ArArtistRating
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
