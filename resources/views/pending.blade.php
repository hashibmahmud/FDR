@extends('layout')
@section('title')
    FDR | Pending
@endsection
@section('content')
    <div class="container">
        <table class="w3-table-all w3-hoverable w3-centered w3-card" id="fdr-table">
            <thead>
                <tr class="w3-green" style="font-size: 20px;">
                    <td>FDR Number</td>
                    <td>Bank Name</td>
                    <td>Branch Name</td>
                    <td>Creator</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($fdrs as $item)
                    <tr style="font-size: 15px;">
                        <td>{{ $item['fdr_number'] }}</td>
                        <td>{{ $item['bank_name'] }}</td>
                        <td>{{ $item['branch_name'] }}</td>
                        <td>{{ App\Models\User::where('email', $item['creator'])->get()[0]['name'] }}
                        </td>
                        <td><a href="{{ route('singlefdr', [$item['id'], 'action'=>'verify']) }}" target="_blank"
                                class="btn btn-outline-success">Details</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
