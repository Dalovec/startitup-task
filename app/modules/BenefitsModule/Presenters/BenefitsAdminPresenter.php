<?php

namespace Crm\BenefitsModule\Presenters;
use Crm\BenefitsModule\Forms\BenefitFormFactory;
use Crm\BenefitsModule\Repositories\BenefitsRepository;
use Tomaj\Form\Renderer\BootstrapRenderer;

class BenefitsAdminPresenter extends \Crm\AdminModule\Presenters\AdminPresenter
{
    private BenefitsRepository $benefitsRepository;
    private BenefitFormFactory $benefitFormFactory;

    public function __construct(
        BenefitsRepository $benefitsRepository,
        BenefitFormFactory $benefitFormFactory,
    )
    {
        parent::__construct();
        $this->benefitsRepository = $benefitsRepository;
        $this->benefitFormFactory = $benefitFormFactory;
    }

    public function renderDefault(): void
    {
        $this->template->timeNow = new \DateTime();
        $this->template->benefits = $this->benefitsRepository->all();
    }

    public function renderEdit($id): void
    {
        $this->params['id'] = $id;
        $this->template->benefit = $this->benefitsRepository->find($id);
    }

    protected function createComponentEditBenefitForm()
    {
        $form = $this->benefitFormFactory->create($this->params['id']);

        return $form;
    }

}