@extends('layouts.app')
@section('title', 'Form_chat_bot')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
@endsection

@section('content')
    <div class="container mt-5 form-inscrire">
        <div class="row">
            <div class="col-md-6 mx-auto" style="margin-top:100px;">
                <div class="chat-window">
                    <div class="chat-header">
                        <div class="btn-chat-header">
                            <div></div>
                            <p class="chat-title">YunEvo SPORT</p>
                            <button class="close-btn">×</button>
                        </div>
                        <div class="photo-chat-header">
                            <img class="photo-chat" src="{{ asset('images/chat.png') }}" alt="photo chat" width="15"
                                height="15">
                            <p class="chat-reponse">Nous vous répondrons dès que possible.</p>
                        </div>
                    </div>
                    <div class="chat-content">
                    </div>
                    <div class="chat-input">
                        <textarea class="chat-text" id="chat-text" type="text" placeholder="Saisissez votre message..."></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const chatInput = document.getElementById('chat-text');
        const chatWindow = document.querySelector('.chat-content');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        chatInput.addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                const message = chatInput.value.trim();
                chatInput.value = ''; 

                if (message) {
                    chatWindow.innerHTML += `<div class="user-message">${message}</div>`;

                    fetch('/send-message', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ message: message })
                    })
                    .then(response => response.json())
                    .then(data => {
                        chatWindow.innerHTML += `<div class="bot-reply">${data.reply}</div>`;
                        chatWindow.scrollTop = chatWindow.scrollHeight;
                    })
                    .catch(error => console.error('Error:', error));
                }
            }
        });
    });
</script>
@endpush
