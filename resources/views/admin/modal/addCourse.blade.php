<form action="/dashboard/courses/{{ '' }}" id="update-course" enctype="multipart/form-data" method="POST">
    @csrf 
    <div class="form-row">
        <div class="form-group col-md-16">
            <label for="InputImeTecaja">Ime tečaja:</label>
            <input type="text" class="form-control" id="InputImeTecaja" name="imetecaja" value="{{ '' }}">
        </div>
        <div class="form-group col-md-2">
            <label for="InputBarva">Barva tečaja:</label>
        <select name="barva" id="InputBarva" class="form-control">
               
            </select>
        </div>
    </div>
        <div class="form-row">
            <div class="form-group col-12">
                <label for="InputOpisTecaja">Opis Tečaja:</label>
                <div id="InputOpisTecaja" class="div-textarea" contenteditable="true">{!! '' !!}</div>
                <input id="hidden-opis-tecaja" type="hidden" name="opistecaja" value='{!! '' !!}'>
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
            <img src="{{ '' }}" style="margin-bottom: 6px;" width="125" height="125" alt="Trenutna naslovna slikica tečaja" title="Trenutna slikica tečaja">
            <br>
                <input type="file" class="form-control" id="InputSlikica" name="slikica">
            </div>
        </div>
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
<form action="/dashboard/courses/{{ '' }}/modules" method="POST">
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
        
    </tbody>
</table>

<form action="/dashboard/courses/{{ '' }}" method="POST">
<input type="hidden" name="_method" value="DELETE">
@csrf
<button type="submit" class="btn btn-primary">Izbriši spletni tečaj</button>
</form>