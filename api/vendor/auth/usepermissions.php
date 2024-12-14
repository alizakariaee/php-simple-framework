<?php
namespace Auth;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
class usePermissions {

    public array $roles;

    public function __construct(string ...$roles) {
        $this->roles = $roles;
    }
}