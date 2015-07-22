<?php

namespace Jag\Common\Services;

// $Id$
// vim: expandtab sw=4 ts=4 sts=4:
# ***** BEGIN LICENSE BLOCK *****
# This file is part of HTML Sanitizer.
# Copyright (c) 2005-2011 Frederic Minne <zefredz@gmail.com>.
# All rights reserved.
#
# HTML Sanitizer is free software; you can redistribute it and/or modify
# it under the terms of the GNU Lesser General Public License as published by
# the Free Software Foundation; either version 3 of the License, or
# (at your option) any later version.
#
# HTML Sanitizer is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU Lesser General Public License
# along with HTML Sanitizer; if not, see <http://www.gnu.org/licenses/>.
#
# ***** END LICENSE BLOCK *****
/**
 * Sanitize HTML contents :
 * Remove dangerous tags and attributes that can lead to security issues like
 * XSS or HTTP response splitting
 *
 * @author    Frederic Minne <zefredz@gmail.com>
 * @copyright Copyright &copy; 2005-2011, Frederic Minne
 * @license   http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License version 3 or later
 * @version   1.1
 */
class HTMLSanitizer implements HTMLSanitizerInterface
{

    // Private fields
    private $_allowedTags;

    private $_allowJavascriptEvents;

    private $_allowJavascriptInUrls;

    private $_allowObjects;

    private $_allowScript;

    private $_allowStyle;

    private $_additionalTags;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->resetAll();
    }

    /**
     * (re)set all options to default value
     */
    public function resetAll()
    {
        $this->_allowDOMEvents = false;
        $this->_allowJavascriptInUrls = false;
        $this->_allowStyle = false;
        $this->_allowScript = false;
        $this->_allowObjects = false;
        $this->_allowStyle = false;
        $this->_allowedTags = '<a><br><b><h1><h2><h3><h4><h5><h6>'
            . '<img><li><ol><p><strong><table><tr><td><th><u><ul><thead>'
            . '<tbody><tfoot><em><dd><dt><dl><span><div><del><add><i><hr>'
            . '<pre><br><blockquote><address><code><caption><abbr><acronym>'
            . '<cite><dfn><q><ins><sup><sub><kbd><samp><var><tt><small><big>';
        $this->_additionalTags = '';
    }

    /**
     * Add additional tags to allowed tags
     *
     * @param string
     *
     * @access public
     */
    public function addAdditionalTags($tags)
    {
        $this->_additionalTags .= $tags;
    }

    /**
     * Allow iframes
     *
     * @access public
     */
    public function allowIframes()
    {
        $this->addAdditionalTags('<iframe>');
    }

    /**
     * Allow HTML5 media tags
     *
     * @access public
     */
    public function allowHtml5Media()
    {
        $this->addAdditionalTags('<canvas><video><audio>');
    }

    /**
     * Allow object, embed, applet and param tags in html
     *
     * @access public
     */
    public function allowObjects()
    {
        $this->_allowObjects = true;
    }

    /**
     * Allow DOM event on DOM elements
     *
     * @access public
     */
    public function allowDOMEvents()
    {
        $this->_allowDOMEvents = true;
    }

    /**
     * Allow script tags
     *
     * @access public
     */
    public function allowScript()
    {
        $this->_allowScript = true;
    }

    /**
     * Allow the use of javascript: in urls
     *
     * @access public
     */
    public function allowJavascriptInUrls()
    {
        $this->_allowJavascriptInUrls = true;
    }

    /**
     * Allow style tags and attributes
     *
     * @access public
     */
    public function allowStyle()
    {
        $this->_allowStyle = true;
    }

    /**
     * Helper to allow all javascript related tags and attributes
     *
     * @access public
     */
    public function allowAllJavascript()
    {
        $this->allowDOMEvents();
        $this->allowScript();
        $this->allowJavascriptInUrls();
    }

    /**
     * Allow all tags and attributes
     *
     * @access public
     */
    public function allowAll()
    {
        $this->allowAllJavascript();
        $this->allowObjects();
        $this->allowStyle();
        $this->allowIframes();
        $this->allowHtml5Media();
    }

    /**
     * Filter URLs to avoid HTTP response splitting attacks
     *
     * @access  public
     *
     * @param   string url
     *
     * @return  string filtered url
     */
    public function filterHTTPResponseSplitting($url)
    {
        $dangerousCharactersPattern = '~(\r\n|\r|\n|%0a|%0d|%0D|%0A)~';

        return preg_replace($dangerousCharactersPattern, '', $url);
    }

    /**
     * Remove potential javascript in urls
     *
     * @access  public
     *
     * @param   string url
     *
     * @return  string filtered url
     */
    public function removeJavascriptURL($str)
    {
        $HTML_Sanitizer_stripJavascriptURL = 'javascript:[^"]+';
        $str = preg_replace("/$HTML_Sanitizer_stripJavascriptURL/i"
            , '__forbidden__'
            , $str);

        return $str;
    }

    /**
     * Remove potential flaws in urls
     *
     * @access  private
     *
     * @param   string url
     *
     * @return  string filtered url
     */
    private function sanitizeURL($url)
    {
        if (! $this->_allowJavascriptInUrls) {
            $url = $this->removeJavascriptURL($url);
        }
        $url = $this->filterHTTPResponseSplitting($url);

        return $url;
    }

    /**
     * Callback for PCRE
     *
     * @access private
     *
     * @param matches array
     *
     * @return string
     * @see    sanitizeURL
     */
    private function _sanitizeURLCallback($matches)
    {
        return 'href="' . $this->sanitizeURL($matches[1]) . '"';
    }

    /**
     * Remove potential flaws in href attributes
     *
     * @access  private
     *
     * @param   string html tag
     *
     * @return  string filtered html tag
     */
    private function sanitizeHref($str)
    {
        $HTML_Sanitizer_URL = 'href="([^"]+)"';

        return preg_replace_callback("/$HTML_Sanitizer_URL/i"
            , [ &$this, '_sanitizeURLCallback' ]
            , $str);
    }

    /**
     * Callback for PCRE
     *
     * @access private
     *
     * @param matches array
     *
     * @return string
     * @see    sanitizeURL
     */
    private function _sanitizeSrcCallback($matches)
    {
        return 'src="' . $this->sanitizeURL($matches[1]) . '"';
    }

    /**
     * Remove potential flaws in href attributes
     *
     * @access  private
     *
     * @param   string html tag
     *
     * @return  string filtered html tag
     */
    private function sanitizeSrc($str)
    {
        $HTML_Sanitizer_URL = 'src="([^"]+)"';

        return preg_replace_callback("/$HTML_Sanitizer_URL/i"
            , [ &$this, '_sanitizeSrcCallback' ]
            , $str);
    }

    /**
     * Remove dangerous attributes from html tags
     *
     * @access  private
     *
     * @param   string html tag
     *
     * @return  string filtered html tag
     */
    private function removeEvilAttributes($str)
    {
        if (! $this->_allowDOMEvents) {
            $str = preg_replace_callback('/<(.*?)>/i'
                , [ &$this, '_removeDOMEventsCallback' ]
                , $str);
        }
        if (! $this->_allowStyle) {
            $str = preg_replace_callback('/<(.*?)>/i'
                , [ &$this, '_removeStyleCallback' ]
                , $str);
        }

        return $str;
    }

    /**
     * Remove DOM events attributes from html tags
     *
     * @access  private
     *
     * @param   string html tag
     *
     * @return  string filtered html tag
     */
    private function removeDOMEvents($str)
    {
        $str = preg_replace('/\s*=\s*/', '=', $str);
        $HTML_Sanitizer_stripAttrib = '(onclick|ondblclick|onmousedown|'
            . 'onmouseup|onmouseover|onmousemove|onmouseout|onkeypress|onkeydown|'
            . 'onkeyup|onfocus|onblur|onabort|onerror|onload)';
        $str = stripslashes(preg_replace("/$HTML_Sanitizer_stripAttrib/i"
            , 'forbidden'
            , $str));

        return $str;
    }

    /**
     * Callback for PCRE
     *
     * @access private
     *
     * @param matches array
     *
     * @return string
     * @see    removeDOMEvents
     */
    private function _removeDOMEventsCallback($matches)
    {
        return '<' . $this->removeDOMEvents($matches[1]) . '>';
    }

    /**
     * Remove style attributes from html tags
     *
     * @access  private
     *
     * @param   string html tag
     *
     * @return  string filtered html tag
     */
    private function removeStyle($str)
    {
        $str = preg_replace('/\s*=\s*/', '=', $str);
        $HTML_Sanitizer_stripAttrib = '(style)';
        $str = stripslashes(preg_replace("/$HTML_Sanitizer_stripAttrib/i"
            , 'forbidden'
            , $str));

        return $str;
    }

    /**
     * Callback for PCRE
     *
     * @access private
     *
     * @param matches array
     *
     * @return string
     * @see    removeStyle
     */
    private function _removeStyleCallback($matches)
    {
        return '<' . $this->removeStyle($matches[1]) . '>';
    }

    /**
     * Remove dangerous HTML tags
     *
     * @access  private
     *
     * @param   string html code
     *
     * @return  string filtered url
     */
    private function removeEvilTags($str)
    {
        $allowedTags = $this->_allowedTags;
        if ($this->_allowScript) {
            $allowedTags .= '<script>';
        }
        if ($this->_allowStyle) {
            $allowedTags .= '<style>';
        }
        if ($this->_allowObjects) {
            $allowedTags .= '<object><embed><applet><param>';
        }
        $allowedTags .= $this->_additionalTags;
        $str = strip_tags($str, $allowedTags);

        return $str;
    }

    /**
     * Sanitize HTML
     *  remove dangerous tags and attributes
     *  clean urls
     *
     * @access  public
     *
     * @param   string html code
     *
     * @return  string sanitized html code
     */
    public function sanitize($html)
    {
        $html = $this->removeEvilTags($html);
        $html = $this->removeEvilAttributes($html);
        $html = $this->sanitizeHref($html);
        $html = $this->sanitizeSrc($html);

        return $html;
    }
}

function html_sanitize($str)
{
    static $san = null;
    if (empty( $san )) {
        $san = new HTML_Sanitizer;
    }

    return $san->sanitize($str);
}

function html_loose_sanitize($str)
{
    static $san = null;
    if (empty( $san )) {
        $san = new HTML_Sanitizer;
        $san->allowAll();
    }

    return $san->sanitize($str);

}
