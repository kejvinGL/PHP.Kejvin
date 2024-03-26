<?php

namespace Models;

interface BaseModel
{

    public function select(): array;
    public function update(): int;
    public function delete(): int;
    public function all(): array;
}
