<form action="{{ route('voucher.process') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="voucher_image">Subir imagen del voucher:</label>
    <input type="file" name="voucher_image" id="voucher_image" required>
    <button type="submit">Procesar</button>
    
</form>


<form action="{{ route('voucher.processyape') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="voucher_image">Subir imagen del voucher:</label>
    <input type="file" name="voucher_image" id="voucher_image" required>
    <button type="submit">Procesar</button>
    
</form>
