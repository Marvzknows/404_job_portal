<?php

interface BaseRepositoryInterface
{

    public function create(array $data);

    public function delete(int $id);

    public function restore(int $id);
}
