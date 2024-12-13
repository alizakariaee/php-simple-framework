<?php

namespace Module;

use controllerInterface\User as userInterface;
use Module\userService as userService;
use Http\BaseController;
use Request\Body;
use Request\Json;
use Request\Headers;

final class userController extends BaseController implements userInterface
{

    private const userData = [
        'fname' => 'string|min:3',
        'lname' => string
    ];

    public function __construct(
        private ?userService $userService = null
    ) {
        $this->userService = $userService ?: new userService();
    }

    /**
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->json($this->userService->findById($id));
    }

    public function login(Body $data): mixed
    {
        return true;
    }

    public function update(
        Json $data = self::userData,
        int $id = 0
    ): mixed {

        return $this->end("User $id Info : " . print_r($data->getAll(), true));
    }


    public function checkToken(Headers $headers): mixed
    {
        $getData = $this->httpData();
        return $headers->authorization->Bearer();
    }
}
