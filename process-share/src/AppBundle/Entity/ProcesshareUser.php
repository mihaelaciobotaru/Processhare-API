<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProcesshareUser
 *
 * @ORM\Table(name="processhare_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProcesshareUserRepository")
 */
class ProcesshareUser
{
    const REWARD = 0.00000385;

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
     * Set username
     *
     * @param string $username
     *
     * @return ProcesshareUser
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set score
     *
     * @param float $score
     *
     * @return ProcesshareUser
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return float
     */
    public function getScore()
    {
        return $this->score;
    }

    public function getReward()
    {
        return $this->score * self::REWARD;
    }

    public function addScore()
    {
        $this->score++;
    }
}
