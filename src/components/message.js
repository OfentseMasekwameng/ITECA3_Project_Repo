document.getElementById('msg_btn').addEventListener('click', function() {
    var messages = document.getElementsByClassName('message');
    
    for (var i = 0; i < messages.length; i++) {
      var message = messages[i];
      
      if (message.style.backgroundColor === 'rgb(229, 231, 235)') {
        message.classList.add('hide_message');
      } else {
        message.classList.remove('hide_message');
      }
    }
});