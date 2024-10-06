<form action="{{ route('create.token') }}" method="POST">
    @csrf
    <input type="text" name="email" placeholder="Email" required>
    <input type="text" name="card_number" placeholder="Número de tarjeta" required>
    <input type="text" name="cvv" placeholder="CVV" required>
    <input type="text" name="expiration_month" placeholder="Mes de expiración" required>
    <input type="text" name="expiration_year" placeholder="Año de expiración" required>
    <input type="text" name="dni" placeholder="DNI" required>
    <button type="submit">Pagar</button>
</form>
