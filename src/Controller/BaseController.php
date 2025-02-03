<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route("api/")]
class BaseController extends AbstractController
{
    public $USERS_DATA = [
        [
            'id' => '1',
            'name' => "Maks",
            'email' => "ipz231_pmo@student.ztu.edu.ua"
        ],
        [
            'id' => '2',
            'name' => "Maks",
            'email' => "ipz231_pmo@student.ztu.edu.ua"
        ],
        [
            'id' => '3',
            'name' => "Maks",
            'email' => "ipz231_pmo@student.ztu.edu.ua"
        ],
        [
            'id' => '4',
            'name' => "Maks",
            'email' => "ipz231_pmo@student.ztu.edu.ua"
        ],
        [
            'id' => '5',
            'name' => "Maks",
            'email' => "ipz231_pmo@student.ztu.edu.ua"
        ],
    ];



    #[Route("", methods: ["GET"])]
    public function ApiIndex() : JsonResponse
    {
        return new JsonResponse(['data' => "It works!"], JsonResponse::HTTP_OK);
    }

    #[Route("get-all/", methods: ["GET"])]
    public function ApiGetAllUsers() : JsonResponse
    {
        return new JsonResponse(['data' => $this->USERS_DATA], JsonResponse::HTTP_OK);
    }

    #[Route("get-user/{id}/", methods: ["GET"])]
    public function ApiGetUser(string $id) : JsonResponse
    {
        $userData = $this->getUserData($id);
        if (!$userData)
            return new JsonResponse(['data' => []], JsonResponse::HTTP_NOT_FOUND);
        return new JsonResponse(['data' => $userData], JsonResponse::HTTP_OK);
    }

    #[Route("create-user/", methods: ["POST"])]
    #[IsGranted("ROLE_ADMIN")]
    public function ApiCreateUser(Request $request) : JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);
        if (!isset($requestData['name'], $requestData['email']))
            return new JsonResponse(['data' => ["Not all data are given"]], JsonResponse::HTTP_LOCKED);
        $countOfUsers = count($this->USERS_DATA);
        $newUser = [
            'id'    => $countOfUsers + 1,
            'name'  => $requestData['name'],
            'email' => $requestData['email']
        ];
        return new JsonResponse(['data' => $newUser], Response::HTTP_CREATED);
    }


    #[Route("delete-user/{id}/", methods: ["DELETE"])]
    #[IsGranted("ROLE_ADMIN")]
    public function ApiDeleteUser(string $id) : JsonResponse
    {
        $userData = $this->getUserData($id);
        if (!$userData)
            return new JsonResponse(['data' => []], JsonResponse::HTTP_NOT_FOUND);
        return new JsonResponse(['data' => []], Response::HTTP_NO_CONTENT);
    }

    #[Route('update-user/{id}/', methods: ['PATCH'])]
    #[IsGranted("ROLE_ADMIN")]
    public function updateItem(string $id, Request $request): JsonResponse
    {
        $userData = $this->getUserData($id);
        $requestData = json_decode($request->getContent(), true);
        if (isset($requestData['name']))
            $userData['name'] = $requestData['name'];
        if (isset($requestData['email']))
            $userData['email'] = $requestData['email'];
        return new JsonResponse(['data' => $userData], Response::HTTP_OK);
    }





    private function getUserData($id) : array
    {
        $userData = null;
        foreach ($this->USERS_DATA as $user) {
            if (!isset($user['id'])) continue;
            if ($user['id'] == $id)
            {
                $userData = $user;
                break;
            }
        }
        return $userData;
    }
}