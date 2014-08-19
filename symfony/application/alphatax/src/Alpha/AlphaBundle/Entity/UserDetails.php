<?php

namespace Alpha\AlphaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserDetails
 *
 * @ORM\Table(name="user_details")
 * @ORM\Entity
 */
class UserDetails
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
     * @ORM\Column(name="firstname", type="string", length=50)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="middlename", type="string", length=50)
     */
    private $middlename;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=50)
     */
    private $lastname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dob", type="date")
     */
    private $dob;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="text")
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="phonenumber_1", type="string", length=40)
     */
    private $phonenumber1;

    /**
     * @var string
     *
     * @ORM\Column(name="photo_file_name", type="string", length=50)
     */
    private $photoFileName;
    
    
    /**
    * desc - created for joining the user table
    * @ORM\OneToOne(targetEntity="User", inversedBy="details")
    * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
    */
    private $user;
    

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
     * Set firstname
     *
     * @param string $firstname
     * @return UserDetails
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    
        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set middlename
     *
     * @param string $middlename
     * @return UserDetails
     */
    public function setMiddlename($middlename)
    {
        $this->middlename = $middlename;
    
        return $this;
    }

    /**
     * Get middlename
     *
     * @return string 
     */
    public function getMiddlename()
    {
        return $this->middlename;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return UserDetails
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    
        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set dob
     *
     * @param \DateTime $dob
     * @return UserDetails
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
     * Set address
     *
     * @param string $address
     * @return UserDetails
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set phonenumber1
     *
     * @param string $phonenumber1
     * @return UserDetails
     */
    public function setPhonenumber1($phonenumber1)
    {
        $this->phonenumber1 = $phonenumber1;
    
        return $this;
    }

    /**
     * Get phonenumber1
     *
     * @return string 
     */
    public function getPhonenumber1()
    {
        return $this->phonenumber1;
    }

    /**
     * Set photoFileName
     *
     * @param string $photoFileName
     * @return UserDetails
     */
    public function setPhotoFileName($photoFileName)
    {
        $this->photoFileName = $photoFileName;
    
        return $this;
    }

    /**
     * Get photoFileName
     *
     * @return string 
     */
    public function getPhotoFileName()
    {
        return $this->photoFileName;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return UserDetails
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
     * @return UserDetails
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
     * Set user
     *
     * @param string $user
     * @return User
     */
    public function setUser($user)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return string 
     */
    public function getUser()
    {
        return $this->user;
    }
}