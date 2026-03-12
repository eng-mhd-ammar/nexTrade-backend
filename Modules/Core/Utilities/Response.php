<?php

namespace Modules\Core\Utilities;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class Response extends HttpFoundationResponse
{
    public const HTTP_CONTINUE = 100;
    public const HTTP_SWITCHING_PROTOCOLS = 101;
    public const HTTP_PROCESSING = 102;            // RFC2518
    public const HTTP_EARLY_HINTS = 103;           // RFC8297
    public const HTTP_OK = 200;
    public const HTTP_CREATED = 201;
    public const HTTP_ACCEPTED = 202;
    public const HTTP_NON_AUTHORITATIVE_INFORMATION = 203;
    public const HTTP_NO_CONTENT = 204;
    public const HTTP_RESET_CONTENT = 205;
    public const HTTP_PARTIAL_CONTENT = 206;
    public const HTTP_MULTI_STATUS = 207;          // RFC4918
    public const HTTP_ALREADY_REPORTED = 208;      // RFC5842
    public const HTTP_IM_USED = 226;               // RFC3229
    public const HTTP_MULTIPLE_CHOICES = 300;
    public const HTTP_MOVED_PERMANENTLY = 301;
    public const HTTP_FOUND = 302;
    public const HTTP_SEE_OTHER = 303;
    public const HTTP_NOT_MODIFIED = 304;
    public const HTTP_USE_PROXY = 305;
    public const HTTP_RESERVED = 306;
    public const HTTP_TEMPORARY_REDIRECT = 307;
    public const HTTP_PERMANENTLY_REDIRECT = 308;  // RFC7238
    public const HTTP_BAD_REQUEST = 400;
    public const HTTP_UNAUTHORIZED = 401;
    public const HTTP_PAYMENT_REQUIRED = 402;
    public const HTTP_FORBIDDEN = 403;
    public const HTTP_NOT_FOUND = 404;
    public const HTTP_METHOD_NOT_ALLOWED = 405;
    public const HTTP_NOT_ACCEPTABLE = 406;
    public const HTTP_PROXY_AUTHENTICATION_REQUIRED = 407;
    public const HTTP_REQUEST_TIMEOUT = 408;
    public const HTTP_CONFLICT = 409;
    public const HTTP_GONE = 410;
    public const HTTP_LENGTH_REQUIRED = 411;
    public const HTTP_PRECONDITION_FAILED = 412;
    public const HTTP_REQUEST_ENTITY_TOO_LARGE = 413;
    public const HTTP_REQUEST_URI_TOO_LONG = 414;
    public const HTTP_UNSUPPORTED_MEDIA_TYPE = 415;
    public const HTTP_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    public const HTTP_EXPECTATION_FAILED = 417;
    public const HTTP_I_AM_A_TEAPOT = 418;                                               // RFC2324
    public const HTTP_MISDIRECTED_REQUEST = 421;                                         // RFC7540
    public const HTTP_UNPROCESSABLE_ENTITY = 422;                                        // RFC4918
    public const HTTP_LOCKED = 423;                                                      // RFC4918
    public const HTTP_FAILED_DEPENDENCY = 424;                                           // RFC4918
    public const HTTP_TOO_EARLY = 425;                                                   // RFC-ietf-httpbis-replay-04
    public const HTTP_UPGRADE_REQUIRED = 426;                                            // RFC2817
    public const HTTP_PRECONDITION_REQUIRED = 428;                                       // RFC6585
    public const HTTP_TOO_MANY_REQUESTS = 429;                                           // RFC6585
    public const HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE = 431;                             // RFC6585
    public const HTTP_UNAVAILABLE_FOR_LEGAL_REASONS = 451;                               // RFC7725
    public const HTTP_INTERNAL_SERVER_ERROR = 500;
    public const HTTP_NOT_IMPLEMENTED = 501;
    public const HTTP_BAD_GATEWAY = 502;
    public const HTTP_SERVICE_UNAVAILABLE = 503;
    public const HTTP_GATEWAY_TIMEOUT = 504;
    public const HTTP_VERSION_NOT_SUPPORTED = 505;
    public const HTTP_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL = 506;                        // RFC2295
    public const HTTP_INSUFFICIENT_STORAGE = 507;                                        // RFC4918
    public const HTTP_LOOP_DETECTED = 508;                                               // RFC5842
    public const HTTP_NOT_EXTENDED = 510;                                                // RFC2774
    public const HTTP_NETWORK_AUTHENTICATION_REQUIRED = 511;

    public function __construct(private $collection = null)
    {
    }

    public function success($collection = null, ?string $message = null, bool $status = true, int $code = self::HTTP_OK, ?string $resName = 'data', array $headers = []): JsonResponse
    {
        $response = [];

        $response['status'] = $status;
        // $response['message'] = is_null($message) ? null : str(translate($message))->title();
        $response['message'] = is_null($message) ? null : str($message)->title();
        $response[$resName] = $collection ?? $this->collection;

        return response()->json($response, $code, $headers);
    }


    public function error(?string $message = null, int $code = self::HTTP_NOT_FOUND, array $headers = []): JsonResponse
    {
        $isNotInternalError = $code != self::HTTP_INTERNAL_SERVER_ERROR;
        // $response = ['status' => false, 'message' => str(translate($message, catch: $isNotInternalError))->when($isNotInternalError, fn($str) => $str->title())];
        $response = ['status' => false, 'message' => str($message)->when($isNotInternalError, fn ($str) => $str->title())];

        // $response['message'] ??= translate('Something Went Wrong');
        $response['message'] ??= 'Something Went Wrong';

        $response['message'] = $response['message'];

        return response()->json($response, $code, $headers);
    }

    public function errors(array $messages = [], int $code = self::HTTP_UNPROCESSABLE_ENTITY, array $headers = []): JsonResponse
    {
        $translatedMessages = [];
        $isNotInternalError = $code != self::HTTP_INTERNAL_SERVER_ERROR;
        foreach ($messages as $key => $message) {
            // $translatedMessages[$key] = str(translate($message, catch: $isNotInternalError))
            $translatedMessages[$key] = str($message)
                ->when($isNotInternalError, fn ($str) => $str->title());
        }

        $response = ['status' => false, 'errors' => $translatedMessages];

        return response()->json($response, $code, $headers);
    }


    public function download(string $path, string $name): bool|Response
    {
        if (File::exists(asset($path))) {
            return response()->download($path, $name);
        }
        return false;
    }
}
