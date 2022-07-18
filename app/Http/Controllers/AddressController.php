<?php

namespace App\Http\Controllers;

use App\Repository\AddressRepository;
use App\Services\ZipCodeService;
use App\Http\Requests\AddressRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddressController extends Controller
{
    private AddressRepository $repository;

    public function __construct(AddressRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAddressByZipcode(string $zipcode)
    {
        $service = new ZipCodeService;
        $response = $service->getAddressByZipcode($zipcode);
        if (array_key_exists('erro', $response)) {
            return response()->json([
                'message' => 'This zip code not exist'
            ], 404);
        }
        if (!$response)
            return response()->json([
                'message' => 'Zip code need 8 characters'
            ], 404);

        return response()->json($response);
    }

    public function getAddresses()
    {
        return response()->json(
            $this->repository->paginate()
        );
    }

    public function getAddress(int $id)
    {
        return response()->json(
            $this->repository->find($id)
        );
    }

    public function postAddress(AddressRequest $request)
    {
        $payload = $this->repository->getPayloadFromRequest($request);
        return response()->json(
            $this->repository->create($payload),
            Response::HTTP_CREATED
        );
    }

    public function putAddress(AddressRequest $request, int $id)
    {
        $payload = $this->repository->getPayloadFromRequest($request);
        return response()->json(
            $this->repository->update($id, $payload)
        );
    }

    public function deleteAddress(int $address)
    {
        return response()->json(
            $this->repository->delete($address),
            Response::HTTP_NO_CONTENT
        );
    }
}
