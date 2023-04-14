<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Chat GPT</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>

<body>
    <header id="mainHeader">
        <nav class="navbar">
            <ul class="first-col">
                <li>
                    <a href="/chat">
                        Чат
                    </a>
                </li>
            </ul>
            <ul class="second-col"></ul>
        </nav>
    </header>
<div class="sidebar">
    <form action="{{ route('chats.store') }}" method="POST">
        @csrf
        <button type="submit" class="tablink sidebar-header">Create Chat</button>
    </form>
        @foreach($chats as $chat)
            <a href="{{ $chat->id }}" class="tablink" onclick="openTab(event, 'tab1')">{{ $chat->title }}</a>
        @endforeach
</div>
<section class="msger">
    <header class="msger-header">
        <div class="msger-header-title">
            <i class="fas fa-comment-alt"></i> ChatGPT
            &nbsp;| ID: <input type="text" id="id" hidden> <span class="id_session"></span>
        </div>
        <div class="msger-header-options">
            <button id="delete-button">Delete History</button>
        </div>
    </header>

    <main class="msger-chat">
    </main>

    <form class="msger-inputarea">
        @csrf
        <input type="hidden" name="chat_id" value="{{ $chat->id }}">
        <input type="hidden" name="user_id" value="{{ Auth()->id() }}">
        <input class="msger-input" placeholder="Enter your message..." require>
        <button type="submit" class="msger-send-btn">Send</button>
    </form>

</section>
<script src='https://use.fontawesome.com/releases/v5.0.13/js/all.js'></script>
<script src="{{asset('js/script.js')}}"></script>
<!-- History feature
<script>
function openTab(evt, tabName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>
-->

</body>

</html>
