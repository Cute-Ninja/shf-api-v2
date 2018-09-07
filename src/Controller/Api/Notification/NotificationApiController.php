<?php

namespace App\Controller\Api\Notification;

use App\Controller\Api\AbstractApiController;
use App\Controller\Api\StandardApiInterface;
use App\Entity\Notification\WebNotification;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NotificationApiController extends AbstractApiController implements StandardApiInterface
{
    /**
     * @param Request $request
     *
     * @return Response
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns the list of Missions",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=WebNotification::class, groups={"default"}))
     *     )
     * )
     * @SWG\Response(
     *     response=204,
     *     description="No Missions found for the search parameters used"
     * )
     * @SWG\Tag(name="Mission")
     * @Security(name="Bearer")
     */
    public function getMany(Request $request): Response
    {
        $builder = $this->getNotificationRepository()
                        ->findManyByCriteriaBuilder(
                            ['user' => $request->query->get('user')]
                        );

        $pagination = $this->paginate($builder, $request);
        $helper     = $this->get('shf_api.action_helper.notification.get_many');

        $helper->doPostConsultActions($this->getUser() ,$pagination);

        return $this->getSuccessResponseBuilder()->buildMultiObjectResponse(
            $pagination,
            $request,
            $this->getRouter(),
            $this->getSerializationGroup($request)
        );
    }

    /**
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     *
     * @SWG\Response(
     *     response=501,
     *     description="Not implemented"
     * )
     *
     * @SWG\Tag(name="Mission")
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
     *     response=501,
     *     description="Not implemented"
     * )
     *
     * @SWG\Tag(name="Mission")
     * @Security(name="Bearer")
     */
    public function post(Request $request): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }

    /**
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     *
     * @SWG\Response(
     *     response=501,
     *     description="Not implemented"
     * )
     *
     * @SWG\Tag(name="Mission")
     * @Security(name="Bearer")
     */
    public function put(Request $request, int $id): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }

    /**
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     *
     * @SWG\Response(
     *     response=501,
     *     description="Not implemented"
     * )
     *
     * @SWG\Tag(name="Mission")
     * @Security(name="Bearer")
     */
    public function delete(Request $request, int $id): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }
}