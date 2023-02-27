<?php

/**
 * Session Interface.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 15/02/23
 */

declare(strict_types = 1);

namespace App\Interface;

interface SessionInterface
{
    public function start() : void;

    public function save() : void;

    public function isActive() : bool;

    public function get(string $key, mixed $default = 'null') : mixed;

    public function regenerate() : bool;

    public function store(string $key, mixed $value) : void;

    public function exists(string $key) : bool;

    public function delete(string $key) : void;

    public function destroy() : void;
}