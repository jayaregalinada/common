<?php

namespace Jag\Common\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Whoops\Handler\JsonResponseHandler;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

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
                return response()->jsonp($request->input('callback'), $this->getJsonResponse($request, $e, $response), $response->getStatusCode());
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
        $whoops = new Run();
        if ($request->ajax() || $request->wantsJson()) {
            $whoops->pushHandler(new JsonResponseHandler);
        } else {
            $whoops->pushHandler(new PrettyPageHandler);
        }

        return response($whoops->handleException($e), $e->getStatusCode(), $e->getHeaders());
    }

    /**
     * @param \Illuminate\Http\Request  $request
     * @param \Exception                $exception
     * @param $response
     *
     * @return array
     */
    protected function getJsonResponse(Request $request, Exception $exception, $response)
    {
        $o = new \stdClass();
        $o->code = $response->getStatusCode();
        $o->title = $response::$statusTexts[$response->getStatusCode()];
        $o->message = $exception->getMessage();
        if ($request->input('with') == 'exception') {
            $o->exception = [
                'file'       => class_basename($exception->getFile()),
                'line'       => $exception->getLine(),
                'code'       => $exception->getCode(),
                'instanceof' => class_basename($exception),
            ];
        }

        return [ 'error' => $o ];
    }
}
