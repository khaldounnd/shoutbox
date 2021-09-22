$(document).ready(function (){

    let textarea = $("#message").emojioneArea({
        pickerPosition: "top",
        tonesStyle: "radio"
    });

    /**
     * \
     * @type {HTMLElement}
     */
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
     *
     * @type {WebSocket}
     */
    let conn = new WebSocket('ws://localhost:8080');
    conn.onopen = function(e) {
        console.log("Connection established!");
    };

    /**
     *
     * @param e
     */
    conn.onmessage = function(e) {
        addMessage(e.data);
    };

    /**
     *
     */
    $('#send').click(function (){
        let message = textarea[0].emojioneArea.getText();
        sendMessage(message, 0)
    })

    /**
     *
     */
    $('#sendImage').click(function (){
        document.getElementById('image').click();
    })

    /**
     *
     */
    $('#image').on('change', function (){
        let fd = new FormData();
        let image = $('#image')[0].files;

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
    });

    /**
     *
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
            p.appendChild(image)
        }

        p.addEventListener('click', function (){
            alert(message.message);
        });
        body.append(p);
    }

    /**
     *
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
})