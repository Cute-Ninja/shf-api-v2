<?php

namespace App\HttpResponse;

use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;

class SuccessResponseBuilder extends AbstractResponseBuilder
{
    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * SuccessResponseBuilder constructor.
     *
     * @param ViewHandlerInterface $viewHandler
     */
    public function __construct(ViewHandlerInterface $viewHandler)
    {
        parent::__construct($viewHandler);

        try {
            $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));

            $normalizer = new ObjectNormalizer($classMetadataFactory);
            $callback = function ($dateTime) {
                return $dateTime instanceof \DateTime
                    ? $dateTime->format(\DateTime::ATOM)
                    : '';
            };

            $normalizer->setCallbacks(['createdAt' => $callback, 'updatedAt' => $callback]);

            $this->serializer = new Serializer(
                [$normalizer],
                [new JsonEncoder()]
            );
        } catch (\Exception $exception) {
            $this->getServerErrorResponseBuilder()->exception($exception);
        }
    }

    /**<
     * @param mixed $object
     * @param array $serializationGroups
     *
     * @return Response
     */
    public function buildSingleObjectResponse($object, array $serializationGroups = []): Response
    {
        if (null === $object) {
            return $this->getClientErrorResponseBuilder()->notFound();
        }

        if (is_array($object) && empty($object)) {
            return $this->getClientErrorResponseBuilder()->notFound();
        }

        $normalizedObject = $this->serializer->normalize(
            $object,
            null,
            ['groups' => $serializationGroups]
        );

        return $this->ok($normalizedObject);
    }

    /**
     * @param SlidingPagination $pagination
     * @param Request $request
     * @param Router  $router
     * @param array   $serializationGroups
     *
     * @return Response
     */
    public function buildMultiObjectResponse(
        SlidingPagination $pagination,
        Request $request,
        Router $router,
        array $serializationGroups = array()
    ): Response {
        if (empty($pagination->getItems())) {
            return $this->getSuccessResponseBuilder()->ok();
        }

        $paginationData = $pagination->getPaginationData();
        $link           = $this->buildPaginationLink($paginationData, $request, $router);

        $headers = [];
        if (!empty($link)) {
            $headers['Link'] = $link;
        }

        if (isset($paginationData['totalCount'])) {
            $headers['X-Total-Count'] = $paginationData['totalCount'];
        }

        $normalizedObjects = $this->serializer->normalize(
            $pagination->getItems(),
            null,
            ['groups' => $serializationGroups]
        );

        return $this->ok($normalizedObjects, $headers);
    }

    /**
     * @param       $object
     * @param array $serializationGroups
     *
     * @return Response
     */
    public function created($object, array $serializationGroups = []): Response
    {
        $normalizedObject = $this->serializer->normalize(
            $object,
            null,
            ['groups' => $serializationGroups]
        );

        return $this->handle(View::create($normalizedObject, Response::HTTP_CREATED));
    }

    /**
     * @param array   $paginationData
     * @param Request $request
     * @param Router  $router
     *
     * @return string
     */
    private function buildPaginationLink(array $paginationData, Request $request, Router $router): string
    {
        $routeBaseParameters = $request->query->all();

        $currentPage = array_key_exists('current', $paginationData) ? $paginationData['current'] : 1;
        $links       = [];
        foreach (['prev' => 'previous', 'next', 'first', 'last'] as $index => $page) {
            if (false === isset($paginationData[$page])) {
                continue;
            }

            if (false === array_key_exists($paginationData[$page], $links) && $paginationData[$page] !== $currentPage) {
                $routeBaseParameters['page']   = $paginationData[$page];
                $route = $router->generate($request->get('_route'), $routeBaseParameters, true);
                $rel = is_int($index) ? $page : $index;

                $links[$paginationData[$page]] = sprintf('<%s>; rel="%s"', $route, $rel);
            }
        }

        return implode(',', $links);
    }
}
