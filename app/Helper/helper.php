<?php

if (!function_exists('tokenNameGenerator')) {
    /**
     * Generates the name of a token.
     *
     * @param string $token The token to generate the name for.
     * @return string The generated token name.
     */
    function tokenNameGenerator(string $token): string
    {
        return 'hello';
    }
}
