<?php

namespace Crm\BenefitsModule\Presenters;
use Crm\BenefitsModule\Repositories\BenefitsRepository;
use Tomaj\Form\Renderer\BootstrapRenderer;

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

    public function createComponentEditBenefitForm(): \Nette\Application\UI\Form
    {
        $form = new \Nette\Application\UI\Form();
        $form->setRenderer(new BootstrapRenderer());

        $form->addText('name', 'Name')->setDefaultValue($this->template->benefit->name);
        $form->addText('code', 'Code')->setDefaultValue($this->template->benefit->code);
        $form->addText('photo', 'Photo Url')->setDefaultValue($this->template->benefit->photo);
        $form->addDateTime('start_date', 'Start Date')->setDefaultValue($this->template->benefit->start_date);
        $form->addDateTime('end_date', 'End Date')->setDefaultValue($this->template->benefit->end_date);
        $form->addSubmit('save', 'Save');

        return $form;
    }

}