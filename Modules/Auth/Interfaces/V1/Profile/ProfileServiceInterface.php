<?php

namespace Modules\Auth\Interfaces\V1\Profile;

use Modules\Auth\DTO\V1\ProfileDTO;

interface ProfileServiceInterface
{
    public function show(string $user_id);
    public function update(string $clientId, ProfileDTO $DTO);
    public function delete(string $user_id);
}
