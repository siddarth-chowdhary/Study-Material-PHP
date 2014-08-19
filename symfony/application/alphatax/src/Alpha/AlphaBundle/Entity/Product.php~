<?php

namespace Alpha\AlphaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity
 */
class Product
{
    /**
     * @author siddarth
     * desc - for setting the created and updated values dynamically
     */
    public function __construct()
    {
        $this->setCreated(new \DateTime());
        $this->setUpdated(new \DateTime());
    }
    
    /**
     * @ORM\PreUpdate
     * desc - this function will automatically set the updated time before 
     * updating the entity
     */
    public function setUpdatedValue()
    {
       $this->setUpdated(new \DateTime());
    }
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="product_file_name", type="string", length=50)
     */
    private $productFileName;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;
    
    /**
    * desc - created for joining the brand table ,one way only
    * @ORM\OneToOne(targetEntity="Brand")
    * @ORM\JoinColumn(name="brand_id", referencedColumnName="id")
    */
    private $brand;
    
    /**
    * desc - created for joining the category table ,one way only
    * @ORM\OneToOne(targetEntity="Category")
    * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
    */
    private $category;
    

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updated;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set productFileName
     *
     * @param string $productFileName
     * @return Product
     */
    public function setProductFileName($productFileName)
    {
        $this->productFileName = $productFileName;
    
        return $this;
    }

    /**
     * Get productFileName
     *
     * @return string 
     */
    public function getProductFileName()
    {
        return $this->productFileName;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return Product
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Product
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Product
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set brand
     *
     * @param \Alpha\AlphaBundle\Entity\Brand $brand
     * @return Product
     */
    public function setBrand(\Alpha\AlphaBundle\Entity\Brand $brand = null)
    {
        $this->brand = $brand;
    
        return $this;
    }

    /**
     * Get brand
     *
     * @return \Alpha\AlphaBundle\Entity\Brand 
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set category
     *
     * @param \Alpha\AlphaBundle\Entity\Category $category
     * @return Product
     */
    public function setCategory(\Alpha\AlphaBundle\Entity\Category $category = null)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return \Alpha\AlphaBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }
}