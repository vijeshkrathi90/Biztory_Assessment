<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use Illumniate\Http\Response;

/**
 * Class BaseController
 *
 * @package App\Http\Controllers\Api\v1
 */
class BaseController extends Controller
{
    /**
     * HTTP status code for the response.
     *
     * @var int
     */
    protected $statusCode = 200;

    /**
     * BaseController constructor.
     */
    public function __construct()
    {
        // Constructor logic, if any.
    }

    /**
     * Respond with an error.
     *
     * @param array $errors   Array of errors.
     * @param bool  $status   Status of the response.
     * @param bool  $error    Whether it's an error or not.
     * @param null  $message  Custom message for the response.
     * @param array $headers  Additional headers for the response.
     * @return mixed
     */
    public function respondWithError($errors = [], $status = false, $error = true, $message = null, $headers = [])
    {
        return $this->respond([], $errors, $status, $error, $message, $headers);
    }

    /**
     * Respond with a formatted response.
     *
     * @param array $data     Data to be included in the response.
     * @param array $errors   Array of errors.
     * @param bool  $status   Status of the response.
     * @param bool  $error    Whether it's an error or not.
     * @param null  $message  Custom message for the response.
     * @param array $headers  Additional headers for the response.
     * @return mixed
     */
    public function respond($data = [], $errors = [], $status = false, $error = false, $message = null, $headers = [])
    {
        $response = [
            'statusCode' => $this->getStatusCode(),
            'message' => $message,
            'error' => $error,
            'status' => $status,
            'errors' => $errors,
        ];

        if ($this->getStatusCode() == 200) {
            $response['response'] = [
                'data' => $data
            ];
        }

        return response()->json(
            $response,
            $this->getStatusCode(),
            $headers
        );
    }

    /**
     * Get the HTTP status code.
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Set the HTTP status code.
     *
     * @param int $statusCode  HTTP status code.
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * Respond with an object created message.
     *
     * @param array $errors   Array of errors.
     * @param bool  $status   Status of the response.
     * @param bool  $error    Whether it's an error or not.
     * @param null  $message  Custom message for the response.
     * @return mixed
     */
    public function respondObjectCreated($errors = [], $status = false, $error = true, $message = 'Object Created!')
    {
        return $this->setStatusCode(201)->respondWithError($errors, $status, $error, $message);
    }

    /**
     * Respond with a no content message.
     *
     * @param array $errors   Array of errors.
     * @param bool  $status   Status of the response.
     * @param bool  $error    Whether it's an error or not.
     * @param null  $message  Custom message for the response.
     * @return mixed
     */
    public function respondNoContent($errors = [], $status = false, $error = true, $message = 'No Content!')
    {
        return $this->setStatusCode(204)->respondWithError($errors, $status, $error, $message);
    }

    /**
     * Respond with a partial content message.
     *
     * @param array $data     Data to be included in the response.
     * @param null  $message  Custom message for the response.
     * @return mixed
     */
    public function respondPartialContent($data = [], $message = 'Partial Content!')
    {
        //return $this->setStatusCode(206)->respond($data, [], true, false, $message);
        return $this->setStatusCode(206)->respond($data, false, true,  $message);
    }

    /**
     * Respond with a bad request message.
     *
     * @param array $errors   Array of errors.
     * @param bool  $status   Status of the response.
     * @param bool  $error    Whether it's an error or not.
     * @param null  $message  Custom message for the response.
     * @return mixed
     */
    public function respondBadRequest($errors = [], $status = false, $error = true, $message = 'Bad Request!')
    {
        return $this->setStatusCode(400)->respondWithError($errors, $status, $error, $message);
    }

    /**
     * Respond with an unauthorized message.
     *
     * @param array $errors   Array of errors.
     * @param bool  $status   Status of the response.
     * @param bool  $error    Whether it's an error or not.
     * @param null  $message  Custom message for the response.
     * @return mixed
     */
    public function respondUnauthorized($errors = [], $status = false, $error = true, $message = 'Unauthorized!')
    {
        return $this->setStatusCode(401)->respondWithError($errors, $status, $error, $message);
    }

    /**
     * Respond with a forbidden message.
     *
     * @param array $errors   Array of errors.
     * @param bool  $status   Status of the response.
     * @param bool  $error    Whether it's an error or not.
     * @param null  $message  Custom message for the response.
     * @return mixed
     */
    public function respondForbidden($errors = [], $status = false, $error = true, $message = 'Forbidden!')
    {
        return $this->setStatusCode(403)->respondWithError($errors, $status, $error, $message);
    }

    /**
     * Respond with a not found message.
     *
     * @param array $errors   Array of errors.
     * @param bool  $status   Status of the response.
     * @param bool  $error    Whether it's an error or not.
     * @param null  $message  Custom message for the response.
     * @return mixed
     */
    public function respondNotFound($errors = [], $status = false, $error = true, $message = 'Records Not Found!')
    {
        return $this->setStatusCode(404)->respondWithError($errors, $status, $error, $message);
    }

    /**
     * Respond with a method not allowed message.
     *
     * @param array $errors   Array of errors.
     * @param bool  $status   Status of the response.
     * @param bool  $error    Whether it's an error or not.
     * @param null  $message  Custom message for the response.
     * @return mixed
     */
    public function respondMethodNotAllowed($errors = [], $status = false, $error = true, $message = 'Method Not Allowed!')
    {
        return $this->setStatusCode(405)->respondWithError($errors, $status, $error, $message);
    }

    /**
     * Respond with a method already exists message.
     *
     * @param array $errors   Array of errors.
     * @param bool  $status   Status of the response.
     * @param bool  $error    Whether it's an error or not.
     * @param null  $message  Custom message for the response.
     * @return mixed
     */
    public function respondMethodAlreadyExists($errors = [], $status = false, $error = true, $message = 'Method Already Exists!')
    {
        return $this->setStatusCode(409)->respondWithError($errors, $status, $error, $message);
    }

    /**
     * Respond with an unprocessable entity message.
     *
     * @param array $errors   Array of errors.
     * @param bool  $status   Status of the response.
     * @param bool  $error    Whether it's an error or not.
     * @param null  $message  Custom message for the response.
     * @return mixed
     */
    public function respondUnprocessableEntity($errors = [], $status = false, $error = true, $message = 'Unprocessable Entity!')
    {
        return $this->setStatusCode(422)->respondWithError($errors, $status, $error, $message);
    }

    /**
     * Respond with an internal error message.
     *
     * @param array $errors   Array of errors.
     * @param bool  $status   Status of the response.
     * @param bool  $error    Whether it's an error or not.
     * @param null  $message  Custom message for the response.
     * @return mixed
     */
    public function respondInternalError($errors = [], $status = false, $error = true, $message = 'Internal Error!')
    {
        return $this->setStatusCode(500)->respondWithError($errors, $status, $error, $message);
    }

    /**
     * Respond with a service unavailable message.
     *
     * @param string $message  Custom message for the response.
     * @return mixed
     */
    public function respondServiceUnavailable($message = 'Service Unavailable!')
    {
        return $this->setStatusCode(503)->respondWithError([], false, $message);
    }
}
