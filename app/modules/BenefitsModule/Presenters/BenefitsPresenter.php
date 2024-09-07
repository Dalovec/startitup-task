<?php

namespace Crm\BenefitsModule\Presenters;

use Crm\ApplicationModule\Presenters\FrontendPresenter;
use Crm\BenefitsModule\Repositories\BenefitsRepository;
use Crm\BenefitsModule\Repositories\UserBenefitsRepository;

class BenefitsPresenter extends FrontendPresenter
{
    private $benefitsRepository;
    private $userBenefitsRepository;

    public function __construct(
        BenefitsRepository $benefitsRepository,
        UserBenefitsRepository $userBenefitsRepository
    )
    {
        parent::__construct();
        $this->benefitsRepository = $benefitsRepository;
        $this->userBenefitsRepository = $userBenefitsRepository;
    }
    public function startup()
    {
        $this->onlyLoggedIn();

        parent::startup();
    }

    public function renderDefault()
    {
        $this->template->benefits = $this->benefitsRepository->all();
        $this->template->timeNow = new \DateTime();
        $userId = $this->getUser()->id;
        $this->template->userId = $userId;
        $this->template->isClaimed = $this->userBenefitsRepository->isClaimed($userId);
    }

    public function handleClaim($benefitId)
    {
        $userId = $this->getUser()->id;
        $this->userBenefitsRepository->add($userId, $benefitId);

        $this->flashMessage('Benefit claimed', 'info');
        $this->redirect('this');
    }
}