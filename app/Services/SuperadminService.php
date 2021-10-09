<?php

namespace App\Services;

use App\Repositories\GeneralRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class SuperadminService
{
    private $generalRepository;
    private $userRepository;

    public function __construct(
        GeneralRepository $generalRepository,
        UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
        $this->generalRepository = $generalRepository;
    }

    public function create($data)
    {
        $data['password'] = Hash::make($data['password']);
        return $this->userRepository->createKomda($data);
    }

    public function list()
    {
        $data = $this->userRepository->listKomda();
        return $data->map(function ($item) {
            $province = $this->generalRepository->province($item->province_id);

            return [
                'id' => $item->id,
                'name' => $item->name,
                'email' => $item->email,
                'fullname' => $item->fullname,
                'phone_number' => $item->phone_number,
                'area' => $province->name,
                'area_id' => $province->id
            ];
        });
    }

    public function findUser($userID){
        return $this->userRepository->findUser($userID);
    }

    public function edit($data, $userID){
        return $this->userRepository->editKomda($data, $userID);
    }

    public function delete($userID){
        return $this->userRepository->deleteUser($userID);
    }
}
