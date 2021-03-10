@extends('layout')
@section('title')
    FDR | Renew
@endsection
@section('content')
    <div class="container">
        <div class="mb-4"></div>
        <form action="{{ url('/fdr-renew') }}" class="form-horizontal" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $data['id'] }}">
            <div class="form-group row">
                <label for="" class="col-lg-2 col-md-3">Renew Date</label>
                <input type="text" readonly class="form-control-plaintext col-md-7" id="renew" name="renew_date" value="{{ $data['next_maturity'] }}">
            </div>
            <div class="form-group row">
                <label for="" class="col-lg-2 col-md-3">Period</label>
                <input type="text" class="form-control col-6 col-sm-3" id="period" name="period" onkeyup="updateClosingDate()" required>
            </div>
            <div class="form-group row">
                <label for="" class="col-lg-2 col-md-3">Next maturity</label>
                <input type="text" class="form-control-plaintext col-md-7" id="next" name="new_maturity" readonly>
            </div>
            <div class="form-group row">
                <label for="" class="col-lg-2 col-md-3">Contact Person</label>
                <input type="text" class="form-control col-md-5" id="person" name="person" value="{{ $data["contact_person"] }}" required>
            </div>
            <div class="form-group row">
                <label for="" class="col-lg-2 col-md-3">Contact number</label>
                <input type="text" class="form-control col-md-5" id="number" name="number" value="{{ $data["contact_number"] }}" required>
            </div>
            <div class="row d-flex justify-content-around"><input type="submit" class="btn btn-outline-success"
                    value="Submit" /></div>
        </form>
    </div>
    <script>
        function updateClosingDate() {
            var valid_date = [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31] // assuming each one is leap year
            var month_name = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            var openingDate = document.getElementById('renew');
            var period = document.getElementById('period');
            var closeDate = document.getElementById('next');
            if (openingDate.value && period.value) {
                let open_date = new Date(openingDate.value);
                let newYear = 0,
                    newMonth = 0,
                    prd = parseInt(period.value),
                    newDate = open_date.getDate();
                let oldMonth = parseInt(open_date.getMonth()) + 1,
                    oldYear = parseInt(open_date.getFullYear());
                if (oldMonth + prd > 12) {
                    newYear = oldYear + Math.floor((oldMonth + prd) / 12);
                    newMonth = (oldMonth + prd) % 12;
                } else {
                    newYear = oldYear;
                    newMonth = oldMonth + prd;
                }
                if (valid_date[newMonth - 1] < open_date.getDate()) { // if date is not available in new month
                    newDate = valid_date[newMonth - 1];
                    if (newYear % 4 != 0 && newMonth == 2) { // in case of not leap year
                        newDate = 28;
                    }
                };
                closeDate.value = newDate + ' ' + month_name[newMonth - 1] + ' ' + newYear;
            } else {
                closeDate.value = "";
            }
        }

    </script>
@endsection
