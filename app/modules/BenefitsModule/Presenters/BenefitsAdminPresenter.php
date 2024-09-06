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

    public function renderDefault(): void
    {
        $this->template->timeNow = new \DateTime();
        $this->template->benefits = $this->benefitsRepository->all();
    }

    public function renderEdit($id): void
    {
        $this->template->benefit = $this->benefitsRepository->find($id);
    }

}