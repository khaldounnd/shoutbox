# Shoutbox

### Requirements
```PHP >= 8.0``` <br/>
```Composer```

### Features List
 
This is my version of a shoutbox. It has the following features:
- Broadcasting messages in real-time
- Sending Images as Messages
- Emojis!!
- Fully responsive design
- Maximum of 10 messages are shown, rest are deleted

### Getting Started

After cloning this project run ```composer install```, import ```db/init.sql``` into MySQL, and update the ```Connection/Connection.php``` with your 
credentials. Start it either using apache or PHP cli. 

Run the command ```php bin/chat-server.php``` in the terminal. 

Note: you might need to give write permission to uploads folder if you are using LAMP from ```var/www/html```

You are now good to go. Enjoy!