<?php

namespace App\Swagger;

/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     title="Utilisateur",
 *     required={"nom", "email", "role", "password"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nom", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", example="john.doe@example.com"),
 *     @OA\Property(property="role", type="string", example="Client"),
 *     @OA\Property(property="telephone", type="string", example="123456789"),
 *     @OA\Property(property="adresse", type="string", example="123 rue de Paris"),
 *     @OA\Property(property="zone_intervention", type="string", example="Paris"),
 *     @OA\Property(property="disponibilite", type="boolean", example=true),
 *     @OA\Property(property="ajoute_par", type="string", example="admin"),
 *     @OA\Property(property="team", type="string", example="Equipe 1"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class UserSchema
{
}