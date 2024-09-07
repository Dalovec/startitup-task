<?php

namespace Crm\BenefitsModule\Repositories;

use Crm\ApplicationModule\Models\Database\ActiveRow;
use Crm\ApplicationModule\Models\Database\Repository;
use Crm\ApplicationModule\Repositories\AuditLogRepository;
use Nette\Database\Explorer;
use Nette\Utils\ArrayHash;

class BenefitsRepository extends Repository
{
    protected $tableName = 'benefits';
    public function __construct(
        Explorer           $database,
        AuditLogRepository $auditLogRepository
    )
    {
        parent::__construct($database);
        $this->auditLogRepository = $auditLogRepository;
    }

    final public function all(): \Crm\ApplicationModule\Models\Database\Selection
    {
        return $this->getTable()->where('name IS NOT NULL');
    }

    final public function find($id): ?\Crm\ApplicationModule\Models\Database\ActiveRow
    {
        $result = $this->getTable()->where(['id' => $id])->fetch();
        return $result;
    }

    final public function add(ArrayHash $data): ActiveRow
    {
//        dump($data);
        $row = $this->getTable()->insert($data);
        return $row;
    }

    final public function delete(\Nette\Database\Table\ActiveRow &$row): void
    {
        $this->getTable()->where(['id' => $row->id])->delete();
    }

}