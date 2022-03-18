<?php
/**
 * Created by PhpStorm.
 * User: Abnet
 * Date: 3/1/2021
 * Time: 11:46 AM
 */
namespace Application\conf;

class AuthConfiguration {

    public static $conf = [
        "user_auth" => [
            "table" => "Users",
            "with" => [
                "username",
                "password"
            ],
            "order" => "keep",//once
            "save" => ["id", "username", "role", "fullname", "image"]
        ],
        "admin_auth" => [
            "table" => "Admin",
            "with" => [
                "username",
                "password"
            ],
            "order" => "keep",
            "save" => ["id", "username", "role", "fullname"]
        ]
    ];

    /**
     * @var int
     * this variable should only be integer value which will set
     * after how many hours the token expired.
     */
    public static $TOKEN_EXPIRATION = 6;

}
