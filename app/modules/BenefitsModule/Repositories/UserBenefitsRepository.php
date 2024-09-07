<?php

namespace Crm\BenefitsModule\Repositories;

use Crm\ApplicationModule\Models\Database\ActiveRow;
use Crm\ApplicationModule\Models\Database\Repository;
use Crm\ApplicationModule\Repositories\AuditLogRepository;
use Nette\Database\Explorer;

/**
 * Class UserBenefitsRepository
 *
 * This class is used to manage the relation between users and benefits.
 * It is used to add, remove and check if a user has a benefit.
 *
 * This is a many-to-many relationship.
 *
 */
class UserBenefitsRepository extends Repository
{
    protected $tableName = 'benefits_user';

    public function __construct(
        Explorer           $database,
        AuditLogRepository $auditLogRepository
    )
    {
        parent::__construct($database);
        $this->auditLogRepository = $auditLogRepository;
    }

    /**
     * Find a relationship by user id.
     *
     * @param int $userId  The user id.
     *
     * @return ActiveRow|null
     */
    public function findByUserId($userId): \Nette\Database\Table\ActiveRow
    {
        $result = $this->getTable()->where(['user_id' => $userId])->fetch();
        return $result;
    }

    /**
     * Find a relationship by benefit id.
     *
     * @param int $benefitId  The benefit id.
     *
     * @return ActiveRow|null
     */
    public function findByBenefitId($benefitId): \Nette\Database\Table\ActiveRow
    {
        $result = $this->getTable()->where(['benefit_id' => $benefitId])->fetch();
        return $result;
    }

    /**
     * Add a new relationship.
     *
     * @param int $userId  The user id.
     * @param int $benefitId  The benefit id.
     *
     * @return ActiveRow
     */
    public function add($userId, $benefitId): ActiveRow
    {
        if($this->isClaimed($userId)){
            return $this->getTable()->where(['user_id' => $userId])->fetch();
        }
        $row = $this->getTable()->insert(['user_id' => $userId, 'benefit_id' => $benefitId]);
        return $row;
    }

    /**
     * Remove all relationships for a user.
     *
     * @param int $userId  The user id.
     *
     * @return void
     */
    public function resetUser($userId): void
    {
        $this->getTable()->where(['user_id' => $userId])->delete();
    }

    /**
     * Check if a user has a benefit.
     *
     * @param int $userId  The user id.
     *
     * @return int|null - The benefit id or null if the user doesn't have a benefit.
     */
    public function isClaimed($userId): ?int
    {
        $result = $this->getTable()->where(['user_id' => $userId])->fetch()->benefit_id ?? null;
        return $result;
    }
}