<?php

namespace Crm\BenefitsModule\Forms;

use Crm\BenefitsModule\Repositories\BenefitsRepository;
use Nette\Application\UI\Form;

class BenefitFormFactory
{
    public $onUpdate;
    public $onSave;
    public function __construct(
        private BenefitsRepository $benefitsRepository,
    ){
    }

    public function create($id = null)
    {
        $form = new Form();

        $form->setRenderer(new \Tomaj\Form\Renderer\BootstrapRenderer());
        $form->addHidden('id');
        $form->addText('name', 'Name');
        $form->addText('code', 'Code');
        $form->addText('photo', 'Photo Url');
        $form->addDateTime('start_date', 'Start Date');
        $form->addDateTime('end_date', 'End Date');

        if ($id) {
            $benefit = $this->benefitsRepository->find($id);
            $form->setDefaults([
                'id' => $benefit->id,
                'name' => $benefit->name,
                'code' => $benefit->code,
                'photo' => $benefit->photo,
                'start_date' => $benefit->start_date,
                'end_date' => $benefit->end_date,
            ]);
        }

        $form->addSubmit('save', 'Save');
        $form->onSuccess[] = [$this, 'formSucceeded'];

        return $form;
    }

    public function formSucceeded($form, $values)
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