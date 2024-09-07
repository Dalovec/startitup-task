<?php

namespace Crm\BenefitsModule\Repositories;

use Crm\ApplicationModule\Models\Database\ActiveRow;
use Crm\ApplicationModule\Models\Database\Repository;
use Crm\ApplicationModule\Repositories\AuditLogRepository;
use Nette\Database\Explorer;
use Nette\Utils\ArrayHash;

/**
 * Class BenefitsRepository
 *
 * This class is used to manage the benefits.
 * It is used to add, remove and check if a user has a benefit.
 *
 */
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

    /**
     * Returns all benefits that are not deleted.
     *
     * @return \Crm\ApplicationModule\Models\Database\Selection
     */
    final public function all(): \Crm\ApplicationModule\Models\Database\Selection
    {
        return $this->getTable()->where('is_deleted IS FALSE');
    }

    /**
     * Find a benefit by id.
     *
     * @param int $id
     *
     * @return ActiveRow|null
     */
    final public function find($id): ?ActiveRow
    {
        $result = $this->getTable()->where(['id' => $id])->fetch();
        return $result;
    }

    /**
     * Add a new benefit.
     *
     * @param ArrayHash $data The benefit data.
     *
     * @return ActiveRow
     */
    final public function add(ArrayHash $data): ActiveRow
    {
        $row = $this->getTable()->insert($data);
        return $row;
    }

    /**
     * Delete a benefit.
     * Sets the is_deleted flag to true.
     *
     * @param ActiveRow $row The benefit to delete.\
     *
     * @return void
     */
    final public function delete(\Nette\Database\Table\ActiveRow &$row): void
    {
        $this->getTable()->where(['id' => $row->id])->update(['is_deleted' => true]);
    }

    /**
     * Delete a benefit.
     * Destructive method - removes the benefit from the database.
     *
     * @param ActiveRow $row The benefit to delete.
     *
     * @return void
     */
    final public function destroy(\Nette\Database\Table\ActiveRow &$row): void
    {
        $this->delete($row);
    }

}