<form id="add-newuser" action="javascript:void(0);">
    @csrf 
    <div class="form-row">
        <div class="form-group col-md-16">
            <label for="InputIme">Ime:</label>
            <input type="text" class="form-control" id="InputIme" name="name">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-16">
            <label for="InputEmail">E-pošta:</label>
            <input type="text" class="form-control" id="InputEmail" name="email">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-16">
            <label for="InputGeslo">Geslo:</label>
            <input type="text" class="form-control" id="InputGeslo" name="password">
        </div>
    </div>
    <div class="form-group">
        <label for="tecaji">Izberite spletne tečaje (ob izbiri večih tečajev držite tipko Ctrl ali Shift):</label>
        <select name="tecaji[]" class="form-control" id="tecaji" multiple>
            <option disabled selected>Izberite tečaje</option>
            @foreach ($tecaji as $tecaj)
                <option value="{{ $tecaj->id }}">{{ $tecaj->title }}</option>
            @endforeach
        </select>
    </div>
    <button class="btn btn-primary" type="submit">Dodaj novega uporabnika</button>
</form>
<script>
    $('#add-newuser').on('submit', function () {
        var formData = new FormData(this);
        $.ajax({
            url: '/api/dashboard/users',
            method: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        })
        .done((msg) => {
            alert(msg);
            $('#exampleModal').modal('hide');
            location.reload();
        });
});
</script>