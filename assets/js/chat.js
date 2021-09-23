$(document).ready(function (){

    /**
     * Initializing Emoji Area
     * @type {HTMLElement}
     */
    let textarea = $("#message").emojioneArea({
        pickerPosition: "top",
        tonesStyle: "radio"
    });
    textarea[0].emojioneArea.on('keyup', function (button, event){
        if (event.key === 'Enter') {
            event.preventDefault();
            if(textarea[0].emojioneArea.getText() === "\n\n\n" || textarea[0].emojioneArea.getText() === "") {
                alert('Message can\'t be empty');
            } else {
                document.getElementById("send").click();
            }
        }
    });

    /**
     * Initializing Websocket
     * @type {WebSocket}
     */
    let conn = new WebSocket('ws://localhost:8080');
    conn.onopen = function(e) {
        console.log("Connection established!");
    };

    /**
     * Handling new message from socket
     * @param e
     */
    conn.onmessage = function(e) {
        addMessage(e.data);
    };

    /**
     * Event Handler for Clicking The Send Button
     */
    $('#send').click(function (){
        let message = textarea[0].emojioneArea.getText();
        sendMessage(message, 0)
    })

    /**
     * Opening hidden file upload field
     */
    $('#sendImage').click(function (){
        document.getElementById('image').click();
    })

    /**
     * Uploading File
     */
    $('#image').on('change', function (){
        let fd = new FormData();
        let image = $('#image')[0].files;

        $.confirm({
            title: 'Are You Sure?',
            content: 'Upload Image?',
            buttons: {
                confirm: function () {
                    if(image.length > 0 ) {
                        fd.append('image', image[0]);

                        $.ajax({
                            url: 'submitImage.php',
                            type: 'POST',
                            contentType: false,
                            processData: false,
                            data: fd,
                            success: function (data) {
                                sendMessage(data, 1);
                            },

                            error: function (data) {
                                alert('Unable to upload image')
                            },
                        });
                    }
                },
                cancel: function () {
                    $.alert('Canceled');
                },
            }
        });
    });

    /**
     * Method to handle new images.
     * @param message
     */
    function addMessage(message){
        let body = $('#messages');
        if(body.children().length >= 10) {
            body.find('p:first').remove();
        }

        message = JSON.parse(message);

        let p = document.createElement('p');
        p.className = 'chat-message';

        if(message.is_image == 0){
            p.innerHTML = message.message;
        } else {
            let image = document.createElement('img');
            image.src = message.message;
            image.alt = message.message;
            p.appendChild(image)
        }

        //Attach Click Event Listener to open Modal showing message
        p.addEventListener('click', function (){
            showModal(message.message, message.is_image);
        });
        body.append(p);

        //Scroll down to newest message
        let objDiv = document.getElementById("messages");
        objDiv.scrollTop = objDiv.scrollHeight;
    }

    /**
     * Send message through socket
     * @param message
     * @param is_image
     */
    function sendMessage(message, is_image){

        let agent = $('#user-agent').val();

        if(message !== "\n\n\n" && message !== "") {

            let data = {
                message: message,
                agent: agent,
                is_image: is_image
            }

            conn.send(JSON.stringify(data));
            addMessage(JSON.stringify(data))
            $('#message').val('')
            $('#message').html('')
            $('.emojionearea-editor').html('')
        } else {
            alert('Message can\'t be empty');
        }
    }

    /**
     * Open Modal and Add Related data to its body
     * @param message
     * @param is_image
     */
    function showModal(message, is_image) {
        let body = $('#modal-body');
        if (is_image == 0) {
            body.html(null);
            body.append("<p>" + message + "</p>")
        } else {
            body.html(null);
            body.append("<img src=\"" + message + "\" alt='message'>")
        }

        $('#modal').modal('toggle')
    }
})