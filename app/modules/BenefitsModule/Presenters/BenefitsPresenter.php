<?php

namespace Crm\BenefitsModule\Presenters;

use Crm\ApplicationModule\Presenters\FrontendPresenter;
use Crm\BenefitsModule\Repositories\BenefitsRepository;
use Crm\BenefitsModule\Repositories\UserBenefitsRepository;

/**
 * Class BenefitsPresenter
 *
 * Presenter for the frontend endpoints of the benefits module.
 *
 */
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

    /**
     * Only allow logged in users to access this presenter.
     *
     * @return void
     */
    public function startup(): void
    {
        $this->onlyLoggedIn();

        parent::startup();
    }

    /**
     * Render the default view.
     *
     * Template: default.latte
     *
     * This view shows a list of all non-deleted benefits and active benefits.
     *
     * @return void
     */
    public function renderDefault(): void
    {
        $this->template->benefits = $this->benefitsRepository->all();
        $this->template->timeNow = new \DateTime();
        $userId = $this->getUser()->id;
        $this->template->userId = $userId;
        $this->template->isClaimed = $this->userBenefitsRepository->isClaimed($userId);
    }

    /**
     * Handle the claim action.
     *
     * @param int $benefitId The benefit id.
     *
     * @return void
     */
    public function handleClaim(int $benefitId): void
    {
        $userId = $this->getUser()->id;
        $this->userBenefitsRepository->add($userId, $benefitId);

        $this->flashMessage('Benefit claimed', 'info');
        $this->redirect('this');
    }
}