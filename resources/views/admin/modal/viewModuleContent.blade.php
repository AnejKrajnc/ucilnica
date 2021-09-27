<form id="update-modulecontent" action="javascript:void(0);" data-modulecontentid="{{ $modulecontent->id }}">
    @csrf 
    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="InputTip">Tip vsebine:</label>
        <select name="tip" id="InputTip" class="form-control">
                @if($modulecontent->type == 'video')
                <option value="video" selected>Video</option>
                <option value="meditacija">Meditacija</option>
                <option value="eknjiga">E-knjižica</option>
                @elseif($modulecontent->type == 'meditacija')
                <option value="video">Video</option>
                <option value="meditacija" selected>Meditacija</option>
                <option value="eknjiga">E-knjižica</option>
                @elseif($modulecontent->type == 'eknjiga')
                <option value="video">Video</option>
                <option value="meditacija">Meditacija</option>
                <option value="eknjiga" selected>E-knjižica</option>
                @else
                <option selected disabled>Izberite tip vsebine</option>
                <option value="video">Video</option>
                <option value="meditacija">Meditacija</option>
                <option value="eknjiga">E-knjižica</option>
                @endif
            </select>
        </div>
        <div class="form-group col-md-16">
            <label for="InputNalovVsebine">Naslov vsebine:</label>
            <input type="text" class="form-control" id="InputNaslovVsebine" name="naslov" value="{{ $modulecontent->title }}">
            <i>Povezava tečaja se avtomatsko generira glede na ime v zgornjem polju</i>
        </div>
        <div class="form-group col-md-16">
            <label for="InputNalovVsebine">Povezava do vsebine v spletni učilnici:</label>
            <input type="text" class="form-control" id="InputPovezava" name="povezava" value="{{ $modulecontent->content_link ?? '' }}">
            <i>(Povezavo do te vsebine v spletni učilnici lahko po želji tudi spremenite s poljubnim vnosom)</i>
        </div>
    </div>
        <div class="form-row">
            <div class="form-group col-12">
                @if($modulecontent->type == 'video')
                <label for="InputVsebina">Povezava do posnetka na youtube:</label>
                <input type="text" class="form-control" id="InputVsebina" name="vsebina" value="{{ $modulecontent->content ?? '' }}">
                @elseif($modulecontent->type == 'meditacija')
                <label for="InputVsebina">Povezava do posnetka meditacije na soundcloud-u:</label>
                <input type="text" class="form-control" id="InputVsebina" name="vsebina" value="{{ $modulecontent->content ?? '' }}">
                @else
                @if($modulecontent->content != NULL)
                <a href="{{ url('/prenos/tecaji/'.$modulecontent->content) }}">Prenos trenutne e-knjižice</a>
                @endif
                <label for="InputVsebina">E-knjižica za nalaganje:</label>
                <input type="file" class="form-control" id="InputVsebina" name="vsebina">
                @endif
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

<form action="/dashboard/courses/{{ $modulecontent->id }}" method="POST">
<input type="hidden" name="_method" value="DELETE">
@csrf
<button type="submit" class="btn btn-primary">Izbriši vsebino modula</button>
</form>
<script>
    $('#update-modulecontent').on('submit', function () {
        var formData = new FormData(this);
        $.ajax({
            url: '/api/dashboard/modulecontent/'+$(this).data('modulecontentid'),
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

    $('#InputTip').on('change', function () {
        if ($(this).val() == 'video') {
            $("label[for='InputVsebina']").html('Povezava do videa na youtube:');
            $('#InputVsebina').attr('type', 'text');
        }
        else if ($(this).val() == 'meditacija') {
            $("label[for='InputVsebina']").html('Povezava do videa na soundcloud:');
            $('#InputVsebina').attr('type', 'text');
        }
        else if ($(this).val() == 'eknjiga') {
            $("label[for='InputVsebina']").html('E-knjižica za nalaganje:');
            $('#InputVsebina').attr('type', 'file');
        }
    });
</script>