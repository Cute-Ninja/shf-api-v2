<?php

namespace App\Controller\Api;

use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserWorkoutApiController extends AbstractApiController implements StandardApiInterface
{
    /**
     * @var Request $request
     *
     * @return Response
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns the list UserWorkouts",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=UserWorkout::class, groups={"default"}))
     *     )
     * )
     * @SWG\Response(
     *     response=204,
     *     description="No UserWorkouts found for the search parameters used"
     * )
     *
     * @SWG\Tag(name="UserWorkout")
     * @Security(name="Bearer")
     */
    public function getMany(Request $request): Response
    {
        $builder = $this->getUserWorkoutRepository()
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
     * @var string  $id
     *
     * @return Response
     *
     * @SWG\Response(
     *     response=501,
     *     description="Not implemented"
     * )
     *
     * @SWG\Tag(name="UserWorkout")
     * @Security(name="Bearer")
     */
    public function getOne(Request $request, string $id): Response
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
     * @SWG\Tag(name="UserWorkout")
     * @Security(name="Bearer")
     */
    public function post(Request $request): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }
    
    /**
     * @var Request $request
     * @var string  $id
     *
     * @return Response
     *
     *
     * @SWG\Response(
     *     response=501,
     *     description="Not implemented"
     * )
     *
     * @SWG\Tag(name="UserWorkout")
     * @Security(name="Bearer")
     */
    public function put(Request $request, string $id): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }

    /**
     * @var Request $request
     * @var string  $id
     *
     * @return Response
     *
     * @SWG\Response(
     *     response=501,
     *     description="Not implemented"
     * )
     *
     * @SWG\Tag(name="UserWorkout")
     * @Security(name="Bearer")
     */
    public function delete(Request $request, string $id): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }

}