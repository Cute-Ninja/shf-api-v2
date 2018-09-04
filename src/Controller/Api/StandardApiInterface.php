<?php

namespace App\Controller\Api;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface StandardApiInterface
{
    public function getMany(Request $request): Response;

    public function getOne(Request $request, int $id): Response;

    public function post(Request $request): Response;

    public function put(Request $request, int $id): Response;

    public function delete(Request $request, int $id): Response;
}