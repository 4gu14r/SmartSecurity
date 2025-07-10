<?php

namespace SmartSecurity\Utils;

class Session
{
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public static function set(string $key, mixed $value): void
    {
        self::start();
        $_SESSION[$key] = $value;
    }
    
    public static function get(string $key, mixed $default = null): mixed
    {
        self::start();
        return $_SESSION[$key] ?? $default;
    }
    
    public static function has(string $key): bool
    {
        self::start();
        return isset($_SESSION[$key]);
    }
    
    public static function remove(string $key): void
    {
        self::start();
        unset($_SESSION[$key]);
    }
    
    public static function destroy(): void
    {
        self::start();
        session_destroy();
    }
    
    public static function regenerateId(): void
    {
        self::start();
        session_regenerate_id(true);
    }
    
    public static function flash(string $key, mixed $value): void
    {
        self::set("flash_{$key}", $value);
    }
    
    public static function getFlash(string $key, mixed $default = null): mixed
    {
        $value = self::get("flash_{$key}", $default);
        self::remove("flash_{$key}");
        return $value;
    }
    
    public static function isLoggedIn(): bool
    {
        return self::has('user_id');
    }
    
    public static function getUserId(): ?int
    {
        return self::get('user_id');
    }
    
    public static function getUserRole(): ?string
    {
        return self::get('user_role');
    }
    
    public static function login(int $userId, string $role, array $userData = []): void
    {
        self::regenerateId();
        self::set('user_id', $userId);
        self::set('user_role', $role);
        self::set('user_data', $userData);
    }
    
    public static function logout(): void
    {
        self::destroy();
    }
}

