<?php
namespace Auth;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
class useGuard {

    public function __construct(public string $guardName) {}
}