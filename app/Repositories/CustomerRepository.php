<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Models\User;

class CustomerRepository extends Repository
{
    public function model()
    {
        return Customer::class;
    }

    public function getAllOrFindBySearch()
    {
        $searchKey = \request('search');
        $customers = $this->model()::query();

        if ($searchKey) {
            $customers = $customers->whereHas('user', function ($user) use ($searchKey) {
                $user->where('first_name', 'like', "%{$searchKey}%")
                    ->orWhere('last_name', 'like', "%{$searchKey}%")
                    ->orWhere('email', 'like', "%{$searchKey}%");
            });
        }

        return $customers->latest('id')->paginate(20);
    }

    public function storeByUser(User $user): Customer
    {
        return $this->model()::create([
            'user_id' => $user->id
        ]);
    }
}
