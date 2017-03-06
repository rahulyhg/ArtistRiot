<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ArVenueCategory
 *
 * @ORM\Table(name="ar_venue_category")
 * @ORM\Entity
 */
class ArVenueCategory
{
    /**
     * @var integer
     *
     * @ORM\Column(name="category_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $categoryId;

    /**
     * @var string
     *
     * @ORM\Column(name="event_type", type="string", length=30, nullable=false)
     */
    private $eventType;


    /**
     * Get categoryId
     *
     * @return integer 
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * Set eventType
     *
     * @param string $eventType
     * @return ArVenueCategory
     */
    public function setEventType($eventType)
    {
        $this->eventType = $eventType;
    
        return $this;
    }

    /**
     * Get eventType
     *
     * @return string 
     */
    public function getEventType()
    {
        return $this->eventType;
    }
}
