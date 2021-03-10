@extends('layout')
@section('title')
    All FDR
@endsection
@section('content')
    <div class="container mt-4">
        <table class="w3-table-all w3-hoverable w3-centered w3-card" id="fdr-table">
            <thead>
                <tr class="w3-green" style="font-size: 20px;">
                    <td>FDR Number</td>
                    <td>Bank Name</td>
                    <td>Branch Name</td>
                    <td>Remaining</td>
                    <td>
                        @if (isset($source) && $source == 'myfdr')
                            Status
                        @else
                            Creator
                        @endif
                    </td>
                    <td>Action</td>
                </tr>
            </thead>
            {{-- <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><input type="text" class="form-control" id="day-filter" onkeyup="filter()"
                            style="margin: 0 auto; text-align:center; width:40%;"></td>
                    <td></td>
                </tr>
            </tbody> --}}
            <tbody>
                @foreach ($data as $item)
                    <tr style="font-size: 15px;">
                        <td>{{ $item['fdr_number'] }}</td>
                        <td>{{ $item['bank_name'] }}</td>
                        <td>{{ $item['branch_name'] }}</td>
                        <td>
                            @if (Carbon\Carbon::parse($item['next_maturity'])->isPast())
                                -
                            @endif
                            {{ $diff = Carbon\Carbon::parse($item['next_maturity'])->diffInDays(Carbon\Carbon::now()) + 1 }}
                            day(s)
                        </td>
                        <td>
                            @if (isset($source) && $source == 'myfdr')
                                {{ $item['status'] }}
                            @else
                                {{ App\Models\User::where('email', $item['creator'])->get()[0]['name'] }}
                            @endif
                        </td>
                        <td><a href="{{ route('singlefdr', $item['id']) }}" target="_blank"
                                class="btn btn-outline-success">Details</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        function filter() {
            var input = document.getElementById("day-filter");
            var filter_key = parseInt(input.value);
            var table = document.getElementById("fdr-table");
            var rows = table.getElementsByTagName("tr");
            for (let i = 2; i < rows.length; i++) {
                var cell = rows[i].getElementsByTagName("td")[3];
                if (cell) {
                    var val = parseInt((cell.textContent || cell.innerText).split(" ")[0]);
                    if (val <= filter_key || !filter_key) {
                        rows[i].style.display = "";
                    } else {
                        rows[i].style.display = "none";
                    }
                }
            }
        }

    </script>
@endsection
