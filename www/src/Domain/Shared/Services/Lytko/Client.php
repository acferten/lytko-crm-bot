<?php

namespace Domain\Shared\Services\Lytko;

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
        $response = $this->request()
            ->get("{$this->uri}/users", [
                'context' => 'edit',
                'per_page' => 5,
            ])->throw()
            ->json();

        $collection = new Collection();

        foreach ($response as $user) {
            $data = UserData::fromResponse($user);

            $collection->add(
                item: CreateUserAction::execute($data),
            );
        }

        return $collection;
    }
}
