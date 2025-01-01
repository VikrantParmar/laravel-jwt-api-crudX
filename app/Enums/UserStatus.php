<?php
/**
 * Created by PhpStorm.
 * User: VP
 * Date: 29/10/2024
 * Time: 04:08 PM
 */
namespace App\Enums;

class UserStatus
{
    const Active = 1;
    const Inactive = 0;
    const Pending = 2;
    const Banned = 3;
    const Deleted = 4;

    // Optionally, add a method to get the names of the constants
    public static function getValues()
    {
        return [
            self::Active => 'Active',
            self::Inactive => 'Inactive',
            self::Pending => 'Pending',
            self::Banned => 'Banned',
            self::Deleted => 'Deleted',
        ];
    }
}
