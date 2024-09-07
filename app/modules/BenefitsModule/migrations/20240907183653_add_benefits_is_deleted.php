<?php

use Phinx\Migration\AbstractMigration;

class AddBenefitsIsDeleted extends AbstractMigration
{
    public function change()
    {
        // Create the table for storing benefits
        $benefits = $this->table('benefits');
        $benefits
            ->addColumn('is_deleted', 'boolean', ['default' => false])
            ->save();


    }
}
