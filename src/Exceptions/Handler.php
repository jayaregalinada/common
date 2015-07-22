<?php

namespace Jag\Common\Exceptions;

use Exception;
use Whoops\Run;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Handler\JsonResponseHandler;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception               $e
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if (config('app.debug')) {
            return $this->renderExceptionWithWhoops($request, $e);
        } else {
            $response = parent::render($request, $e);
            if ($request->ajax() || $request->wantsJson()) {
                return response()->jsonp($request->input('callback'), $this->getJsonResponse($request, $response),
                    $response->getStatusCode());
            } else {
                return $response;
            }
        }
    }

    /**
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception               $e
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function renderExceptionWithWhoops($request, Exception $e)
    {
        $whoops = new Run;
        if ($request->ajax() || $request->wantsJson()) {
            $whoops->pushHandler(new JsonResponseHandler);
        } else {
            $whoops->pushHandler(new PrettyPageHandler);
        }

        return response($whoops->handleException($e), $e->getStatusCode(), $e->getHeaders());
    }

    /**
     * @param \Illuminate\Http\Request  $request
     * @param \Illuminate\Http\Response $response
     *
     * @return array
     */
    protected function getJsonResponse(Request $request, Response $response)
    {
        $o = new \stdClass;
        $o->code = $response->getStatusCode();
        $o->title = $response::$statusTexts[$response->getStatusCode()];
        $o->message = $response->exception->getMessage();
        if ($request->input('with') == 'exception') {
            $o->exception = [
                'file'       => class_basename($response->exception->getFile()),
                'line'       => $response->exception->getLine(),
                'code'       => $response->exception->getCode(),
                'instanceof' => class_basename($response->exception),
            ];
        }

        return [ 'error' => $o ];
    }
}
