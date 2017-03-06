<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ArArtistSubCategory
 *
 * @ORM\Table(name="ar_artist_sub_category")
 * @ORM\Entity
 */
class ArArtistSubCategory
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sub_category_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $subCategoryId;

    /**
     * @var string
     *
     * @ORM\Column(name="sub_category_name", type="string", length=50, nullable=false)
     */
    private $subCategoryName;

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
     * Get subCategoryId
     *
     * @return integer 
     */
    public function getSubCategoryId()
    {
        return $this->subCategoryId;
    }

    /**
     * Set subCategoryName
     *
     * @param string $subCategoryName
     * @return ArArtistSubCategory
     */
    public function setSubCategoryName($subCategoryName)
    {
        $this->subCategoryName = $subCategoryName;
    
        return $this;
    }

    /**
     * Get subCategoryName
     *
     * @return string 
     */
    public function getSubCategoryName()
    {
        return $this->subCategoryName;
    }

    /**
     * Set category
     *
     * @param \ArArtistCategory $category
     * @return ArArtistSubCategory
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
}
