@extends('pengurus.app')

@section('content')
    <div class="row mt-5 mb-5">
        <div class="col-lg-12 margin-tb">
            <div class="float-left">
                <h2>List Users</h2>
            </div>
            <div class="float-right">
                <a class="btn btn-success" href="{{ route('pengurusFormAdd') }}"> Tambah User</a>
            </div>
            <div class="float-right">
                <a class="btn btn-danger" href="{{ route('logout') }}"> Logout</a>
            </div>

        </div>
    </div>

    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif

    @if ($message = Session::get('danger'))
    <div class="alert alert-danger">
        <p>{{ $message }}</p>
    </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Nama Lengkap</th>
            <th>No Handphone</th>
            <th>Level</th>
            <th width="280px"class="text-center">Action</th>
        </tr>
         @foreach ($users as $user)
        <tr>
            <td>{{ $user['name'] }}</td>
            <td>{{ $user['email'] }}</td>
            <td>{{ $user['fullname'] }}</td>
            <td>{{ $user['phone_number'] }}</td>
            <td>{{ $user['level'] }}</td>
            <td class="text-center">
                <form action="{{ route('pengurusDelete',$user['id']) }}" method="POST">

                    <a class="btn btn-primary btn-sm" href="{{ route('pengurusEdit',$user['id']) }}">Edit</a>

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>


@endsection
