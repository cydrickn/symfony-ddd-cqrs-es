<?php

declare(strict_types = 1);

namespace UI\Http\Api\Controller;

use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use UI\Http\Api\Request\CreateUserRequest;
use UI\Http\Api\Request\GetAllUserRequest;
use UI\Http\Api\Request\GetUserRequest;
use UI\Http\Bus\RequestBus;

/**
 * Description of UserController
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 *
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/create", methods={"POST"})
     * @SWG\Tag(name="User")
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     @SWG\Schema(
     *         @SWG\Property(property="username", type="string", example="admin"),
     *         @SWG\Property(property="password", type="string", example="admin")
     *     )
     * )
     * @SWG\Response(
     *     response=201,
     *     description="Successfully Created an account",
     *     @SWG\Schema(
     *         @SWG\Property(property="id", type="string", example="92960a78-2a43-4ccb-8c82-b436c831a532"),
     *         @SWG\Property(property="username", type="string", example="admin"),
     *         @SWG\Property(property="created_at", type="string", example="2019-02-03")
     *     )
     * )
     * @SWG\Response(
     *     response=422,
     *     description="Validation failed",
     *     @SWG\Schema(
     *         @SWG\Property(property="message", type="string", example="Invalid Input"),
     *         @SWG\Property(property="errors", type="object"),
     *     )
     * )
     */
    public function createUser(Request $request, RequestBus $bus): Response
    {
        $createUserRequest = CreateUserRequest::createFromRequest($request);

        return $bus->handle($createUserRequest);
    }

    /**
     * @Route("/get", methods={"GET"})
     * @SWG\Tag(name="User")
     * @SWG\Parameter(
     *     name="id",
     *     in="query",
     *     type="string"
     * )
     * @SWG\Response(
     *     response=200,
     *     description="OK"
     * )
     */
    public function getSpecificUser(Request $request, RequestBus $bus): Response
    {
        $getUserRequest = GetUserRequest::createFromRequest($request);

        return $bus->handle($getUserRequest);
    }

    /**
     * @Route("/all", methods={"GET"})
     * @SWG\Tag(name="User")
     * @SWG\Response(
     *     response=200,
     *     description="OK"
     * )
     */
    public function getAllUser(Request $request, RequestBus $bus): Response
    {
        $getUserAllRequest = GetAllUserRequest::createFromRequest($request);

        return $bus->handle($getUserAllRequest);
    }
}
