<?php

namespace Domain\Shared\Services\Lytko;

use Domain\Order\Actions\UpsertOrderAction;
use Domain\Order\DataTransferObjects\OrderData;
use Domain\Product\Actions\UpsertProductAction;
use Domain\Product\DataTransferObjects\ProductData;
use Domain\Shared\Services\Concerns\HasFake;
use Domain\User\Actions\CreateUserAction;
use Domain\User\DataTransferObjects\UserData;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class Client
{
    use HasFake;

    public function __construct(
        protected string $uri,
        protected string $username,
        protected string $password,
        protected int $timeout = 10,
        protected ?int $retryTimes = null,
        protected ?int $retryMilliseconds = null,
    ) {
    }

    private function request(): PendingRequest
    {
        $request = Http::withBasicAuth($this->username, $this->password)
            ->withHeaders([
                'Accept' => 'application/json',
            ])->timeout(
                seconds: $this->timeout,
            );

        if (! is_null($this->retryTimes) && ! is_null($this->retryMilliseconds)) {
            $request->retry(
                times: $this->retryTimes,
                sleepMilliseconds: $this->retryMilliseconds,
            );
        }

        return $request;
    }

    public function users(): Collection
    {
        $page = 1;
        $collection = new Collection();

        do {
            $response = $this->request()
                ->get("{$this->uri}/wp/v2/users", [
                    'context' => 'edit',
                    'per_page' => 100,
                    'page' => $page,
                ])->throw();

            foreach ($response->json() as $user) {
                $data = UserData::fromResponse($user);

                $collection->add(
                    item: CreateUserAction::execute($data),
                );
            }
            $page++;
        } while ($page <= $response->header('X-WP-TotalPages'));

        return $collection;
    }

    public function products(): Collection
    {
        $page = 1;
        $collection = new Collection();

        do {
            $response = $this->request()
                ->get("{$this->uri}/wc/v3/products", [
                    'status' => 'publish',
                    'per_page' => 100,
                    'page' => $page,
                ])->throw();

            foreach ($response->json() as $product) {
                $data = ProductData::fromResponse($product);

                $collection->add(
                    item: UpsertProductAction::execute($data),
                );
            }
            $page++;
        } while ($page <= $response->header('X-WP-TotalPages'));

        return $collection;
    }

    public function orders()
    {
        $page = 1;
        $collection = new Collection();

        do {
            $response = $this->request()
                ->get("{$this->uri}/wc/v3/orders", [
                    'per_page' => 100,
                    'context' => 'edit',
                    'page' => $page,
                ])->throw();

            foreach ($response->json() as $order) {
                $data = OrderData::fromResponse($order);

                $collection->add(
                    item: UpsertOrderAction::execute($data)
                );
            }
            $page++;
        } while ($page <= $response->header('X-WP-TotalPages'));

        return $collection->count();
    }
}
