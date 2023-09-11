<form id="update-course" action="javascript:void(0);" data-courseid="{{ $course->id }}">
    @csrf 
    <div class="form-row">
        <div class="form-group col-md-16">
            <label for="InputImeTecaja">Ime tečaja:</label>
            <input type="text" class="form-control" id="InputImeTecaja" name="imetecaja" value="{{ $course->title }}">
            <i>Povezava tečaja se avtomatsko generira glede na ime v zgornjem polju</i>
        </div>
        <div class="form-group col-md-5">
            <label for="InputKategorija">Glavna kategorija tečaja:</label>
        <select name="kategorija_id" id="InputKategorija" class="form-control">
                @if($course->category_id == 1)
                <option value="1" selected>Spletni tečaji</option>
                <option value="2">Celostni program samopomoči</option>
                <option value="3">Sotini akademija</option>
                <option value="5">Intenzivna šola samopomoči</option>
                @elseif($course->category_id == 2)
                <option value="1">Spletni tečaji</option>
                <option value="2" selected>Celostni program samopomoči</option>
                <option value="3">Sotini akademija</option>
                <option value="5">Intenzivna šola samopomoči</option>
                @elseif($course->category_id == 3)
                <option value="1">Spletni tečaji</option>
                <option value="2">Celostni program samopomoči</option>
                <option value="3" selected>Sotini akademija</option>
                <option value="5">Intenzivna šola samopomoči</option>
                @elseif($course->category_id == 5)
                <option value="1">Spletni tečaji</option>
                <option value="2">Celostni program samopomoči</option>
                <option value="3">Sotini akademija</option>
                <option value="5" selected>Intenzivna šola samopomoči</option>
                @else
                <option value="NULL" selected>Izberite kategorijo tečaja</option>
                <option value="1">Spletni tečaji</option>
                <option value="2">Celostni program samopomoči</option>
                <option value="3">Sotini akademija</option>
                <option value="5">Intenzivna šola samopomoči</option>
                @endif
            </select>
            <br>
            <label for="InputBarva">Barva tečaja:</label>
        <select name="barva" id="InputBarva" class="form-control">
                @if($course->color == 'red')
                <option value="red" selected>Rdeča</option>
                <option value="green">Zelena</option>
                @elseif($course->color == 'green')
                <option value="red">Rdeča</option>
                <option value="green" selected>Zelena</option>
                @else
                <option selected>Izberite barvo tečaja</option>
                <option value="red">Rdeča</option>
                <option value="green">Zelena</option>
                @endif
            </select>
        </div>
    </div>
        <div class="form-row">
            <div class="form-group col-12">
                <label for="InputOpisTecaja">Opis Tečaja:</label>
                <div id="InputOpisTecaja" class="div-textarea" contenteditable="true">{!! $course->description !!}</div>
                <input id="hidden-opis-tecaja" type="hidden" name="opistecaja" value='{!! $course->description !!}'>
            </div>
        </div>
        <script>
            document.querySelector('#update-course').addEventListener('DOMSubtreeModified', function() {
                document.querySelector('#hidden-opis-tecaja').value = document.querySelector('#InputOpisTecaja').innerHTML;
                console.log('OK');
            });
        </script>
        <div class="form-row">
            <div class="form-group col-5"> 
                <label for="InputSlikica">Naslovna slikica tečaja:</label><br>
            <img id="predogledSlikice" src="{{ asset($course->thumbnail) }}" style="margin-bottom: 6px;" width="125" height="125" alt="Trenutna naslovna slikica tečaja" title="Trenutna slikica tečaja">
            <br>
                <input type="file" class="form-control" id="InputSlikica" name="slikica">
            </div>
        </div>
        <script>
            var slika = document.getElementById('InputSlikica');
        slika.onchange = evt => {
            const [file] = slika.files;
            if (file) {
                document.querySelector('#predogledSlikice').src = URL.createObjectURL(file);
            }
            }
        </script>
    <button class="btn btn-primary" type="submit">Shrani spremembe</button>
    <br>
    @if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
    @endif
    <br>
</form>
<h5>Moduli tečaja</h5>
<span style="position:absolute; width:32px; height: 3px; background-color:#f41256;"></span>
<br>
<form id="add-module" action="javascript:void(0);" data-courseid="{{ $course->id }}">
    @csrf
    <div class="form-row">
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Dodaj modul</button> 
        </div>
    </div>
</form>
<table id="table" class="table">
    <thead>
        <tr>
            <th scope="col" data-type="number">#</th>
            <th scope="col">Ime modula</th>
        </tr>
    </thead>
    <tbody>
        @if($modules != NULL)
        @foreach ($modules as $module)
    <tr draggable="true" data-module="{{ $module->id }}">
        <th scope="row">{{ $module->order }}</th>
        <td><a href="/dashboard/courses/{{ $course->id }}/modules/{{ $module->id }}">{{ $module->title }}</a></td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>

<form id="remove-course" action="javascript:void(0);" data-courseid="{{ $course->id }}">
@csrf
<button type="submit" class="btn btn-primary">Izbriši spletni tečaj</button>
</form>
<script>
    $('#update-course').on('submit', function () {
        var formData = new FormData(this);
        $.ajax({
            url: '/api/dashboard/courses/'+$(this).data('courseid'),
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

    $('#add-module').on('submit', function () {
        var formData = new FormData(this);
        $.ajax({
            url: '/api/dashboard/courses/'+$(this).data('courseid')+'/modules',
            method: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        })
        .done((data) => {
            $('#table tbody').append('<tr draggable="true" data-module="'+data.id+'"><th scope="row">'+data.id+'</th><td><a href="/dashboard/courses/'+data.course_id+'/modules/'+data.id+'">'+data.title+'</a></td></tr>');
        })
    });

    $('#remove-course').on('submit', function () {
        var formData = new FormData(this);
        $.ajax({
            url: '/api/dashboard/courses/'+$(this).data('courseid'),
            method: "DELETE",
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        })
        .done((data) => {
            if (data.success == true) {
                alert('Tečaj uspešno zbrisan!');
                $('#exampleModal').modal('hide');
                location.reload();
            }
            else
                alert('Prišlo je do napake pri brisanju tečaja! Poskusite ponovno kasneje');
        })
    });

</script>
