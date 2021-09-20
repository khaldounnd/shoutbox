$(document).ready(function (){

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

    let conn = new WebSocket('ws://localhost:8080');
    conn.onopen = function(e) {
        console.log("Connection established!");

    };

    conn.onmessage = function(e) {
        addMessage(e.data);
    };

    $('#send').click(function (){
        let message = $('#message').val();
        let agent = $('#user-agent').val();

        if(message !== "") {

            let data = {
                message: message,
                agent: agent
            }

            conn.send(JSON.stringify(data));
            addMessage(message)
            $('#message').val('')
        } else {
            alert('Message can\'t be empty');
        }
    })

    function addMessage(message){
        let body = $('#messages');
        if(body.children().length >= 10) {
            body.find('p:first').remove();
        }

        let p = document.createElement('p');
        p.className = 'chat-message';
        p.innerHTML = message;
        p.addEventListener('click', function (){
            alert(message);
        });
        body.append(p);
    }
})