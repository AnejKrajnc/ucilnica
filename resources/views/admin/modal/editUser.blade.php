<form id="update-user" action="javascript:void(0);" data-userid="{{ $user->id }}">
    @csrf 
    <div class="form-row">
        <div class="form-group col-md-16">
            <label for="InputIme">Ime:</label>
            <input type="text" class="form-control" id="InputIme" name="name" value="{{ $user->name }}">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-16">
            <label for="InputEmail">E-pošta:</label>
            <input type="text" class="form-control" id="InputEmail" name="email" value="{{ $user->email }}">
        </div>
    </div>
    <button class="btn btn-primary" type="submit">Shrani spremembe</button>
</form>
<h5>Sprememba gesla</h5>
<span style="position:absolute; width:32px; height: 3px; background-color:#f41256;"></span>
<br>
<form id="password-reset" action="javascript:void(0);">
    @csrf
    <div class="form-row">
        <div class="form-group">
            <label for="InputNovoGeslo">Novo geslo: </label>
            <input type="text" class="form-control" id="InputNovoGeslo" name="password">
            <input type="hidden" name="user" value="{{ $user->id }}">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Spremeni geslo</button> 
        </div>
    </div>
</form>
<h5>Obstoječi tečaji uporabnika</h5>
<span style="position:absolute; width:32px; height: 3px; background-color:#f41256;"></span>
<br>
<table id="table" class="table">
    <thead>
        <tr>
            <th scope="col" data-type="number">#</th>
            <th scope="col">Ime tečaja</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($user->courses()->get() as $course)
    <tr draggable="true" data-module="{{ $loop->iteration }}">
        <td>{{ $loop->iteration }}</td>
        <td><a>{{ $course->title }}</a></td>
        <td><a class="remove-course-user" data-userid="{{ $user->id }}" data-courseid="{{ $course->id }}" style="cursor: pointer;">Odstrani</a></td>
        </tr>
        @endforeach
    </tbody>
</table>
<h5>Dodaj tečaje uporabniku</h5>
<form id="add-course-touser">
    <input type="hidden" name="user" value="{{ $user->id }}">
    <div class="form-group">
        <label for="tecaji">Izberite spletne tečaje (ob izbiri večih tečajev držite tipko Ctrl ali Shift):</label>
        <select name="tecaji[]" class="form-control" id="tecaji" multiple>
            <option disabled selected>Izberite tečaje</option>
            @foreach ($tecaji as $tecaj)
                <option value="{{ $tecaj->id }}">{{ $tecaj->title }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Shrani spremembe</button>
</form>
<br><br>
<form id="delete-user" data-userid="{{ $user->id }}" action="javascript:void(0);" method="POST">
<input type="hidden" name="_method" value="DELETE">
@csrf
<button type="submit" class="btn btn-primary">Izbriši uporabnika</button>
</form>
<script>
    $('#update-user').on('submit', function () {
        var formData = new FormData(this);
        $.ajax({
            url: '/api/dashboard/users/'+$(this).data('userid'),
            method: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        })
        .done((msg) => {
            alert(msg);
        });
});

$('#add-course-touser').on('submit', function () {
        var formData = new FormData(this);
        $.ajax({
            url: '/api/dashboard/users/add-course',
            method: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        })
        .done((msg) => {
            alert(msg);
        });
});

$('#password-reset').on('submit', function () {
        var formData = new FormData(this);
        $.ajax({
            url: '/api/dashboard/users/password-reset',
            method: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        })
        .done((msg) => {
            alert(msg);
        });
});

$('.remove-course-user').on('click', function () {
        $.ajax({
            url: '/api/dashboard/users/remove-course',
            method: "DELETE",
            data: {
                user: $(this).data('userid'),
                course: $(this).data('courseid')
            }
        })
        .done((msg) => {
            alert(msg);
        });
});

$('#delete-user').on('submit', function () {
        var formData = new FormData(this);
        $.ajax({
            url: '/api/dashboard/users/'+$(this).data('userid'),
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