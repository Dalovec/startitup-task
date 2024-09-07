<?php

use Phinx\Migration\AbstractMigration;

/**
 * Class AddBenefitsIsDeleted
 *
 * This migration adds the is_deleted column to the benefits table.
 * Written in Phinx.
 *
 */
class AddBenefitsIsDeleted extends AbstractMigration
{
    public function change()
    {
        // Add the is_deleted column to the benefits table.
        $benefits = $this->table('benefits');
        $benefits
            ->addColumn('is_deleted', 'boolean', ['default' => false])
            ->save();


    }
}
