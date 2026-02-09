<?php

interface UserRepositoryInterface
{
    public function findByEmail(string $email);

    public function register(array $data);
}
