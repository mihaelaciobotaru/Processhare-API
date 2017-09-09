<?php
namespace AppBundle\Entity;

/**
 * ProcesshareUser
 *
 * @ORM\Table(name="processhare_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProcesshareUserRepository")
 */
class ProcesshareUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     * @var float
     * @ORM\Column(name="score", type="float")
     */
    private $score;
}
