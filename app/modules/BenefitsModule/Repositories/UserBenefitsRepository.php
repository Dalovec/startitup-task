<?php

namespace Crm\BenefitsModule\Repositories;

use Crm\ApplicationModule\Models\Database\ActiveRow;
use Crm\ApplicationModule\Models\Database\Repository;
use Crm\ApplicationModule\Repositories\AuditLogRepository;
use Nette\Database\Explorer;

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

    public function findByUserId($userId): \Nette\Database\Table\ActiveRow
    {
        $result = $this->getTable()->where(['user_id' => $userId])->fetch();
        return $result;
    }

    public function findByBenefitId($benefitId): \Nette\Database\Table\ActiveRow
    {
        $result = $this->getTable()->where(['benefit_id' => $benefitId])->fetch();
        return $result;
    }

    public function add($userId, $benefitId)
    {
        if($this->isClaimed($userId)){
            return $this->getTable()->where(['user_id' => $userId])->fetch();
        }
        $row = $this->getTable()->insert(['user_id' => $userId, 'benefit_id' => $benefitId]);
        return $row;
    }

    public function resetUser($userId)
    {
        $this->getTable()->where(['user_id' => $userId])->delete();
    }

    public function isClaimed($userId): ?int
    {
        $result = $this->getTable()->where(['user_id' => $userId])->fetch()->benefit_id ?? null;
        return $result;
    }
}