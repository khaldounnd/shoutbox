$(document).ready(function (){

    /**
     * \
     * @type {HTMLElement}
     */
    const textarea = document.getElementById("message");
    textarea.addEventListener("keyup", function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            if(textarea.value === "\n" || textarea.value === "") {
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
        let message = $('#message').val();
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
        } else {

        }
    });

    /**
     *
     * @param message
     */
    function addMessage(message){
        console.log(message)
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
            image.style.width = "20%";
            image.style.height = "100%";
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

        if(message !== "") {

            let data = {
                message: message,
                agent: agent,
                is_image: is_image
            }

            conn.send(JSON.stringify(data));
            addMessage(JSON.stringify(data))
            $('#message').val('')
        } else {
            alert('Message can\'t be empty');
        }
    }
})