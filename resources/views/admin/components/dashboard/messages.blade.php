<section class="panel important">
    <h2>Messages</h2>
    @foreach(AdminController::get_unread_messages('positive') as $message)
        <div class="feedback success">{{$message}}</div>
    @endforeach
    @foreach(AdminController::get_unread_messages('neutral') as $message)
        <div class="feedback">{{$message}}</div>
    @endforeach
    @foreach(AdminController::get_unread_messages('warning') as $message)
        <div class="feedback error">{{$message}}</div>
    @endforeach
</section>
