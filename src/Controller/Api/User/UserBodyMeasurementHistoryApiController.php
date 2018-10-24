<?php

namespace App\Controller\Api\User;

use App\Controller\Api\AbstractApiController;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserBodyMeasurementHistoryApiController extends AbstractApiController
{
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
     * @SWG\Tag(name="UserBodyMeasurementHistory")
     * @Security(name="Bearer")
     */
    public function getMany(Request $request): Response
    {
        $builder = $this->getUserBodyMeasurementHistoryRepository()
                        ->findManyByCriteriaBuilder(
                            ['username' => $request->get('username')]
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
     * @var string  $username
     * @var int     $id
     *
     * @return Response
     *
     * @SWG\Response(
     *     response=501,
     *     description="Not implemented"
     * )
     *
     * @SWG\Tag(name="UserBodyMeasurementHistory")
     * @Security(name="Bearer")
     */
    public function getOne(Request $request, string $username, int $id): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
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
     * @SWG\Tag(name="UserBodyMeasurementHistory")
     * @Security(name="Bearer")
     */
    public function post(Request $request): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }

    /**
     * @var Request $request
     * @var string  $username
     * @var int     $id
     *
     * @return Response
     *
     * @SWG\Response(
     *     response=501,
     *     description="Not implemented"
     * )
     *
     * @SWG\Tag(name="UserBodyMeasurementHistory")
     * @Security(name="Bearer")
     */
    public function put(Request $request, string $username, int $id): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }

    /**
     * @var Request $request
     * @var string  $username
     * @var int     $id
     *
     * @return Response
     *
     * @SWG\Response(
     *     response=501,
     *     description="Not implemented"
     * )
     *
     * @SWG\Tag(name="UserBodyMeasurementHistory")
     * @Security(name="Bearer")
     */
    public function delete(Request $request, string $username, int $id): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }
}