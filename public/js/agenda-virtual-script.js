if (agendaVirtualVisible.visible == 1) {
  var botao_av = document.createElement('a');
  botao_av.id = 'botao-agendavirtual';
  botao_av.classList.add('botao-agendavirtual');

  var icon = agendaVirtualDataIcon.icon;
  botao_av.innerHTML = '<i class="icon '+icon+'"></i>';

  var cor = agendaVirtualDataCor.cor;
  botao_av.style.backgroundColor = cor;

  var boxchat_av = document.querySelector('#virtual-assistant-box');
  var chat_message = document.querySelector('.chat-message');

  var position = agendaVirtualDataPosition.position;
  switch (position) {
    case 'inferior_direito':
      botao_av.classList.add('botao-agendavirtual-inferior-direito');
      boxchat_av.classList.add('box-chat-inferior-direito');
      chat_message.classList.add('bottom-chat');
      break;
    case 'inferior_esquerdo':
      botao_av.classList.add('botao-agendavirtual-inferior-esquerdo');
      boxchat_av.classList.add('box-chat-inferior-esquerdo');
	  chat_message.classList.add('bottom-chat');
      break;
    case 'superior_direito':
      botao_av.classList.add('botao-agendavirtual-superior-direito');
      boxchat_av.classList.add('box-chat-superior-direito');
	  chat_message.classList.add('top-chat');
      break;
    case 'superior_esquerdo':
      botao_av.classList.add('botao-agendavirtual-superior-esquerdo');
      boxchat_av.classList.add('box-chat-superior-esquerdo');
	  chat_message.classList.add('top-chat');
      break;
    default:
      botao_av.classList.add('botao-agendavirtual-inferior-direito');
      boxchat_av.classList.add('box-chat-inferior-direito');
	  chat_message.classList.add('bottom-chat');
  }

  document.body.appendChild(botao_av);
}

jQuery(document).ready(function($) {
    $('.botao-agendavirtual').click(function() {
        if ($('.virtual-assistant-box').is(':visible')) {
            $('.virtual-assistant-box').fadeOut(100);
        } else {
            $('.virtual-assistant-box').fadeIn(100);
            $('#message').focus();
            $('#virtual-assistant-box').scrollTop($('#virtual-assistant-box')[0].scrollHeight);
        }
    });
});