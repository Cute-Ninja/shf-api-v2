<?php

namespace App\Controller\Api;

use App\Entity\WaterTracker\WaterTrackerEntry;
use App\Form\Type\WaterTrackerEntryType;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WaterTrackerEntryApiController extends AbstractApiController
{
    /**
     * @var Request $request
     * @var string  $trackerId
     *
     * @return Response
     *
     * @SWG\Response(
     *     response=501,
     *     description="Not implemented"
     * )
     *
     * @SWG\Tag(name="WaterTrackerEntry")
     * @Security(name="Bearer")
     */
    public function getMany(Request $request, string $trackerId): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }

    /**
     * @var Request $request
     * @var string  $trackerId
     * @var string  $id
     *
     * @return Response
     *
     * @SWG\Response(
     *     response=501,
     *     description="Not implemented"
     * )
     *
     * @SWG\Tag(name="WaterTrackerEntry")
     * @Security(name="Bearer")
     */
    public function getOne(Request $request, string $trackerId, string $id): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }

    /**
     * @var Request $request
     * @var string  $trackerId
     *
     * @return Response
     *
     * @SWG\Parameter(
     *     name="form",
     *     in="body",
     *     description="User update parameters",
     *     @Model(type=WaterTrackerEntryType::class)
     * )
     * @SWG\Response(
     *     response=200,
     *     description="The WaterTrackerEntry has been successfully created and returned",
     *     @Model(type=WaterTrackerEntry::class, groups={"default"})
     * )
     * @SWG\Response(
     *     response=422,
     *     description="Error in the form you are submitted (details in Response body).",
     * )
     * @SWG\Tag(name="WaterTrackerEntry")
     *
     * @Security(name="Bearer")
     */
    public function post(Request $request, string $trackerId): Response
    {
        $tracker = $this->getWaterTrackerRepository()
                        ->findOneByCriteria(['id' => $trackerId]);

        if (null === $tracker) {
            return $this->getClientErrorResponseBuilder()->notFound();
        }

        if ($this->getUser()->getId() !== $tracker->getUser()->getId()) {
            return $this->getClientErrorResponseBuilder()->forbidden();
        }

        $trackerEntry = new WaterTrackerEntry($tracker);
        $form = $this->createForm(
            WaterTrackerEntryType::class,
            $trackerEntry,
            ['method' => 'POST']
        );

        $form->handleRequest($request);
        if (false === $form->isSubmitted() || false === $form->isValid()) {
            return $this->getClientErrorResponseBuilder()->jsonResponseFormError($form);
        }

        $this->getEntityManager()->persist($trackerEntry);
        $this->getEntityManager()->flush();

        return $this->getSuccessResponseBuilder()->buildSingleObjectResponse(
            $tracker,
            $this->getSerializationGroup($request)
        );
    }

    /**
     * @var Request $request
     * @var string  $trackerId
     * @var string  $id
     *
     * @return Response
     *
     * @SWG\Response(
     *     response=501,
     *     description="Not implemented"
     * )
     *
     * @SWG\Tag(name="WaterTrackerEntry")
     * @Security(name="Bearer")
     */
    public function put(Request $request, string $trackerId, string $id): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }

    /**
     * @var Request $request
     * @var string  $trackerId
     * @var string  $id
     *
     * @return Response
     *
     * @SWG\Response(
     *     response=204,
     *     description="The WaterTrackerEntry has been deleted successfully"
     * )
     * @SWG\Response(
     *     response=403,
     *     description="You are not allowed to delete this WaterTrackerEntry"
     * )
     * @SWG\Response(
     *     response=404,
     *     description="No id was matching an existing WaterTrackerEntry"
     * )
     *
     * @SWG\Tag(name="WaterTrackerEntry")
     * @Security(name="Bearer")
     */
    public function delete(Request $request, string $trackerId, string $id): Response
    {
        $entry = $this->getWaterTrackerEntryRepository()
                      ->findOneByCriteria(['id' => $id, 'waterTrackerId' => $trackerId]);

        if (null === $entry) {
            return $this->getClientErrorResponseBuilder()->notFound();
        }

        if ($this->getUser()->getId() !== $entry->getTracker()->getUser()->getId()) {
            return $this->getClientErrorResponseBuilder()->forbidden();
        }

        $this->getEntityManager()->remove($entry);
        $this->getEntityManager()->flush();

        return $this->getSuccessResponseBuilder()->buildSingleObjectResponse(
            $entry->getTracker(),
            $this->getSerializationGroup($request)
        );
    }
}