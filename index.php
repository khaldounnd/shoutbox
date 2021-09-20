<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Super Cool Shoutbox</title>
        <meta charset="utf-8"/>
        <link rel="icon"
              type="image/png"
              href="./favicon.png">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
              integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l"
              crossorigin="anonymous">

        <link rel="stylesheet" href="./assets/css/chat.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    </head>

    <body>
        <div class="container mt-5">

            <div class="row">
                <div class="col-12">
                    <h2>Messages:</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class=" card border-default" id="messages"></div>
                </div>
            </div>

            <div class="row">
                <div id="textAreaDiv">
                    <textarea id="message" class="form-control"></textarea>
                </div>
                <div id="sendButtonDiv">
                    <button id="send" class="btn btn-primary"><span class="fa fa-comment-alt"></span></button>
                </div>
                <div id="sendImageDiv">
                    <button id="sendImage" class="btn btn-secondary"><span class="fa fa-image"></span></button>
                </div>
                <input hidden id="image" type="file" accept="image/*">
                <input hidden id="user-agent" value="<?php echo $_SERVER['HTTP_USER_AGENT']; ?>">
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"
                integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
                crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
        <script src="./assets/js/chat.js"></script>
    </body>
</html>

