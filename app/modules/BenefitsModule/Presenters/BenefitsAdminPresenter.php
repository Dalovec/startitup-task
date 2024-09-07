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

    public function renderNew(): void
    {
        $this->template->timeNow = new \DateTime();
    }

    protected function createComponentBenefitForm()
    {
        $form = $this->benefitFormFactory->create();

        $this->benefitFormFactory->onSave = function($benefit) {
//            dump($benefit);
//            $this->flashMessage("$benefit->name Benefit created", 'info');
            $this->redirect(':Benefits:BenefitsAdmin:default');
        };

        return $form;
    }

    public function handleDelete($id):void
    {
        $row = $this->benefitsRepository->find($id);
        $this->benefitsRepository->delete($row);
        $this->flashMessage('Benefit deleted', 'info');
        $this->redirect(':Benefits:BenefitsAdmin:default');
    }

    protected function createComponentEditBenefitForm()
    {
        $form = $this->benefitFormFactory->create($this->params['id']);

        $this->benefitFormFactory->onUpdate = function($benefit) {
            $this->flashMessage("$benefit->name Benefit updated", 'info');
            $this->redirect(':Benefits:BenefitsAdmin:default');
        };

        return $form;
    }

}