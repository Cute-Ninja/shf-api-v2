<?php

namespace App\Controller\Api\User;

use App\Controller\Api\AbstractApiController;
use App\Controller\Api\StandardApiInterface;
use App\Controller\Api\User\ActionHelper\PatchMissionActionHelper;
use App\Exception\Http\NotImplementedHttpException;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserMissionApiController extends AbstractApiController implements StandardApiInterface
{
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
     * @SWG\Tag(name="UserMission")
     * @Security(name="Bearer")
     */
    public function getMany(Request $request): Response
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
     * @SWG\Tag(name="UserMission")
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
     * @SWG\Tag(name="UserMission")
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
     * @SWG\Tag(name="UserMission")
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
     * @SWG\Tag(name="UserMission")
     * @Security(name="Bearer")
     */
    public function delete(Request $request, int $id): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }

    /**
     * @param Request $request
     * @param string  $action
     *
     * @return Response
     *
     * @SWG\Response(
     *     response=200,
     *     description="The mission has been successfully realized"
     * )
     * @SWG\Response(
     *     response=404,
     *     description="No id was matching an existing Mission"
     * )
     * @SWG\Response(
     *     response=501,
     *     description="The selected action is not available"
     * )
     *
     * @SWG\Tag(name="UserMission")
     * @Security(name="Bearer")
     */
    public function patch(Request $request, string $action): Response
    {
        $helper = new PatchMissionActionHelper($this->getEntityManager());
        try {
            $userMission = $helper->doPatchAction($action, $this->getUser(), $request->query->get('missionId'));

            return $this->getSuccessResponseBuilder()->buildSingleObjectResponse(
                $userMission,
                $this->getSerializationGroup($request)
            );
        }  catch (NotFoundHttpException $exception) {
            $errorResponse = $this->getClientErrorResponseBuilder()->notFound();
        } catch (AccessDeniedHttpException $exception) {
            $errorResponse = $this->getClientErrorResponseBuilder()->forbidden();
        } catch (NotImplementedHttpException $exception) {
            $errorResponse = $this->getServerErrorResponseBuilder()->notImplemented();
        }

        return $errorResponse;
    }
}