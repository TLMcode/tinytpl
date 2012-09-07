<?php
/*
 * index.php
 *
 * Copyright 2012 derRaphael <software@itholic.org>
 *
 * Basic index.php for usage with tinyTpl
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are
 * met:
 *
 * * Redistributions of source code must retain the above copyright
 *   notice, this list of conditions and the following disclaimer.
 * * Redistributions in binary form must reproduce the above
 *   copyright notice, this list of conditions and the following disclaimer
 *   in the documentation and/or other materials provided with the
 *   distribution.
 * * Neither the name of the  nor the names of its
 *   contributors may be used to endorse or promote products derived from
 *   this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 */

/**
 *
 * Configuration of tinyTpl happens to be in an own config class in the
 * tinyTpl namespace. If nothing is defined in here or if this class doesn't
 * exists, default values will be used.
 *
**/
namespace tinyTpl
{
    class config
    {
        public static
            $dev_state = "dev";
    }
}

namespace
{
    try {

        // That's all it takes. Just invoke the main tinyTpl class - fairly simple.
        require_once( dirname( $_SERVER["DOCUMENT_ROOT"] ) . "/lib/tiny.class.php" );

        // dump the result based on given master_tpl
        echo $tiny::sys()->html( "master_tpl" );

    } catch ( Exception $e ) {

        // FCGI Check for proper Header
        if ( any_array_key_exists( array( "FCGI_ROLE","PHP_FCGI_CHILDREN","PHP_FCGI_MAX_REQUESTS" ), $_SERVER ) )
        {
            $header_prefix = "Status:";

        } else if ( array_key_exists('SERVER_PROTOCOL', $_SERVER) ) {

            $header_prefix = $_SERVER["SERVER_PROTOCOL"];

        } else {

            $header_prefix = "HTTP/1.0";
        }
        header( $header_prefix . " 500 Internal Server Error.", true, 500 );

        /*
         * Dump a friendly error page, since we have an 500 Internal Server Error.
         * It's hardcoded in here, for the case that everything else fails.
         *
         * When available (and working) tinyTpl attempts to show the buildin
         * errorpages or even custom defined ones.
         */
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="description" content="Internal Server Error">
	<meta name="author" content="tinyTpl">
	<meta name="viewport" content="width=device-width">
	<title>Internal Server Error</title>
    <style type="text/css">
        html,body { margin:0;padding:0;height:100%; font-size: 14px; }
        body { background: #000; font-size: 1.1em; font-family: serif; color: #eee; }
        div.container { min-height:100%;position:relative; }
        div.bg { position:absolute; top: 0; left: 0; bottom: 0; right: 0; width: auto; height: auto;
            overflow: hidden; }
        div.bg div { position: absolute; bottom: -30%; right: 0; font-size: 45em; letter-spacing: -.09em;
            font-weight:bold; color: #222; color: rgba(0,0,0,.25); text-shadow: 0 0 1em #444; }
        div.box { position: absolute; left: 1em; right: 1em; top: 1em; bottom: 1em; width: auto; height: auto;
            background: rgba(64,16,16,.5); padding: 3em; margin: 3em; font-family: sans;
            -webkit-border-radius: 2em; -moz-border-radius: 2em; border-radius: 2em;}
        div.box h1 { color: #888; text-shadow: 0 0 .25em #000;  }
        div.box p { font-size: 1.2em; text-shadow: 0 0 1em #aaa; }
        div.box hr { background: #444; color: #444; border: 0; height: 2px;  }
        div.box a { color: #f80;  }
    </style>
</head>
<body>
<div class="container" role="main">
    <div class="bg"><div>500</div></div>
    <div class="box">
        <h1>There is an error here, sorry.</h1>
        <hr />
        <p>You're seeing this page, because our server is currently expiriencing some difficulties.</p>
        <p>We apologise for any inconvenience.</p>
<!--[if lt IE 8]>
        <hr />
        <p class=chromeframe>
            Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade
            to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">
            install Google Chrome Frame</a> to experience this site.
        </p>
<![endif]-->
    </div>
</div>
</body>
</html>
<?php

    } // End of Catch Exception
}
?>