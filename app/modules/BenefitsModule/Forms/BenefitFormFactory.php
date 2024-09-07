<?php

namespace Crm\BenefitsModule\Forms;

use Crm\BenefitsModule\Repositories\BenefitsRepository;
use Exception;
use Nette\Application\UI\Form;
use Nette\Forms\Validator;
use Nette\Utils\ArrayHash;

/**
 * Class BenefitFormFactory
 *
 * This class is used to create the benefit form.
 * It is used to create both new and edit forms.
 *
 */
class BenefitFormFactory
{
    public $onUpdate;
    public $onSave;
    public function __construct(
        private BenefitsRepository $benefitsRepository,
    ){
    }

    /**
     * Create the benefit form.
     *
     * Handles both new and edit forms.
     *
     * @param int|null $id The benefit id.
     *
     * @return Form
     */
    public function create($id = null): Form
    {
        $form = new Form();

        $form->setRenderer(new \Tomaj\Form\Renderer\BootstrapRenderer());
        $form->addHidden('id');
        $form->addText('name', 'Name')
            ->setMaxLength(255)
            ->setRequired();
        $form->addText('code', 'Code')
            ->setMaxLength(255)
            ->setRequired();
        $form->addTextArea('description', 'Description')
            ->setMaxLength(1000)
            ->setNullable();
        $form->addText('photo', 'Photo Url')
            ->setRequired();
        $form->addDateTime('start_date', 'Start Date')
            ->setRequired();
        $form->addDateTime('end_date', 'End Date')
            ->setRequired();

        // If the benefit exists, set the values from the database.
        if ($id) {
            $benefit = $this->benefitsRepository->find($id);
            $form->setDefaults([
                'id' => $benefit->id,
                'name' => $benefit->name,
                'code' => $benefit->code,
                'description' => $benefit->description,
                'photo' => $benefit->photo,
                'start_date' => $benefit->start_date,
                'end_date' => $benefit->end_date,
            ]);
        }

        $form->addSubmit('save', 'Save');
        $form->onSuccess[] = [$this, 'formSucceeded'];

        return $form;
    }

    /**
     * Handle the form submission.
     *
     * @param $form The form.
     * @param ArrayHash|array $values The form values.
     *
     * @return void
     * @throws Exception
     */
    public function formSucceeded($form, $values): void
    {
        $id = $values['id'];
        if ($id){
            $row = $this->benefitsRepository->find($id);
            $this->benefitsRepository->update($row, $values);
            $this->onUpdate->__invoke($row);
        }
        else {
            $row = $this->benefitsRepository->add($values);
            $this->onSave->__invoke($row);
        }
    }
}