<div class="messenger-sendCard">
    <form id="message-form" method="POST" action="{{ route('send.message') }}" enctype="multipart/form-data">
        @csrf
        <label><span class="fas fa-paperclip"></span><input disabled='disabled' type="file" class="upload-attachment" name="file" accept="image/*, .txt, .rar, .zip, .pdf, .doc, .docx, .bmp, .avi, .mp4, .mpeg, .mwv, .xlsx, .mp3" /></label>
        <textarea readonly='readonly' name="message" class="m-send app-scroll" placeholder="Escribe su mensaje"></textarea>
        <button disabled='disabled'><span class="fas fa-paper-plane"></span></button>
    </form>
</div>