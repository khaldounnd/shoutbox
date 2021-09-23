<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Super Cool Shoutbox</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Shoutbox Application For ovos Task.">
        <link rel="icon"
              type="image/png"
              href="./favicon.png">

        <link rel="stylesheet" href="./assets/css/bootstrap.min.css">

        <link rel="stylesheet" href="./assets/css/emojionearea.min.css">
        <link rel="stylesheet" href="./assets/css/chat.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

        <link rel="stylesheet" href="./assets/css/jquery-confirm.min.css">

    </head>

    <body>
        <video autoplay muted loop id="background">
            <source src="./assets/img/chat.mp4" type="video/mp4">
            Your browser does not support HTML5 video.
        </video>
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
                    <button id="send" class="btn btn-primary" aria-label="Send"><span class="fa fa-comment-alt"></span></button>
                </div>
                <div id="sendImageDiv">
                    <button id="sendImage" class="btn btn-secondary" aria-label="Send Image"><span class="fa fa-image"></span></button>
                </div>
                <input hidden id="image" type="file" accept="image/*">
                <input hidden id="user-agent" value="<?php echo $_SERVER['HTTP_USER_AGENT']; ?>">
            </div>
        </div>

        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Message</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modal-body"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="./assets/js/jquery-3.6.0.min.js"></script>
        <script src="./assets/js/bootstrap.min.js"></script>
        <script src="./assets/js/font-awesome.min.js"></script>
        <script src="./assets/js/jquery-confirm.min.js"></script>
        <script src="./assets/js/emojionearea.min.js"></script>
        <script src="./assets/js/chat.js"></script>
    </body>
</html>

