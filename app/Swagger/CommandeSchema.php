<?php

namespace App\Swagger;

/**
 * @OA\Schema(
 *     schema="Commande",
 *     type="object",
 *     title="Commande",
 *     required={"status", "localisation", "prix_total"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="status", type="string", example="en attente"),
 *     @OA\Property(property="localisation", type="string", example="Libreville"),
 *     @OA\Property(property="prix_total", type="string", example="15000"),
 *     @OA\Property(property="service_id", type="integer", example=1),
 *     @OA\Property(property="user_id", type="integer", example=2),
 *     @OA\Property(property="supplement_gabarit_id", type="integer", example=1),
 *     @OA\Property(property="supplement_localisation_id", type="integer", example=1),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */

class CommandeSchema
{
}