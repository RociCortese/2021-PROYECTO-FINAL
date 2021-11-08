{{-- user info and avatar --}}
<div class="avatar av-l"></div>
<p class="info-name">{{ Auth::user()->email }}</p>
<div class="messenger-infoView-btns">
    {{-- <a href="#" class="default"><i class="fas fa-camera"></i> default</a> --}}
    <a href="#" class="danger delete-conversation"><i class="fas fa-trash-alt"></i> Delete Conversation</a>
</div>
