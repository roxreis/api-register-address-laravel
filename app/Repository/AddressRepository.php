<?php
Namespace App\Repository;

use App\Models\Address;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;


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
    public function create(array $payload): Address
    {
        return $this->query->create($payload);
    }

    public function find(int $id): Address
    {
        return $this->query->findOrFail($id);
    }

    public function update(int $id, array $payload): Address
    {
        $this->query->find($id)->update($payload);
        return $this->query->find($id);
    }

    public function delete(int $id): bool
    {
        return $this->query->findOrFail($id)->delete();
    }
}
