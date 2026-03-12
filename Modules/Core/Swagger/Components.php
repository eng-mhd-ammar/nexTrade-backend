<?php

namespace Modules\Core\Swagger;

/**
 * @OA\Components(
 *     @OA\Response(
 *         response="Unauthorized",
 *         description="Unauthenticated",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Unauthenticated.")
 *         )
 *     ),
 *     @OA\Response(
 *         response="ServerError",
 *         description="Server Exception",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Server Exception occurred.")
 *         )
 *     ),
 *     @OA\Response(
 *         response="ValidationError",
 *         description="Validation errors",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="success", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Validation errors occurred"),
 *             @OA\Property(
 *                 property="errors",
 *                 type="object",
 *                 @OA\Property(property="field", type="string", example="Field is required.")
 *             )
 *         )
 *     ),
 * 
 *     @OA\Parameter(
 *         parameter="AllParam",
 *         name="all",
 *         in="query",
 *         description="If true, return all addresses. If false or omitted, return only authenticated user's addresses (admin only).",
 *         required=false,
 *         @OA\Schema(type="boolean", example=false)
 *     ),
 *     @OA\Parameter(
 *         parameter="FilterTrashedParam",
 *         name="filter[trashed]",
 *         in="query",
 *         description="Include soft deleted records: only | with (admin only)",
 *         required=false,
 *         @OA\Schema(type="string", enum={"only","with"}, nullable=true)
 *     ),
 *     @OA\Parameter(
 *         parameter="FilterUserParam",
 *         name="filter[user_id]",
 *         in="query",
 *         description="Filter addresses by user id (admin only)",
 *         required=false,
 *         @OA\Schema(type="string", format="uuid", example="a036a04c-fa1f-40f5-bd10-6b1bea56e9b4")
 *     ),
 *     @OA\Parameter(
 *         parameter="FilterStateParam",
 *         name="filter[state_id]",
 *         in="query",
 *         description="Filter addresses by state id",
 *         required=false,
 *         @OA\Schema(type="string", example="12")
 *     ),
 *
 *     @OA\RequestBody(
 *         request="AddressRequestBody",
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="user_id", type="string", format="uuid", example="a036a04c-fa1f-40f5-bd10-6b1bea56e9b4"),
 *             @OA\Property(property="state_id", type="string", example="12"),
 *             @OA\Property(property="name", type="string", example="Home"),
 *             @OA\Property(property="lng", type="number", format="float", example=36.2765),
 *             @OA\Property(property="lat", type="number", format="float", example=33.5138),
 *             @OA\Property(property="area", type="string", example="Downtown"),
 *             @OA\Property(property="street_name", type="string", example="Main Street"),
 *             @OA\Property(property="phone", type="string", example="+963991234567"),
 *             @OA\Property(property="details", type="string", example="Near the central park")
 *         )
 *     )
 * )
 */
class Components {}
