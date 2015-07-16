<?php

namespace Jag\Common\Services;

interface HTMLSanitizerInterface
{

    /**
     * @return mixed
     */
    public function resetAll();

    /**
     * @return mixed
     */
    public function allowAll();

    /**
     * @param $tags
     *
     * @return mixed
     */
    public function addAdditionalTags( $tags );

    /**
     * @param $html
     *
     * @return mixed
     */
    public function sanitize( $html );

}
