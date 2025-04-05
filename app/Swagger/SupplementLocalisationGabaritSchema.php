<?php

namespace App\Swagger;

/**
 * @OA\Schema(
 *     schema="SupplementLocalisation",
 *     type="object",
 *     title="Supplement Localisation",
 *     required={"lieu", "montant"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="lieu", type="string", example="Libreville"),
 *     @OA\Property(property="montant", type="integer", example=5000),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */

class SupplementLocalisationGabaritSchema
{
}