<?php

use Phinx\Migration\AbstractMigration;

class BenefitsModuleInit extends AbstractMigration
{
    public function change()
    {
        // Create the table for storing benefits
        $benefits = $this->table('benefits');
        $benefits
            ->addColumn('name', 'string', ['limit' => 255])
            ->addColumn('code', 'string', ['limit' => 255])
            ->addColumn('photo', 'string')
            ->addColumn('start_date', 'datetime')
            ->addColumn('end_date', 'datetime')
            ->addTimestamps()
            ->create();

        // Create the table for MANY-TO-MANY relation between users and benefits
        $benefitsUser = $this->table('benefits_user');
        $benefitsUser
            ->addColumn('user_id', 'integer')
            ->addColumn('benefit_id', 'integer')
            ->addTimestamps()
            ->create();
    }
}
