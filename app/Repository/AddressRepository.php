<?php
Namespace App\Repository;

use App\Models\Address;
use App\Services\ZipCodeService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class AddressRepository
{
    const PAGINATION_SIZE = 10;

    private Builder $query;

    public function __construct()
    {
        $this->query = Address::query();
    }

    public function findRegisterByParam(string $column, $value): int
    {
        return DB::table('addresses')->where("$column", $value)->count();
    }

    public function paginate()
    {
        $hasRegister = DB::table('addresses')->get()->count();
        if ($hasRegister === 0)
            return response()->json([
                'message' => 'Not content'
            ], 204);

        return $this->query->paginate(self::PAGINATION_SIZE);
    }

    public function create(array $payload)
    {
       $hasRegister = $this->findRegisterByParam('zip_code', $payload['zip_code']);;
        if ($hasRegister > 0)
            return response()->json([
            'message' => 'This zip code already exist'
        ], 502);

        return $this->query->create($payload);
    }

    public function find(int $id)
    {
        $hasRegister = $this->findRegisterByParam('id', $id);
        if ($hasRegister === 0)
            return response()->json([
                'message' => 'This id not exist'
            ], 404);
        return $this->query->findOrFail($id);
    }

    public function update(int $id, array $payload)
    {
        $hasRegister =  $this->findRegisterByParam('id', $id);
        if ($hasRegister === 0)
            return response()->json([
                'message' => 'This address not exist'
            ], 404);

        $this->query->find($id)->update($payload);
        return $this->query->find($id);
    }

    public function getPayloadFromRequest($data)
    {
        $service = new ZipCodeService;
        $addressData = $service->getAddressByZipcode($data['zip_code']);
        if (array_key_exists('erro', $addressData))
            return response()->json([
                'message' => 'This address not exist'
            ], 404);

        return [
            'zip_code' => $data['zip_code'],
            'house_number' => $data['house_number'],
            'complement' => $data['complement'],
            'street' => $addressData['logradouro'],
            'neighborhood' => $addressData['bairro'],
            'city' => $addressData['localidade'],
            'state' => $addressData['uf']
        ];
    }

    public function delete(int $id)
    {
        $hasRegister =  $this->findRegisterByParam('id', $id);
        if ($hasRegister === 0)
            return response()->json([
                'message' => 'This address not exist'
            ], 404);

        return $this->query->findOrFail($id)->delete();
    }
}
