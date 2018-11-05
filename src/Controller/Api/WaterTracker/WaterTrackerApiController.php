<?php

namespace App\Controller\Api\WaterTracker;

use App\Controller\Api\AbstractApiController;
use App\Controller\Api\StandardApiInterface;
use App\Entity\WaterTracker\WaterTracker;
use App\Utils\Clock;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WaterTrackerApiController extends AbstractApiController implements StandardApiInterface
{
    /**
     * @var Request $request
     *
     * @return Response
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns the list WaterTrackers",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=WaterTracker::class, groups={"default"}))
     *     )
     * )
     * @SWG\Response(
     *     response=204,
     *     description="No WaterTrackers found for the search parameters used"
     * )
     *
     * @SWG\Tag(name="WaterTracker")
     * @Security(name="Bearer")
     */
    public function getMany(Request $request): Response
    {
        $builder = $this->getWaterTrackerRepository()
                        ->findManyByCriteriaBuilder(
                            ['user' => $request->query->get('user')]
                        );

        return $this->getSuccessResponseBuilder()->buildMultiObjectResponse(
            $this->paginate($builder, $request),
            $request,
            $this->getRouter(),
            $this->getSerializationGroup($request)
        );
    }

    /**
     * @var Request $request
     * @var int     $id
     *
     * @return Response
     *
     * @SWG\Response(
     *     response=501,
     *     description="Not implemented"
     * )
     *
     * @SWG\Tag(name="WaterTracker")
     * @Security(name="Bearer")
     */
    public function getOne(Request $request, int $id): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }

    /**
     * @param Request $request
     *
     * @return Response
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns today's WaterTracker",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=WaterTracker::class, groups={"default"}))
     *     )
     * )
     * @SWG\Response(
     *     response=404,
     *     description="No WaterTracker found for the search parameters used"
     * )
     *
     * @SWG\Tag(name="WaterTracker")
     * @Security(name="Bearer")
     */
    public function getToday(Request $request): Response
    {
        $waterTracker = $this->getWaterTrackerRepository()
                             ->findOneByCriteria(
                                 [
                                     'user' => $request->query->get('user'),
                                     'createdBetween' => [
                                         'start' => Clock::today(),
                                         'end'   => Clock::tomorrow()
                                     ]
                                 ],
                                 ['waterTrackerEntry']
                             );

        return $this->getSuccessResponseBuilder()->buildSingleObjectResponse(
            $waterTracker,
            $this->getSerializationGroup($request)
        );
    }

    /**
     * @var Request $request
     *
     * @return Response
     *
     * @SWG\Response(
     *     response=501,
     *     description="Not implemented"
     * )
     *
     * @SWG\Tag(name="WaterTracker")
     * @Security(name="Bearer")
     */
    public function post(Request $request): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }

    /**
     * @var Request $request
     * @var int     $id
     *
     * @return Response
     *
     *
     * @SWG\Response(
     *     response=501,
     *     description="Not implemented"
     * )
     *
     * @SWG\Tag(name="WaterTracker")
     * @Security(name="Bearer")
     */
    public function put(Request $request, int $id): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }

    /**
     * @var Request $request
     * @var int     $id
     *
     * @return Response
     *
     * @SWG\Response(
     *     response=501,
     *     description="Not implemented"
     * )
     *
     * @SWG\Tag(name="WaterTracker")
     * @Security(name="Bearer")
     */
    public function delete(Request $request, int $id): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }
}