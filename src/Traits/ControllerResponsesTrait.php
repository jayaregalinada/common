<?php

namespace Jag\Common\Traits;

use Request;

class ControllerResponsesTrait
{
    /**
     * @param        $data
     * @param int    $statusCode
     * @param string $callback
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function responseInJson( $data, $statusCode = 200, $callback = 'callback' )
    {
        if( Request::ajax() || Request::wantsJson() )
            return response()->jsonp( Request::input( $callback ), $data, $statusCode );

        return response( $data, $statusCode );
    }

    /**
     * @param string $message
     * @param array  $data
     * @param int    $statusCode
     * @param string $callback
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function responseSuccess( $message = '', $data = [ ], $statusCode = 200, $callback = 'callback' )
    {
        return $this->responseInJson( [ 'success' => [
            'title' => 'Success!',
            'message' => $message,
            'data' => $data
        ] ], $statusCode, $callback );
    }

    /**
     * @param string $message
     * @param array  $data
     * @param int    $statusCode
     * @param string $callback
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function responseInSuccess( $message = '', $data = [ ], $statusCode = 200, $callback = 'callback' )
    {
        return $this->responseSuccess( $message, $data, $statusCode, $callback );
    }

    /**
     * @param string $message
     * @param array  $data
     * @param int    $statusCode
     * @param string $callback
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function responseError( $message = '', $data = [ ], $statusCode = 404, $callback = 'callback' )
    {
        return $this->responseInJson( [ 'error' => [
            'title' => 'Opps!',
            'message' => $message,
            'data' => $data
        ] ], $statusCode, $callback );
    }

    /**
     * @param string $message
     * @param array  $data
     * @param int    $statusCode
     * @param string $callback
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function responseInError( $message = '', $data = [ ], $statusCode = 404, $callback = 'callback' )
    {
        return $this->responseError( $message, $data, $statusCode, $callback );
    }

}
