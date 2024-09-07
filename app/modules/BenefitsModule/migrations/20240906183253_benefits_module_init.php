<?php

use Phinx\Migration\AbstractMigration;

/**
 * Class BenefitsModuleInit
 *
 * This migration creates the benefits table and benefits_user table.
 * Written in Phinx.
 *
 */
class BenefitsModuleInit extends AbstractMigration
{
    public function change()
    {
        // Create the table for storing benefits
        $benefits = $this->table('benefits');
        $benefits
            ->addColumn('name', 'string', ['limit' => 255])
            ->addColumn('code', 'string', ['limit' => 255])
            ->addColumn('description', 'text')
            ->addColumn('photo', 'text')
            ->addColumn('start_date', 'datetime')
            ->addColumn('end_date', 'datetime')
            ->addTimestamps()
            ->create();

        // Create the table for MANY-TO-MANY relation between users and benefits
        $benefitsUser = $this->table('benefits_user');
        $benefitsUser
            ->addColumn('user_id', 'integer')
            ->addColumn('benefit_id', 'integer')
            ->addIndex(['user_id'], ['unique' => true])
            ->addTimestamps()
            ->create();
    }
}
