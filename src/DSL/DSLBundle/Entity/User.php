<?php

namespace DSL\DSLBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="DSL\DSLBundle\Repository\UserRepository")
 */
class User extends BaseUser
 {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /** @ORM\Column(name="facebook_id", type="string", length=255, nullable=true) */
    protected $facebook_id;
    
    /** @ORM\Column(name="facebook_access_token", type="string", length=255, nullable=true) */
    protected $facebook_access_token;

    public function __construct() {
        parent::__construct();
    }
    
    function getFacebookId() {
        return $this->facebook_id;
    }

    function getFacebookAccessToken() {
        return $this->facebook_access_token;
    }

    function setFacebookId($facebookId) {
        $this->facebook_id = $facebookId;
    }

    function setFacebookAccessToken($facebookAccessToken) {
        $this->facebook_access_token = $facebookAccessToken;
    }


}
