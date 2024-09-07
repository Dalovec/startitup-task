<?php

namespace Crm\BenefitsModule\Presenters;
use Crm\BenefitsModule\Forms\BenefitFormFactory;
use Crm\BenefitsModule\Repositories\BenefitsRepository;
use Nette\Application\AbortException;
use Nette\Forms\Form;

/**
 * Class BenefitsAdminPresenter
 *
 * Presenter for the admin endpoints of the benefits module.
 *
 */
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

    /**
     * Render the default view.
     *
     * Template: default.latte
     *
     * This view shows a list of all non-deleted benefits.
     *
     * @return void
     */
    public function renderDefault(): void
    {
        $this->template->timeNow = new \DateTime();
        $this->template->benefits = $this->benefitsRepository->all();
    }

    /**
     * Render the edit view.
     *
     * Template: edit.latte
     *
     * Allows editing of a benefit.
     *
     * @param int $id The benefit id.
     *
     * @return void
     */
    public function renderEdit(int $id): void
    {
        $this->params['id'] = $id;
        $this->template->benefit = $this->benefitsRepository->find($id);
    }

    /**
     * Render the new view.
     *
     * Template: new.latte
     *
     * Allows creating a new benefit.
     *
     * @return void
     */
    public function renderNew(): void
    {
        $this->template->timeNow = new \DateTime();
    }

    /**
     * Create the benefit form component.
     *
     * @return Form
     */
    protected function createComponentBenefitForm(): Form
    {
        $form = $this->benefitFormFactory->create();

        $this->benefitFormFactory->onSave = function($benefit) {
            $this->flashMessage("$benefit->name Benefit created", 'info');
            $this->redirect(':Benefits:BenefitsAdmin:default');
        };

        return $form;
    }

    /**
     * Handle the delete action.
     *
     * @param int $id The benefit id.
     *
     * @return void
     * @throws AbortException
     */
    public function handleDelete(int $id): void
    {
        $row = $this->benefitsRepository->find($id);
        $this->benefitsRepository->delete($row);
        $this->flashMessage('Benefit deleted', 'info');
        $this->redirect(':Benefits:BenefitsAdmin:default');
    }

    /**
     * Create the edit benefit form component.
     *
     * @return Form
     */
    protected function createComponentEditBenefitForm(): Form
    {
        $form = $this->benefitFormFactory->create($this->params['id']);

        $this->benefitFormFactory->onUpdate = function($benefit) {
            $this->flashMessage("$benefit->name Benefit updated", 'info');
            $this->redirect(':Benefits:BenefitsAdmin:default');
        };

        return $form;
    }

}