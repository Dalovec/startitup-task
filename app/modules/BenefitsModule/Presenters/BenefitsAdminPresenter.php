<?php

namespace Crm\BenefitsModule\Presenters;
use Crm\BenefitsModule\Repositories\BenefitsRepository;

class BenefitsAdminPresenter extends \Crm\AdminModule\Presenters\AdminPresenter
{
    private BenefitsRepository $benefitsRepository;

    public function __construct(
        BenefitsRepository $benefitsRepository,
    )
    {
        parent::__construct();
        $this->benefitsRepository = $benefitsRepository;
    }

    public function renderDefault()
    {
        // in Admin presenters even empty render methods are necessary
    }
}