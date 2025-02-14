<?php

namespace ScoutUnitsList\Model;

use JsonSerializable;
use stdClass;

/**
 * Person model
 */
class Person implements JsonSerializable, VersionedModelInterface
{
    use VersionedModelTrait;

    /** @var int */
    protected $id;

    /** @var int */
    protected $userId;

    /** @var User|null */
    protected $user;

    /** @var int */
    protected $unitId;

    /** @var Unit|null */
    protected $unit;

    /** @var int */
    protected $positionId;

    /** @var Position|null */
    protected $position;

    /** @var int|null */
    protected $orderId;

    /** @var Attachment|null */
    protected $order;

    /** @var string */
    protected $orderNo;

    /** @var int */
    protected $sort = 0;

    /** @var string|null */
    protected $userName;

    /** @var string|null */
    protected $userGrade;

    /**
     * Get ID
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get user ID
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set user ID
     *
     * @param int $userId user ID
     *
     * @return self
     */
    public function setUserId($userId)
    {
        $this->userId = (int) $userId;

        return $this;
    }

    /**
     * Get user
     *
     * @return User|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set user
     *
     * @param User $user user
     *
     * @return self
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get unit ID
     *
     * @return int
     */
    public function getUnitId()
    {
        return $this->unitId;
    }

    /**
     * Set unit ID
     *
     * @param int $unitId unit ID
     *
     * @return self
     */
    public function setUnitId($unitId)
    {
        $this->unitId = (int) $unitId;

        return $this;
    }

    /**
     * Get unit
     *
     * @return Unit|null
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set unit
     *
     * @param Unit $unit unit
     *
     * @return self
     */
    public function setUnit(Unit $unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get position ID
     *
     * @return int
     */
    public function getPositionId()
    {
        return $this->positionId;
    }

    /**
     * Set position ID
     *
     * @param int $positionId position ID
     *
     * @return self
     */
    public function setPositionId($positionId)
    {
        $this->positionId = (int) $positionId;

        return $this;
    }

    /**
     * Get position
     *
     * @return Position|null
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set position
     *
     * @param Position $position position
     *
     * @return self
     */
    public function setPosition(Position $position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Is leader
     *
     * @return bool
     */
    public function isLeader()
    {
        $position = $this->getPosition();
        $isLeader = isset($position) && $position->isLeader();

        return $isLeader;
    }

    /**
     * Get order ID
     *
     * @return int|null
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Set order ID
     *
     * @param int|null $orderId order ID
     *
     * @return self
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * Get order
     *
     * @return Attachment|null
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set order
     *
     * @param Attachment $order order
     *
     * @return self
     */
    public function setOrder(Attachment $order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order no
     *
     * @return string
     */
    public function getOrderNo()
    {
        return $this->orderNo;
    }

    /**
     * Set order no
     *
     * @param string $orderNo order no
     *
     * @return self
     */
    public function setOrderNo($orderNo)
    {
        $this->orderNo = $orderNo;

        return $this;
    }

    /**
     * Get sort
     *
     * @return int
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Set sort
     *
     * @param int $sort sort
     *
     * @return self
     */
    public function setSort($sort)
    {
        $this->sort = (int) $sort;

        return $this;
    }

    /**
     * Get user name
     *
     * @param bool $addGrade add grade
     *
     * @return string|null
     */
    public function getUserName($addGrade = false)
    {
        $userName = $this->userName;
        if ($addGrade && !empty($this->userGrade)) {
            $userName = $this->userGrade . ' ' . $userName;
        }

        return $userName;
    }

    /**
     * Has user name
     *
     * @return bool
     */
    public function hasUserName()
    {
        $hasUserName = !empty($this->userName);

        return $hasUserName;
    }

    /**
     * Set user name
     *
     * @param string|null $userName user name
     *
     * @return self
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * Get user grade
     *
     * @return string|null
     */
    public function getUserGrade()
    {
        return $this->userGrade;
    }

    /**
     * Set user grade
     *
     * @param string|null $userGrade user grade
     *
     * @return self
     */
    public function setUserGrade($userGrade)
    {
        $this->userGrade = $userGrade;

        return $this;
    }

    /**
     * JSON serialize
     *
     * @return array
     */
    public function jsonSerialize()
    {
        $position = $this->getPosition();
        $user = $this->getUser();

        $data = [
            'duty' => isset($user) ? $user->getDuty() : null,
            'email' => isset($user) ? $user->getEmailIfAllowed() : null,
            'grade' => isset($user) ? $user->getGrade() : $this->getUserGrade(),
            'name' => isset($user) ? $user->getDisplayName() : $this->getUserName(),
            'position' => isset($position) ? [
                'description' => $position->getDescription(),
                'leader' => $position->isLeader(),
                'name' => $position->getNameFor($user),
                'responsibilities' => $position->getResponsibilities(),
            ] : null,
        ];

        return $data;
    }

    /**
     * Create
     *
     * @param stdClass $structure structure
     * @param Unit     $unit      unit
     *
     * @return Unit
     */
    public static function create(stdClass $structure, Unit $unit = null)
    {
        $person = new self();
        $person->setUserName($structure->name)
            ->setUserGrade($structure->grade)
        ;

        if (isset($structure->position)) {
            $position = new Position();
            $position->setDescription($structure->position->description)
                ->setNameMale($structure->position->name)
                ->setLeader($structure->position->leader)
                ->setResponsibilities($structure->position->responsibilities)
            ;
            $person->setPosition($position);
        }

        $user = new User();
        $user->setGrade($structure->grade)
            ->setDisplayName($structure->name)
        ;
        if (!empty($structure->duty)) {
            $user->setDuty($structure->duty);
        }
        if (!empty($structure->email)) {
            $user->setEmail($structure->email)
                ->setPublishEmail(User::PUBLISH_EMAIL_YES)
            ;
        }
        $person->setUser($user);

        if (isset($unit)) {
            $person->setUnitId($unit->getId())
                ->setUnit($unit)
            ;
        }

        return $person;
    }
}
