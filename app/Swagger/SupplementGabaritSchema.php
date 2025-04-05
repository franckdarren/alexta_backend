<?php

namespace App\Swagger;

/**
 * @OA\Schema(
 *     schema="SupplementGabarit",
 *     type="object",
 *     title="Supplement Gabarit",
 *     required={"type", "montant"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="type", type="string", example="Type A"),
 *     @OA\Property(property="montant", type="integer", example=100),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */

class SupplementGabaritSchema
{
}