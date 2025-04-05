<?php

namespace App\Swagger;

/**
 * @OA\Schema(
 *     schema="Service",
 *     type="object",
 *     title="Service",
 *     required={"nom", "description", "prix_base"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nom", type="string", example="Service de transport"),
 *     @OA\Property(property="description", type="string", example="Service de transport rapide"),
 *     @OA\Property(property="prix_base", type="integer", example=1500),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class ServiceSchema
{
}